<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Cycle;
use App\Models\Payment;
use App\Models\Welfare;
use App\Exports\LedgerYear;
use App\Exports\LedgerCycle;
use Illuminate\Http\Request;
use App\Exports\CyclesExport;
use App\Imports\LedgerImport;
use App\Exports\LedgersSelect;
use App\Exports\MembersLedger;
use App\Imports\MembersImport;
use App\Imports\MembersPayments;
use Illuminate\Support\Facades\DB;
use App\Notifications\UploadLedger;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelUploads\LedgersExcelController;

class LedgersController extends Controller
{
    public function index()
    {
        $info = new DashboardController();
        $cycles = $info->CyclesInfo();

        return Inertia::render('Ledgers', [
            'info'   => $cycles
        ]);
    }

    public function uploadTemplates() 
    {
        $path = public_path('excelSheets');
        $files = scandir($path, SCANDIR_SORT_DESCENDING);

        foreach ($files as $file) {
            // file year 
            if ($file == '2024sheet.xlsx') {
                $year = 2024;
            }
            if ($file == '2023sheet.xlsx') {
                $year = 2023;
            }

            // upload excel
            $collection  = Excel::toCollection(new MembersImport, public_path('excelSheets') . '/' . $file);
            $collection2 = Excel::toCollection(new MembersPayments, public_path('excelSheets') . '/' . $file);

            // sort the collection
            $rows       = $collection[0];
            $filtered   = $rows->where(['0', null]);
            $new        = $filtered->all();

            // upload all info array
            $setup      = new LedgersExcelController();

            $members = $setup->memberArray($new);

            $setup->paysArray($collection2, $collection, $year);

            $user = User::where('id', auth()->id())->first();
            Notification::send($user, new UploadLedger($year));
        }
    }

    public function getTemplates()
    {
        // store the public path
        $path = public_path('excelSheets');
        $files = scandir($path, SCANDIR_SORT_DESCENDING);

        // foreach ($files as $index => $file) {
        $first          = $files[0];
        $download_path  = public_path('excelSheets') . '/' . $first;
        return response()->download($download_path); 
    }

    public function exportLedger()
    {
        $name = strtoupper('Payments & Welfares Ledger');

        return Excel::download(new MembersLedger(), "$name Template.xlsx");
    }

    public function exportLedgerYear($year)
    {
        $name = strtoupper('Full ' . $year.' Payments & Welfares Ledger');

        return Excel::download(new LedgerYear($year), "$name Template.xlsx");
    }

    public function exportLedgerCycle(Cycle $cycle)
    {
        $name = strtoupper('Full '. $cycle->month .' ' . $cycle->year . ' Payments & Welfares Ledger');

        return Excel::download(new CyclesExport($cycle), "$name Template.xlsx");
    }

    public function exportLedgerCycleSelection($from, $to)
    {
        $start = Cycle::find($from);
        $end   = Cycle::find($to);

        $name = strtoupper('Ledger payments: ' . $start->name . ' - ' . $end->name);

        $cycles = Cycle::whereBetween('id', [$from, $to])
                        ->with('payments')
                        ->get();

        return Excel::download(new LedgersSelect($cycles, $from, $to), "$name.xlsx");

        // return [$start, $end, $name, $cycles];
    }

    public function storeCyclesLedger(Request $request)
    {
        // upload excel
        $array      = Excel::import(new LedgerImport, $request->file('excel'), \Maatwebsite\Excel\Excel::XLSX);

        $headings   = (new HeadingRowImport)->toArray($request->file('excel'));

        $rows = $array;
        return $rows;

        // Enter the info row by row 
        foreach ($rows  as $row) {
            // if row is not null 
            if ($row[0]  != null) {
                // Contribution Payments 
                if ($row[2]  != null) {
                    $payment      = $row[2];
                    $newpayment   = str_replace(',', '', $payment);

                    Payment::create([
                        'user_id'       => auth()->id(),
                        // 'cycle_id'      => $cycle->id,
                        'member_id'     => $row[0],
                        'payment'       => $newpayment,
                    ]);
                }
                // Welfare Payments 
                if ($row[3]  != null) {
                    $welfare      = $row[3];
                    $newwelfare   = str_replace(',', '', $welfare);

                    Welfare::create([
                        'user_id'       => auth()->id(),
                        // 'cycle_id'      => $cycle->id,
                        'member_id'     => $row[0],
                        'payment'       => $newwelfare,
                        'type'          => 1
                    ]);
                }
                // Welfare Owes 
                if ($row[4]  != null) {
                    $owe      = $row[4];
                    $newowe   = str_replace(',', '', $owe);

                    Welfare::create([
                        'user_id'       => auth()->id(),
                        // 'cycle_id'      => $cycle->id,
                        'member_id'     => $row[0],
                        'payment'       => $newowe,
                        'type'          => 0
                    ]);
                }
            }
        }

        // update all 
        // $this->updateCycle($cycle);

        return back();
    }

    public function ledgerExist($year)
    {
        $cycles = DB::table('cycles')
                        ->where('deleted_at', null)
                        ->where('year', $year)
                        ->count();

        if ($cycles > 0) {
            $message    = 'Ledger: '. $year . ' Already has ( '. $cycles.' ) cycles! All Existing Member Information will be updated with the new upload!'; 
            $exist      = true;
        } else {
            $message    = 'Ledger: '. $year . ' Can be filled!'; 
            $exist      = false;
        }
        
        return [$cycles, $message, $exist];
    }
}

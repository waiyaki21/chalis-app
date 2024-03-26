<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Cycle;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Welfare;
use App\Models\Finances;
use Illuminate\Http\Request;
use App\Exports\MemberSingle;
use App\Exports\MembersLedger;
use App\Imports\MembersImport;
use App\Exports\MembersTemplate;
use App\Imports\MembersPayments;
use App\Notifications\StoreMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateController;

use App\Http\Controllers\FinancesController;
use Illuminate\Support\Facades\Notification;

class MemberController extends Controller
{
    public function index()
    {   
        // get all members 
        $members    = Member::orderBy('created_at', 'asc')
                        ->withCount('payments', 'welfares')
                        ->get();

        
        $active    = DB::table('members')->where('active', 1)->count();
        $inactive  = DB::table('members')->where('active', 0)->count();
        
        // payment total
        $paySum     = Payment::sum('payment');

        $amntbefore = DB::table('members')->sum('amount_before');

        $grandtotal = $paySum + intval($amntbefore);

        // welfare totals
        $addwelfs   = Welfare::where('type', 1)->sum('payment');
        $before     = $members->sum('welfare_before');
        $welfareIn  = $before + $addwelfs;

        $beforeOwed = $members->sum('welfareowed_before');
        $minuswelfs = Welfare::where('type', 0)->sum('payment');
        $welfareOwed= $minuswelfs + intval($beforeOwed); 

        $welfSum    = $welfareIn - $welfareOwed;

        $user       = Auth::user();

        // return $members;
        return Inertia::render('Members', [
            'name'      => env('APP_NAME'),
            'route'     => Route::current()->getName(),
            'members'   => $members,
            'paySum'    => $paySum,
            'welfSum'   => $welfSum,
            'active'    => $active,
            'inactive'  => $inactive,
            'user'      => $user,
            'grandtotal'=> $grandtotal,
            'amntbefore'=> $amntbefore,
            'welfareOwed'=> $welfareOwed,
            'welfareIn'  => $welfareIn
        ]);
    }

    public function store(Request $request)
    {
        // validate
        request()->validate([
            'name'          => 'required',
            'telephone'     => 'required',
            'amount_before' => 'required',
            'welfare_before'=> 'required'
        ]);
        
        // create member 
        Member::create([
            'user_id'       => auth()->id(),
            'name'          => request('name'),
            'telephone'     => request('telephone'),
            'amount_before' => request('amount_before'),
            'welfare_before' => request('welfare_before')
        ]);

        // update finances records
        $this->UpdateAll();

        return back();
    }

    public function storeModal(Request $request)
    {
        // validate
        request()->validate([
            'name'          => 'required',
            'telephone'     => 'required',
            'amount_before' => 'required',
            'welfare_before' => 'required'
        ]);

        // create member 
        $member = Member::create([
            'user_id'       => auth()->id(),
            'name'          => request('name'),
            'telephone'     => request('telephone'),
            'amount_before' => request('amount_before'),
            'welfare_before' => request('welfare_before')
        ]);

        // update finances records
        $this->UpdateAll();

        return back();
    }

    public function show(Member $member)
    {
        // send notification
        // $user = User::where('id', $member->user_id)->first(); 
        // Notification::send($user, new StoreMember($member));

        // $not = auth()->user()->unreadnotifications;
        // return $not;

        // get the member 
        $member = Member::where('id', $member->id)
                        ->with('payments')
                        ->first();

        // return $member;
        $payments = Payment::where('member_id', $member->id)
                            ->orderBy('created_at', 'desc')
                            ->with('cycle:id,name')
                            ->get();

        $welfares = Welfare::where('member_id', $member->id)
                            ->orderBy('created_at', 'desc')
                            ->with('cycle:id,name')
                            ->get();

        $total = $member->total_investment;

        if ($total == 0) {
            $payPercent = 0;
            $welPercent = 0;
            $owePercent = 0;
        } else {
            $payPercent = number_format($member->payments_total / $total * 100);
            $welPercent = number_format($member->total_in / $total * 100);
            $owePercent = number_format($member->welfare_out / $total * 100);
        }

        // get all cycles 
        $cycles      = DB::table('cycles')->orderBy('id', 'desc')->where('deleted_at', null)
                            ->get(['id','name']);

        // return $cycles;
        $cycle       = DB::table('cycles')->orderBy('id', 'desc')->where('deleted_at', null)
                                ->first(['id', 'name', 'amount', 'welfare_amnt']);

        if ($cycles->count() == 0) {
            $pays   = [];
        } else {            
            $pays        = Payment::where('member_id', $member->id)
                                    ->where('cycle_id', $cycle->id)
                                    ->count();
        }
        
        // return [$cycle, $cycles];
        return Inertia::render('Member', [
            'name'          => env('APP_NAME'),
            'route'         => Route::current()->getName(),
            'member'        => $member,
            'payPercent'    => $payPercent,
            'welPercent'    => $welPercent,
            'owePercent'    => $owePercent,
            'payments'      => $payments,
            'welfares'      => $welfares,
            'cycles'        => $cycles,
            'cycle'         => $cycle,
            'pays'          => $pays,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        // dd($request);

        //validate the request
        $this->validate($request, [
            'name'                  => 'required',
            'telephone'             => 'required',
            'amount_before'         => 'required',
            'welfare_before'        => 'required',
            'welfareowed_before'    => 'required',
            'active'                => 'required'
        ]);

        // request to update member
        Member::where('id', $member->id)
                ->update([
                    'name'                  => $request->name,
                    'telephone'             => $request->telephone,
                    'amount_before'         => $request->amount_before,
                    'welfare_before'        => $request->welfare_before,
                    'welfareowed_before'    => $request->welfareowed_before,
                    'active'                => $request->active
                ]);

        // $member->update($request->all());
        // return Member::where('id', $member->id)->first();

        // update finances records
        $this->UpdateAll();

        return back();
    }

    public function updateActive(Member $member)
    {
        if ($member->active) {
            $active = 0;
        } else {
            $active = 1;
        }

        // request to update member
        Member::where('id', $member->id)
                ->update([
                    'active'   => $active
                ]);

        return back();
    }

    public function destroy(Member $member)
    {
        $payments = Payment::where('member_id', $member->id)->get();

        $welfares = Welfare::where('member_id', $member->id)->get();

        foreach ($payments as $payment) {
            $payment->delete();
        }

        foreach ($welfares as $welfare) {
            $welfare->delete();
        }

        $member->delete();

        // update finances records
        $this->UpdateAll();

        return back();
    }

    public function destroyReset(Member $member)
    {
        $payments = Payment::where('member_id', $member->id)->get();

        $welfares = Welfare::where('member_id', $member->id)->get();

        foreach ($payments as $payment) {
            $payment->delete();
        }

        foreach ($welfares as $welfare) {
            $welfare->delete();
        }

        $member->delete();

        // update finances records
        $this->UpdateAll();

        return redirect('/members');
    }

    public function destroyAll()
    {
        $members = Member::get();

        foreach ($members as $member) {
            $this->destroy($member);
        }

        // update finances records
        $this->UpdateAll();

        return back();
    }

    public function clearWelfare(Member $member)
    {
        $cycle      = Cycle::orderBy('created_at', 'desc')
                            ->first();

        if ($member->welfare_out > 0) {
            $owedbefore       = $member->welfareowed_before;

            $owed             = Welfare::where([['member_id', $member->id], ['type', 0]])->sum('payment');

            $totalOwed        = $owed + $owedbefore;

            Welfare::create([
                'user_id'       => auth()->id(),
                'cycle_id'      => $cycle->id,
                'member_id'     => $member->id,
                'payment'       => abs($totalOwed),
                'type'          => 1,
            ]);

            Member::where('id', $member->id)
            ->update([
                'welfareowed_before'    => '0',
            ]);

            // delete welfares 
            $welfares    = Welfare::where([['member_id', $member->id],['type', 0]])->get();
            $delete      = new WelfareController();
            foreach ($welfares as $welfare) {
                $delete->destroy($welfare);
            }
        }

        // update all 
        $this->UpdateAll();    

        // return [$payments, $cycle];
        $url = '/member/' . $member->id;
        
        return redirect($url)->with([
            'message'   => 'Welfares cleared successfully',
            'class'     => 'border-b-[4px] border-emerald-800 dark:border-emerald-800 shadow-green-900 dark:shadow-green-900 bg-green-100 dark:bg-green-500',
            'type'      => 'success'
        ]);
    }

    // excel sheets 
    public function exportTemplate()
    {
        $name = 'Enter New Members';

        return Excel::download(new MembersTemplate(), "$name Template.xlsx");
    }

    public function exportTemplateMember(Member $member) 
    {
        $name = strtoupper($member->name . ' Financial Report');

        return Excel::download(new MemberSingle($member), "$name Template.xlsx");
    }

    public function sheetMembersExist(Request $request)
    {
        // try {
            $request->validate(
                [
                    'excel'          => 'required|mimes:xlsx, csv, xls|max:10240'
                ],
                [
                    'excel.required' => 'File Ledger is required!',
                    'excel.mimes'    => 'Wrong File Format, Upload an excelsheet!',
                    'excel.max'      => 'This file is to big too be uploaded!',
                ]
            );

            // upload excel
            $collection  = Excel::toCollection(new MembersImport, $request->file('excel'));

            $rows       = $collection[0];
            $filtered   = $rows->where(['0', null]);

            $new        = $filtered->all();

            $count = 0;

            // get new members
            $leftOut  = array();

            foreach ($new  as $index => $row) {

                // create the arrays 
                $OGmembers = array();

                $info     = array('name' => $row[1], 'row_id' => $index);
                array_push($leftOut);

                try {
                    // get members 
                    $members = DB::table('members')->where('deleted_at', null)->get();

                    // loop members 
                    if ($members->count() != 0) {
                        foreach ($members as $member) {
                            // if there is a match update else create
                            if ($member->name == $row[1]) {
                                $count = $count + 1;
                            }

                            $rec    = array('name' => $member->name, 'member_id' => $member->id);
                            array_push($OGmembers, $rec);
                        }
                    } else {
                        $count = 0;
                    }
                } catch (Exception $e) {
                    // throw $e;
                    return $e->getMessage();
                    return 'My error message';
                }
            }

            $left = $filtered->count() - $count;

            $members = Member::query();
            $names   = $rows->where(['0', null])->pluck('1');
            
            foreach ($names as $name) {
                $members->orWhere('name', 'LIKE', '%' . $name . '%');
            }
            $OGmembers = $members->distinct()->get();

            return [$count, $left, 500];

        // } catch (\Illuminate\Validation\ValidationException $th) {
        //     $type = 'error';

        //     return [$type, $th->validator->errors(), 422];
        // }
    }

    public function storeSheetMembers(Request $request)
    {
        $cycle = Cycle::orderBy('created_at', 'desc')
                    ->first();

        $cycles = Cycle::count();

        // upload excel
        $collection = Excel::toCollection(new MembersImport, $request->file('excel'));

        $rows       = $collection[0];
        $filtered   = $rows->where(['0',null]);

        $message    = '( ' . $filtered->count() . ' ) New Members have been added!';

        $new        = $filtered->all();

        // get members 
        // $this->destroyAll();
        // $members = DB::table('members')->where('deleted_at', null)->get();

        // return $new;
        
        foreach ($new  as $index => $row) {
            if ($row[0]  != null) {
                $phone      = $row[2];
                $before     = $row[3];

                if($row[4] == null) {
                    $welfare = '0';
                } else {
                    $welfare    = $row[4];
                }

                if ($row[5] == null) {
                    $welfareOwed = '0';
                } else {
                    $welfareOwed    = $row[5];
                }

                $newphone   = str_replace(',', '', $phone);
                $newbefore  = str_replace(',', '', $before);
                $newwelfare = str_replace(',', '', $welfare);
                $newOwed    = str_replace(',', '', $welfareOwed);

                try {
                    // get members 
                    $members = DB::table('members')->where('deleted_at', null)->get();

                    // loop members 
                    if ($members->count() != 0) {
                        foreach ($members as $member) {
                            // if there is a match update else create
                            if ($member->name == $row[1]) {
                                // Member::where('name', $row[1])->update([
                                    // 'user_id'        => auth()->id(),
                                    // 'name'           => $row[1],
                                    // 'telephone'      => $newphone,
                                    // 'amount_before'  => $newbefore,
                                    // 'welfare_before' => $newwelfare,
                                    // 'welfareowed_before' => $newOwed,
                                // ]);
                            } else {
                                Member::firstOrCreate([
                                    'user_id'        => auth()->id(),
                                    'name'           => $row[1],
                                    'telephone'      => $newphone,
                                    'amount_before'  => $newbefore,
                                    'welfare_before' => $newwelfare,
                                    'welfareowed_before' => $newOwed,
                                ]);
                            }
                        }
                    } else {
                        Member::firstOrCreate([
                            'user_id'        => auth()->id(),
                            'name'           => $row[1],
                            'telephone'      => $newphone,
                            'amount_before'  => $newbefore,
                            'welfare_before' => $newwelfare,
                            'welfareowed_before' => $newOwed,
                        ]);
                    }
                    
                    
                } catch (Exception $e) {
                    // throw $e;
                    return $e->getMessage();
                    return 'My error message';
                }
            }
        }

        // update all if there are any!
        if ($cycles != 0) {
            $this->UpdateEverything($cycle);
        } else {
            // update finances
            $updateFinance = new FinancesController();
            $updateFinance->update();
        }
        
        // get all members 
        $members = Member::orderBy('created_at', 'desc')
                        ->get();

        return response()->json([$members, $message]);
    }

    public function UpdateEverything(Cycle $cycle) 
    {
        // update cycle & finances
        $update = new UpdateController();
        $update->updateEverything($cycle);
    }

    public function UpdateAll()
    {
        // update cycle & finances
        $update = new FinancesController();
        $update->update();
    }

    // API CALLS 
    public function getMember(Member $member) 
    {
        $member = Member::where('id', $member->id)
                        ->with('payments')
                        ->withCount('payments', 'welfares')
                        ->first();

        return [$member];
    }

    public function getMemberNew() 
    {
        $member = DB::table('members')->where('deleted_at', null)->orderBy('created_at', 'desc')
                        ->first();

        return [$member];
    }

    public function searchMembers($search) 
    {
        if ($search == 'search') {
            $members = Member::orderBy('created_at', 'desc')
                ->withCount('payments', 'welfares')
                ->get();
        } else {
            $members = Member::where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->withCount('payments', 'welfares')
                ->get();
        }
        
        return [$members];
    }

    public function getMembersOrder($to, $id)
    {

        $members = Member::orderBy($to, $id)
                        ->withCount('payments', 'welfares')
                        ->get();

        return [$members, $members->count()];
    }

    public function getMembersOrderPaginate($to, $id)
    {
        $members = Member::orderBy($to, $id)
                        ->withCount('payments', 'welfares')
                        ->paginate(10);

        return $members;
    }

    public function getMembersPays(Member $member, $to, $id)
    {
        $pays = Payment::where('member_id', $member->id)
                        ->orderBy($to, $id)
                        ->with('cycle')
                        ->get();

        $welfs = Welfare::where('member_id', $member->id)
                        ->orderBy($to, $id)
                        ->with('cycle')
                        ->get();

        $member = Member::where('id', $member->id)
                        ->withCount('payments', 'welfares')
                        ->first();

        // return $member;
        return [$pays, $welfs, $member];
    }

    public function getCyclePays(Member $member, Cycle $cycle) 
    {
        // return [$member, $cycle];
        $pays = Payment::where('member_id', $member->id)
                        ->where('cycle_id', $cycle->id)
                        ->count();
                        
        return $pays;
    }
}

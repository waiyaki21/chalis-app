<?php

namespace App\Exports;

use App\Models\Cycle;
use App\Models\Member;

use App\Models\Payment;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Exports\Helpers\ExcelStyles;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class MembersTemplate implements FromView, WithEvents, WithColumnWidths, WithStyles, WithProperties, ShouldAutoSize, WithColumnFormatting
{
    public function __construct()
    {

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function (AfterSheet $event) {
                $counts = DB::table('members')->where('deleted_at', null)->count();

                // columns are 4 from a - e 
                $startCol = 'A';
                $endCol   = 'F';

                //get rows
                $rowBody  = $counts + 1;
                $rowTotal = $counts + 3;

                $rowEndTotal    = $counts + 3;
                $rowEndBody     = $counts + 1;

                $startBody      = $startCol . '2';

                $endBody        = $endCol . $rowEndBody;

                $startTotal     = 'A' . $rowTotal;

                $endTotal       = 'F' . $rowEndTotal;

                $rangeBody      = $startBody . ':' . $endBody;
                $rangeTotal     = $startTotal . ':' . $endTotal;

                $rangeId        = 'A2:A' . $rowBody;

                // Get styles
                $styles = ExcelStyles::getExcelStyles();

                $cellRange0 = $rangeId;      // id
                $cellRange1 = 'A1:F1';       // header
                $cellRange2 = $rangeBody;    // body
                $cellRangeT = $rangeTotal;   // totals

                $event->sheet->getDelegate()->getStyle($cellRange0)->applyFromArray($styles['idStyle']);
                $event->sheet->getDelegate()->getStyle($cellRange1)->applyFromArray($styles['headerStyle']);
                $event->sheet->getDelegate()->getStyle($cellRange2)->applyFromArray($styles['allStyle']);
                $event->sheet->getDelegate()->getStyle($cellRangeT)->applyFromArray($styles['totalsStyle']);

                $event->sheet->getDelegate()->freezePane('C2'); // freezing here
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // sheet rows 
        $sheet->getColumnDimension('G')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('H')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('I')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('J')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('K')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('L')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('M')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('N')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('O')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('P')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('Q')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('R')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('S')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('T')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('U')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('V')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('W')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('X')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('Y')->setAutoSize(false)->setVisible(false)->setCollapsed(true);
        $sheet->getColumnDimension('Z')->setAutoSize(false)->setVisible(false)->setCollapsed(true);

        // get table headers
        $sheet->setCellValue("A1",  "No.");
        $sheet->setCellValue("B1",  "Members Name");
        $sheet->setCellValue("C1",  "Contact");
        $sheet->setCellValue("D1",  "Contributions B/F");
        $sheet->setCellValue("E1",  "Welfare B/F");
        $sheet->setCellValue("F1",  "Welfare Owed B/F");

        $sheet->getColumnDimension('A')->setCollapsed(false)->setVisible(true)->setWidth(5);
        $sheet->getColumnDimension('B')->setCollapsed(false)->setVisible(true)->setWidth(30);
        $sheet->getColumnDimension('C')->setCollapsed(false)->setVisible(true)->setWidth(15);
        $sheet->getColumnDimension('D')->setCollapsed(false)->setVisible(true)->setWidth(15);
        $sheet->getColumnDimension('E')->setCollapsed(false)->setVisible(true)->setWidth(15);
        $sheet->getColumnDimension('F')->setCollapsed(false)->setVisible(true)->setWidth(15);

        // get all members 
        $rows   = Member::where('deleted_at', null)->get();

        $numOfRows = $rows->count();
        $num       = $numOfRows + 1;
        $sumRow    = $numOfRows + 3;

        foreach ($rows as $index => $row) {
            // new row 
            $newRow = $index + 2;

            $sheet->setCellValue("A{$newRow}",  "$row->id");
            $sheet->setCellValue("B{$newRow}",  "$row->name");

            // telephone 
            if ($row->telephone != '') {
                $telephone = $row->telephone;
                $sheet->setCellValue("C{$newRow}",  "$telephone");
            }

            $sheet->setCellValue("D{$newRow}",  "$row->amount_before");
            $sheet->setCellValue("E{$newRow}",  "$row->welfare_before");

            // owed 
            if ($row->welfareowed_before != '') {
                $owed = '0';
                $sheet->setCellValue("F{$newRow}",  "$owed");
            } else {
                $sheet->setCellValue("F{$newRow}",  "$row->welfareowed_before");
            }
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => Auth::user()->name,
            'title'          => 'Add new members',
            'description'    => 'Use this sheet to add new members to the group',
            // 'subject'        => 'Subject Performance Breakdown',
            'company'        => Env('APP_NAME'),
        ];
    }

    public function view(): View
    {
        return view('exports.members_template');
    }
}

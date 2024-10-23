<?php

namespace App\Exports\Helpers; // Adjust the namespace according to your directory structure

use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelStyles
{
    public static function getExcelStyles()
    {
        return [
            'allStyle' => [
                'font' => [
                    'name' => 'Arial Narrow',
                    'color' => ['rgb' => '000000'],
                    'size' => 12,
                ]
            ],
            'headerStyle' => [
                'font' => [
                    'name' => 'Arial Narrow',
                    'size' => 12,
                    'underline' => true,
                    'bold' => true,
                    'alignment' => [
                        'horizontal' => 'right'
                    ]
                ]
            ],
            'idStyle' => [
                'font' => [
                    'name' => 'Arial Narrow',
                    'size' => 12,
                    'underline' => false,
                    'bold' => true,
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT
                    ]
                ]
            ],
            'highlightStyle' => [
                'font' => [
                    'name' => 'Arial Narrow',
                    'color' => ['rgb' => '002060'],
                    'size' => 12,
                ]
            ],
            'totalsStyle' => [
                'font' => [
                    'name' => 'Arial Narrow',
                    'size' => 12,
                    'bold' => false,
                    'underline' => true,
                ]
            ],
        ];
    }
}

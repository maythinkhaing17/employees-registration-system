<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class EmployeeMartialExport
 *
 * @author May Thin Khaing
 * @created 23/06/2023
 *
 * @return \Illuminate\Support\Collection
 */

class EmployeeMaritalExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    /**
     * Retrieve the collection of employee marital status for export.
     *
     * @author May Thin Khaing
     * @created 23/06/2023
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [
            [1, 'Single'],
            [2, 'Married'],
            [3, 'Divorced'],
        ];

        return new Collection($data);
    }

    /**
     * Retrieve the headings of employee marital status for export.
     *
     * @author May Thin Khaing
     * @created 23/06/2023
     *
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'ID', 'Marital Status'
        ];
    }
    
    /**
     * Apply styles to the worksheet for the employee martial status export.
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * 
     * @author May Thin Khaing
     * @created 23/06/2023
     *
     * @return void
     */

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the sheet

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);

        $sheet->getStyle('A1:B1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '00FF00'], // Green fill color code
            ],
            'font' => [
                'bold' => true,
                'italic' => true,
                'color' => ['rgb' => '000000'],
            ],
        ]);

        // Apply header styles
        $sheet->getStyle('A2:B2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'D3D3D3'],
            ],
        ]);

        // Apply cell styles
        $sheet->getStyle('A2:B' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    }

    /**
     * Get the title for the employee martial status export.
     *
     * @return string
     * 
     * @author May Thin Khaing
     * @created 23/06/2023
     */

    public function title(): string
    {
        return 'Marital Status';
    }
}

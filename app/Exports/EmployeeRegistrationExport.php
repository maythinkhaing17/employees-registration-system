<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Retrieve the collection of employee genders for export.
 *
 * @author May Thin Khaing
 * @created 23/06/2023
 *
 * @return \Illuminate\Support\Collection
 */

class EmployeeRegistrationExport implements WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    /**
     * Retrieve the headings of employee for employee registration export.
     *
     * @return string
     * 
     * @author May Thin Khaing
     * @created 23/06/2023
     */

    public function headings(): array
    {
        return ['Employee Code', 'Employee Name', 'NRC Number', 'Password', 'Email Address', 'Date of Birth', 'Gender', 'Marital Status', 'Address'];
    }
    /**
     * Apply styles to the worksheet for employee registration export.
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
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(150);
        $sheet->getColumnDimension('B')->setWidth(150);
        $sheet->getColumnDimension('C')->setWidth(250);
        $sheet->getColumnDimension('D')->setWidth(150);
        $sheet->getColumnDimension('E')->setWidth(150);
        $sheet->getColumnDimension('F')->setWidth(150);
        $sheet->getColumnDimension('G')->setWidth(150);
        $sheet->getColumnDimension('H')->setWidth(150);
        $sheet->getColumnDimension('I')->setWidth(150);

        // Apply header styles
        $sheet->getStyle('A1:F' . ($sheet->getHighestRow()))->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FF0000'], //Red Text Colour
            ],
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
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'C6EFCE'],
            ],
        ]);

        // Apply header styles
        $sheet->getStyle('G1:I' . ($sheet->getHighestRow()))->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'], // Black text color
            ],
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
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'C6EFCE'],
            ],
        ]);
    }

    /**
     * Get the title for employee registration export.
     *
     * @return string
     * 
     * @author May Thin Khaing
     * @created 23/06/2023
     */

    public function title(): string
    {
        return 'Employee Registration';
    }
}

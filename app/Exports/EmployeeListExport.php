<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class EmployeesListExport
 *
 * @author May Thin Khaing
 * @created 27/06/2023
 *
 */

class EmployeeListExport implements FromCollection, WithStyles, ShouldAutoSize, WithHeadings, WithColumnWidths
{
    private $employees;
    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    /** Retrieves a collection of employee data.
     * @author May Thin Khaing
     * @created 27/06/2023
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employees = collect($this->employees);

        return $employees->map(function ($employee, $key) {
            $gender = null;
            $maritalStatus = null;
            // $no = 1;
            if (!empty($employee->gender)) {
                $gender = $employee->gender == 1 ? 'Male' : 'Female';
            }
            if (!empty($employee->martial_status)) {
                $maritalStatus = $employee->martial_status == 'single' ? 'Single' : ($employee->martial_status == 'married' ? 'Married' : 'Divorced');
            }

            return [
                'No' => $key + 1,
                'Employee ID' => $employee->employee_id ?? null,
                'Employee Code' => $employee->employee_code ?? null,
                'Employee Name' => $employee->employee_name ?? null,
                'Email' => $employee->email_address ?? null,
                'NRC Number' => $employee->nrc_number ?? null,
                'Gender' =>  $gender,
                'Date of Birth'  => $employee->date_of_birth ?? null,
                'Marital Status' => $maritalStatus,
                'Address' => $employee->address ?? null,
            ];
        });
    }

    /**
     * Retrieve the headings for the employee list data.
     *
     * @author May Thin Khaing
     * @created 27/06/2023
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Employee ID',
            'Employee Code',
            'Employee Name',
            'Email',
            'NRC Number',
            'Gender',
            'Date of Birth',
            'Marital Status',
            'Address',
        ];
    }
    /**
     * Apply styles to the worksheet for the employee list data.
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * 
     * @author May Thin Khaing
     * @created 27/06/2023
     *
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // 1 => ['font' => ['bold' => true]],
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '000000']]
            ],
            'J' => ['alignment' => ['wrapText' => true]],
            'A:J' => ['alignment' => ['vertical' => 'center']],
            'A:J' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
    /**
     * Retrieves the column widths for the spreadsheet.
     * 
     * @author May Thin Khaing
     * @created 27/06/2023
     *
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 30,
            'E' => 25,
            'F' => 20,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 35,
        ];
    }
}

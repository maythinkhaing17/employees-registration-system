<?php

namespace App\Exports;

use App\Exports\EmployeeGenderExport;
use App\Exports\EmployeeMaritalExport;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\EmployeeRegistrationExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Class EmployeesExport
 *
 * @author May Thin Khaing
 * @created 23/06/2023
 *
 * @return \Illuminate\Support\Collection
 */

class EmployeesExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {
        $sheets = [
            new EmployeeRegistrationExport(),
            new EmployeeGenderExport(),
            new EmployeeMaritalExport(),
        ];
        return $sheets;
    }
}

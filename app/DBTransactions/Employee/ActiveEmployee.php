<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;

/**
 * To active employee
 *
 * @author May Thin Khaing
 * @created 26/06/2023
 *
 */
class ActiveEmployee extends DBTransaction
{
    private $employeeId;

    /**
     * Constructor to assign to variable
     *
     * @author May Thin Khaing
     * @created 26/06/2023
     * @param $employeeId
     *
     */
    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }
    /**
     * Process the deletion of an employee record.
     *
     * @author May Thin Khaing
     * @created 26/06/2023
     *
     */
    public function process()
    {
        $employeeId = $this->employeeId;

        $active = DB::table('employees')->where('employee_id', $employeeId)->update(['deleted_at' => null, 'updated_at' => now()]);
        
        # check record is affected or not
        if (!$active) {
            return ['status' => false];
        }
        return ['status' => true];
    }
}

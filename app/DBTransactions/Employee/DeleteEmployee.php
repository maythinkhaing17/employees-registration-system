<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;
use Illuminate\Support\Facades\File;

/**
 * Class DeteteEmployee
 *
 * @author May Thin Khaing
 * @created 26/06/2023
 *
 */
class DeleteEmployee extends DBTransaction
{
    private $employeeId;
    private $softDeleteFlag;

    /**
     * Process the deletion of an employee record.
     *
     * @author May Thin Khaing
     * @created 26/06/2023
     * @param $employeeId,$softDeleteFlag
     *
     */
    public function __construct($employeeId, $softDeleteFlag)
    {
        $this->employeeId = $employeeId;
        $this->softDeleteFlag = $softDeleteFlag;
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

        # get photo info of deleted employee
        $getPhoto = EmployeeUpload::where('employee_id', $employeeId)->value('file_path');

        # check delete flag is soft or force
        if ($this->softDeleteFlag == true) {
            $affected = Employee::where('employee_id', $employeeId)->delete();
        } else {
            $affected = Employee::where('employee_id', $employeeId)->forceDelete();
            EmployeeUpload::where('employee_id', $employeeId)->delete();
        }

        # check record is affected or not.
        if (!$affected) {
            return ['status' => false];
        } else {
            if ($getPhoto) {
                $this->removePhoto($getPhoto); # remove file path from public folder
            }
        }
        return ['status' => true];
    }

    /**
     * Remove file path form public folder.
     *
     * @author May Thin Khaing
     * @created 30/06/2023
     */
    public function removePhoto($path)
    {
        $filePath = public_path($path);
        # delete file path when upload process is fail
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}

<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

/**
 * Store Employee data and Employees Upload.
 *
 * @author  May Thin Khaing
 * @create  22/06/2023
 */
class SaveEmployee extends DBTransaction
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     *handling the registration process of a new employee and saving
     *
     * @author  May Thin Khaing
     * @create  22/06/2023
     */
    public function process()
    {
        $request = $this->request;
        # insert employee data
        $employee = new Employee();
        $employee->employee_id = $request->employeeId;
        $employee->employee_code = $request->employeeCode;
        $employee->employee_name = $request->employeeName;
        $employee->nrc_number = $request->nrcNumber;
        $employee->password = Hash::make($request->password);
        $employee->email_address = $request->email;
        $employee->gender = $request->gender;
        $employee->date_of_birth = $request->dob;
        $employee->martial_status = $request->maritalStatus;
        $employee->address = $request->address;
        $employee->save();

        # check photo is exit 
        if ($request->hasFile('photo')) {
            # Retrieve the employee ID
            $employeeId = $employee->employee_id;
            $image = $request->file('photo');

            # generate image name
            $fileExtension = $image->getClientOriginalExtension();
            $fileName = time() . '_' . $image->getClientOriginalName();
            $filePath = 'uploadFile/' . $fileName;
            # Get the file size in bytes
            $sizeInBytes = $image->getSize();
            # Move the uploaded file to the public folder
            $image->move(public_path('uploadFile'), $fileName);

            $empUpload = new EmployeeUpload();
            $empUpload->employee_id = $employeeId;
            $empUpload->file_path = $filePath;
            $empUpload->file_size = $sizeInBytes;
            $empUpload->file_extension = $fileExtension;
            $empUpload->save();

            # check photo upload process is not success
            if (!$empUpload) {
                $path = public_path($filePath);
                # delete file path when upload process is fail
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }
        # Check if both employee and employee upload were saved successfully
        if (!$employee) {
            return ['status' => false];
        }
        return ['status' => true];
    }
}

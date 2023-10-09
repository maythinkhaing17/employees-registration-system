<?php

namespace App\DBTransactions\Employee;

use App\Classes\DBTransaction;
use App\Models\EmployeeUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class UpdateEmployee extends DBTransaction
{
    private $employeeId;
    private $request;
    /**
     * Constructor to assign to variable
     *
     * @author May Thin Khaing
     * @created 30/06/2023
     * @param $employeeId, $request
     *
     */
    public function __construct($employeeId, $request)
    {
        $this->employeeId = $employeeId;
        $this->request = $request;
    }

    /**
     * Process the deletion of an employee record.
     *
     * @author May Thin Khaing
     * @created 30/06/2023
     *
     */
    public function process()
    {
        $employeeId = $this->employeeId;
        $request = $this->request;

        $newValues = [
            'employee_code' => $request['employeeCode'],
            'employee_name' => $request['employeeName'],
            'nrc_number' => $request['nrcNumber'],
            'email_address' => $request['email'],
            'gender' => $request['gender'],
            'date_of_birth' => $request['dob'],
            'martial_status' => $request['maritalStatus'],
            'address' => $request['address'],
            'updated_at' => now(),
        ];

        # Update the employee and employee uploads record in the database
        $empUpdate = DB::table('employees')->where('employee_id', $employeeId)->update($newValues);

        # Check if a new photo file has been uploaded
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            # generate image name
            $fileExtension = $photo->getClientOriginalExtension();
            $fileName = time() . '_' . $photo->getClientOriginalName();
            # Get the file size in bytes
            $sizeInBytes = $photo->getSize();
            $filePath = 'uploadFile/' . $fileName;

            # Move the uploaded file to the public folder
            $photo->move(public_path('uploadFile'), $fileName);

            # Update the photo file path in the database
            $newPhotoValues = [
                'employee_id' => $employeeId,
                'file_path' => $filePath,
                'file_size' => $sizeInBytes,
                'file_extension' => $fileExtension,
                'updated_at' => now()
            ];

            $checkPhoto = DB::table('employee_uploads')->where('employee_id', $employeeId)->value('file_path');

            if (!empty($checkPhoto)) {
                $this->removePhoto($checkPhoto); # remove file path from public folder

                $newPhoto = DB::table('employee_uploads')->where('employee_id', $employeeId)->update($newPhotoValues);
            } else {
                $newPhotoValues['created_at'] = now();
                $newPhoto = DB::table('employee_uploads')->insert($newPhotoValues);
            }

            # check process is success or not
            if (!$newPhoto) {
                $this->removePhoto($filePath);
                return ['status' => false, 'error' => 'Failed to update employee uploads.'];
            }
        } elseif (empty($request['hidden_file_path']) || $request['hidden_file_path'] == null) {
            # check photo is exists in database
            $checkPhoto = DB::table('employee_uploads')->where('employee_id', $employeeId)->value('file_path');

            # check photo is not exists
            if (!empty($checkPhoto)) {
                # delete photo from database
                $deletePhoto = EmployeeUpload::where('employee_id', $employeeId)->where('file_path', $checkPhoto)->delete();
                $this->removePhoto($checkPhoto); # remove file path from public folder
            }
        }

        # check employee update process is success or not
        if (!$empUpdate) {
            return ['status' => false, 'error' => 'Failed to updated.'];
        }
        return ['status' => true];
    }

    /**
     * Remove file path form public folder
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

<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Class EmployeeRegistrationImport
 * 
 * @author May Thin Khaing
 * @created 23/6/2023
 * 
 */
class EmployeeRegistrationImport implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        $rowCnts = $rows->count();
        # check excel rows is less than 0 or not
        if ($rowCnts == 0) {
            $errors[] = [
                'row' => '',
                'errors' => 'Please fill employees information.',
            ];
            $this->handleValidationErrors($errors);
        } elseif ($rows->count() > 100) { # check maximum row
            $errors[] = [
                'row' => '',
                'errors' => 'Exceeded maximum allowed rows (100)',
            ];
            $this->handleValidationErrors($errors);
        }
        $employeeRepo = new EmployeeRepository;
        $newEmpId = $employeeRepo->generateNewEmployeeId();

        $errors = [];
        $rowNo = 2;

        # prepare to save 
        foreach ($rows as $row) {
            if ($this->isEmployeeRegistrationSheet($row)) {
                $dateOfBirth = $row['date_of_birth'];
                $tempArray = $row->toArray();
                # check date of birth is numeric
                if (is_numeric($dateOfBirth)) {
                    $formattedDateOfBirth = Date::excelToDateTimeObject($dateOfBirth)->format('Y-m-d');
                    $tempArray['date_of_birth'] = $formattedDateOfBirth;
                }

                $validator = Validator::make($tempArray, $this->getValidationRules(), [], $this->attributeNames());

                # check validation is success or not
                if ($validator->fails()) {
                    $errorMessages = $validator->errors()->all();
                    $errors[] = [
                        'row' => $rowNo,
                        'errors' => $errorMessages,
                    ];
                    $rowNo++;
                    continue;
                } else {
                    DB::beginTransaction();
                    try {
                        $employee = Employee::create([
                            'employee_id' => $newEmpId,
                            'employee_code' => $row['employee_code'],
                            'employee_name' => $row['employee_name'],
                            'nrc_number' => $row['nrc_number'],
                            'password' => Hash::make($row['password']), // Hash the password
                            'email_address' => $row['email_address'],
                            'gender' => $row['gender'],
                            'date_of_birth' => $formattedDateOfBirth,
                            'martial_status' => $row['marital_status'],
                            'address' => $row['address'],
                        ]);
                        $employee->save();

                        $newEmpId++;

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::debug($e->getMessage() . ' in file ' . __FILE__ . ' on line ' . __LINE__);
                        return view('employees.create')->with('error_message', 'Fail to create employee');
                    }
                }
                $rowNo++;
            }
        }
        if (!empty($errors)) {
            $this->handleValidationErrors($errors);
        }
    }
    /**
     * all the required fields for a valid employee registration.
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     * @param array $row
     * @return bool
     */
    private function isEmployeeRegistrationSheet($row): bool
    {
        return isset($row['employee_code']) && isset($row['employee_name']) && isset($row['nrc_number'])
            && isset($row['password']) && isset($row['email_address']) && isset($row['gender'])
            && isset($row['date_of_birth']) && isset($row['marital_status']) && isset($row['address']);
    }
    /**
     * Retrieves the validation rules for an employee registration.
     * @author May Thin Khaing
     * @created 27/6/2023
     * 
     */
    private function getValidationRules(): array
    {
        return [
            'employee_code' => 'required|alpha_num',
            'employee_name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'nrc_number' => 'required|regex:/^[a-zA-Z0-9\/\(\)]+$/',
            'password' => [
                'required',
                'min:4',
                'max:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s:])([^\s]){4,8}$/'
            ],
            'email_address' => 'required|email|unique:employees,email_address',
            'gender' => 'nullable',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'marital_status' => 'nullable',
            'address' => 'nullable',
        ];
    }
    /**
     * Retrieves the attribute names for the employee registration fields.
     * @author May Thin Khaing
     * @created 27/6/2023
     * 
     */
    private function attributeNames(): array
    {
        return [
            'employee_code' => 'Employee Code',
            'employee_name' => 'Employee Name',
            'nrc_number' => 'NRC Number',
            'password' => 'Password',
            'email_address' => 'Email Address',
            'gender' => 'Gender',
            'date_of_birth' => 'Date of Birth',
            'martial_status' => 'Marital Status',
            'address' => 'Address',
        ];
    }
    /**
     * Handles validation errors by throwing a ValidationException.
     * @author May Thin Khaing
     * @created 27/6/2023
     * 
     */
    private function handleValidationErrors(array $errors): void
    {
        $exception = ValidationException::withMessages($errors);

        throw $exception;
    }
}

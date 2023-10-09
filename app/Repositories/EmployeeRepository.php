<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class EmployeeRepository
 * 
 * @author May Thin Khaing
 * @created 23/6/2023
 * 
 */
class EmployeeRepository implements EmployeeInterface
{
    use ResponseAPI;
    /**
     * Retrieves all employees with pagination.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function getAllEmployees()
    {
        $data = DB::table('employees')->paginate(20);
        return $data;
    }
    /**
     * Retrieves an employee by their ID.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function  getEmployeeById($employeeId)
    {
        $findId = Employee::where('employee_id', $employeeId)->exists();
        return $findId;
    }
    /**
     * Generates a new employee ID based on the maximum existing employee ID.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function generateNewEmployeeId()
    {
        $maxEmpId = DB::table('employees')->max('employee_id');
        // Log::info($maxEmpId);

        if ($maxEmpId) {
            $newEmpId = $maxEmpId + 1;
        } else {
            $newEmpId = 20001;
        }
        return $newEmpId;
    }
    /**
     * Search Query for EmployeeRegistration.
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function search($request)
    {
        $conditions = [];

        if ($request->filled('employeeId')) {
            $conditions[] = ['employee_id', $request->input('employeeId')];
        }

        if ($request->filled('employeeCode')) {
            $conditions[] = ['employee_code', $request->input('employeeCode')];
        }

        if ($request->filled('employeeName')) {
            $conditions[] = ['employee_name', 'LIKE', '%' . $request->input('employeeName') . '%'];
        }

        if ($request->filled('email')) {
            $conditions[] = ['email_address', 'LIKE', '%' . $request->input('email') . '%'];
        }

        $employees = DB::table('employees')->where($conditions)->paginate(20);

        return $employees->appends([
            'employeeId' => $request->employeeId,
            'employeeCode' => $request->employeeCode,
            'employeeName' => $request->employeeName,
            'email' => $request->email,
        ]);
    }
    /**
     * Search Query for EmployeeRegistration.
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function downloadEmployeeData($request)
    {
        $conditions = [];

        if ($request->filled('employeeId')) {
            $conditions[] = ['employee_id', $request->input('employeeId')];
        }

        if ($request->filled('employeeCode')) {
            $conditions[] = ['employee_code', $request->input('employeeCode')];
        }

        if ($request->filled('employeeName')) {
            $conditions[] = ['employee_name', 'LIKE', '%' . $request->input('employeeName') . '%'];
        }

        if ($request->filled('email')) {
            $conditions[] = ['email_address', 'LIKE', '%' . $request->input('email') . '%'];
        }

        $employees = DB::table('employees')->where($conditions)->get()->toArray();
        return $employees;
    }

    /**
     * Check employee id is exits in database or not
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function isEmployeeExists($employeeId)
    {
        $findId = DB::table('employees')->where('employee_id', $employeeId)->exists();
        return $findId;
    }

    /**
     * Get employee detail by employee id
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     */
    public function show($employeeId)
    {
        $details =  DB::table('employees')
            ->leftJoin('employee_uploads', 'employee_uploads.employee_id', '=', 'employees.employee_id')
            ->select('employees.*', 'employee_uploads.file_path')
            ->where('employees.employee_id', $employeeId)
            ->first();
        return $details;
    }

    /**
     * Get active employee data by employee id
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * @param   $employeeId
     */
    public function getActiveEmployeeById($employeeId)
    {
        $activeEmp =  DB::table('employees')
            ->leftJoin('employee_uploads', 'employee_uploads.employee_id', '=', 'employees.employee_id')
            ->select('employees.*', 'employee_uploads.file_path')
            ->where('employees.employee_id', $employeeId)
            ->whereNull('employees.deleted_at')
            ->first();
        return $activeEmp;
    }

    /**
     * Search employee data with paging
     * 
     * @author May Thin Khaing
     * @created 11/07/2023
     * @param   $employeeId
     */
    public function searchWithPaging($request, $page)
    {
        $conditions = [];

        if ($request->filled('employeeId')) {
            $conditions[] = ['employee_id', $request->input('employeeId')];
        }

        if ($request->filled('employeeCode')) {
            $conditions[] = ['employee_code', $request->input('employeeCode')];
        }

        if ($request->filled('employeeName')) {
            $conditions[] = ['employee_name', 'LIKE', '%' . $request->input('employeeName') . '%'];
        }

        if ($request->filled('email')) {
            $conditions[] = ['email_address', 'LIKE', '%' . $request->input('email') . '%'];
        }

        $employees = DB::table('employees')->where($conditions)->paginate(20, ['*'], 'page', $page);

        return $employees->appends([
            'employeeId' => $request->employeeId,
            'employeeCode' => $request->employeeCode,
            'employeeName' => $request->employeeName,
            'email' => $request->email,
        ]);
    }
}

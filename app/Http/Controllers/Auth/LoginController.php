<?php

namespace App\Http\Controllers\Auth;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Class LoginController
 * Handles user login functionality.
 *
 * @author May Thin Khaing
 * @created 21/06/2023
 */
class LoginController extends Controller
{
    /**
     * Display the login form.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023
     */
    public function showLoginForm()
    {
        return view('login');
    }
    /**
     * Handle the successful authentication and redirect the user accordingly.
     *
     * @author May Thin Khaing
     * @created 21/06/2023
     */
    protected function authenticated(Request $request)
    {
        $employeeId = $request->input('employee_id');
        # check employee Id is numeric or not
        if (is_numeric($employeeId)) {
            $employee = Employee::where('employee_id', $request->input('employee_id'))->first();
            if ($employee && Hash::check($request->input('password'), $employee->password)) {

                session()->put('employee', $employee);
                return redirect()->route('employees.search');
            } else {
                return redirect()->back()->with('error', 'Invalid Employee ID and Password.');
            }
        } else {
            return redirect()->back()->with('error', 'Employee ID must be an interger.');
        }
    }
    /**
     * Logout session.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023
     */
    public function logout()
    {
        Session::forget('employee');
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use App\Exports\EmployeeListExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Imports\EmployeeRegistrationImport;
use App\DBTransactions\Employee\SaveEmployee;
use Illuminate\Validation\ValidationException;
use App\DBTransactions\Employee\ActiveEmployee;
use App\DBTransactions\Employee\DeleteEmployee;
use App\DBTransactions\Employee\UpdateEmployee;
use App\Http\Requests\EmployeeValidationRequest;
use App\Http\Requests\EmployeeUpdateValidationRequest;

/**
 * for handling other CRUD operations on employee records
 *
 * @author May Thin Khaing
 * @created 21/6/2023
 */

class EmployeeController extends Controller
{
    use ResponseAPI;
    protected $employeeInterface;

    /**
     * Create a new instance of the class.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023 
     */

    public function __construct(EmployeeInterface $employeeInterface)
    {
        $this->employeeInterface = $employeeInterface;
    }

    /**
     * Display the employees list based on a search query.
     *
     * @author May Thin Khaing
     * @created 28/06/2023
     *
     */
    public function search(Request $request)
    {
        $employees = $this->employeeInterface->search($request);
        Session::put('search', $request->fullUrl());

        # check current page is greater than last page
        if ($employees->currentPage() > $employees->lastPage()) {
            $page = $employees->lastPage();
            $employees = $this->employeeInterface->searchWithPaging($request, $page);

            $errMsg = Session::get('error_message');
            $succMsg = Session::get('success_message');
            // Log::alert($errMsg);
            // Log::info($succMsg);

            // Clear a specific session variable
            Session::forget('error_message');
            Session::forget('success_message');

            // Check session
            if (isset($errMsg)) {
                return redirect()->to($request->fullUrlWithQuery(compact('page')))->with('error', $errMsg);
            } else {
                return redirect()->to($request->fullUrlWithQuery(compact('page')))->with('success', $succMsg);
            }
        }
        return view('employees.list', compact('employees'));
    }

    /**
     * Display a form for creating a new employee.
     * @author May Thin Khaing
     * @created 22/06/2023 
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $newId = $this->employeeInterface->generateNewEmployeeId();

        return view('employees.create', ['employee_id' => $newId]);
    }

    /**
     * Store employees data and employees upload files.
     * 
     * @author May Thin Khaing
     * @created 22/6/2023 
     * 
     * @param  \Illuminate\Http\Request\EmployeeValidationRequest $request
     * @return \Illuminate\Http\Response
     */

    public function store(EmployeeValidationRequest $request)
    {
        try {
            $save = new SaveEmployee($request);
            $save = $save->executeProcess();
            if ($save) {
                # generate new employee id 
                $newId = $this->employeeInterface->generateNewEmployeeId();

                return redirect()->back()->with([
                    'normal_success' => 'Employee created successfully',
                    'employee_id' => $newId
                ]);
            } else {
                return redirect()->back()->with('normal_error', 'Something went wrong');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . 'in file ' . __FILE__ . ' on line ' . __LINE__);
            return view('employees.create')->with('normal_error', 'Fail to save Employee Data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId)
    {
        $isEmpExist = $this->employeeInterface->isEmployeeExists($employeeId);
        # check employee is exists in database or not
        if (!$isEmpExist) {
            // Check success message session is exists or not
            if (!empty(Session::get('success_message'))) {
                Session::forget('success_message');
            }
            Session::put('error_message', 'This employee is no longer exist.');
            return redirect()->back()->with('error', 'This employee is no longer exist.');
        } else {
            $empDetail = $this->employeeInterface->show($employeeId);
            return view('employees.detail')->with('employee', $empDetail);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employeeId)
    {
        // dd(url()->previous());
        $homeUrl = Session::get('search');
        $employee = $this->employeeInterface->getEmployeeById($employeeId);
        # check employee is exists in database or not
        if (!$employee) {
            // Check success message session is exists or not
            if (!empty(Session::get('success_message'))) {
                Session::forget('success_message');
            }
            Session::put('error_message', 'Unable to edit this employee.');
            return redirect()->to($homeUrl)->with('error', 'Unable to edit this employee.');
        } else {
            $activeEmp = $this->employeeInterface->getActiveEmployeeById($employeeId);
            return view('employees.update')->with('employee', $activeEmp);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateValidationRequest $request, $employeeId)
    {
        $employee = $this->employeeInterface->getEmployeeById($employeeId);
        $search = Session::get('search');

        if (!$employee) {
            // Check success message session is exists or not
            if (!empty(Session::get('success_message'))) {
                Session::forget('success_message');
            }
            Session::put('error_message', 'Unable to update this employee.');
            return redirect()->to($search)->with('error', 'Unable to update this employee.');
        } else {
            $update = new UpdateEmployee($employeeId, $request);
            $update = $update->executeProcess();

            # check update process is success or not
            if ($update) {
                // Check error message session is exists or not
                if (!empty(Session::get('error_message'))) {
                    Session::forget('error_message');
                }
                Session::put('success_message', 'Employee updated successfully');
                return redirect()->to($search)->with('success', 'Employee updated successfully.');
            } else {
                // Check success message session is exists or not
                if (!empty(Session::get('success_message'))) {
                    Session::forget('success_message');
                }
                Session::put('error_message', 'Failed to update');
                return redirect()->to($search)->with('error', 'Failed to update.');
            }
        }
    }
    /**
     * Delete an employee record.
     *
     * @author May Thin Khaing
     * @created 26/06/2023
     *
     */
    public function destory($employeeId)
    {
        try {
            $employee = $this->employeeInterface->getEmployeeById($employeeId);

            if (!$employee) {
                // Check success message session is exists or not
                if (!empty(Session::get('success_message'))) {
                    Session::forget('success_message');
                }
                Session::put('error_message', 'The employee is already deleted.');
                return redirect()->back()->with('error', 'The employee is already deleted.');
            } else {
                // dd('dsada');
                if ($employeeId == '20001') {
                    return redirect()->route('employees.search')->with('error', 'This user not allow to delete');
                }
                $softDeleteFlag = false;
                $delete = new DeleteEmployee($employeeId, $softDeleteFlag);
                $delete = $delete->executeProcess();

                # check delete process is success or not
                if ($delete) {
                    // Check error message session is exists or not
                    if (!empty(Session::get('error_message'))) {
                        Session::forget('error_message');
                    }
                    Session::put('success_message', 'Employee deleted successfully');
                    return redirect()->back()->with('success', 'Employee deleted successfully');
                } else {
                    // Check success message session is exists or not
                    if (!empty(Session::get('success_message'))) {
                        Session::forget('success_message');
                    }
                    Session::put('error_message', 'Failed to delete');
                    return redirect()->back()->with('error', 'Failed to delete.');
                }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . 'in file ' . __FILE__ . ' on line ' . __LINE__);
            return redirect()->back()->with('error', 'Internal server error.');
        }
    }

    /**
     * Excel Export for EmployeeRegistration
     *
     * @author May Thin Khaing
     * @created 23/06/2023
     *
     * @return \Illuminate\Support\Collection
     */

    public function excelExport()
    {
        return Excel::download(new EmployeesExport, 'EmployeesRegistration.xlsx');
    }

    /**
     * Import EmployeeRegistration from Excel
     *
     * @author May Thin Khaing
     * @created 23/06/2023
     *
     * @return \Illuminate\Support\Collection
     */

    public function excelImport(Request $request)
    {
        # check validation
        $validator = Validator::make($request->all(), ['file' => 'required|file|mimes:xlsx']);
        # show error message when validation fail
        if ($validator->fails()) {
            return redirect()->back()->with('excel_error', 'Please select a valid excel file');
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        # Check file name
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

        # check valid name of excel file
        if (strpos($fileNameWithoutExtension, 'EmployeesRegistration') !== 0) {
            return redirect()->back()->with('excel_error', 'Please import a valid name of excel file.');
        }

        try {
            $file = $request->file('file');
            Excel::import(new EmployeeRegistrationImport, $file);

            return redirect()->back()->with('excel_success', 'Employee imported successfully.');
        } catch (ValidationException  $e) {
            # Validation failed, retrieve the error messages
            $errorMessages = $e->errors();
            if (!empty($errorMessages)) {
                $returnMessages = [];

                # prepare error message to show
                foreach ($errorMessages as $errorMessage) {
                    $rowNo = $errorMessage[0];
                    $messages = $errorMessage[1];

                    # check if array
                    if (is_array($messages)) {
                        // Log::info($messages);
                        // Log::info(implode(',', $messages));
                        foreach ($messages as $message) {
                            array_push($returnMessages, 'Row (' . $rowNo . ') ' . $message);
                        }
                    } else {
                        array_push($returnMessages, $messages);
                    }
                }

                return redirect()->back()->with('excel_error', $returnMessages);
            } else {
                return redirect()->back()->with('excel_error', 'Something is wrong!');
            }
        }
    }
    /**
     * Excel Download for EmployeeRegistration
     *
     * @author May Thin Khaing
     * @created 26/06/2023
     *
     */
    public function downloadExcel(Request $request)
    {
        $employees = $this->employeeInterface->downloadEmployeeData($request);
        if (!empty($employees)) {

            $export = new EmployeeListExport($employees);

            return Excel::download($export, 'search_results.xlsx');
        } else {
            return redirect()->back()->with('error', 'No employee data to download.');
        }
    }
    /**
     * Pdf Download for EmployeeRegistration
     *
     * @author May Thin Khaing
     * @created 30/06/2023
     *
     */
    public function downloadPdf(Request $request)
    {
        $employees = $this->employeeInterface->downloadEmployeeData($request);
        // check employee data is exists or not
        if (!empty($employees)) {
            $pdf = new Dompdf();

            $html = view('employees.downloadpdf', compact('employees'))->render();
            $pdf->loadHtml($html);

            // (Optional) Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // (Optional) Increase memory limit to avoid memory exhausted error
            ini_set('memory_limit', '512M');

            // Render the PDF
            $pdf->render();

            // Download the PDF file with a custom filename
            return $pdf->stream('employees.pdf');
        } else {
            return redirect()->back()->with('error', 'No employee data to download.');
        }
    }

    /**
     * Change inactive employee
     *
     * @author  May Thin Khaing
     * @create  28/06/2023
     * @param   $employeeId
     */
    public function inactive($employeeId)
    {
        $isEmpExist = $this->employeeInterface->getEmployeeById($employeeId);
        # check employee is exists in database or not
        if (!$isEmpExist) {
            // Check success message session is exists or not
            if (!empty(Session::get('success_message'))) {
                Session::forget('success_message');
            }
            Session::put('error_message', 'Unable to inactive this employee.');
            return redirect()->back()->with('error', 'Unable to inactive this employee.');
        } else {
            $softDeleteFlag = true;
            $delete = new DeleteEmployee($employeeId, $softDeleteFlag);
            $delete = $delete->executeProcess();
            # check delete proces is success or not
            if ($delete) {
                // Check error message session is exists or not
                if (!empty(Session::get('error_message'))) {
                    Session::forget('error_message');
                }
                Session::put('success_message', 'Employee inactived successfully.');
                return redirect()->back()->with('success', 'Employee inactived successfully.');
            } else {
                // Check success message session is exists or not
                if (!empty(Session::get('success_message'))) {
                    Session::forget('success_message');
                }
                Session::put('error_message', 'Failed to inactive.');
                return redirect()->back()->with('error', 'Failed to inactive.');
            }
        }
    }

    /**
     * Change active employee
     *
     * @author  May Thin Khaing
     * @create  28/06/2023
     * @param   $employeeId
     */
    public function active($employeeId)
    {
        $isEmpExist = $this->employeeInterface->isEmployeeExists($employeeId);
        # check employee is exists in database or not
        if (!$isEmpExist) {
            // Check success message session is exists or not
            if (!empty(Session::get('success_message'))) {
                Session::forget('success_message');
            }
            Session::put('error_message', 'Unable to active this employee.');
            return redirect()->back()->with('error', 'Unable to active this employee.');
        } else {
            $active = new ActiveEmployee($employeeId);
            $active = $active->executeProcess();
            # check active proces is success or not
            if ($active) {
                // Check error message session is exists or not
                if (!empty(Session::get('error_message'))) {
                    Session::forget('error_message');
                }
                Session::put('success_message', 'Employee inactived successfully.');
                return redirect()->back()->with('success', 'Employee actived successfully.');
            } else {
                // Check success message session is exists or not
                if (!empty(Session::get('success_message'))) {
                    Session::forget('success_message');
                }
                Session::put('error_message', 'Failed to inactive.');
                return redirect()->back()->with('error', 'Failed to actived.');
            }
        }
    }
}

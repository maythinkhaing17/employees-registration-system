<?php

namespace App\Interfaces;

interface EmployeeInterface
{
    /**
     * Retrieves all employees with pagination.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function getAllEmployees();

    /**
     * Retrieves an employee by their ID.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function getEmployeeById($id);

    /**
     * Generates a new employee ID based on the maximum existing employee ID.
     * 
     * @author May Thin Khaing
     * @created 23/6/2023
     * 
     */
    public function generateNewEmployeeId();

    /**
     * Check employee id is exits in database or not
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function isEmployeeExists($employeeId);

    /**
     * Get employee detail by employee id
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     */
    public function show($employeeId);

    /**
     * Get active employee data by employee id
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * @param   $employeeId
     */
    public function getActiveEmployeeById($employeeId);
    /**
     * Search Query for EmployeeRegistration.
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function downloadEmployeeData($request);

    /**
     * Search Query for EmployeeRegistration.
     * 
     * @author May Thin Khaing
     * @created 28/6/2023
     * 
     */
    public function search($request);

    /**
     * Search employee data with paging
     * 
     * @author May Thin Khaing
     * @created 11/07/2023
     * @param   $employeeId
     */
    public function searchWithPaging($request, $page);
}

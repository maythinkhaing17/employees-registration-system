<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class EmployeeSeeder
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 *
 */
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'employee_id' => '20001',
            'employee_code' => 'Emp_001',
            'employee_name' => 'Aye',
            'nrc_number' => '12/pathana(N)092193',
            'password' => Hash::make('mm123456'),
            'email_address' => 'a@gmail.com',
            'gender' => '1',
            'date_of_birth' => '2001/6/17',
            'martial_status' => '1',
            'address' => 'Yangon',
        ]);
    }
}

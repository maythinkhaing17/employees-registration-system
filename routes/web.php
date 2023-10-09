<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});


// Route for Login/Logout
Route::get('/login-form', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@authenticated')->name('authenticated');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


// Route Middleware Group
Route::middleware('auth.login')->group(function () {
    // Route for Employees 
    Route::get('/create', 'EmployeeController@create')->name('employees.create');
    Route::post('/store', 'EmployeeController@store')->name('employees.store');
    Route::get('/show/{employee_id}', 'EmployeeController@show')->name('employees.detail');
    Route::get('/edit/{employee_id}', 'EmployeeController@edit')->name('employees.edit');
    Route::put('/update/{employee_id}', 'EmployeeController@update')->name('employees.update');
    Route::delete('/delete/{employee_id}', 'EmployeeController@destory')->name('employees.delete');

    // Route for Excel Export and Import and Excel Download and Pdf Download
    Route::get('/excel-export-download', 'EmployeeController@excelExport')->name('employees.excel-export-download');
    Route::post('/excel-import-download', 'EmployeeController@excelImport')->name('employees.excel_import');
    Route::get('/excel-download', 'EmployeeController@downloadExcel')->name('employees.excel_download');
    Route::get('/pdf-download', 'EmployeeController@downloadPdf')->name('employees.pdf_download');

    // Route for Search
    Route::get('/employees', 'EmployeeController@search')->name('employees.search');

    //Route for Active and Inactive
    Route::patch('/active/{employee_id}', 'EmployeeController@active')->name('employees.active');
    Route::patch('/inactive/{employee_id}', 'EmployeeController@inactive')->name('employees.inactive');

    // Route For Language Change
    Route::get('language/switch/{locale}', 'LanguageController@switch')->name('language.switch');
});

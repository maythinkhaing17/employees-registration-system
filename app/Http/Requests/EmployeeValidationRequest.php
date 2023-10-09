<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation Request for Employee.
 * 
 * @author May Thin Khaing
 * @created 22/06/2023
 * 
 * @return bool
 */
class EmployeeValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @author May Thin Khaing
     * @created 22/06/2023
     * 
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @author May Thin Khaing
     * @created 22/06/2023
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'employeeCode' => 'required|alpha_num',
            'employeeName' => 'required|regex:/^[a-zA-Z\s]+$/',
            'nrcNumber' => 'required|regex:/^[a-zA-Z0-9\/\(\)]+$/',
            'password' => [
                'required',
                'min:4',
                'max:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s:])([^\s]){4,8}$/'
            ],
            'email' => 'required|email|unique:employees,email_address',
            'dob' => 'required|date|before_or_equal:today',
            'photo' => 'image|mimes:jpeg,png,jpg|max:10485760',
        ];
    }

    /**
     * Custom messages for the defined validation rules.
     * 
     * @author May Thin Khaing
     * @created 22/06/2023
     * 
     * @return array
     */

    public function messages()
    {
        return [
            'date_of_birth.before_or_equal' => 'The date of birth must be a date before or equal to the current date.',
        ];
    }
}

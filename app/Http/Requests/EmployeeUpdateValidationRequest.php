<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @author May Thin Khaing
     * @created 03/07/2023
     *
     */
    public function rules()
    {
        $employeeId = $this->route('employee_id'); // Assuming my route parameter is 'employee_id'

        return [
            'employeeCode' => 'required|alpha_num',
            'employeeName' => 'required|regex:/^[a-zA-Z\s]+$/',
            'nrcNumber' => 'required|regex:/^[a-zA-Z0-9\/\(\)]+$/',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email_address')->ignore($employeeId, 'employee_id'),
            ],
            'dob' => 'required|date|before_or_equal:today',
            'maritalStatus' => 'in:1,2,3',
            'photo' => 'image|mimes:jpeg,png,jpg|max:10485760',
        ];
    }

    /**
     * Custom messages for the defined validation rules.
     * 
     * @author May Thin Khaing
     * @created 03/07/2023
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.'
        ];
    }
}

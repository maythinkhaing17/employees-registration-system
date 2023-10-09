@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

@section('title')
Employee Detail
@endsection

@section('content')
<h1 class="text-center mt-5">{{ __('messages.Employee Registration Detail Form') }}</h1>
<br>

<div class="form-group w-75 mx-auto">
    <div class="text-center  w-75 mx-auto">
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div style="display: flex;" class="w-75">

                @if (isset($employee->file_path))
                <img src="{{ asset($employee->file_path) }}" alt="Employee Image" width="200">
                @else
                <img src="https://cdn-icons-png.flaticon.com/512/1876/1876904.png" alt="Default Image" width="200">
                @endif
            </div>
        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="employeeId">{{ __('messages.Employee ID') }}:</label>
            </div>
            <input type="text" class="form-control w-75" id="employeeId" name="employeeId" value="{{ $employee->employee_id }}" readonly>
        </div><br>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="employeeCode">{{ __('messages.Employee Code') }}:</label>
            </div>
            <input type="text" class="form-control w-75" id="employeeCode" name="employeeCode" value="{{ $employee->employee_code }}" readonly>
        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="employeeName">{{ __('messages.Employee Name') }}: </label>
            </div>
            <input type="text" class="form-control w-75" id="employeeName" name="employeeName" value="{{ $employee->employee_name }}" readonly>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="nrcNumber">{{ __('messages.NRC Number') }}:</label>
            </div>
            <input type="text" class="form-control w-75" id="nrcNumber" name="nrcNumber" value="{{ $employee->nrc_number }}" readonly>
        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="email">{{ __('messages.Email Address') }}: </label>
            </div>
            <input type="email" class="form-control w-75" id="email" name="email" value="{{ $employee->email_address }}" readonly>
        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <label>{{ __('messages.Gender') }}:</label>
            <div class="form-check-inline">
                <input type="radio" class="form-check-input w-60" id="male" name="gender" value="1" {{ $employee->gender == '1' ? 'checked' : '' }} disabled>
                <label for="male" class="form-check-label">Male</label>
            </div>
            <div class="form-check-inline">
                <input type="radio" class="form-check-input w-60" id="female" name="gender" value="2" {{ $employee->gender == '2' ? 'checked' : '' }} disabled>
                <label for="female" class="form-check-label">Female</label>
            </div>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <label for="martialStatus">{{ __('messages.Marital Status') }}:</label>
            @php
            if ($employee->martial_status == 1) {
            $maritalStatus = 'Single';
            } elseif ($employee->martial_status == 2) {
            $maritalStatus = 'Married';
            } else {
            $maritalStatus = 'Divorced';
            }
            @endphp
            <input type="text" class="form-control w-75" id="employeeCode" name="employeeCode" value="{{ $maritalStatus }}" readonly>

        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <div>
                <label for="dob">{{ __('messages.Date of Birth') }}:</label>
            </div>
            <input type="date" class="form-control w-75" id="dob" name="dob" value="{{ $employee->date_of_birth }}" readonly>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center">
            <label for="address">{{ __('messages.Address') }}:</label>
            <textarea class="form-control w-75" id="address" name="address" readonly>{{ $employee->address }}</textarea>
        </div>
    </div>
</div>
@endsection

</html>
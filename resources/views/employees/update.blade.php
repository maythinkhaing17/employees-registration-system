@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

@section('title')
Employee Update
@endsection

@section('styles')
<style>
    .red-text {
        color: red;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')

<h1 class="text-center mt-5">{{ __('messages.Employee Registration Update Form') }}</h1>
<br>

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="form-group w-75 mx-auto">
    <div class="text-center  w-75 mx-auto">
        <form class="w-75 mx-auto" action="{{ route('employees.update', $employee->employee_id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="employeeId">{{ __('messages.Employee ID') }}:<span class="red-text"> *</span></label>
                </div>
                <input type="text" class="form-control w-75" id="employeeId" name="employeeId" value="{{$employee->employee_id}}" readonly>
            </div><br>
            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="employeeCode">{{ __('messages.Employee Code') }}:<span class="red-text"> *</span></label>
                </div>
                <input type="text" class="form-control w-75" id="employeeCode" name="employeeCode" value="{{old('employeeCode', $employee->employee_code)}}">
            </div>
            @error('employeeCode')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>
            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="employeeName">{{ __('messages.Employee Name') }}:<span class="red-text"> *</span> </label>
                </div>
                <input type="text" class="form-control w-75" id="employeeName" name="employeeName" value="{{old('employeeName', $employee->employee_name) }}">
            </div>
            @error('employeeName')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="nrcNumber">{{ __('messages.NRC Number') }}:<span class="red-text"> *</span></label>
                </div>
                <input type="text" class="form-control w-75" id="nrcNumber" name="nrcNumber" value="{{old('nrcNumber', $employee->nrc_number) }}">
            </div>
            @error('nrcNumber')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="email">{{ __('messages.Email Address') }}: <span class="red-text"> *</span></label>
                </div>
                <input type="email" class="form-control w-75" id="email" name="email" value="{{old('email', $employee->email_address) }}">
            </div>
            @error('email')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <label>{{ __('messages.Gender') }}:</label>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input w-60" id="male" name="gender" value="1" {{ $employee->gender == '1' ? 'checked' : '' }}>
                    <label for="male" class="form-check-label">Male</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input w-60" id="female" name="gender" value="2" {{ $employee->gender == '2' ? 'checked' : '' }}>
                    <label for="female" class="form-check-label">Female</label>
                </div>
            </div>

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <label for="maritalStatus">{{ __('messages.Marital Status') }}</label>
                <select class="form-control w-75" name="maritalStatus" id="maritalStatus">
                    <option value="1" @if ($employee->martial_status == '1') selected @endif>Single</option>
                    <option value="2" @if ($employee->martial_status == '2') selected @endif>Married</option>
                    <option value="3" @if ($employee->martial_status == '3') selected @endif>Divorced</option>
                </select>
            </div>

            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <label for="address">{{ __('messages.Address') }}:</label>
                <textarea class="form-control w-75" id="address" name="address">{{old('address', $employee->address) }}</textarea>
            </div>
            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <div>
                    <label for="dob">{{ __('messages.Date of Birth') }}:<span class="red-text"> *</span></label>
                </div>
                <input type="date" class="form-control w-75" id="dob" name="dob" value="{{old('dob', $employee->date_of_birth) }}">
            </div>
            @error('dob')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>
            
            <div class="form-group d-flex justify-content-between my-3 align-items-center">
                <label for="photo">{{ __('messages.Upload File') }}:</label>
                <div style="display: flex;" class="w-75">
                    <input type="file" class="form-control-file w-75" id="photo" name="photo" value="{{ old('photo') }}">
                    <button type="button" class="btn btn-danger btn-sm" id="removePhoto">Remove</button>
                    <input type="hidden" name="hidden_file_path" id="hidden_file" value="{{ $employee->file_path }}">
                </div>
                <img id="photoPreview" src="{{ asset($employee->file_path) }}" class="object-fit-cover mx-2" alt="" style="width: 100px; height: 100px">
            </div>
            @error('photo')
            <div class="error" style="color: red;">{{ $message }}</div>
            @enderror <br>

            <div style="text-align: center w-75 mx-auto">
                <button type="submit" class="btn btn-primary">{{ __('messages.Update') }}</button>
            </div>
            <input type="hidden" name="previous" value="{{url()->previous()}}">
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');

    // Add an event listener to the file input
    fileInput.addEventListener('change', function(event) {
        // Get the selected file
        const file = event.target.files[0];

        // Check if a file is selected
        if (file) {
            // Create a FileReader object to read the file
            const reader = new FileReader();

            // Set the background image when the FileReader has finished reading the file
            reader.onload = function() {
                photoPreview.src = reader.result;
                photoPreview.style.display = 'block';
            };

            // Read the file as a Data URL
            reader.readAsDataURL(file);
        } else {
            // Reset the background image and hide the preview if no file is selected
            photoPreview.style.backgroundImage = '';
            photoPreview.style.display = 'none';
        }
    });

    // Optional: Add functionality to remove the photo
    document.getElementById('removePhoto').addEventListener('click', function() {
        document.getElementById('photo').value = '';
        document.getElementById('hidden_file').value = '';
        photoPreview.style.backgroundImage = '';
        photoPreview.style.display = 'none';
    });
</script>

@endsection
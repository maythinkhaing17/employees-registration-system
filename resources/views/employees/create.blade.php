@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

@section('title')
Create Employee
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

    .right-align {
        text-align: right;
    }

    .input-group-text {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
        cursor: pointer;
    }

    .input-group-text:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style>
@endsection

@section('content')

<h1 class="text-center mt-5">{{ __('messages.Employee Registration System') }}</h1>
<br>

<div class="form-group">
    <div id="messageSection">

        {{-- Normal Errors Section --}}
        @if (session('normal_success'))
        <div class="alert alert-success">
            {{ session('normal_success') }}
        </div>
        @endif
        @if (session('normal_error'))
        <div class="alert alert-danger">
            {{ session('normal_error') }}
        </div>
        @endif

        {{-- Excel Errors Section --}}
        @if (session('excel_success'))
        <div class="alert alert-success" id="successId">
            {{ session('excel_success') }}
        </div>
        @endif
        @if (session('excel_error'))
        <div class="alert alert-danger" id="errorId">
            @if (is_array(session('excel_error')))
            {!! implode('<br>', session('excel_error')) !!}
            @else
            {{ session('excel_error') }}
            @endif
        </div>
        @endif
    </div>
</div>

<div class="text-center w-75 mx-auto">
    <div class="form-check-inline">
        <input type="radio" class="form-check-input" id="normalRegister" name="registrationType" value="normal">
        <label class="form-check-label" for="normalRegister">{{ __('messages.Normal Register') }}</label>
    </div>
    <div class="form-check-inline">
        <input type="radio" class="form-check-input" id="excelUploadRegister" name="registrationType" value="excel" {{ old('registrationType') == 'excel' ? 'checked' : '' }}>
        <label class="form-check-label" for="excelUploadRegister">{{ __('messages.Excel Register') }}</label>
    </div>
</div>

<!-- Normal Register Form -->
<div id="normalRegisterForm">
    <form class="w-75 mx-auto" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="register">
        @csrf
        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="employeeId">{{ __('messages.Employee ID') }}: <span class="red-text">*</span></label>
            </div>
            <input type="text" class="form-control w-75" id="employeeId" name="employeeId" value="{{ isset($employee_id) ? $employee_id : '' }}" readonly>
        </div><br>
        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="employeeCode">{{ __('messages.Employee Code') }}:<span class="red-text"> *</span></label>
            </div>
            <div class="form-group w-75">
                <input type="text" class="form-control" id="employeeCode" name="employeeCode" value="{{ old('employeeCode') }}">
                @error('employeeCode')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="employeeName">{{ __('messages.Employee Name') }}:<span class="red-text"> *</span></label>
            </div>
            <div class="form-group w-75">
                <input type="text" class="form-control" id="employeeName" name="employeeName" value="{{ old('employeeName') }}">
                @error('employeeName')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="nrcNumber">{{ __('messages.NRC Number') }}:<span class="red-text"> *</span></label>
            </div>
            <div class="form-group w-75">
                <input type="text" class="form-control" id="nrcNumber" name="nrcNumber" value="{{ old('nrcNumber') }}">
                @error('nrcNumber')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>

        <div class="form-group password-toggle d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="password">{{ __('messages.Password') }}:<span class="red-text"> *</span></label>
            </div>
            <div class="w-75">
                <div class="input-group">
                    <input type="password" class="form-control " id="password" name="password" value="{{ old('password') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" id="toggle-password" onclick="togglePasswordVisibility()">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <button class="" type="button" id="generatePasswordBtn" style="background-color: rgb(50, 126, 239); color: white;">{{ __('messages.Generate Password') }}</button>
                </div>

                @error('password')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror
            </div>
        </div><br>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="email">{{ __('messages.Email Address') }}: <span class="red-text"> *</span></label>
            </div>
            <div class="form-group w-75">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <label>{{ __('messages.Gender') }}:</label>
            <div class="w-75 d-flex gap-5">
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="male" name="gender" value="1" {{ old('gender')== '1' ? 'checked' : '' }}>
                    <label for="male" class="form-check-label">{{ __('messages.Male') }}</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="female" name="gender" value="2" {{ old('gender')== '2' ? 'checked' : '' }}>
                    <label for="female" class="form-check-label">{{ __('messages.Female') }}</label>
                </div>
            </div>
        </div><br>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <label for="maritalStatus">{{ __('messages.Marital Status') }}:</label>
            <select class="form-control w-75" id="maritalStatus" name="maritalStatus" value="{{ old('maritalStatus') }}">
                <option value="1">Single</option>
                <option value="2">Married</option>
                <option value="3">Divorced</option>
            </select>
        </div><br>

        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <label for="address">{{ __('messages.Address') }}:</label>
            <textarea class="form-control w-75" id="address" name="address">{{ old('address') }}</textarea>
        </div><br>
        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <div>
                <label for="dob">{{ __('messages.Date of Birth') }}:<span class="red-text"> *</span></label>
            </div>
            <div class="form-group w-75">
                <input type="date" class="form-control w-75" id="dob" name="dob" value="{{ old('dob') }}">
                @error('dob')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>


        <div class="form-group d-flex justify-content-between my-3 align-items-center w-75 mx-auto">
            <label for="photo">{{ __('messages.Upload File') }}:</label>
            <div class="form-group w-75">
                <input type="file" class="form-control-file w-75" id="photo" name="photo" value="{{ old('photo') }}">
                <button type="button" class="btn btn-danger btn-sm" id="removePhoto">
                    {{ __('messages.Remove') }}</button>
                @error('photo')
                <div class="error" style="color: red;">{{ $message }}</div>
                @enderror <br>
            </div>
        </div>
        <div class="form-group d-flex justify-content-between my-3 align-items-center  w-75 mx-auto">
            <img id="photoPreview" src="" class="object-fit-cover" alt="Photo Preview" style="display: none; width: 100px; height: 100px;">
        </div>
        <div class="text-center w-75 mx-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i>{{ __('messages.Save') }}</button>
        </div>
    </form>
</div>

<!-- Excel Upload Form -->
<div id="excelUploadForm" style="display: none;">
    <div class="form-group align-items-center w-75 mx-auto">
        <div class="form-group right-align">
            <a href="{{ route('employees.excel-export-download') }}" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i>
                {{ __('messages.Excel Export Format') }}
            </a>
        </div><br>
        <div>
            <form action="{{ route('employees.excel_import') }}" method="POST" enctype="multipart/form-data" id="upload">
                @csrf
                <div class="form-group align-items-center w-75 mx-auto">
                    <label for="file" class="form-label">{{ __('messages.Choose Excel File') }}</label>
                    <div class="input-group">
                        <input type="file" name="file" id="file" class="form-control">
                        <label class="btn btn-primary" for="file">
                            <i class="bi bi-file-arrow-up"></i> {{ __('messages.Upload File') }}
                        </label>
                    </div>
                </div>
                <br><br><br>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-save-fill"></i>
                        {{ __('messages.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var radioBtn = document.getElementById('normalRegister');
        radioBtn.checked = true;
        showNormalRegisterForm();

        // Check if there is an error message
        var errorMessage = document.querySelector('#errorId');
        var successMessage = document.querySelector('#successId');
        if (errorMessage || successMessage ) {
            var radioBtnError = document.getElementById('excelUploadRegister');
            radioBtnError.checked = true;
            showExcelUploadForm();
        } else {
            showNormalRegisterForm();
        }
    };
    // Get references to the radio buttons and form sections
    const normalRegisterRadio = document.getElementById('normalRegister');
    const excelUploadRegisterRadio = document.getElementById('excelUploadRegister');
    const normalRegisterForm = document.getElementById('normalRegisterForm');
    const excelUploadForm = document.getElementById('excelUploadForm');
    const errorMessage = document.getElementById("messageSection");

    // Add event listeners to the radio buttons
    normalRegisterRadio.addEventListener('change', showNormalRegisterForm);
    excelUploadRegisterRadio.addEventListener('change', showExcelUploadForm);
    normalRegisterRadio.addEventListener("change", clearErrorMessage);
    excelUploadRegisterRadio.addEventListener("change", clearErrorMessage);

    // Show the normal register form initially
    showNormalRegisterForm();

    // Function to show the normal register form
    function showNormalRegisterForm() {

        normalRegisterForm.style.display = 'block';
        excelUploadForm.style.display = 'none';
        excelUploadRegisterRadio.checked = false;
        normalRegisterRadio.checked = true;
    }

    // Function to show the excel upload section
    function showExcelUploadForm() {
        normalRegisterForm.style.display = 'none';
        excelUploadForm.style.display = 'block';
        excelUploadRegisterRadio.checked = true;
        normalRegisterRadio.checked = false;
    }

    // Function to clear the error message
    function clearErrorMessage() {
        errorMessage.textContent = ""; // Clear the error message text
    }
</script>

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
        photoPreview.style.backgroundImage = '';
        photoPreview.style.display = 'none';
    });
</script>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var passwordIcon = document.getElementById("password-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.remove("fa-eye");
            passwordIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove("fa-eye-slash");
            passwordIcon.classList.add("fa-eye");
        }
    }


    document.getElementById("generatePasswordBtn").addEventListener("click", function() {
        var length = 8;
        var capitalLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var smallLetters = "abcdefghijklmnopqrstuvwxyz";
        var numbers = "0123456789";
        var specialChars = "!@#$%^&*(),.?:;<=>@+_";

        var password = "";
        password += capitalLetters.charAt(Math.floor(Math.random() * capitalLetters.length));
        password += smallLetters.charAt(Math.floor(Math.random() * smallLetters.length));
        password += numbers.charAt(Math.floor(Math.random() * numbers.length));
        password += specialChars.charAt(Math.floor(Math.random() * specialChars.length));

        var remainingLength = length - 4;

        for (var i = 0; i < remainingLength; i++) {
            var characters = capitalLetters + smallLetters + numbers + specialChars;
            password += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        // Shuffle the password to ensure randomness
        password = password.split('').sort(function() {
            return 0.5 - Math.random()
        }).join('');

        // document.getElementById("password").value = password;
        var passwordInput = document.getElementById("password");
        passwordInput.value = password;
        passwordInput.type = "password";
        document.getElementById("passwordError").textContent = "";
    });
</script>

@endsection
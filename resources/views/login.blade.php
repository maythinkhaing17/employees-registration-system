<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('header')
    @yield('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('https://image.slidesdocs.com/responsive-images/background/line-professional-frame-blue-square-shape-business-powerpoint-background_9c874dd0f4__960_540.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 400px;
            padding: 30px;
            border: none;
            border-radius: 10px;
            /* background-color: rgb(197, 224, 245); */
            background-color: rgb(166, 213, 246);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-group .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
        }

        .form-group .eye-icon:hover {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('messages.Login') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('authenticated') }}">
                    @csrf
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="employee_id">{{ __('messages.Employee ID') }}</label>
                        <input id="employee_id" type="text"
                            class="form-control @error('employee_id') is-invalid @enderror" name="employee_id"
                            value="{{ old('employee_id') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('messages.Password') }}</label>
                        <div class="position-relative">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required>
                            <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('messages.Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>

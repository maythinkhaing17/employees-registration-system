<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('https://img.freepik.com/free-vector/blue-curve-background_53876-113112.jpg?w=2000');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .txt-white {
            color: white !important;
        }
    </style>

    @yield('styles')

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand txt-white" href="{{ route('employees.search') }}">{{ __('messages.Employee Registration System') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown" style="display: flex; justify-content: flex-end;">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active txt-white" aria-current="page" href="{{ route('employees.create') }}">{{ __('messages.Register') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link txt-white" href="{{ route('employees.search') }}">{{ __('messages.List') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle txt-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.Language') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'mm') }}">{{ __('messages.Myanmar') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item text-right">
                        <a class="nav-link txt-white" href="{{ route('logout') }}">{{ __('messages.Logout') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br><br>

    @yield('content')

    @yield('footer')

</body>

</html>
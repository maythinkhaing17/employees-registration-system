@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

@section('title')
    Employee List
@endsection

@section('header')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>

    </style>
@endsection

@section('content')

    <body style="background-color: #e1f5fe">

        <h2 style="text-align:center">{{ __('messages.Employee List') }}</h2><br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (isset($error_message))
            <div class="alert alert-danger">
                {{ $error_message }}
            </div>
        @endif
        <form method="GET" action="" id="employeeForm">
            <div style="display: flex; justify-content: center;">
                <div style="margin-right: 10px;">
                    <label for="employeeId">{{ __('messages.Employee ID') }}:</label>
                    <input type="text" class="form-control" id="employeeId" name="employeeId"
                        value="{{ Request::input('employeeId') }}">
                </div>
                <div>
                    <label for="employeeCode">{{ __('messages.Employee Code') }}:</label>
                    <input type="text" class="form-control" id="employeeCode" name="employeeCode"
                        value="{{ Request::input('employeeCode') }}">
                </div>
            </div>

            <div style="display: flex; justify-content: center;">
                <div style="margin-right: 10px;">
                    <label for="employeeName">{{ __('messages.Employee Name') }}:</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName"
                        value="{{ Request::input('employeeName') }}">
                </div>
                <div>
                    <label for="email">{{ __('messages.Employee Email') }}:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ Request::input('email') }}">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: center" class="gap-5">
                <div>
                    <button onclick="searchEmployees()" class="btn btn-primary">
                        <i class="bi bi-search"></i>&nbsp;{{ __('messages.Search') }}</button>
                </div>
                <div>
                    <button onclick="downloadPDF()" class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf-fill"></i>&nbsp;{{ __('messages.PDF Download') }}</button>
                </div>
                <div>
                    <button onclick="downloadExcel()" class="btn btn-primary">
                        <i class="bi bi-file-earmark-excel-fill"></i>&nbsp;{{ __('messages.Excel Download') }}</button>
                </div>
            </div>

        </form>
        <br><br>

        <div class="card">
            <div class="card-body">
                <br>
                @if (isset($employees))
                    @php
                        $totalRows = $employees->toArray()['total'];
                    @endphp
                    <div class="total-rows" style="text-align: right; color: darkblue; font-weight: bold;">
                        <span class="label">Total Rows:</span>
                        <span class="count">{{ $totalRows }} rows</span>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        @if ($employees->isEmpty())
                            <div class="text" style="text-align: center; color: red; font-weight:bold;">
                                {{ __('messages.Employee data not found') }}.</div>
                        @else
                            <table class="table table-striped table-bordered">
                                <thead class="thead-style">
                                    <tr>
                                        <th rowspan="2" class="text-center" style="font-size: 18;">
                                            {{ __('messages.No') }}
                                        </th>
                                        <th rowspan="2" class="text-center" style="font-size: 18;">
                                            {{ __('messages.Employee ID') }}
                                        </th>
                                        <th rowspan="2" class="text-center" style="font-size: 18;">
                                            {{ __('messages.Employee Code') }}
                                        </th>
                                        <th rowspan="2" class="text-center" style="font-size: 18;">
                                            {{ __('messages.Employee Name') }}
                                        </th>
                                        <th rowspan="2" class="text-center" style="font-size: 18;">
                                            {{ __('messages.Email Address') }}
                                        </th>
                                        <th colspan="4" class="text-center" style="font-size: 18;">
                                            {{ __('messages.Action') }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="font-size: 18;">{{ __('messages.Edit') }}</th>
                                        <th class="text-center" style="font-size: 18;">{{ __('messages.Detail') }}</th>
                                        <th class="text-center" style="font-size: 18;">{{ __('messages.Active/Inactive') }}
                                        </th>
                                        <th class="text-center" style="font-size: 18;">{{ __('messages.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td class="text-center">{{ $no }}</td>
                                            <td class="text-center">{{ $employee->employee_id }}</td>
                                            <td class="text-center">{{ $employee->employee_code }}</td>
                                            <td class="text-center">{{ $employee->employee_name }}</td>
                                            <td class="text-center">{{ $employee->email_address }}</td>

                                            <td class="text-center">
                                                @if ($employee->deleted_at)
                                                    <button class="btn btn-secondary" disabled><i
                                                            class="fas fa-edit"></i></button>
                                                @else
                                                    <form action="{{ route('employees.edit', $employee->employee_id) }}"
                                                        method="GET">
                                                        <input type="" name="page"
                                                            value="{{ request()->page ?? 1 }}" hidden>
                                                        <button type="submit" class="btn btn-success"><i
                                                                class="fas fa-edit"></i></button>
                                                @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('employees.detail', $employee->employee_id) }}"
                                                    class="btn btn-primary"><i class="bi bi-info-circle-fill"></i></a>
                                            </td>
                                            <td class="text-center">
                                                @if ($employee->deleted_at)
                                                    <form action="{{ route('employees.active', $employee->employee_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure want to active?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-secondary" type="submit">Inactive</button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('employees.inactive', $employee->employee_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure want to inactive?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-warning" type="submit">Active</button>
                                                    </form>
                                                @endif
                                            </td>
                                            
                                            <td class="text-center">
                                                <form action="{{ route('employees.delete', $employee->employee_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    @if ($employee->deleted_at)
                                                        <button class="btn btn-danger" type="submit" disabled><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    @else
                                                        <button class="btn btn-danger" type="submit"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $employees->links() }}

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection

<script>
    function searchEmployees() {
        document.getElementById('employeeForm').action = "{{ route('employees.search') }}";
        document.getElementById('employeeForm').submit();
    }

    function downloadExcel() {
        document.getElementById('employeeForm').action = "{{ route('employees.excel_download') }}";
        document.getElementById('employeeForm').submit();
    }

    function downloadPDF() {
        document.getElementById('employeeForm').action = "{{ route('employees.pdf_download') }}";
        document.getElementById('employeeForm').submit();
    }
</script>

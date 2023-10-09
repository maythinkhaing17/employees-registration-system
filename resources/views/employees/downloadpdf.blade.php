<!DOCTYPE html>
<html>

<head>
    <title>Employee List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }
        .address {
            max-width: 200px;
            /* Adjust the value as needed */
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <h1>Employee List</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Employee ID</th>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>NRC Number</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Matial Status</th>
                <th>Address</th>
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
                    <td class="text-center">{{ $employee->nrc_number }}</td>
                    <td class="text-center">
                        @if ($employee->gender == 1)
                            Male
                        @else
                            Female
                        @endif
                    </td>
                    <td class="text-center">{{ $employee->date_of_birth }}</td>
                    <td class="text-center">
                        @if ($employee->martial_status == 'single')
                            Single
                        @elseif ($employee->martial_status == 'married')
                            Married
                        @else
                            Divorced
                        @endif
                    </td>
                    <td class="address text-center" >{{ $employee->address }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>

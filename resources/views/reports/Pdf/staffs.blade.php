<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header {
            width: 100%;
            border-collapse: collapse;
        }

        .report-header td {
            border: 0px solid #000;
        }

        .left-container,
        .right-container {
            vertical-align: top;
        }

        .left-container p,
        .right-container p {
            margin: 0;
        }

        .left-container {
            text-align: left;
        }

        .right-container {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Staff Report</h2>
        <table class="report-header">
            <tr>
                <td class="left-container">
                    @if (isset($from))
                        <p><strong>From date:</strong> {{ $from }}</p>
                    @endif
                    @if (isset($to))
                        <p><strong>To date:</strong> {{ $to }}</p>
                    @endif
                </td>
                <td class="right-container">
                    @if (isset($type))
                        <p>Type: {{ $type }}</p>
                    @endif
                    @if (isset($total))
                        <p><strong>Total:</strong> {{ number_format($total) }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Name</th>
                <th>Labour Number</th>
                <th>Working Days</th>
                <th>Total Labour Payment</th>
                <th>Salary / Rate per Day</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($staffs) && !$staffs->isEmpty())
                @foreach ($staffs as $key => $item)
                    @php
                        $joiningDate = $item->joining_date ? \Carbon\Carbon::parse($item->joining_date) : null;
                        $resignDate = $item->resign_date
                            ? \Carbon\Carbon::parse($item->resign_date)
                            : \Carbon\Carbon::now();
                        $workingDays = $joiningDate ? $joiningDate->diffInDays($resignDate) : 0;
                        $totalLabourPayment = $workingDays * $item->labour_number * $item->rate_per_day;
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->type == 1 ? 'Salaried' : 'On demand' }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->labour_number }}</td>
                        <td>{{ $workingDays }}</td>
                        <td>{{ $totalLabourPayment }}</td>
                        <td>{{ $item->type == 1 ? $item->salary : $item->rate_per_day }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>

<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Role</th>
            <th>Name</th>
            <th>Labour Number</th>
            <th>Labour Working Days</th>
            <th>Total Labour Payment</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Salary / Daily Wages</th>
            <th>Joining Date</th>
            <th>Resign Date</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($staffs) && !$staffs->isEmpty())
            @foreach ($staffs as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->type == 1 ? 'Salaried' : 'On demand' }}</td>
                    <td>{{ $item->role }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->labour_number }}</td>
                    <td>{{ $item->working_days }}</td>
                    <td>{{ $item->total_labour_payment }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->type == 1 ? $item->salary : $item->rate_per_day }}</td>
                    <td>{{ $item->joining_date ? date('d-m-Y', strtotime($item->joining_date)) : '' }}</td>
                    <td>{{ $item->resign_date ? date('d-m-Y', strtotime($item->resign_date)) : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Type</th>
            <th>Role</th>
            <th>Name</th>
            <th>labour Number</th>
            <th>labour Working Days</th>
            <th>Total labour Payment</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Salary / Daily wages</th>
            <th>Joining Date</th>
            <th>Resign Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        @if (isset($staffs) && !$staffs->isEmpty())
            @foreach ($staffs as $key => $item)
                <tr class="tr-{{ $item->id }}">
                    <td>{{ $key + 1 }}</td>
                    <td> <img src="{{ asset('uploads/staffs/' . $item->image) }}" alt="" width="50"></td>
                    <td>{{ $item->type == 1 ? 'Salaried' : 'On demand' }}</td>
                    <td>{{ $item->role }}</td>
                    <td>
                        @if ($item->is_leader == 1)
                            {{-- <a href="{{ route('staff.teams', $item->id) }}"> {{ $item->name }} </a> --}}
                            {{ $item->name }}
                        @else
                            {{ $item->name }}
                        @endif
                    </td>
                    {{-- <td>
                        {{ $item->name }}
                    </td> --}}
                    @php
                        $joiningDate = $item->joining_date ? \Carbon\Carbon::parse($item->joining_date) : null;
                        $resignDate = $item->resign_date
                            ? \Carbon\Carbon::parse($item->resign_date)
                            : \Carbon\Carbon::now();
                        $workingDays = $joiningDate ? $joiningDate->diffInDays($resignDate) : 0;
                        $totalLabourPayment = $workingDays * $item->labour_number * $item->rate_per_day;
                    @endphp

                    <td>{{ $item->labour_number }}</td>
                    <td>{{ $workingDays }}</td>
                    <td>{{ $totalLabourPayment }}</td>


                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->type == 1 ? $item->salary : $item->rate_per_day }}</td>
                    <td>{{ $item->joining_date != null ? date('d-m-Y', strtotime($item->joining_date)) : '' }}</td>
                    <td>{{ $item->resign_date != null ? date('d-m-Y', strtotime($item->resign_date)) : '' }}</td>
                    <td>
                        @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('staffs-edit'))
                            <a href="{{ route('staffs.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i
                                    class="fa fa-pen text-primary mr-2"></i> </a>
                        @endif
                        @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('staffs-delete'))
                            <a href="javascript:;" class="delete-staffs" data-id="{{ $item->id }}"
                                data-route="{{ route('staffs.destroy', $item->id) }}" data-toggle="tooltip"
                                title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

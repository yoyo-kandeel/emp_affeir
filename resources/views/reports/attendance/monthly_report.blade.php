@extends('layouts.master')
@section('title','تقرير الحضور الشهري')

@section('content')
<h3>تقرير الحضور من {{ $fromDate->toDateString() }} إلى {{ $toDate->toDateString() }}</h3>

<table id="monthly_table" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>اسم الموظف</th>
            <th>عدد ساعات العمل</th>
            <th>التأخير الكلي بالدقائق</th>
            <th>أيام الغياب</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report as $r)
        <tr>
            <td>{{ $r['employee_name'] }}</td>
            <td>{{ $r['total_hours'] }}</td>
            <td>{{ $r['total_late_minutes'] }}</td>
            <td>{{ $r['absent_days'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

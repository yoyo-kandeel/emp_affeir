@extends('layouts.master')
@section('title','تقرير الحضور حسب الفترة')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<h4>تقرير الحضور من {{ $fromDate->toDateString() }} إلى {{ $toDate->toDateString() }}</h4>

<!-- أزرار الطباعة و Excel -->
<form method="POST" action="{{ route('attendance.report.results') }}" class="mb-3">
    @csrf
    <input type="hidden" name="from_date" value="{{ $fromDate->toDateString() }}">
    <input type="hidden" name="to_date" value="{{ $toDate->toDateString() }}">
    <button type="submit" name="export_excel" value="1" class="btn btn-success">تصدير Excel</button>
    <button type="button" onclick="window.print();" class="btn btn-primary">طباعة</button>
</form>

@foreach($report as $employeeId => $records)
<div class="card mb-3">
    <div class="card-header">
        <strong>{{ $records[0]['employee_name'] }}</strong> - {{ $records[0]['department_name'] ?? '-' }} - {{ $records[0]['job_name'] ?? '-' }}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped period_table">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>الورديه</th>
                    <th>دخول</th>
                    <th>خروج</th>
                    <th>عدد ساعات العمل</th>
                    <th>التأخير بالدقائق</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $r)
                <tr>
                    <td>{{ $r['date'] }}</td>
                    <td>{{ $r['shift'] }}</td>
                    <td>{{ $r['time_in'] }}</td>
                    <td>{{ $r['time_out'] }}</td>
                    <td>{{ $r['hours_worked'] }}</td>
                    <td>
                        @php
                            $late = 0;
                            if($r['time_in'] != '-' && $r['shift'] != '-'){
                                // تحويل الوقت الى Carbon
                                $shiftStart = \Carbon\Carbon::parse($r['shift_start'] ?? '00:00');
                                $timeIn     = \Carbon\Carbon::parse($r['time_in']);
                                $diff = $timeIn->diffInMinutes($shiftStart, false);
                                $late = $diff > 0 ? $diff : 0;
                            }
                        @endphp
                        {{ $late }}
                    </td>
                    <td>{{ $r['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('.period_table').DataTable({
        "order": [[0, "asc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
        },
        "paging": false,
        "searching": false,
        "info": false
    });
});
</script>
@endsection

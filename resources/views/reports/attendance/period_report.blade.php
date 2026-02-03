@extends('layouts.master')
@section('title','تقرير الحضور حسب الفترة')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />

<style>
@media print {
    /* إخفاء الهيدر والفوتر والقوائم */
    .main-header,
    footer,
    .btn,
    .sidebar,
    .breadcrumb {
        display: none !important;
    }

    body {
        margin: 0;
        font-size: 12px;
        color: #000;
    }

    /* تنسيق الكروت والجداول */
    .card {
        border: none !important;
        box-shadow: none !important;
        page-break-inside: avoid;
    }

    table {
        width: 100% !important;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #000 !important;
        padding: 5px !important;
        font-size: 12px;
    }

    /* شعار الشركة */
    #logoPreview {
        max-height: 80px;
        display: block;
    }

    /* اجعل كل بطاقة تبدأ في صفحة جديدة إذا كبيرة */
    .card {
        page-break-after: auto;
    }
}
</style>


@endsection


@section('content')
&nbsp;
  <div class="row mb-2 align-items-center">
 
    <div class="col-md-5">
        <strong>اسم المنشأة:</strong> {{ $organization->name }}
    </div>
    <div class="col-md-5">
        <strong>عنوان المنشأة:</strong> {{ $organization->address }}
    </div>
       <div class="col-md-2">
        @if($organization->logo)
    <img id="logoPreview" src="{{ $organization->logo ? asset('storage/'.$organization->logo) : '#' }}" 
                             style="max-width:80px; display: {{ $organization->logo ? 'block' : 'none' }}">        @else
            <span>لا يوجد شعار</span>
        @endif
    </div>
</div>
 <hr>
      <h4>تقرير الحضور من {{ $fromDate->toDateString() }} إلى {{ $toDate->toDateString() }}</h4>
 <hr>
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
                    <th>الانصراف المبكر بالدقائق</th>

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

                    if($r['time_in'] != '-' && $r['start_time'] != '-'){
                        $shiftStart = \Carbon\Carbon::parse($r['start_time']);
                        $timeIn     = \Carbon\Carbon::parse($r['time_in']);

                        if ($timeIn->gt($shiftStart)) {
                            $late = $shiftStart->diffInMinutes($timeIn);
                        }
                    }
                @endphp

                {{ $late }}
                    </td>
                      <td>
        @php
            $earlyLeave = 0;
            if($r['time_out'] != '-' && isset($r['end_time']) && $r['end_time'] != '-') {
                $shiftEnd = \Carbon\Carbon::parse($r['end_time']);
                $timeOut  = \Carbon\Carbon::parse($r['time_out']);
                if ($timeOut->lt($shiftEnd)) {
                    $earlyLeave = $timeOut->diffInMinutes($shiftEnd);
                }
            }
        @endphp
        {{ $earlyLeave }}
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

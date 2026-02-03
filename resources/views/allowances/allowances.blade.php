@extends('layouts.master')
@section('title','البدلات')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ البدلات</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
@include('layouts.maseg')

<div class="col-xl-12">
<div class="card mg-b-20">

<div class="card-body">

{{-- روابط الإضافة --}}
<div class="mb-3">
    @can('إضافة بدل')
    <a href="{{ route('allowances.create') }}" class="btn btn-success">إضافة بدل جديد</a>
    @endcan
</div>

{{-- الفلاتر --}}
<div class="row mb-3">
    <div class="col-md-3">
        <label>السنة</label>
        <select id="filterYear" class="form-control select2">
            <option value="">الكل</option>
            @foreach($years as $year)
                <option value="{{ $year->id }}">{{ $year->year }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label>الشهر</label>
        <select id="filterMonth" class="form-control select2">
            <option value="">الكل</option>
            @foreach($months as $month)
                <option value="{{ $month->id }}">{{ $month->month_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="table-responsive">
<table id="example1" class="table key-buttons text-md-nowrap">
<thead>
<tr>
    <th>#</th>
    <th>اسم البدل</th>
    <th>السنة</th>
    <th>الشهر</th>
    <th>الملاحظات</th>
</tr>
</thead>
<tbody>
@foreach($allowances as $allowance)
<tr data-year="{{ $allowance->year_id }}" data-month="{{ $allowance->month_id }}">
    <td>{{ $loop->iteration }}</td>
    <td>
        @can('تعديل بدل')
        <a href="{{ route('allowances.edit', $allowance->id) }}">
            {{ $allowance->allowance_name }}
        </a>
        @else
            {{ $allowance->allowance_name }}
        @endcan
    </td>
    <td>{{ $allowance->year->year ?? '-' }}</td>
    <td>{{ $allowance->month->month_name ?? '-' }}</td>
    <td>{{ $allowance->description }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script>
$(document).ready(function(){
    $('#example1').DataTable();

    // فلترة الجدول
    $('#filterYear,#filterMonth').on('change',function(){
        let y=$('#filterYear').val(), m=$('#filterMonth').val();
        $('#example1 tbody tr').each(function(){
            let show=true;
            if(y && $(this).data('year')!=y) show=false;
            if(m && $(this).data('month')!=m) show=false;
            $(this).toggle(show);
        });
    });
});
</script>
@endsection

@extends('layouts.master')
@section('title','كشف المرتبات')

@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المرتبات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كشف المرتبات</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
@include('layouts.maseg')

<div class="col-xl-12">

{{-- الفلترة --}}
<div class="card mg-b-20">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <label>السنة</label>
                <select id="year_id" class="form-control select2">
                    <option value="">اختر السنة</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>الشهر</label>
                <select id="month_id" class="form-control select2">
                    <option value="">اختر الشهر</option>
                    @foreach($months as $month)
                        <option value="{{ $month->id }}">{{ $month->month_name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>

{{-- الجدول --}}
<div class="card mg-b-20">
    <div class="card-header pb-0 d-flex justify-content-between">
        @can('اضافة كشف مرتب')
        <a href="{{ route('emp_salaries.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> إضافة كشف مرتب
        </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="salaries_table" class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الموظف</th>
                        <th>الراتب الأساسي</th>
                        <th>إجمالي البدلات</th>
                        <th>إجمالي الخصومات</th>
                        <th>صافي المرتب</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

</div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script>
$(document).ready(function () {

    $('.select2').select2();

    // ===================== تهيئة DataTable =====================
    let table = $('#salaries_table').DataTable({
        processing: true,
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        ajax: {
            url: "{{ route('emp_salaries.index') }}",
            type: 'GET',
            data: function (d) {
                d.year_id  = $('#year_id').val();
                d.month_id = $('#month_id').val();
            },
            dataSrc: function (json) {
                if (!$('#year_id').val() || !$('#month_id').val()) {
                    return [];
                }

                if (json.data !== undefined) {
                    return json.data;
                }

                return json;
            }
        },
       columns: [
    { data: null, render: (d,t,r,m) => m.row + 1 },

    {
        data: 'employee',
        render: function (employee, type, row) {

            if (!employee || !employee.full_name) {
                return '<span class="text-muted">غير محدد</span>';
            }

            return `
             @can('عرض كشف المرتبات')
                <a href="/emp_salaries/${row.id}" class="text-primary font-weight-bold">
                @endcan
                    ${employee.full_name}
                </a>
            `;
        }
    },

    { data: 'basic_salary', defaultContent: 0 },
    { data: 'total_allowances', defaultContent: 0 },
    { data: 'total_deductions', defaultContent: 0 },
    { data: 'net_salary', defaultContent: 0 }
],
        language: {
            emptyTable: 'يرجى اختيار السنة والشهر أولاً'
        }
    });

    // ===================== تغيير الفلاتر =====================
    $('#year_id, #month_id').on('change', function () {
        table.ajax.reload();
    });

});
</script>
@endsection

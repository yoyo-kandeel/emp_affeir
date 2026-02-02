@extends('layouts.master')
@section('title','بيانات التوظيف')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ بيانات التوظيف</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

<div class="row">
    @include('layouts.maseg')

    <div class="col-xl-12">

        <!-- فلترة -->
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <label>الإدارة</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">اختر الإدارة</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>الوظيفة</label>
                        <select name="job_id" id="job_id" class="form-control">
                            <option value="">اختر الوظيفة</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <!-- الجدول -->
        <div class="card mg-b-20">
          
            <div class="card-header pb-0 d-flex justify-content-between">
                @can('اضافة بيانات التوظيف')
                <a href="{{ route('emp_employment.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>  إضافة بيانات توظيف جديدة
                </a>
                @endcan

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="employees_table"
                           class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الموظف</th>
                                <th>الراتب الأساسي</th>
                                <th>مؤمن عليه؟ </th>
                                
                            </tr>
                        </thead>
                        <tbody>
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
  <!-- Internal Data tables -->
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
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

    
<script>
$(document).ready(function () {

    let savedDepartment = localStorage.getItem('filter_department');
    let savedJob = localStorage.getItem('filter_job');

    // 🔹 تحميل الوظائف أولاً لو هناك إدارة محفوظة
    if (savedDepartment) {
        $('#department_id').val(savedDepartment);

        // تحميل الوظائف تلقائيًا
        $.get('/department/' + savedDepartment + '/jobs', function (data) {
            $('#job_id').html('<option value="">اختر الوظيفة</option>');
            $.each(data, function (i, job) {
                $('#job_id').append(`<option value="${job.id}">${job.job_name}</option>`);
            });

            // اختيار الوظيفة المحفوظة لو موجودة
            if (savedJob) {
                $('#job_id').val(savedJob);
            }

            // بعد تحميل الوظائف واختيار الفلتر، حدث الجدول
            if (savedDepartment && savedJob) {
                table.ajax.reload();
            }
        });
    }

    // تهيئة DataTable
    let table = $('#employees_table').DataTable({
        processing: true,
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        ajax: {
            url: '/employment/filter',
            type: 'GET',
            data: function (d) {
                d.department_id = $('#department_id').val();
                d.job_id = $('#job_id').val();
            },
            dataSrc: function (json) {
                if (!$('#department_id').val() || !$('#job_id').val()) return [];
                return json;
            }
        },
        columns: [
            { data: null, render: (d,t,r,m) => m.row + 1 },
            { data: 'full_name', render: (data, type, row) => `@can('عرض بيانات التوظيف')<a href="/emp_employment/${row.id}">${data}</a>@else${data}@endcan` },
            { data: 'basic_salary' },
           { data: 'insured', render: d => d == 1 ? 'نعم' : 'لا' }


        ],
        language: { emptyTable: 'يرجى اختيار الإدارة والوظيفة أولاً' }
    });

    // تغيير الإدارة
    $('#department_id').on('change', function () {
        let departmentId = $(this).val();
        localStorage.setItem('filter_department', departmentId);
        localStorage.removeItem('filter_job'); // امسح فلتر الوظيفة لأن الإدارة تغيرت
        $('#job_id').html('<option value="">اختر الوظيفة</option>');

        if (departmentId) {
            $.get('/department/' + departmentId + '/jobs', function (data) {
                $.each(data, function (i, job) {
                    $('#job_id').append(`<option value="${job.id}">${job.job_name}</option>`);
                });
            });
        }

        table.clear().draw();
    });

    // تغيير الوظيفة
    $('#job_id').on('change', function () {
        localStorage.setItem('filter_job', $(this).val());
        table.ajax.reload();
    });
});

</script>



@endsection
 
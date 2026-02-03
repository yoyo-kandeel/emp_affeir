@extends('layouts.master')
@section('title','بيانات الموظفين')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ بيانات الموظفين</span>
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
               
                @can('تصدير اكسيل موظفين')
               <a href="{{ url('/test-export') }}" class="btn btn-info mb-3">
    <i class="fas fa-file-download"></i> تصدير اكسيل
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
                                <th>الوظيفة</th>
                                <th>كود البصمة</th>
                                <th>تاريخ التعيين</th>
                                <th>ملاحظات</th>
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

    let table;
    const departmentSelect = $('#department_id');
    const jobSelect = $('#job_id');
    const savedDepartment = localStorage.getItem('filter_department');
    const savedJob = localStorage.getItem('filter_job');

    // تهيئة DataTable
    table = $('#employees_table').DataTable({
        processing: true,
        ordering: true,
        searching: true,
        paging: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'بيانات الموظفين',
                className: 'd-none',
                exportOptions: { columns: ':visible', stripHtml: true }
            }
        ],
        ajax: {
            url: '/employees/filter',
            data: function(d) {
                d.department_id = departmentSelect.val() || '';
                d.job_id = jobSelect.val() || '';
            },
            dataSrc: function(json) {
                if (!departmentSelect.val() || !jobSelect.val()) return [];
                return json;
            }
        },
       columns: [
    { data: null, render: (d,t,r,m) => m.row + 1 },
    { data: 'full_name', render: (data, type, row) =>
        `@can('عرض معلومات الموظف')<a href="/emp_data/${row.id}">${data}</a>@else${data}@endcan`
    },
    { data: 'job_name', defaultContent: '-' },
    { data: 'print_id', defaultContent: '-' },
    { data: 'hire_date', defaultContent: '-' },
    { data: 'notes', defaultContent: '-' }
        ],
        language: { emptyTable: "يرجى اختيار الإدارة والوظيفة أولاً" }
    });

    // 🔹 تحميل الوظائف عند وجود إدارة محفوظة مسبقًا
    if (savedDepartment) {
        departmentSelect.val(savedDepartment);
        loadJobs(savedDepartment, savedJob);
    }

    // تغيير الإدارة
    departmentSelect.on('change', function() {
        const departmentId = $(this).val();

        // حفظ الفلتر
        localStorage.setItem('filter_department', departmentId);
        localStorage.removeItem('filter_job');

        // إعادة تهيئة الوظائف
        jobSelect.html('<option value="">اختر الوظيفة</option>');
        table.clear().draw(); // تفريغ الجدول مؤقتًا

        if (departmentId) loadJobs(departmentId, null);
    });

    // تغيير الوظيفة
    jobSelect.on('change', function() {
        const jobId = $(this).val();
        localStorage.setItem('filter_job', jobId);

        if (departmentSelect.val() && jobId) {
            table.ajax.reload();
        }
    });

    // زر تصدير Excel
    $('#exportExcel').click(function() {
        if (!departmentSelect.val() || !jobSelect.val()) {
            alert('يجب اختيار الإدارة والوظيفة أولاً');
            return;
        }
        table.button('.buttons-excel').trigger();
    });

    // 🔹 دالة تحميل الوظائف
    function loadJobs(departmentId, selectJobId = null) {
        $.get(`/department/${departmentId}/jobs`, function(data) {
            jobSelect.html('<option value="">اختر الوظيفة</option>');
            $.each(data, function(i, job) {
                jobSelect.append(`<option value="${job.id}">${job.job_name}</option>`);
            });

            // إذا كان هناك وظيفة محفوظة مسبقًا
            if (selectJobId) {
                jobSelect.val(selectJobId);
                table.ajax.reload();
            }
        });
    }

});
</script>



@endsection

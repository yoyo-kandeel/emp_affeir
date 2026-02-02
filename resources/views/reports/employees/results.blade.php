@extends('layouts.master')
@section('title','تقرير الموظفين')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<style>
/* اعدادات الطباعة */
@media print {
    body {
        direction: rtl;
        font-family: Arial, sans-serif;
        font-size: 12pt;
    }

    .no-print {
        display: none !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: auto;
    }

    th, td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
        vertical-align: middle;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
}
</style>
@endsection

@section('content')


<div class="row">
    <div class="col-12">

        <!-- بيانات المنشأة وفلاتر التقرير -->
        <div class="card mg-b-20">
            <div class="card-body">
                <h4 style="text-align: center;">بيانات المنشأة</h4>
                <hr>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>اسم المنشأة:</strong> {{ $organization->name }}</div>
                    <div class="col-md-6"><strong>عنوان المنشأة:</strong> {{ $organization->address }}</div>
                </div>

                <h4 style="text-align: center;">فلترة التقرير</h4>
                <hr>
                <div class="row">
                    <div class="col-md-3"><strong>الإدارة:</strong> {{ $request->department_id == 'all' ? 'كل الإدارات' : $employees->first()->department->department_name ?? '-' }}</div>
                    <div class="col-md-3"><strong>الوظيفة:</strong> {{ $request->job_id == 'all' ? 'كل الوظائف' : $employees->first()->job->job_name ?? '-' }}</div>
                    <div class="col-md-3"><strong>الموظف:</strong> {{ $request->employee_id == 'all' ? 'كل الموظفين' : $employees->first()->full_name ?? '-' }}</div>
                    <div class="col-md-3"><strong>نوع التقرير:</strong> {{ $request->report_type == 'detailed' ? 'تفصيلي' : 'مختصر' }}</div>
                </div>
            </div>
        </div>

        <!-- جدول الموظفين -->
        <div class="card mg-b-20">
            <div class="card-body table-responsive">
                <table id="report_table" class="table table-bordered table-striped text-md-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            @if($request->report_type == 'detailed')
                            <th>رقم الموظف</th>
                            <th>الاسم الكامل</th>
                            <th>الاسم بالإنجليزي</th>
                            <th>تاريخ الميلاد</th>
                            <th>مكان الميلاد</th>
                            <th>الجنس</th>
                            <th>الجنسية</th>
                            <th>الحالة الاجتماعية</th>
                            <th>عدد الأطفال</th>
                            <th>الرقم القومي</th>
                            <th>رقم الهاتف</th>
                            <th>العنوان</th>
                            <th>الموقف من التجنيد</th>
                            <th>الخبرات السابقة</th>
                            <th>الشهادة</th>
                            <th>تاريخ التعيين</th>
                            <th>القسم</th>
                            <th>الوظيفة</th>
                            <th>الحالة</th>
                            <th>الملاحظات</th>
                            <th>كود البصمة</th>
                            <th>مهارات الكمبيوتر</th>
                            <th>مستوى اللغة الإنجليزية</th>
                            <th>الديانة</th>
                            @else
                            <th>المسمى الوظيفي</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $index => $emp)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if($request->report_type == 'detailed')
                            <td>{{ $emp->emp_number }}</td>
                            <td>{{ $emp->full_name }}</td>
                            <td>{{ $emp->english_name }}</td>
                            <td>{{ $emp->birth_date }}</td>
                            <td>{{ $emp->birth_place }}</td>
                            <td>{{ $emp->gender }}</td>
                            <td>{{ $emp->nationality }}</td>
                            <td>{{ $emp->marital_status }}</td>
                            <td>{{ $emp->children_count }}</td>
                            <td>{{ $emp->national_id }}</td>
                            <td>{{ $emp->phone }}</td>
                            <td>{{ $emp->address }}</td>
                            <td>{{ $emp->status_service }}</td>
                            <td>{{ $emp->experience }}</td>
                            <td>{{ $emp->certificate }}</td>
                            <td>{{ $emp->hire_date }}</td>
                            <td>{{ $emp->department->department_name ?? '-' }}</td>
                            <td>{{ $emp->job->job_name ?? '-' }}</td>
                            <td>{{ $emp->status }}</td>
                            <td>{{ $emp->notes }}</td>
                            <td>{{ $emp->print_id }}</td>
                            <td>{{ $emp->computer_skills }}</td>
                            <td>{{ $emp->english_proficiency }}</td>
                            <td>{{ $emp->religion }}</td>
                            @else
                            <td>{{ $emp->job->job_name ?? '-' }}</td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $request->report_type == 'detailed' ? 25 : 2 }}" class="text-center">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>

<script>
$(document).ready(function() {
    $('#report_table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        scrollX: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'تصدير Excel',
                title: 'تقرير الموظفين',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                text: 'طباعة',
                title: '',
                customize: function (win) {
                    $(win.document.body).css({
                        'font-size': '12pt',
                        'direction': 'rtl'
                    });
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size','inherit')
                        .css('border-collapse','collapse');
                    // إضافة بيانات المنشأة وفلاتر التقرير أعلى الجدول عند الطباعة
                    var header = `
                        <h4 style="text-align:center;">بيانات المنشأة</h4>
                        <p><strong>اسم المنشأة:</strong> {{ $organization->name }} - <strong>عنوان المنشأة:</strong> {{ $organization->address }}</p>
                        <h4 style="text-align:center;">فلترة التقرير</h4>
                        <p>
                            <strong>الإدارة:</strong> {{ $request->department_id == 'all' ? 'كل الإدارات' : $employees->first()->department->department_name ?? '-' }} -
                            <strong>الوظيفة:</strong> {{ $request->job_id == 'all' ? 'كل الوظائف' : $employees->first()->job->job_name ?? '-' }} -
                            <strong>الموظف:</strong> {{ $request->employee_id == 'all' ? 'كل الموظفين' : $employees->first()->full_name ?? '-' }} -
                            <strong>نوع التقرير:</strong> {{ $request->report_type == 'detailed' ? 'تفصيلي' : 'مختصر' }}
                        </p><hr>`;
                    $(win.document.body).prepend(header);
                },
                exportOptions: { columns: ':visible' }
            }
        ]
    });
});
</script>
@endsection

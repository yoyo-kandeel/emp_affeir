@extends('layouts.master')
@section('title','عرض الخصومات')

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
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  الخصومات</span>
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

                    {{-- الموظف --}}
                    <div class="col-md-4 position-relative">
                        <label>الموظف</label>
                        <input type="text" id="employee_search" class="form-control" placeholder="اكتب الاسم أو رقم الموظف">
                        <ul id="employee_results" class="list-group mt-1"
                            style="position:absolute; z-index:999; width:100%"></ul>
                        <input type="hidden" id="emp_id">
                    </div>

                    {{-- السنة --}}
                    <div class="col-md-4">
                        <label>السنة</label>
                        <select id="year_id" class="form-control">
                            <option value="">اختر السنة</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- الشهر --}}
                    <div class="col-md-4">
                        <label>الشهر</label>
                        <select id="month_id" class="form-control" disabled>
                            <option value="">اختر الشهر</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- الجدول --}}
        <div class="card mg-b-20">
            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="deductions_table" class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نوع الخصومات</th>
                                <th>القيمة</th>
                                <th>الشهر</th>
                                <th>تاريخ الإنشاء</th>
                                
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

    // ===================== استرجاع الفلاتر من sessionStorage =====================
    let savedEmpId   = sessionStorage.getItem('filter_emp_id');
    let savedEmpName = sessionStorage.getItem('filter_emp_name');
    let savedYear    = sessionStorage.getItem('filter_year');
    let savedMonth   = sessionStorage.getItem('filter_month');

    // ===================== استرجاع اسم الموظف =====================
    if (savedEmpId && savedEmpName) {
        $('#emp_id').val(savedEmpId);
        $('#employee_search').val(savedEmpName);
    }

    // ===================== دالة تحميل الشهور =====================
    function loadMonths(yearId) {
        return $.get("{{ route('months.byYear') }}", { year_id: yearId }, function(data){
            $('#month_id').empty().append('<option value="">اختر الشهر</option>');
            $.each(data, function(i, month){
                $('#month_id').append(`<option value="${month.id}">${month.month_name}</option>`);
            });
            $('#month_id').prop('disabled', false);
        });
    }

    // ===================== تحميل الشهور + اختيار الشهر المخزن =====================
    function initFiltersAndTable() {
        if (savedYear) {
            $('#year_id').val(savedYear);

            loadMonths(savedYear).then(function(){
                if (savedMonth) {
                    $('#month_id').val(savedMonth);
                }
                // بعد اكتمال كل الفلاتر، نهيئ DataTable
                initDataTable();
            });
        } else {
            // لو مفيش سنة مخزنة نهيئ الجدول مباشرة
            initDataTable();
        }
    }

    // ===================== تهيئة DataTable =====================
    function initDataTable() {
        $('#deductions_table').DataTable({
            processing: true,
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            ajax: {
                url: "{{ route('emp_deductions.filter') }}",
                type: 'GET',
                data: function (d) {
                    d.emp_id   = $('#emp_id').val();
                    d.year_id  = $('#year_id').val();
                    d.month_id = $('#month_id').val();
                },
                dataSrc: function (json) {
                    if (!$('#emp_id').val() || !$('#year_id').val() || !$('#month_id').val()) {
                        return [];
                    }
                    return json;
                }
            },
         columns: [
    { data: null, render: (d,t,r,m) => m.row + 1 },
    {
        data: 'deduction_type',
        render: function(data, type, row){
            let typeText = data == 0 ? 'غياب' : data == 1? 'تأخير' : 'جزاء';
            return `@can('تعديل خصم')<a href="/emp_deductions/${row.id}/edit">${typeText}</a>@else${typeText}@endcan`;
        }
    },
    { data: 'quantity' },
    { data: 'month_name' },
    { data: 'created_at' },
]
,
            language: {
                emptyTable: 'يرجى اختيار الموظف والسنة والشهر أولاً'
            }
        });
    }

    // ===================== البحث عن الموظف =====================
    $('#employee_search').keyup(function(){
        let query = $(this).val();
        if(query.length >= 1){
            $.get("{{ route('emp.search') }}", { search: query }, function(data){
                $('#employee_results').empty();
                if(data.length){
                    $.each(data, function(i, emp){
                        $('#employee_results').append(`
                            <li class="list-group-item list-group-item-action"
                                data-id="${emp.id}" data-name="${emp.emp_number} - ${emp.full_name}">
                                ${emp.emp_number} - ${emp.full_name}
                            </li>
                        `);
                    });
                } else {
                    $('#employee_results').append('<li class="list-group-item text-muted">لا يوجد نتائج</li>');
                }
            });
        } else {
            $('#employee_results').empty();
            $('#emp_id').val('');
            sessionStorage.removeItem('filter_emp_id');
            sessionStorage.removeItem('filter_emp_name');
        }
    });

    // ===================== اختيار الموظف =====================
    $(document).on('click','#employee_results li', function(){
        let empId = $(this).data('id');
        let empName = $(this).data('name');

        $('#emp_id').val(empId);
        $('#employee_search').val(empName);
        sessionStorage.setItem('filter_emp_id', empId);
        sessionStorage.setItem('filter_emp_name', empName);

        $('#employee_results').empty();
        $('#deductions_table').DataTable().ajax.reload();
    });

    // ===================== تغيير السنة =====================
    $('#year_id').change(function(){
        let year_id = $(this).val();
        sessionStorage.setItem('filter_year', year_id);

        if(year_id){
            loadMonths(year_id).then(function(){
                $('#month_id').val('');
                sessionStorage.removeItem('filter_month');
                $('#deductions_table').DataTable().clear().draw();
            });
        } else {
            $('#month_id').prop('disabled', true).html('<option value="">اختر الشهر</option>');
            $('#deductions_table').DataTable().clear().draw();
        }
    });

    // ===================== تغيير الشهر =====================
    $('#month_id').change(function(){
        let month_id = $(this).val();
        sessionStorage.setItem('filter_month', month_id);
        $('#deductions_table').DataTable().ajax.reload();
    });

    // ===================== تهيئة الصفحة =====================
    initFiltersAndTable();

});


</script>

@endsection

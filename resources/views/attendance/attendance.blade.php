@extends('layouts.master')
@section('title','سجلات الحضور والانصراف')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
<!--- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="content-title mb-0">الحضور والانصراف</h4>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">

        {{-- الفلاتر --}}
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="row">

                    {{-- الموظف --}}
                    <div class="col-md-4">
                        <label>الموظف</label>
                        <input type="text" id="employee_search" class="form-control"
                               placeholder="اكتب الاسم أو رقم الموظف">
                        <ul id="employee_results" class="list-group mt-1"
                            style="position:absolute;z-index:999;width:100%"></ul>
                        <input type="hidden" id="emp_id">
                    </div>

                    {{-- من --}}
                    <div class="col-md-3">
                        <label>من تاريخ</label>
                        <input type="date" id="from_date" class="form-control">
                    </div>

                    {{-- إلى --}}
                    <div class="col-md-3">
                        <label>إلى تاريخ</label>
                        <input type="date" id="to_date" class="form-control">
                    </div>

                    {{-- عرض الكل --}}
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button id="show_all_btn" class="btn btn-secondary btn-block">
                            عرض كل الموظفين
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- الجدول --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="attendance_table" class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الموظف</th>
                                <th>الجهاز</th>
                                <th>النوع</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
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

		
<!-- JS -->.
<script>
$(document).ready(function () {

    // ============== DataTable فاضي أول ما الصفحة تفتح ==============
    let table = $('#attendance_table').DataTable({
        processing: true,
        serverSide: false,
        searching: false,
        ordering: false,
        data: [], // فاضي
        columns: [
            { data: null, render: (d,t,r,m) => m.row + 1 },
            { data: 'employee_name' },
            { data: 'device_ip' },
            { data: 'type' },
            { data: 'log_date' },
            { data: 'log_time' }
        ],
        language:{
            emptyTable:'اختر فترة لعرض البيانات'
        }
    });

    // ============== دالة لتحميل البيانات حسب الفلاتر ==============
    function reloadTable() {
        let emp_id = $('#emp_id').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();

        if(!from_date || !to_date) return;

        $.get("{{ route('attendance.filter') }}", {
            emp_id: emp_id,
            from_date: from_date,
            to_date: to_date
        }, function(data){
            table.clear().rows.add(data).draw();
        });
    }

    // ============== تحميل عند تغيير التواريخ ==============
    $('#from_date, #to_date').on('change', reloadTable);

    // ============== زر عرض كل الموظفين ==============
    $('#show_all_btn').click(function(e){
        e.preventDefault();

        if(!$('#from_date').val() || !$('#to_date').val()){
            alert('لازم تحدد الفترة الأول');
            return;
        }

        $('#emp_id').val('');
        $('#employee_search').val('');
        reloadTable();
    });

    // ============== البحث عن الموظف ==============
    $('#employee_search').keyup(function(){
        let q = $(this).val();
        if(q.length < 1){
            $('#employee_results').empty();
            return;
        }

        $.get("{{ route('emp.search') }}", {search: q}, function(data){
            $('#employee_results').empty();
            data.forEach(emp=>{
                $('#employee_results').append(`
                    <li class="list-group-item list-group-item-action"
                        data-id="${emp.id}"
                        data-name="${emp.emp_number} - ${emp.full_name}">
                        ${emp.emp_number} - ${emp.full_name}
                    </li>
                `);
            });
        });
    });

    // ============== اختيار الموظف من القائمة ==============
    $(document).on('click','#employee_results li',function(){
        if(!$('#from_date').val() || !$('#to_date').val()){
            alert('حدد الفترة الأول');
            return;
        }

        $('#emp_id').val($(this).data('id'));
        $('#employee_search').val($(this).data('name'));
        $('#employee_results').empty();

        reloadTable();
    });

});

</script>

@endsection

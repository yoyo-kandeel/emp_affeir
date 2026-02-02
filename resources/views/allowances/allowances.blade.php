@extends('layouts.master')
@section('title',' البدلات')

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

@can('اضافة بدل')
<div class="card-header pb-0">
    <div class="d-flex justify-content-between">
        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
            <a class="modal-effect btn btn-outline-primary btn-block"
               data-effect="effect-newspaper" data-toggle="modal"
               href="#modaldemo8">اضافة بدل جديد</a>
        </div>
    </div>
</div>
@endcan

<div class="card-body">

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
        <a href="javascript:void(0)"
           onclick="editAllowance(
           '{{ $allowance->id }}',
           '{{ $allowance->allowance_name }}',
           '{{ $allowance->description }}',
           '{{ $allowance->year_id }}',
           '{{ $allowance->month_id }}')">
           {{ $allowance->allowance_name }}
        </a>
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

{{-- إضافة --}}
<div class="modal" id="modaldemo8">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content modal-content-demo">
<div class="modal-header">
<h6 class="modal-title">اضافة بدل جديد</h6>
<button class="close" data-dismiss="modal">&times;</button>
</div>

<form action="{{ route('allowances.store') }}" method="post">
@csrf
<div class="modal-body">
<div class="form-group">
<label>السنة</label>
<select class="form-control" name="year_id">
@foreach($years as $year)
<option value="{{ $year->id }}">{{ $year->year }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>الشهر</label>
<select class="form-control" name="month_id">
@foreach($months as $month)
<option value="{{ $month->id }}">{{ $month->month_name }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>اسم البدل</label>
<input type="text" class="form-control" name="allowance_name">
</div>

<div class="form-group">
<label>الملاحظات</label>
<textarea class="form-control" name="description"></textarea>
</div>
</div>

<div class="modal-footer">
<button class="btn btn-primary">حفظ</button>
<button class="btn btn-secondary" data-dismiss="modal">رجوع</button>
</div>
</form>
</div>
</div>
</div>

@can('تعديل بدل')
<div class="modal" id="editModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content modal-content-demo">
<div class="modal-header">
<h6 class="modal-title">تعديل البدل</h6>
<button class="close" data-dismiss="modal">&times;</button>
</div>

<form id="editForm" method="post">
@csrf
@method('PUT')
<div class="modal-body">
    <div class="form-group">

    <label>السنة</label>

<select id="editYear" name="year_id" class="form-control mb-2">
@foreach($years as $year)
<option value="{{ $year->id }}">{{ $year->year }}</option>
@endforeach
</select>
</div>

<div class="form-group">

<label>الشهر</label>
<select id="editMonth" name="month_id" class="form-control mb-2">
@foreach($months as $month)
<option value="{{ $month->id }}">{{ $month->month_name }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>اسم البدل</label>
<input id="editName" name="allowance_name" class="form-control mb-2">
</div>
<div class="form-group">
<label>الملاحظات</label>
<textarea id="editNotes" name="description" class="form-control"></textarea>
</div>
</div>

<div class="modal-footer" style="position:relative;">
<button class="btn btn-primary">حفظ</button>
</form>

@can('حذف بدل')
                     <!-- زر الحذف -->
                 <button class="btn ripple btn-danger" id="deleteBtn" type="button">حذف</button>
                        @endcan
<!-- مربع تأكيد الحذف -->
 <div id="deleteConfirmBox" class="p-2 border rounded bg-light text-center d-none" 
     style="position:absolute; bottom:50px; right:100px; width:220px; box-shadow:0 3px 10px rgba(0,0,0,0.2);">
    <small class="d-block mb-2 text-muted">هل تريد التأكيد؟</small>
    <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE') 
        <button class="btn btn-sm btn-danger mx-1" type="submit">نعم</button>
        <button class="btn btn-sm btn-secondary mx-1" type="button" id="cancelDelete">لا</button>
    </form>
</div>

<button class="btn btn-secondary" data-dismiss="modal">رجوع</button>
</div>
</div>
</div>
@endcan
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

		
<!-- JS -->
<script>
function editAllowance(id,name,desc,year,month){
    $('#editName').val(name);
    $('#editNotes').val(desc);
    $('#editYear').val(year);
    $('#editMonth').val(month);
    $('#editForm').attr('action','/allowances/'+id);
    $('#deleteForm').attr('action','/allowances/'+id);
    $('#deleteConfirmBox').addClass('d-none');
    $('#editModal').modal('show');
}

$('#filterYear,#filterMonth').on('change',function(){
let y=$('#filterYear').val(), m=$('#filterMonth').val();
$('#example1 tbody tr').each(function(){
let show=true;
if(y && $(this).data('year')!=y) show=false;
if(m && $(this).data('month')!=m) show=false;
$(this).toggle(show);
});
});

$('#deleteBtn').click(()=>$('#deleteConfirmBox').removeClass('d-none'));
$('#cancelDelete').click(()=>$('#deleteConfirmBox').addClass('d-none'));
</script>
@endsection

@extends('layouts.master')
@section('title','أجهزة البصمة')

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
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">إدارة أجهزة البصمة</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ أجهزة البصمة</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">

@include('layouts.maseg')

<div class="col-xl-12">
<div class="card mg-b-20">

@can('اضافة جهاز')
<div class="card-header pb-0">
    <div class="d-flex justify-content-between">
        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
            <a class="modal-effect btn btn-outline-primary btn-block"
               data-effect="effect-newspaper"
               data-toggle="modal"
               href="#addDeviceModal">
               إضافة جهاز جديد
            </a>
        </div>
    </div>
</div>
@endcan

<div class="card-body">
<div class="table-responsive">
<table id="example1" class="table key-buttons text-md-nowrap">
<thead>
<tr>
    <th>#</th>
    <th>IP</th>
    <th>Port</th>
    <th>نوع الجهاز</th>
    <th>الحالة</th>
</tr>
</thead>
<tbody>
@foreach($devices as $device)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>
        <a href="javascript:void(0)"
           onclick="editDevice(
           '{{ $device->id }}',
           '{{ $device->ip_address }}',
           '{{ $device->port }}',
           '{{ $device->type }}',
           '{{ $device->is_active }}'
           )">
           {{ $device->ip_address }}
        </a>
    </td>
    <td>{{ $device->port }}</td>
    <td>{{ $device->type }}</td>
    <td>{{ $device->is_active ? 'مفعل' : 'موقف' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

</div>
</div>

<!-- Add Modal -->
<div class="modal" id="addDeviceModal">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content modal-content-demo">
<div class="modal-header">
    <h6 class="modal-title">إضافة جهاز جديد</h6>
    <button class="close" data-dismiss="modal" type="button">
        <span>&times;</span>
    </button>
</div>

<form action="{{ route('fingerprint-devices.store') }}" method="POST">
@csrf
<div class="modal-body">

<div class="form-group">
    <label>IP الجهاز</label>
    <input type="text" class="form-control" name="ip_address" required>
</div>

<div class="form-group">
    <label>Port</label>
    <input type="number" class="form-control" name="port" value="4370">
</div>

<div class="form-group">
    <label>نوع الجهاز</label>
    <input type="text" class="form-control" name="type" required>
</div>

</div>
<div class="modal-footer">
    <button class="btn ripple btn-primary" type="submit">حفظ</button>
    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
</div>
</form>

</div>
</div>
</div>

@can('تعديل جهاز')
<!-- Edit Modal -->
<div class="modal" id="editDeviceModal">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content modal-content-demo">
<div class="modal-header">
    <h6 class="modal-title">تعديل الجهاز</h6>
    <button class="close" data-dismiss="modal" type="button">
        <span>&times;</span>
    </button>
</div>

<form id="editForm" method="POST">
@csrf
@method('PUT')

<div class="modal-body">
<div class="form-group">
    <label>IP الجهاز</label>
    <input type="text" class="form-control" id="edit_ip" name="ip_address">
</div>

<div class="form-group">
    <label>Port</label>
    <input type="number" class="form-control" id="edit_port" name="port">
</div>

<div class="form-group">
    <label>نوع الجهاز</label>
    <input type="text" class="form-control" id="edit_type" name="type">
</div>

<div class="form-group">
    <label>الحالة</label>
    <select class="form-control" id="edit_is_active" name="is_active">
        <option value="1">مفعل</option>
        <option value="0">موقف</option>
    </select>
</div>
</div>

<div class="modal-footer" style="position:relative;">
<button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
</form>

@can('حذف جهاز')
<button class="btn ripple btn-danger" id="deleteBtn" type="button">حذف</button>
@endcan

<div id="deleteConfirmBox"
     class="p-2 border rounded bg-light text-center d-none"
     style="position:absolute; bottom:50px; right:100px; width:220px;">
    <small class="d-block mb-2 text-muted">هل تريد التأكيد؟</small>
    <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger mx-1" type="submit">نعم</button>
        <button class="btn btn-sm btn-secondary mx-1" type="button" id="cancelDelete">لا</button>
    </form>
</div>

<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
</div>

</div>
</div>
</div>
@endcan

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

<script>
let deviceId;

function editDevice(id, ip, port, type, active){
    deviceId = id;
    $('#edit_ip').val(ip);
    $('#edit_port').val(port);
    $('#edit_type').val(type);
    $('#edit_is_active').val(active);

    $('#editForm').attr('action','/fingerprint-devices/' + id);
    $('#deleteForm').attr('action','/fingerprint-devices/' + id);

    $('#deleteConfirmBox').addClass('d-none');
    $('#editDeviceModal').modal('show');
}

$('#deleteBtn').on('click', function(){
    $('#deleteConfirmBox').removeClass('d-none');
});

$('#cancelDelete').on('click', function(){
    $('#deleteConfirmBox').addClass('d-none');
});
</script>
@endsection

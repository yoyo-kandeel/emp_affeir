@extends('layouts.master')
@section('title','الوردية')

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
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الوردية</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الورديات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<div class="row">

@include('layouts.maseg')

<div class="col-xl-12">
    <div class="card mg-b-20">
        @can('اضافة وردية')
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">اضافة وردية جديدة</a>
                </div>
            </div>
        </div>
        @endcan

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table key-buttons text-md-nowrap">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">اسم الوردية</th>
                            <th class="border-bottom-0">وقت البداية</th>
                            <th class="border-bottom-0">وقت النهاية</th>
                            <th class="border-bottom-0">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shifts as $shift)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="editShift('{{ $shift->id }}','{{ $shift->name }}','{{ $shift->start_time }}','{{ $shift->end_time }}','{{ $shift->description }}')">
                                    {{ $shift->name }}
                                </a>
                            </td>
                            <td>{{ $shift->start_time }}</td>
                            <td>{{ $shift->end_time }}</td>
                            <td>{{ $shift->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Add Modal -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة وردية جديدة</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('shifts.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الوردية</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>وقت البداية</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label>وقت النهاية</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea class="form-control" name="description"></textarea>
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

@can('تعديل وردية')
<!-- Edit Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل الوردية</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="editForm" method="post" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الوردية</label>
                        <input type="text" class="form-control" id="editShiftName" name="name">
                    </div>
                    <div class="form-group">
                        <label>وقت البداية</label>
                        <input type="time" class="form-control" id="editShiftStart" name="start_time">
                    </div>
                    <div class="form-group">
                        <label>وقت النهاية</label>
                        <input type="time" class="form-control" id="editShiftEnd" name="end_time">
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea class="form-control" id="editShiftDesc" name="description"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="position:relative;">
                    <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                       </form>
                       @can('حذف وردية')
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

                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
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
let shiftId;

function editShift(id, name, start, end, desc){
    shiftId = id;
    document.getElementById('editShiftName').value = name;
    document.getElementById('editShiftStart').value = start;
    document.getElementById('editShiftEnd').value = end;
    document.getElementById('editShiftDesc').value = desc;

    document.getElementById('editForm').action = '/shifts/' + id;
    document.getElementById('deleteForm').action = '/shifts/' + id;

    document.getElementById('deleteConfirmBox').classList.add('d-none');

    $('#editModal').modal('show');
}

// إظهار مربع التأكيد
document.getElementById('deleteBtn')?.addEventListener('click', function(){
    document.getElementById('deleteConfirmBox').classList.remove('d-none');
});

// إخفاء مربع التأكيد
document.getElementById('cancelDelete')?.addEventListener('click', function(){
    document.getElementById('deleteConfirmBox').classList.add('d-none');
});
</script>
@endsection

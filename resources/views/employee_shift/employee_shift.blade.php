@extends('layouts.master')
@section('title','جدول الورديات')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">ربط الورديات للموظفين</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الورديات</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
@include('layouts.maseg')

<div class="col-xl-12">
    <div class="card mg-b-20">
        @can('اضافة وردية')
        <div class="card-header pb-0">
            <a class="modal-effect btn btn-outline-primary" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">إضافة وردية لموظف</a>
        </div>
        @endcan

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table key-buttons text-md-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الموظف</th>
                            <th>الوردية</th>
                            <th>الفترة</th>
                            <th>أيام العمل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $daysAr = [
                                'Monday'=>'الاثنين','Tuesday'=>'الثلاثاء','Wednesday'=>'الأربعاء',
                                'Thursday'=>'الخميس','Friday'=>'الجمعة','Saturday'=>'السبت','Sunday'=>'الأحد'
                            ];
                        @endphp
                        @foreach($employeeShifts as $shift)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="editModal(
                                    '{{ $shift->id }}',
                                    '{{ $shift->emp_data_id }}',
                                    '{{ $shift->shift_id }}',
                                    '{{ $shift->from_date }}',
                                    '{{ $shift->to_date }}',
                                    '{{ $shift->work_days }}'
                                )">
                                    {{ $shift->employee_name }}
                                </a>
                            </td>
                            <td>{{ $shift->shift_name }}</td>
                            <td>من {{ $shift->from_date }} <br> إلى {{ $shift->to_date }}</td>
                            <td>
                                @if($shift->work_days)
                                    @php
                                        $workDaysArray = json_decode($shift->work_days, true) ?? [];
                                    @endphp
                                    @foreach($workDaysArray as $day)
                                        {{ $daysAr[$day] ?? $day }}@if(!$loop->last) , @endif
                                    @endforeach
                                @endif
                            </td>
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
                <h6 class="modal-title">إضافة وردية لموظف</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('employee_shifts.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>الموظف</label>
                        <select name="emp_data_id" class="form-control" required>
                            <option value="">اختر الموظف</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الوردية</label>
                        <select name="shift_id" class="form-control" required>
                            <option value="">اختر الوردية</option>
                            @foreach($shifts as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->start_time }} - {{ $s->end_time }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>من تاريخ</label>
                        <input type="date" class="form-control" name="from_date" required>
                    </div>

                    <div class="form-group">
                        <label>إلى تاريخ</label>
                        <input type="date" class="form-control" name="to_date" required>
                    </div>

                    <div class="form-group">
                        <label>أيام العمل</label><br>
                        @foreach($daysAr as $key => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="work_days[]" value="{{ $key }}" id="addDay{{ $key }}">
                                <label class="form-check-label" for="addDay{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                        <small class="text-muted d-block">اختر أيام الأسبوع التي يعمل فيها الموظف</small>
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
                <h6 class="modal-title">تعديل وردية الموظف</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="editForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>الموظف</label>
                        <select name="emp_data_id" id="editEmp" class="form-control" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الوردية</label>
                        <select name="shift_id" id="editShift" class="form-control" required>
                            @foreach($shifts as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->start_time }} - {{ $s->end_time }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>من تاريخ</label>
                        <input type="date" class="form-control" id="editFromDate" name="from_date" required>
                    </div>

                    <div class="form-group">
                        <label>إلى تاريخ</label>
                        <input type="date" class="form-control" id="editToDate" name="to_date" required>
                    </div>

                    <div class="form-group">
                        <label>أيام العمل</label><br>
                        @foreach($daysAr as $key => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input edit-day-checkbox" type="checkbox" name="work_days[]" value="{{ $key }}" id="editDay{{ $key }}">
                                <label class="form-check-label" for="editDay{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer" style="position:relative;">
                    <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                     </form>
                    @can('حذف وردية')
                    <button class="btn ripple btn-danger" id="deleteBtn" type="button">حذف</button>
                    @endcan
                    
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
</div>
@endcan

@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
function editModal(id, emp, shift, fromDate, toDate, workDays){
    document.getElementById('editForm').action = '/employee-shifts/update/' + id;
    document.getElementById('editEmp').value = emp;
    document.getElementById('editShift').value = shift;
    document.getElementById('editFromDate').value = fromDate;
    document.getElementById('editToDate').value = toDate;

    const days = JSON.parse(workDays || '[]');
    document.querySelectorAll('.edit-day-checkbox').forEach(cb => {
        cb.checked = days.includes(cb.value);
    });

    document.getElementById('deleteForm').action = '/employee-shifts/delete/' + id;
    document.getElementById('deleteConfirmBox').classList.add('d-none');
    $('#editModal').modal('show');
}

document.getElementById('deleteBtn')?.addEventListener('click', function(){
    document.getElementById('deleteConfirmBox').classList.remove('d-none');
});
document.getElementById('cancelDelete')?.addEventListener('click', function(){
    document.getElementById('deleteConfirmBox').classList.add('d-none');
});
</script>
@endsection

@extends('layouts.master')
@section('title','قواعد التأخير والانصراف المبكر')

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
            <h4 class="content-title mb-0 my-auto">إدارة الحضور</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قواعد التأخير والانصراف المبكر</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg')

    <div class="col-xl-12">
        <div class="card mg-b-20">

        	<div class="card-header pb-0">
                @can('اضافة قاعدة تأخير')
								<div class="d-flex justify-content-between">
									<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal" href="#modaldemo8">اضافة قاعدة جديد</a>
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
                                <th>من (دقيقة)</th>
                                <th>إلى (دقيقة)</th>
                                <th>خصم التأخير</th>
                                <th>خصم الانصراف المبكر</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rules as $rule)
                            <tr>
                                <td> 
                                    @can('تعديل قاعدة تأخير')<a href="javascript:void(0)" 
                                onclick="editRule('{{ $rule->id }}','{{ $rule->from_minutes }}','{{ $rule->to_minutes }}','{{ $rule->deduction_type }}','{{ $rule->deduction_value }}','{{ $rule->early_leave_type }}','{{ $rule->early_leave_value }}','{{ $rule->notes }}','{{ $rule->is_active }}')" >
                            @endcan
                                {{ $loop->iteration }}</a></td>
                                <td>{{ $rule->from_minutes }}</td>
                                <td>{{ $rule->to_minutes }}</td>
                                <td>{{ $rule->deduction_value }} {{ $rule->deduction_type }}</td>
                                <td>
                                    @if($rule->early_leave_value)
                                        {{ $rule->early_leave_value }} {{ $rule->early_leave_type }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $rule->is_active ? 'مفعل' : 'موقف' }}</td>
                                
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
                    <h6 class="modal-title">إضافة قاعدة جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('lateness_rules.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>من (دقيقة تأخير)</label>
                            <input type="number" class="form-control" name="from_minutes" required>
                        </div>
                        <div class="form-group">
                            <label>إلى (دقيقة تأخير)</label>
                            <input type="number" class="form-control" name="to_minutes" required>
                        </div>
                        <div class="form-group">
                            <label>نوع الخصم للتأخير</label>
                            <select class="form-control" name="deduction_type" required>
                                <option value="fixed">قيمة ثابتة</option>
                                <option value="percentage">نسبة</option>
                                <option value="day">يوم كامل</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>قيمة الخصم للتأخير</label>
                            <input type="number" class="form-control" step="0.01" name="deduction_value" required>
                        </div>

                        <div class="form-group">
                            <label>نوع الخصم للانصراف المبكر</label>
                            <select class="form-control" name="early_leave_type">
                                <option value="">-- بدون --</option>
                                <option value="fixed">قيمة ثابتة</option>
                                <option value="percentage">نسبة</option>
                                <option value="day">يوم كامل</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>قيمة الخصم للانصراف المبكر</label>
                            <input type="number" class="form-control" step="0.01" name="early_leave_value">
                        </div>

                        <div class="form-group">
                            <label>الملاحظات</label>
                            <textarea class="form-control" rows="2" name="notes"></textarea>
                        </div>
                        <div class="form-group">
                            <label>الحالة</label>
                            <select class="form-control" name="is_active">
                                <option value="1">مفعل</option>
                                <option value="0">موقف</option>
                            </select>
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

    <!-- Edit Modal -->
    <div class="modal" id="editLatenessModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل القاعدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="editRuleForm" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>من (دقيقة تأخير)</label>
                            <input type="number" class="form-control" id="edit_from_minutes" name="from_minutes" required>
                        </div>
                        <div class="form-group">
                            <label>إلى (دقيقة تأخير)</label>
                            <input type="number" class="form-control" id="edit_to_minutes" name="to_minutes" required>
                        </div>
                        <div class="form-group">
                            <label>نوع الخصم للتأخير</label>
                            <select class="form-control" id="edit_deduction_type" name="deduction_type" required>
                                <option value="fixed">قيمة ثابتة</option>
                                <option value="percentage">نسبة</option>
                                <option value="day">يوم كامل</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>قيمة الخصم للتأخير</label>
                            <input type="number" class="form-control" step="0.01" id="edit_deduction_value" name="deduction_value" required>
                        </div>

                        <div class="form-group">
                            <label>نوع الخصم للانصراف المبكر</label>
                            <select class="form-control" id="edit_early_leave_type" name="early_leave_type">
                                <option value="">-- بدون --</option>
                                <option value="fixed">قيمة ثابتة</option>
                                <option value="percentage">نسبة</option>
                                <option value="day">يوم كامل</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>قيمة الخصم للانصراف المبكر</label>
                            <input type="number" class="form-control" step="0.01" id="edit_early_leave_value" name="early_leave_value">
                        </div>

                        <div class="form-group">
                            <label>الملاحظات</label>
                            <textarea class="form-control" id="edit_notes" rows="2" name="notes"></textarea>
                        </div>
                        <div class="form-group">
                            <label>الحالة</label>
                            <select class="form-control" id="edit_is_active" name="is_active">
                                <option value="1">مفعل</option>
                                <option value="0">موقف</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                        </form>
                        @can('حذف قاعدة تأخير')
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

<script>
let ruleId;

function editRule(id, from, to, type, value, earlyType, earlyValue, notes, active) {
    ruleId = id;

    // ملء الحقول في مودال التعديل
    document.getElementById('edit_from_minutes').value = from;
    document.getElementById('edit_to_minutes').value = to;
    document.getElementById('edit_deduction_type').value = type;
    document.getElementById('edit_deduction_value').value = value;

    document.getElementById('edit_early_leave_type').value = earlyType;
    document.getElementById('edit_early_leave_value').value = earlyValue;

    document.getElementById('edit_notes').value = notes;
    document.getElementById('edit_is_active').value = active;

    // فورم التعديل
    document.getElementById('editRuleForm').action = '/lateness_rules/' + id;

    // إخفاء مربع التأكيد عند فتح المودال
    if(document.getElementById('deleteConfirmBox')){
        document.getElementById('deleteConfirmBox').classList.add('d-none');
    }

    // فتح المودال
    $('#editLatenessModal').modal('show');
}

// إظهار مربع التأكيد للحذف
if(document.getElementById('deleteBtn')) {
    document.getElementById('deleteBtn').addEventListener('click', function() {
        document.getElementById('deleteConfirmBox').classList.remove('d-none');
    });
}

// إخفاء مربع التأكيد للحذف
if(document.getElementById('cancelDelete')) {
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteConfirmBox').classList.add('d-none');
    });
}


</script>

@endsection

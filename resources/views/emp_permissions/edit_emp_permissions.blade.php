@extends('layouts.master')
@section('title','تعديل إذن للموظف')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('emp_permissions.index') }}"> الأذونات</a></span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل إذن للموظف</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                @include('layouts.maseg')

                {{-- فورم التحديث --}}
                <form action="{{ route('emp_permissions.update', $empPermission) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- الموظف --}}
                    <div class="form-group mb-3">
                        <label>الموظف</label>
                        <input type="text" id="employee_search" class="form-control" 
                               value="{{ $empPermission->employee->full_name ?? '' }}">
                        <input type="hidden" name="emp_data_id" id="emp_id" value="{{ $empPermission->emp_data_id }}">
                        <ul id="employee_results" class="list-group mt-1" style="position:absolute; z-index:999;"></ul>
                    </div>

                    {{-- السنة --}}
                    <div class="form-group mb-3">
                        <label>السنة</label>
                        <select name="year_id" id="year_id" class="form-control">
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" 
                                    {{ $year->id == $empPermission->year_id ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- الشهر --}}
                    <div class="form-group mb-3">
                        <label>الشهر</label>
                        <select name="month_id" id="month_id" class="form-control"></select>
                    </div>

                    {{-- نوع الإذن --}}
                    <div class="form-group mb-3">
                        <label>نوع الإذن</label><br>
                        <div class="btn-group" role="group">
                            <label class="btn-radio {{ $empPermission->permission_type == 1 ? 'active' : '' }}" data-value="خروج">
                                <input type="radio" name="permission_type" value="1" {{ $empPermission->permission_type == 1 ? 'checked' : '' }}> خروج
                            </label>
                            <label class="btn-radio {{ $empPermission->permission_type == 2 ? 'active' : '' }}" data-value="غياب">
                                <input type="radio" name="permission_type" value="2" {{ $empPermission->permission_type == 2 ? 'checked' : '' }}> غياب
                            </label>
                            <label class="btn-radio {{ $empPermission->permission_type == 3 ? 'active' : '' }}" data-value="انصراف">
                                <input type="radio" name="permission_type" value="3" {{ $empPermission->permission_type == 3 ? 'checked' : '' }}> انصراف
                            </label>
                        </div>
                    </div>

                    {{-- تاريخ الإذن --}}
                    <div class="form-group mb-3">
                        <label>تاريخ الإذن</label>
                        <input type="date" name="permission_date" class="form-control" value="{{ $empPermission->permission_date ?? date('Y-m-d') }}">
                    </div>

                    {{-- من و إلى --}}
                    <div class="form-group mb-3">
                        <label for="from_datetime">من (تاريخ + وقت)</label>
                        <input type="datetime-local" id="from_datetime" name="from_datetime" class="form-control" value="{{ $empPermission->from_datetime }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="to_datetime">إلى (تاريخ + وقت)</label>
                        <input type="datetime-local" id="to_datetime" name="to_datetime" class="form-control" value="{{ $empPermission->to_datetime }}">
                    </div>

                    {{-- بخصم / بدون خصم --}}
                    <div class="form-group mb-3">
                        <label>الحالة</label>
                        <select name="with_deduction" class="form-control">
                            <option value="0" {{ $empPermission->with_deduction == 0 ? 'selected' : '' }}>بدون خصم</option>
                            <option value="1" {{ $empPermission->with_deduction == 1 ? 'selected' : '' }}>بخصم</option>
                        </select>
                    </div>

                    {{-- ملاحظات --}}
                    <div class="form-group mb-3">
                        <label>ملاحظات</label>
                        <textarea name="notes" class="form-control">{{ $empPermission->notes }}</textarea>
                    </div>

                    {{-- زر التحديث --}}
                    <button type="submit" class="btn btn-success">تحديث الإذن</button>
                </form>
@can('حذف إذن')
                {{-- زر الحذف يفتح المودال --}}
<button class="btn btn-danger" data-toggle="modal" data-target="#deletePermission"
        data-id="{{ $empPermission->id }}">
    حذف الإذن
</button>
@endcan
{{-- مودال الحذف --}}
<div class="modal fade" id="deletePermission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deletePermissionForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف الإذن</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من حذف هذا الإذن؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                </div>
            </div>
        </form>
    </div>
</div>




                {{-- زر الرجوع --}}
                <a href="{{ route('emp_permissions.index') }}" class="btn btn-secondary">الرجوع للقائمة</a>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script><script>
$(document).ready(function(){

    function loadMonths(selectedMonth = null){
        let year_id = $('#year_id').val();
        if(year_id){
            $.get("{{ route('months.byYear') }}", { year_id: year_id }, function(data){
                $('#month_id').empty().append('<option value="">اختر الشهر</option>');
                $.each(data, function(i, month){
                    let selected = selectedMonth && selectedMonth.toString() === month.id.toString() ? 'selected' : '';
                    $('#month_id').append('<option value="'+month.id+'" '+selected+'>'+month.month_name+'</option>');
                });
                $('#month_id').prop('disabled', false);
            });
        } else {
            $('#month_id').empty().append('<option value="">اختر الشهر</option>').prop('disabled', true);
        }
    }

    // تحميل الشهور عند فتح الصفحة
    let currentMonth = '{{ $empPermission->month_id }}';
    loadMonths(currentMonth);

    // عند تغيير السنة
    $('#year_id').change(function(){
        loadMonths();
    });

    // البحث عن الموظف
    $('#employee_search').on('keyup', function(){
        let query = $(this).val();
        if(query.length >= 1){
            $.get("{{ route('emp.search') }}", { search: query }, function(data){
                $('#employee_results').empty();
                if(data.length > 0){
                    $.each(data, function(i, emp){
                        $('#employee_results').append(
                            '<li class="list-group-item list-group-item-action" data-id="'+emp.id+'">'+
                            emp.emp_number+' - '+emp.full_name+
                            '</li>'
                        );
                    });
                } else {
                    $('#employee_results').append('<li class="list-group-item">لا يوجد نتائج</li>');
                }
            });
        } else {
            $('#employee_results').empty();
            $('#emp_id').val('');
        }
    });

    // اختيار الموظف
    $(document).on('click','#employee_results li', function(){
        let id = $(this).data('id');
        let text = $(this).text();
        $('#employee_search').val(text);
        $('#emp_id').val(id);
        $('#employee_results').empty();
    });

    // تأثير البوتونز
    $('.btn-radio').click(function(){
        $('.btn-radio').removeClass('active');
        $(this).addClass('active');
    });

    // تفعيل الزر المحدد عند تحميل الصفحة
    let currentType = '{{ $empPermission->permission_type ?? 1 }}';
    $('.btn-radio').each(function(){
        if($(this).find('input').val() === currentType.toString()){
            $(this).addClass('active');
        }
    });

});
</script>
<script>
$('#deletePermission').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var permissionId = button.data('id');
    var form = $(this).find('#deletePermissionForm');
    form.attr('action', '/emp_permissions/' + permissionId);
});
</script>
@endsection

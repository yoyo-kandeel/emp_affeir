@extends('layouts.master')
@section('title','إضافة إذن للموظف')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
<h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('emp_permissions.index') }}"> الأذونات</a></span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة إذن للموظف</span>
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

                <form action="{{ route('emp_permissions.store') }}" method="POST">
                    @csrf

                    {{-- البحث عن الموظف --}}
                    <div class="form-group mb-3">
                        <label>بحث عن الموظف</label>
                        <input type="text" id="employee_search" class="form-control" placeholder="اكتب الاسم أو رقم الموظف">
                        <ul id="employee_results" class="list-group mt-1" style="position:absolute; z-index:999;"></ul>
                        <input type="hidden" name="emp_data_id" id="emp_id">
                    </div>

                    {{-- السنة --}}
                    <div class="form-group mb-3">
                        <label>السنة</label>
                        <select name="year_id" id="year_id" class="form-control">
                            <option value="">اختر السنة</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}"> {{ $year->year }} </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- الشهر --}}
                    <div class="form-group mb-3">
                        <label>الشهر</label>
                        <select name="month_id" id="month_id" class="form-control" disabled>
                            <option value="">اختر الشهر</option>
                        </select>
                    </div>

                    {{-- نوع الإذن --}}
 <div class="form-group mb-3">
    <label>نوع الإذن</label><br>
    <div class="btn-group" role="group">
        <label class="btn-radio">
            <input type="radio" name="permission_type" value="1"> خروج
        </label>
        <label class="btn-radio">
            <input type="radio" name="permission_type" value="2"> غياب
        </label>
        <label class="btn-radio">
            <input type="radio" name="permission_type" value="3"> انصراف
        </label>
    </div>
</div>

<div class="form-group mb-3">
    <label>تاريخ الإذن</label>
    <input type="date" name="permission_date" class="form-control"
           value="{{ $empPermission->permission_date ?? date('Y-m-d') }}">
</div>

<!-- من و إلى -->
<div id="time-fields">
    <div class="form-group mb-3">
        <label for="from_datetime">من (تاريخ + وقت)</label>
        <input type="datetime-local" id="from_datetime" name="from_datetime" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="to_datetime">إلى (تاريخ + وقت)</label>
        <input type="datetime-local" id="to_datetime" name="to_datetime" class="form-control">
    </div>
</div>


                    {{-- بخصم / بدون خصم --}}
                    <div class="form-group mb-3">
                        <label>الحالة</label>
                        <select name="with_deduction" class="form-control">
                            <option value="0">بدون خصم</option>
                            <option value="1">بخصم</option>
                        </select>
                    </div>

                    {{-- ملاحظات --}}
                    <div class="form-group mb-3">
                        <label>ملاحظات</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">حفظ الإذن</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script>
$(document).ready(function(){

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
                            emp.emp_number + ' - ' + emp.full_name +
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

    // تحميل الشهور حسب السنة
    $('#year_id').change(function(){
        let year_id = $(this).val();
        if(year_id){
            $.get("{{ route('months.byYear') }}", { year_id: year_id }, function(data){
                $('#month_id').empty().append('<option value="">اختر الشهر</option>');
                $.each(data, function(i, month){
                    $('#month_id').append('<option value="'+month.id+'">'+month.month_name+'</option>');
                });
                $('#month_id').prop('disabled', false);
            });
        } else {
            $('#month_id').empty().append('<option value="">اختر الشهر</option>').prop('disabled', true);
        }
    });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const permissionRadios = document.querySelectorAll('input[name="permission_type"]');
    const timeFields = document.getElementById('time-fields');
    const fromInput = document.getElementById('from_datetime');
    const toInput = document.getElementById('to_datetime');

    function toggleTimeFields() {
        const selected = document.querySelector('input[name="permission_type"]:checked');

        if (selected && selected.value === '2') { // غياب
            timeFields.style.display = 'none';
            fromInput.value = '';
            toInput.value = '';
            fromInput.removeAttribute('required');
            toInput.removeAttribute('required');
        } else {
            timeFields.style.display = 'block';
            fromInput.setAttribute('required', 'required');
            toInput.setAttribute('required', 'required');
        }
    }

    permissionRadios.forEach(radio => {
        radio.addEventListener('change', toggleTimeFields);
    });

    // تشغيلها أول ما الصفحة تفتح (في التعديل)
    toggleTimeFields();
});
</script>

@endsection

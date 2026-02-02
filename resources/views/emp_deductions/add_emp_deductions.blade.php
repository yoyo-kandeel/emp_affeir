@extends('layouts.master')
@section('title','إضافة خصم للموظف')
@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
<h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('emp_deductions.index') }}"> الخصومات</a></span>
                        <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة خصم للموظف</span>
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

                <form action="{{ route('emp_deductions.store') }}" method="POST">
                    @csrf

                    {{-- البحث عن الموظف --}}
                    <div class="form-group mb-3">
                        <label>بحث عن الموظف</label>
                        <input type="text" id="employee_search" class="form-control">
                        <ul id="employee_results" class="list-group mt-1" style="position:absolute; z-index:999;"></ul>
                        <input type="hidden" name="emp_id" id="emp_id">
                    </div>
                        {{-- اختيار السنة --}}
                        <div class="form-group mb-3">
                            <label>السنة</label>
                            <select name="year_id" id="year_id" class="form-control">
                                <option value="">اختر السنة</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- اختيار الشهر --}}
                        <div class="form-group mb-3">
                            <label>الشهر</label>
                            <select name="month_id" id="month_id" class="form-control" disabled>
                                <option value="">اختر الشهر</option>
                                {{-- الشهور سيتم تحميلها ديناميكيًا حسب السنة --}}
                            </select>
                        </div>


                 

                    {{-- نوع الخصم --}}
                    <div class="form-group mb-3">
                        <label>نوع الخصم</label><br>
                        <div class="btn-group" role="group">
                            <label class="btn-radio" data-value="أيام">
                                <input type="radio" name="deduction_type" value="0"> غياب
                            </label>
                            <label class="btn-radio" data-value="ساعات">
                                <input type="radio" name="deduction_type" value="1"> تأخير
                            </label>
                            <label class="btn-radio" data-value="مبلغ">
                                <input type="radio" name="deduction_type" value="2"> جزاء
                            </label>
                        </div>
                    </div>

                    {{-- القيمة --}}
                    <div class="form-group mb-3">
                        <label>القيمة (<span id="unit_label">---</span>)</label>
                        <input type="number" name="quantity" class="form-control" step="0.01" min="0">
                    </div>

                    <button type="submit" class="btn btn-success">حفظ الخصم</button>

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
            $.ajax({
                url: "{{ route('emp.search') }}",
                type: 'GET',
                data: { search: query },
                success: function(data){
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

        // تغيير وحدة القيمة حسب النوع
        let unit = $(this).data('value');
        $('#unit_label').text(unit);
    });

});
</script>
<script>
$(document).ready(function(){

    $('#year_id').change(function(){
        let year_id = $(this).val();
        if(year_id){
            $.ajax({
                url: "{{ route('months.byYear') }}", // نحتاج نعمل route و controller
                type: 'GET',
                data: { year_id: year_id },
                success: function(data){
                    $('#month_id').empty().append('<option value="">اختر الشهر</option>');
                    $.each(data, function(i, month){
                        $('#month_id').append('<option value="'+month.id+'">'+month.month_name+'</option>');
                    });
                    $('#month_id').prop('disabled', false);
                }
            });
        } else {
            $('#month_id').empty().append('<option value="">اختر الشهر</option>').prop('disabled', true);
        }
    });

});
</script>

@endsection

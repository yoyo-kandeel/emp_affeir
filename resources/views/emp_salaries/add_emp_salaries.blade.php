@extends('layouts.master')

@section('title','إضافة كشف مرتب')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('emp_salaries.index') }}"> المرتبات</a></span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة كشف مرتب</span>
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

                <form action="{{ route('emp_salaries.store') }}" method="POST">
                    @csrf

                    {{-- البحث عن الموظف --}}
                    <div class="form-group mb-3 position-relative">
                        <label>بحث عن الموظف</label>
                        <input type="text" id="employee_search" class="form-control" placeholder="اكتب اسم أو رقم الموظف">
                        <ul id="employee_results" class="list-group mt-1" style="position:absolute; z-index:999;"></ul>
                        <input type="hidden" name="emp_id" id="emp_id">
                    </div>

                    {{-- اختيار السنة والشهر --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>السنة</label>
                            <select name="year_id" id="year_id" class="form-control select2">
                                <option value="">اختر السنة</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>الشهر</label>
                            <select name="month_id" id="month_id" class="form-control select2" disabled>
                                <option value="">اختر الشهر</option>
                            </select>
                        </div>
                    </div>

                    {{-- بيانات المرتب --}}
                    <div class="card mb-3">
                        <div class="card-header">بيانات المرتب</div>
                        <div class="card-body row">
                            <div class="col-md-3 mb-2">
                                <label>الراتب الأساسي</label>
                                <input type="number" name="basic_salary" id="basic_salary" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>عدد أيام العمل</label>
                                <input type="number" name="working_days" id="working_days" value="30" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قيمة اليوم</label>
                                <input type="text" id="daily_rate" class="form-control" readonly>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قيمة الساعة</label>
                                <input type="text" id="hourly_rate" class="form-control" readonly>
                            </div>
                            <div class="col-md-3 mb-2">
                            <label>مؤمن عليه</label>
                            <input type="text" id="insurance_status" class="form-control" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>مبلغ التأمين</label>
                            <input type="text" id="insurance_amount" class="form-control" readonly>
                        </div>

                        </div>
                    </div>

                    {{-- الخصومات --}}
                    <div class="card mb-3">
                        <div class="card-header">الخصومات</div>
                        <div class="card-body row">
                            <div class="col-md-3 mb-2">
                                <label>أيام الغياب</label>
                                <input type="number" name="absence_days" id="absence_days" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>ساعات التأخير</label>
                                <input type="number" name="delay_hours" id="delay_hours" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>الجزاءات</label>
                                <input type="number" name="penalties" id="penalties" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>إجمالي الخصومات</label>
                                <input type="text" id="total_deductions" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- البدلات --}}
                    <div class="card mb-3">
                        <div class="card-header">البدلات</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>اسم البدل</th>
                                        <th>القيمة</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="allowances_table">
                                    <!-- البدلات سيتم تحميلها بواسطة AJAX -->
                                </tbody>
                            </table>
                            <button type="button" id="add_allowance" class="btn btn-primary btn-sm">إضافة بدل</button>
                            <div class="mt-2"><strong>إجمالي البدلات: </strong><span id="total_allowances">0</span></div>
                        </div>
                    </div>

                    {{-- صافي المرتب --}}
                    <div class="card bg-light mb-3">
                        <div class="card-body text-center">
                            <h4>صافي المرتب</h4>
                            <h2 id="net_salary">0</h2>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="las la-save"></i> حفظ كشف المرتب
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>

 <script>
$(document).ready(function(){

/* ===============================
   🔎 البحث عن الموظف
================================ */
$('#employee_search').on('keyup', function(){
    let query = $(this).val();
    if(query.length >= 1){
        $.ajax({
            url: "{{ route('emp.search') }}",
            type: 'GET',
            data: { search: query },
            success: function(data){
                $('#employee_results').empty();
                if(data.length){
                    $.each(data,function(i,emp){
                        $('#employee_results').append(`
                            <li class="list-group-item list-group-item-action"
                                data-id="${emp.id}">
                                ${emp.emp_number} - ${emp.full_name}
                            </li>
                        `);
                    });
                }else{
                    $('#employee_results').append('<li class="list-group-item">لا يوجد نتائج</li>');
                }
            }
        });
    }else{
        $('#employee_results').empty();
        $('#emp_id').val('');
    }
});

/* ===============================
   👤 اختيار الموظف
================================ */
$(document).on('click','#employee_results li', function(){
    let empId   = $(this).data('id');
    let empText = $(this).text();

    $('#employee_search').val(empText);
    $('#emp_id').val(empId);

    localStorage.setItem('salary_emp_id', empId);
    localStorage.setItem('salary_emp_text', empText);

    $('#employee_results').empty();
    loadEmployeeData();
});

/* ===============================
   ❌ إغلاق نتائج البحث
================================ */
$(document).click(function(e){
    if(!$(e.target).closest('#employee_search,#employee_results').length){
        $('#employee_results').empty();
    }
});

/* ===============================
   📅 تحميل الشهور عند اختيار السنة
================================ */
$('#year_id').change(function(){
    let year_id = $(this).val();
    localStorage.setItem('salary_year', year_id);

    if(year_id){
        $.ajax({
            url: "{{ route('months.byYear') }}",
            type: 'GET',
            data: { year_id },
            success: function(data){
                $('#month_id').empty().append('<option value="">اختر الشهر</option>');
                $.each(data,function(i,month){
                    $('#month_id').append(`
                        <option value="${month.id}">${month.month_name}</option>
                    `);
                });
                $('#month_id').prop('disabled', false);
            }
        });
    }
});

/* ===============================
   🗓️ اختيار الشهر
================================ */
$('#month_id').change(function(){
    localStorage.setItem('salary_month', $(this).val());
    loadEmployeeData();
});

/* ===============================
   🧮 حساب اليومي والساعة
================================ */
function calculateRates(){
    let salary = parseFloat($('#basic_salary').val()) || 0;
    let days   = parseFloat($('#working_days').val()) || 30;

    $('#daily_rate').val((salary / days).toFixed(2));
    $('#hourly_rate').val((salary / days / 8).toFixed(2));
}

/* ===============================
   💰 حساب الإجماليات
================================ */
function calculateTotals(){
    let absence = parseFloat($('#absence_days').val()) || 0;
    let delay   = parseFloat($('#delay_hours').val()) || 0;
    let penalty = parseFloat($('#penalties').val()) || 0;

    let daily  = parseFloat($('#daily_rate').val()) || 0;
    let hourly = parseFloat($('#hourly_rate').val()) || 0;

    let deductions = (absence * daily) + (delay * hourly) + penalty;

    // خصم التأمين
    let insurance = parseFloat($('#insurance_amount').val()) || 0;
    if($('#insurance_status').val() == 1){
        deductions += insurance;
    }

    $('#total_deductions').val(deductions.toFixed(2));

    let allowances = 0;
    $('.allowance_amount').each(function(){
        allowances += parseFloat($(this).val()) || 0;
    });

    $('#total_allowances').text(allowances.toFixed(2));

    let net = (parseFloat($('#basic_salary').val()) || 0) + allowances - deductions;
    $('#net_salary').text(net.toFixed(2));
}

/* ===============================
   🔁 تحديث الحساب
================================ */
$(document).on('input',
    '#basic_salary,#working_days,#absence_days,#delay_hours,#penalties,#insurance_amount,.allowance_amount',
    function(){
        calculateRates();
        calculateTotals();
});

/* ===============================
   ➕ إضافة بدل
================================ */
let i = 0;
$('#add_allowance').click(function(){
    $('#allowances_table').append(`
        <tr>
            <td>
                <select name="allowances[${i}][id]" class="form-control">
                    <option value="">اختر البدل</option>
                </select>
            </td>
            <td>
                <input name="allowances[${i}][amount]" class="form-control allowance_amount">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
            </td>
        </tr>
    `);
    i++;
});

/* ===============================
   ❌ حذف بدل
================================ */
$(document).on('click','.remove-row',function(){
    $(this).closest('tr').remove();
    calculateTotals();
});

/* ===============================
   📡 تحميل بيانات الموظف
================================ */
function loadEmployeeData(){
    let emp_id   = $('#emp_id').val();
    let year_id  = $('#year_id').val();
    let month_id = $('#month_id').val();

    if(emp_id && year_id && month_id){
        $.ajax({
            url: "{{ route('emp_salaries.getEmployeeData') }}",
            type: 'GET',
            data: { emp_id, year_id, month_id },
            success: function(res){
                if(res.error) return alert(res.error);

                $('#basic_salary').val(res.basic_salary);
                $('#insurance_status').val(res.insured ? 1 : 0);
                $('#insurance_amount').val(res.insurance_amount);

                $('#absence_days').val(res.deductions.absence_days);
                $('#delay_hours').val(res.deductions.delay_hours);
                $('#penalties').val(res.deductions.penalties);

                $('#allowances_table').empty();
                res.allowances.forEach(function(a,index){
                    $('#allowances_table').append(`
                        <tr>
                            <td>${a.name}</td>
                            <td>
                                <input name="allowances[${index}][amount]"
                                       class="form-control allowance_amount"
                                       value="${a.amount}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
                            </td>
                        </tr>
                    `);
                });

                calculateRates();
                calculateTotals();
            }
        });
    }
}

/* ===============================
   ♻️ استرجاع القيم بعد Refresh
================================ */
let savedYear  = localStorage.getItem('salary_year');
let savedMonth = localStorage.getItem('salary_month');
let savedEmpId = localStorage.getItem('salary_emp_id');
let savedEmpText = localStorage.getItem('salary_emp_text');

if(savedYear){
    $('#year_id').val(savedYear).trigger('change');
}

if(savedEmpId && savedEmpText){
    $('#emp_id').val(savedEmpId);
    $('#employee_search').val(savedEmpText);
}

setTimeout(function(){
    if(savedMonth){
        $('#month_id').val(savedMonth);
        loadEmployeeData();
    }
}, 800);

});
</script>

@endsection

@extends('layouts.master')

@section('title','تعديل كشف مرتب')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('emp_salaries.index') }}"> المرتبات</a></span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل كشف مرتب</span>
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

                <form action="{{ route('emp_salaries.update',$salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- البحث عن الموظف --}}
                    <div class="form-group mb-3">
                        <label>بحث عن الموظف</label>
                        <input type="text" id="employee_search" class="form-control" value="{{ $salary->emp->full_name }}" readonly>
                        <input type="hidden" name="emp_id" id="emp_id" value="{{ $salary->emp_id }}">
                    </div>

                    {{-- السنة والشهر --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>السنة</label>
                            <select name="year_id" id="year_id" class="form-control">
                                <option value="">اختر السنة</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}" {{ $salary->year_id==$year->id ? 'selected':'' }}>{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>الشهر</label>
                            <select name="month_id" id="month_id" class="form-control">
                                <option value="">اختر الشهر</option>
                                @foreach($months as $month)
                                    <option value="{{ $month->id }}" {{ $salary->month_id==$month->id ? 'selected':'' }}>{{ $month->month_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- بيانات المرتب --}}
                    <div class="card mb-3">
                        <div class="card-header">بيانات المرتب</div>
                        <div class="card-body row">
                            <div class="col-md-3 mb-2">
                                <label>الراتب الأساسي</label>
                                <input type="number" name="basic_salary" id="basic_salary" class="form-control" value="{{ $salary->basic_salary }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>عدد أيام العمل</label>
                                <input type="number" name="working_days" id="working_days" value="{{ $salary->working_days }}" class="form-control">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قيمة اليوم</label>
                                <input type="text" id="daily_rate" class="form-control" readonly value="{{ $salary->daily_rate }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قيمة الساعة</label>
                                <input type="text" id="hourly_rate" class="form-control" readonly value="{{ $salary->hourly_rate }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>مؤمن عليه</label>
                                <select id="insurance_status" name="insurance_status" class="form-control">
                                    <option value="0" {{ $salary->insurance_status==0 ? 'selected':'' }}>لا</option>
                                    <option value="1" {{ $salary->insurance_status==1 ? 'selected':'' }}>نعم</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>مبلغ التأمين</label>
                                <input type="number" id="insurance_amount" name="insurance_amount" class="form-control" value="{{ $salary->insurance_amount }}">
                            </div>
                        </div>
                    </div>

                    {{-- الخصومات --}}
                    <div class="card mb-3">
                        <div class="card-header">الخصومات</div>
                        <div class="card-body row">
                            <div class="col-md-3 mb-2">
                                <label>أيام الغياب</label>
                                <input type="number" name="absence_days" id="absence_days" class="form-control" value="{{ $salary->absence_days }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>ساعات التأخير</label>
                                <input type="number" name="delay_hours" id="delay_hours" class="form-control" value="{{ $salary->delay_hours }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>الجزاءات</label>
                                <input type="number" name="penalties" id="penalties" class="form-control" value="{{ $salary->penalties }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>إجمالي الخصومات</label>
                                <input type="text" id="total_deductions" class="form-control" readonly value="{{ $salary->total_deductions }}">
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
                                    @foreach($salary->allowances as $i => $a)
                                        <tr>
                                            <td>
                                                <select name="allowances[{{ $i }}][id]" class="form-control allowance_select">
                                                    <option value="{{ $a->allowance_id }}">{{ $a->allowance->allowance_name }}</option>
                                                </select>
                                            </td>
                                            <td><input name="allowances[{{ $i }}][amount]" class="form-control allowance_amount" value="{{ $a->amount }}"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2"><strong>إجمالي البدلات: </strong><span id="total_allowances">{{ $salary->total_allowances }}</span></div>
                        </div>
                    </div>

                    {{-- صافي المرتب --}}
                    <div class="card bg-light mb-3">
                        <div class="card-body text-center">
                            <h4>صافي المرتب</h4>
                            <h2 id="net_salary">{{ $salary->net_salary }}</h2>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="las la-save"></i> حفظ التعديل
                    </button>

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

    // حساب اليومي والساعة
    function calculateRates(){
        let salary = parseFloat($('#basic_salary').val()) || 0;
        let days = parseFloat($('#working_days').val()) || 30;
        $('#daily_rate').val((salary/days).toFixed(2));
        $('#hourly_rate').val((salary/days/8).toFixed(2));
    }

    // حساب الخصومات والبدلات وصافي المرتب
    function calculateTotals(){
        let absence = parseFloat($('#absence_days').val()) || 0;
        let delay = parseFloat($('#delay_hours').val()) || 0;
        let penalty = parseFloat($('#penalties').val()) || 0;
        let daily = parseFloat($('#daily_rate').val()) || 0;
        let hourly = parseFloat($('#hourly_rate').val()) || 0;

        let deductions = (absence*daily) + (delay*hourly) + penalty;

        // خصم التأمين إذا كان مؤمن عليه
        let insurance = parseFloat($('#insurance_amount').val()) || 0;
        if($('#insurance_status').val() == '1'){
            deductions += insurance;
        }

        $('#total_deductions').val(deductions.toFixed(2));

        let allowances = 0;
        $('.allowance_amount').each(function(){ allowances += parseFloat($(this).val()) || 0; });
        $('#total_allowances').text(allowances.toFixed(2));

        let net = (parseFloat($('#basic_salary').val()) || 0) + allowances - deductions;
        $('#net_salary').text(net.toFixed(2));
    }

    // تحديث الحساب عند تغيير أي قيمة
    $(document).on('input','#basic_salary,#working_days,#absence_days,#delay_hours,#penalties,.allowance_amount,#insurance_amount,#insurance_status',function(){
        calculateRates();
        calculateTotals();
    });

    // حساب أول مرة
    calculateRates();
    calculateTotals();

});
</script>
@endsection

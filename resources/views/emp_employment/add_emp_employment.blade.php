@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!-- custom css -->
    <link href="{{ URL::asset('assets/css-rtl/custom_add_emp.css') }}" rel="stylesheet">

@endsection
@section('title','  إضافة بيانات توظيف جديدة')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                 <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  <a href="{{ url('emp_employment') }}">بيانات التوظيف</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/    إضافة بيانات توظيف جديدة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    @include('layouts.maseg')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('emp_employment.store') }}" method="POST" autocomplete="off">
                    @csrf

                    {{-- ================= البيانات الأساسية ================= --}}
                    <div class="card mb-3">
                        <div class="card-header">البيانات الأساسية</div>
                        <div class="card-body row">

                            <div class="col-md-6 mb-2">
                            <label>بحث عن الموظف بالاسم أو الرقم <span class="text-danger">*</span></label>
                            <input type="text" id="employee_search" class="form-control" placeholder="اكتب الاسم أو رقم الموظف">
                            <ul id="employee_results" class="list-group mt-1" style="position: absolute; z-index: 999;"></ul>
                            <input type="hidden" name="emp_id" id="emp_id">
                        </div>


                            <div class="col-md-4 mb-2">
                                <label>الراتب الأساسي <span class="text-danger">*</span></label>
                                <input type="number" name="basic_salary" class="form-control" step="0.1" >
                            </div>

                           <div class="col-md-4 mb-2">
                            <label>مؤمن عليه؟</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="insured" id="insured_yes" value="1">
                                <label class="form-check-label" for="insured_yes">نعم</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="insured" id="insured_no" value="0" checked>
                                <label class="form-check-label" for="insured_no">لا</label>
                            </div>
                        </div>


                        </div>
                    </div>

                    {{-- ================= بيانات التأمين ================= --}}
                    <div id="insurance_card" class="card mb-3">
                        <div  class="card-header">بيانات التأمين</div>
                        <div class="card-body row">

                            <div class="col-md-4 mb-2">
                                <label>تاريخ التأمين</label>
                                <input type="date" name="insurance_date" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>نسبة التأمين (%)</label>
                                <input type="number" name="insurance_rate" class="form-control" step="0.1">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>مبلغ التأمين</label>
                                <input type="number" name="insurance_amount" class="form-control" step="0.1">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الرقم التأمين</label>
                                <input type="number" name="insurance_number" class="form-control" step="1">
                            </div>
                            

                        </div>
                    </div>


                    {{-- ================= زر الحفظ ================= --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="las la-save"></i> حفظ بيانات التوظيف
                            </button>
                        </div>
                    </div>

                </form>

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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>




{{-- سكربت للأرقام فقط --}}
<script>
    document.querySelectorAll('input[type="text"][name="basic_salary"], input[name="insurance_rate"], input[name="insurance_amount"]').forEach(function(input){
        input.addEventListener('input', function(){
            this.value = this.value.replace(/[^0-9]/g,'');
        });
    });
</script>


<script>
$(document).ready(function(){

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

    // اختيار الموظف من القائمة
    $(document).on('click','#employee_results li', function(){
        let id = $(this).data('id');
        let text = $(this).text();
        $('#employee_search').val(text);
        $('#emp_id').val(id);
        $('#employee_results').empty();
    });

});

</script>



<script>
$(document).ready(function () {

    function calculateInsuranceAmount() {
        let salary = parseFloat($('input[name="basic_salary"]').val()) || 0;
        let rate   = parseFloat($('input[name="insurance_rate"]').val()) || 0;

        if (salary > 0 && rate > 0) {
            let amount = (salary * rate) / 100;
            $('input[name="insurance_amount"]').val(amount.toFixed(2));
        }
    }

    function calculateInsuranceRate() {
        let salary = parseFloat($('input[name="basic_salary"]').val()) || 0;
        let amount = parseFloat($('input[name="insurance_amount"]').val()) || 0;

        if (salary > 0 && amount > 0) {
            let rate = (amount / salary) * 100;
            $('input[name="insurance_rate"]').val(rate.toFixed(2));
        }
    }

    // عند تغيير الراتب أو النسبة
    $('input[name="basic_salary"], input[name="insurance_rate"]').on('input', function () {
        if ($('#insured_yes').is(':checked')) {
            calculateInsuranceAmount();
        }
    });

    // عند تغيير مبلغ التأمين
    $('input[name="insurance_amount"]').on('input', function () {
        if ($('#insured_yes').is(':checked')) {
            calculateInsuranceRate();
        }
    });

    // عند اختيار "لا"
    $('#insured_no').on('change', function () {
        $('#insurance_card').hide();
        $('input[name="insurance_date"], input[name="insurance_rate"], input[name="insurance_amount"], input[name="insurance_number"]').val('');
    });

    // عند اختيار "نعم"
    $('#insured_yes').on('change', function () {
        $('#insurance_card').fadeIn();
    });

    // الحالة الافتراضية عند تحميل الصفحة
    if ($('#insured_no').is(':checked')) {
        $('#insurance_card').hide();
    }

});
</script>





@endsection

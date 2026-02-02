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
@section('title',' اضافة موظف جديد')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                 <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  <a href="{{ url('emp_data') }}">بيانات الموظفين</a></span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  اضافة موظف جديد</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    @include('layouts.maseg')

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route(name: 'emp_data.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf


    {{-- ================= البيانات الأساسية ================= --}}
    <div class="card mb-3">
        <div class="card-header">البيانات الأساسية</div>
        <div class="card-body row">

            <div class="col-md-4 mb-2">
                <label>رقم الموظف</label>
                <input type="text" name="emp_number" class="form-control" value="{{ $empNumber }}" readonly>
            </div>

            <div class="col-md-4 mb-2">
                <label>الاسم الكامل <span class="text-danger">*</span></label>
                <input type="text" name="full_name" class="form-control" >
            </div>

            <div class="col-md-4 mb-2">
                <label>الاسم بالإنجليزي</label>
                <input type="text" name="english_name" class="form-control">
            </div>

        </div>
    </div>

   {{-- ================= البيانات الشخصية ================= --}}
<div class="card mb-3">
    <div class="card-header">البيانات الشخصية</div>
    <div class="card-body row">

        <div class="col-md-3 mb-2">
            <label>تاريخ الميلاد</label>
            <input type="date" name="birth_date" class="form-control">
        </div>

        <div class="col-md-3 mb-2">
            <label>مكان الميلاد</label>
            <input type="text" name="birth_place" class="form-control">
        </div>

        <div class="col-md-3 mb-2">
            <label>النوع</label>
            <select name="gender" class="form-control">
                <option value="">اختر</option>
                <option value="ذكر">ذكر</option>
                <option value="أنثى">أنثى</option>
            </select>
        </div>

        <div class="col-md-3 mb-2">
            <label>الديانة</label>
            <select name="religion" class="form-control">
                <option value="">اختر</option>
                <option value="مسلم">مسلم</option>
                <option value="مسيحي">مسيحي</option>
            </select>
        </div>

       
        <div class="col-md-3 mb-2">
            <label>الجنسية</label>
            <input type="text" name="nationality" class="form-control">
        </div>

        
        <div class="col-md-3 mb-2">
            <label>الحالة الاجتماعية</label>
            <select name="marital_status" class="form-control">
                <option value="">اختر</option>
                <option value="أعزب">أعزب</option>
                <option value="متزوج">متزوج</option>
                <option value="مطلق">مطلق</option>
                <option value="أرمل">أرمل</option>
            </select>
        </div>

        <div class="col-md-4 mb-2">
            <label>الرقم القومي <span class="text-danger">*</span></label>
            <input type="text" name="national_id" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
        </div>

        <div class="col-md-4 mb-2">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
        </div>

        <div class="col-md-4 mb-2">
            <label>العنوان</label>
            <textarea name="address" class="form-control" rows="1"></textarea>
        </div>

    </div>
</div>


    {{-- ================= البيانات الوظيفية ================= --}}
    <div class="card mb-3">
        <div class="card-header">البيانات الوظيفية</div>
        <div class="card-body row">

            <div class="col-md-4 mb-2">
                <label>الإدارة <span class="text-danger">*</span></label>
                <select name="department_id" class="form-control">
                    <option value="">اختر الإدارة</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label>الوظيفة <span class="text-danger">*</span></label>
                <select name="job_id" class="form-control">
                    <option value="">اختر الوظيفة</option>
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label>كود البصمة <span class="text-danger">*</span></label>
                <input type="text" name="print_id" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>

            <div class="col-md-4 mb-2">
                <label>تاريخ التعيين</label>
                <input type="date" name="hire_date" class="form-control">
            </div>

           

        </div>
    </div>

    {{-- ================= المهارات والملاحظات ================= --}}
    <div class="card mb-3">
        <div class="card-header">المهارات والملاحظات</div>
        <div class="card-body row">

            <div class="col-md-4 mb-2">
                <label>إجادة الكمبيوتر</label>
                <input type="text" name="computer_skills" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>مستوى اللغة الإنجليزية</label>
                <input type="text" name="english_proficiency" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>الشهادة</label>
                <input type="text" name="certificate" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>الملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-2">
                <label>صورة الشخصية</label>
                <input type="file" name="profile_image" class="dropify">
            </div>

        </div>
    </div>

    {{-- ================= البيانات الإضافية ================= --}}
    <div class="card mb-3">
        <div class="card-header">بيانات إضافية</div>
        <div class="card-body row">

            <div class="col-md-4 mb-2">
                <label>الموقف من التجنيد</label>
                <input type="text" name="status_service" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>الخبرات السابقة</label>
                <input type="text" name="experience" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>عدد الأطفال</label>
                <input type="number" name="children_count" class="form-control" min="0">
            </div>

            {{-- تم الإنشاء بواسطة --}}
            <input type="hidden" name="created_by" value="{{ auth()->user()->name }}">

        </div>
    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="las la-save"></i> حفظ البيانات
                            </button>
                            @can('استيراد اكسيل موظفين')
                            <a class="modal-effect btn btn-outline-primary btn-lg ms-2" data-effect="effect-slide-in-bottom" data-toggle="modal" href="#modaldemo8">
                                <i class="las la-file-excel"></i> استيراد ملف إكسل
                            </a>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>

            <!-- Modal effects -->
            <div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
                            <h6 class="modal-title">اضافة موظفون جدد</h6>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('emp_data.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اختر ملف Excel</label>
                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls">
                            </div>
                            <button type="submit" class="btn btn-success mt-2">استيراد البيانات</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal effects -->
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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


    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
<script>
$(document).ready(function() {
    $('select[name="department_id"]').on('change', function() {
        var departmentId = $(this).val(); // أخذ قيمة الإدارة
        var $jobSelect = $('select[name="job_id"]');
        $jobSelect.empty();
        $jobSelect.append('<option value="" selected disabled>اختر الوظيفة</option>');

        if (departmentId) {
            $.ajax({
                url: '/department/' + departmentId + '/jobs', // الرابط الصحيح للـ route
                type: 'GET',
                dataType: 'json',
                success: function(data) {
             $.each(data, function(index, job) {
    $jobSelect.append('<option value="' + job.id + '">' + job.job_name + '</option>');

                        console.log("Job added: " + job.job_name + " " + job.id);
                    });
                },
                error: function() {
                    alert('حدث خطأ أثناء جلب الوظائف');
                }
            });
        } else {
            console.log('لم يتم اختيار إدارة');
        }
    });
});
</script>

{{-- سكربت للأرقام فقط --}}
<script>
    document.querySelectorAll('input[type="text"][name="print_id"], input[name="national_id"], input[name="phone"]').forEach(function(input){
        input.addEventListener('input', function(){
            this.value = this.value.replace(/[^0-9]/g,'');
        });
    });
</script>






@endsection

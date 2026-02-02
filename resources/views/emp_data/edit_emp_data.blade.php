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

@section('title','تعديل بيانات الموظف')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
               <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  <a href="{{ url('emp_data') }}">بيانات الموظفين</a></span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل بيانات الموظف</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg')

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('emp_data.update', $emp->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')

                    {{-- البيانات الأساسية --}}
                    <div class="card mb-3">
                        <div class="card-header">البيانات الأساسية</div>
                        <div class="card-body row">

                            <div class="col-md-4 mb-2">
                                <label>رقم الموظف</label>
                                <input type="text" name="emp_number" class="form-control" value="{{ $emp->emp_number }}" readonly>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>الاسم الكامل <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $emp->full_name) }}">
                                @error('full_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>الاسم بالإنجليزي</label>
                                <input type="text" name="english_name" class="form-control" value="{{ old('english_name', $emp->english_name) }}">
                                @error('english_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- البيانات الشخصية --}}
                    <div class="card mb-3">
                        <div class="card-header">البيانات الشخصية</div>
                        <div class="card-body row">
                            <div class="col-md-3 mb-2">
                                <label>تاريخ الميلاد</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $emp->birth_date) }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>مكان الميلاد</label>
                                <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $emp->birth_place) }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>النوع</label>
                                <select name="gender" class="form-control">
                                    <option value="">اختر</option>
                                    <option value="ذكر" {{ old('gender', $emp->gender)=='ذكر' ? 'selected':'' }}>ذكر</option>
                                    <option value="أنثى" {{ old('gender', $emp->gender)=='أنثى' ? 'selected':'' }}>أنثى</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>الديانة</label>
                                <select name="religion" class="form-control">
                                    <option value="">اختر</option>
                                    <option value="مسلم" {{ old('religion', $emp->religion)=='مسلم' ? 'selected':'' }}>مسلم</option>
                                    <option value="مسيحي" {{ old('religion', $emp->religion)=='مسيحي' ? 'selected':'' }}>مسيحي</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>الجنسية</label>
                                <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $emp->nationality) }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>الحالة الاجتماعية</label>
                                <select name="marital_status" class="form-control">
                                    <option value="">اختر</option>
                                    <option value="أعزب" {{ old('marital_status', $emp->marital_status)=='أعزب' ? 'selected':'' }}>أعزب</option>
                                    <option value="متزوج" {{ old('marital_status', $emp->marital_status)=='متزوج' ? 'selected':'' }}>متزوج</option>
                                    <option value="مطلق" {{ old('marital_status', $emp->marital_status)=='مطلق' ? 'selected':'' }}>مطلق</option>
                                    <option value="أرمل" {{ old('marital_status', $emp->marital_status)=='أرمل' ? 'selected':'' }}>أرمل</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الرقم القومي</label>
                                <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $emp->national_id) }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $emp->phone) }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>العنوان</label>
                                <textarea name="address" class="form-control" rows="1">{{ old('address', $emp->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- البيانات الوظيفية --}}
                    <div class="card mb-3">
                        <div class="card-header">البيانات الوظيفية</div>
                        <div class="card-body row">
                            <div class="col-md-4 mb-2">
                                <label>الإدارة <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-control">
                                    <option value="">اختر الإدارة</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $emp->department_id)==$department->id ? 'selected':'' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الوظيفة <span class="text-danger">*</span></label>
                                <select name="job_id" class="form-control">
                                    <option value="">اختر الوظيفة</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" {{ old('job_id', $emp->job_id)==$job->id ? 'selected':'' }}>{{ $job->job_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>كود البصمة <span class="text-danger">*</span></label>
                                <input type="text" name="print_id" class="form-control" value="{{ old('print_id', $emp->print_id) }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>تاريخ التعيين</label>
                                <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $emp->hire_date) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الحالة</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status', $emp->status)=='1' ? 'selected':'' }}>نشط</option>
                                    <option value="0" {{ old('status', $emp->status)=='0' ? 'selected':'' }}>غير نشط</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- المهارات والملاحظات --}}
                    <div class="card mb-3">
                        <div class="card-header">المهارات والملاحظات</div>
                        <div class="card-body row">
                            <div class="col-md-4 mb-2">
                                <label>إجادة الكمبيوتر</label>
                                <input type="text" name="computer_skills" class="form-control" value="{{ old('computer_skills', $emp->computer_skills) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>مستوى اللغة الإنجليزية</label>
                                <input type="text" name="english_proficiency" class="form-control" value="{{ old('english_proficiency', $emp->english_proficiency) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الشهادة</label>
                                <input type="text" name="certificate" class="form-control" value="{{ old('certificate', $emp->certificate) }}">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>الملاحظات</label>
                                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $emp->notes) }}</textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>صورة الشخصية</label>
                                <input type="file" name="profile_image" class="dropify">
                            </div>
                        </div>
                    </div>

                    {{-- بيانات إضافية --}}
                    <div class="card mb-3">
                        <div class="card-header">بيانات إضافية</div>
                        <div class="card-body row">
                            <div class="col-md-4 mb-2">
                                <label>الموقف من التجنيد</label>
                                <input type="text" name="status_service" class="form-control" value="{{ old('status_service', $emp->status_service) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>الخبرات السابقة</label>
                                <input type="text" name="experience" class="form-control" value="{{ old('experience', $emp->experience) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>عدد الأطفال</label>
                                <input type="number" name="children_count" class="form-control" min="0" value="{{ old('children_count', $emp->children_count) }}">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">تعديل البيانات</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- هنا كل السكربتات كما هي بدون تعديل -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
</script>

<script>
$(document).ready(function() {
    $('select[name="department_id"]').on('change', function() {
        var departmentId = $(this).val();
        var $jobSelect = $('select[name="job_id"]');
        $jobSelect.empty().append('<option value="" selected disabled>اختر الوظيفة</option>');

        if(departmentId) {
            $.ajax({
                url: '/department/' + departmentId + '/jobs',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, job) {
                        $jobSelect.append('<option value="'+job.id+'">'+job.job_name+'</option>');
                    });
                },
                error: function() {
                    alert('حدث خطأ أثناء جلب الوظائف');
                }
            });
        }
    });
});
</script>

<script>
    document.querySelectorAll('input[type="text"][name="print_id"], input[name="national_id"], input[name="phone"]').forEach(function(input){
        input.addEventListener('input', function(){ this.value = this.value.replace(/[^0-9]/g,''); });
    });
</script>
@endsection

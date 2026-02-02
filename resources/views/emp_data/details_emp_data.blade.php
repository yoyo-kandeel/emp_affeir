@extends('layouts.master')


@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title','تفاصيل الموظف')
 
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
  <h4 class="content-title mb-0 my-auto">إدارة الموظفين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  <a href="{{ url('emp_data') }}">بيانات الموظفين</a></span>
                                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الموظف</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

<!-- row opened -->
<div class="row row-sm">
    @include('layouts.maseg')

    <div class="col-xl-12">
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">المعلومات الشخصية</a></li>
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">البيانات الوظيفية والخبرات</a></li>
                                        <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                 <!-- Tab 1: معلومات الموظف -->
<div class="tab-pane active" id="tab1">
    <div class="table-responsive mt-15">
        <table class="table table-striped text-center">
            <tbody>
                <tr>
                    <th>الاسم الكامل</th>
                    <td>{{ $emp->full_name ?? '-' }}</td>
                    <th>الاسم بالإنجليزي</th>
                    <td>{{ $emp->english_name ?? '-' }}</td>
                    <th>تاريخ الميلاد</th>
                    <td>{{ $emp->birth_date ? $emp->birth_date->format('d-m-Y') : '-' }}</td>
                    <th>مكان الميلاد</th>
                    <td>{{ $emp->birth_place ?? '-' }}</td>
                </tr>
                <tr>
                    <th>النوع</th>
                    <td>{{ $emp->gender ?? '-' }}</td>
                    <th>الجنسية</th>
                    <td>{{ $emp->nationality ?? '-' }}</td>
                    <th>الحالة الاجتماعية</th>
                    <td>{{ $emp->marital_status ?? '-' }}</td>
                    <th>عدد الأطفال</th>
                    <td>{{ $emp->children_count ?? 0 }}</td>
                </tr>
                <tr>
                    <th>الرقم القومي</th>
                    <td>{{ $emp->national_id ?? '-' }}</td>
                    <th>رقم الهاتف</th>
                    <td>{{ $emp->phone ?? '-' }}</td>
                    <th>العنوان</th>
                    <td colspan="3">{{ $emp->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>الديانة</th>
<td>{{ $emp->religion }}</td>
                    <th>الموقف من التجنيد </th>
                    <td>{{ $emp->status_service ?? '-' }}</td>
                    <th>ملاحظات</th>
                    <td colspan="3">{{ $emp->notes ?? '-' }}</td>
                </tr>
                <tr>
<th>صورة الموظف</th>
<td colspan="7">
    @if($emp->profile_image)
        <img src="{{ asset('storage/' . $emp->profile_image) }}" 
             style="width: 150px; height: 150px;"
             alt="صورة الموظف">
    @else
        -
    @endif
</td>


                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Tab 2: البيانات الوظيفية والخبرات -->
<div class="tab-pane" id="tab2">
    <div class="table-responsive mt-15">
        <table class="table table-striped text-center">
            <tbody>
                <tr>
                    <th>تاريخ التعيين</th>
                    <td>{{ $emp->hire_date ? $emp->hire_date->format('d-m-Y') : '-' }}</td>
                    <th>القسم</th>
                    <td>{{ $emp->department->department_name ?? '-' }}</td>
                    <th>الوظيفة</th>
                    <td>{{ $emp->job->job_name ?? '-' }}</td>
                    <th>الحالة الوظيفية</th>
                    <td>{{ $emp->status ?? '-' }}</td>
                </tr>
                <tr>
                    <th>الخبرات السابقة</th>
                    <td colspan="3">{{ $emp->experience ?? '-' }}</td>
                    <th>الشهادة</th>
                    <td>{{ $emp->certificate ?? '-' }}</td>
                    <th>مهارات الكمبيوتر</th>
                    <td>{{ $emp->computer_skills ?? '-' }}</td>
                </tr>
                <tr>
                    <th>مستوى اللغة الإنجليزية</th>
                    <td colspan="7">{{ $emp->english_proficiency ?? '-' }}</td>
                </tr>
                <tr>
                    <th>كود البصمة</th>
                    <td colspan="7">{{ $emp->print_id ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                                    <!-- Tab 3: المرفقات -->
                                    <div class="tab-pane" id="tab3">
                                        <div class="card card-statistics">
                                            <div class="card-body">
                                                @can('اضافة مرفق موظف')
                                                <p class="text-danger">* صيغة المرفق pdf,xlsx,xls,docx,jpg,png,jpeg</p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                             <form method="POST" action="{{ route('empAttachments') }}" enctype="multipart/form-data">
    @csrf
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" name="attachment" required>
        <input type="hidden" name="emp_id" value="{{ $emp->id }}">
        <label class="custom-file-label" for="customFile">حدد المرفق</label>
    </div><br><br>
    <button type="submit" class="btn btn-primary btn-sm">تأكيد</button>
</form>
@endcan
                                            </div>

                                            <div class="table-responsive mt-15">
                                               @if($attachments->count() > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الملف</th>
                <th>تم الإضافة بواسطة</th>
                <th>تاريخ الإضافة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attachments as $attachment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attachment->file_name }}</td>
                    <td>{{ $attachment->created_by }}</td>
                    <td>{{ $attachment->created_at->format('d-m-Y H:i') }}</td>
                    <td>
@can('عرض مرفق موظف')
                        <a class="btn btn-outline-success btn-sm"
                           href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
@endcan
@can('تحميل مرفق موظف')
                        <a class="btn btn-outline-info btn-sm"
                           href="{{ asset('storage/' . $attachment->file_path) }}" download>
                            <i class="fas fa-download"></i>
                        </a>
@endcan
@can('حذف مرفق موظف')
                     <button class="btn btn-outline-danger btn-sm"
        data-toggle="modal"
        data-target="#delete_file"
        data-id_file="{{ $attachment->id }}"
        data-file_name="{{ $attachment->file_name }}">
    حذف
</button>
@endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>لا يوجد مرفقات.</p>
@endif

                                            </div>

                                        </div>
                                    </div>

                                </div> <!-- tab-content -->
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div>
                </div>

<div class="btn-group" role="group" style="gap:5px;">
@can('تعديل موظف')
<a href="{{ route('emp_data.edit', ['emp_datum' => $emp->id]) }}"
   class="btn btn-sm btn-primary"
   title="تعديل الموظف">
    <i class="fas fa-edit"></i> تعديل الموظف
</a>
@endcan

@can('حذف موظف')
<button class="btn btn-sm btn-danger"
        data-toggle="modal"
        data-target="#delete_employee"
        data-id="{{ $emp->id }}">
    <i class="fas fa-trash-alt"></i> حذف الموظف
</button>
@endcan


@can('طباعة بطاقة الموظف')
  <a href="{{ route('employee.card', $emp->id) }}"
   class="btn btn-sm btn-info"
   title="طباعة بطاقة الموظف">
    <i class="fas fa-print"></i> طباعة بطاقة الموظف
</a>
@endcan

</div>

<!-- حذف المرفق -->
<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteFileForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من حذف المرفق <strong id="file_name_text"></strong>؟
                    <input type="hidden" name="id_file" id="id_file">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- حذف الموظف -->
<div class="modal fade" id="delete_employee" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف الموظف</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    هل انت متأكد من عملية الحذف؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                </div>
            </div>
        </form>
    </div>
</div>

   
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!--Internal Input tags js-->
<script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
<!--- Tabs JS-->
<script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
<script src="{{ URL::asset('assets/js/tabs.js') }}"></script>


<script>
  $('#delete_file').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id_file = button.data('id_file');
    var file_name = button.data('file_name');
    var modal = $(this);

    // تعيين اسم الملف في المودال
    modal.find('#file_name_text').text(file_name);
    modal.find('#id_file').val(id_file);

    // تعيين action الفورم بناءً على id المرفق
    modal.find('#deleteFileForm').attr('action', '/attachments/' + id_file);
});


</script>
<script>
$('#delete_employee').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // الزر اللي ضغط عليه المستخدم
    var empId = button.data('id');       // جلب id الموظف
    var form = $(this).find('#deleteForm'); 
    form.attr('action', '/emp_data/' + empId); // تحديث الـ action
});
</script>



@endsection

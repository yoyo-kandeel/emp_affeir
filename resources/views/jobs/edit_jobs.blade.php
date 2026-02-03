@extends('layouts.master')
@section('title','تعديل وظيفة')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأقسام والوظائف</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل وظيفة</span>
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

                <form action="{{ route('jobs.update', $job) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>الإدارة</label>
                        <select class="form-control" name="department_id" required>
                            <option value="">اختر الإدارة</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $job->department_id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>اسم الوظيفة</label>
                        <input type="text" name="job_name" class="form-control" value="{{ $job->job_name }}" required>
                    </div>

                    <div class="form-group">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control" rows="3">{{ $job->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">تحديث الوظيفة</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">الرجوع للقائمة</a>
                </form>
				@can('حذف وظيفة')
				<form action="{{ route('jobs.destroy', $job) }}" method="POST" id="deleteForm">
    @csrf
    @method('DELETE')
    <!-- زر الحذف -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
        حذف الوظيفة
    </button>
</form>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="اغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        هل أنت متأكد من حذف هذه الوظيفة؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
      </div>
    </div>
  </div>
</div>
@endcan

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('select[name="department_id"]').select2({ placeholder: "اختر الإدارة" });
});
</script>
<script>
$(document).ready(function(){

    // select2
    $('select[name="department_id"]').select2({ placeholder: "اختر الإدارة" });

    // زر تأكيد الحذف
    $('#confirmDelete').click(function(){
        $('#deleteForm').submit();
    });

});
</script>

@endsection

@extends('layouts.master')
@section('title','إضافة وظيفة')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأقسام والوظائف</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة وظيفة</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                @include('layouts.maseg')

                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>الإدارة</label>
                        <select class="form-control" name="department_id" required>
                            <option value="">اختر الإدارة</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>اسم الوظيفة</label>
                        <input type="text" name="job_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">حفظ الوظيفة</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">الرجوع للقائمة</a>
                </form>
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
@endsection

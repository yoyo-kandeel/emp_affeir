@extends('layouts.master')
@section('title','إضافة إدارة')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأقسام والوظائف</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                <a href="{{ route('departments.index') }}">الإدارات</a>
            </span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة إدارة</span>
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

                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>اسم الإدارة</label>
                        <input type="text" name="department_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">حفظ</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">رجوع</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

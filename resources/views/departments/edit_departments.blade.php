@extends('layouts.master')
@section('title','تعديل إدارة')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأقسام والوظائف</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                <a href="{{ route('departments.index') }}">الإدارات</a>
            </span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل إدارة</span>
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

                {{-- فورم التعديل --}}
                <form action="{{ route('departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>اسم الإدارة</label>
                        <input type="text" name="department_name" class="form-control"
                               value="{{ $department->department_name }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control">{{ $department->description }}</textarea>
                    </div>

                    <button class="btn btn-success">تحديث</button>
                </form>

                {{-- زر الحذف --}}
                @can('حذف إدارة')
                <form action="{{ route('departments.destroy', $department->id) }}"
                      method="POST" class="mt-3"
                      onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">حذف الإدارة</button>
                </form>
                @endcan

                <a href="{{ route('departments.index') }}" class="btn btn-secondary mt-3">
                    رجوع للقائمة
                </a>

            </div>
        </div>
    </div>
</div>
@endsection

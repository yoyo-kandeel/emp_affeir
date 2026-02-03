@extends('layouts.master')
@section('title','تعديل بدل')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                <a href="{{ route('allowances.index') }}">البدلات</a>
            </span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل بدل</span>
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

                <form action="{{ route('allowances.update', $allowance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>السنة</label>
                        <select name="year_id" class="form-control" required>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ $allowance->year_id == $year->id ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>الشهر</label>
                        <select name="month_id" class="form-control" required>
                            @foreach($months as $month)
                                <option value="{{ $month->id }}" {{ $allowance->month_id == $month->id ? 'selected' : '' }}>
                                    {{ $month->month_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>اسم البدل</label>
                        <input type="text" name="allowance_name" class="form-control" value="{{ $allowance->allowance_name }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control">{{ $allowance->description }}</textarea>
                    </div>

                    <button class="btn btn-primary">تحديث</button>
                       <a href="{{ route('allowances.index') }}" class="btn btn-secondary">رجوع</a>
</form>

                    @can('حذف بدل')
                    <form action="{{ route('allowances.destroy', $allowance->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">حذف</button>
                    </form>
                    @endcan

                 
                
            </div>
        </div>
    </div>
</div>
@endsection

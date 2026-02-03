@extends('layouts.master')
@section('title','إضافة بدل جديد')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرواتب والاستحقاقات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                <a href="{{ route('allowances.index') }}">البدلات</a>
            </span>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة بدل</span>
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

                <form action="{{ route('allowances.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>السنة</label>
                        <select name="year_id" class="form-control" required>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>الشهر</label>
                        <select name="month_id" class="form-control" required>
                            @foreach($months as $month)
                                <option value="{{ $month->id }}">{{ $month->month_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>اسم البدل</label>
                        <input type="text" name="allowance_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>الملاحظات</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">حفظ</button>
                    <a href="{{ route('allowances.index') }}" class="btn btn-secondary">رجوع</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

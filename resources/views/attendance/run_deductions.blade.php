@extends('layouts.master')

@section('title', 'حساب الخصومات اليومية')

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>تشغيل حساب الخصومات اليومية</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('attendance.run') }}">
                @csrf
                <div class="mb-3">
                    <label for="from_date" class="form-label">من تاريخ</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ old('from_date') }}">
                </div>
                <div class="mb-3">
                    <label for="to_date" class="form-label">إلى تاريخ</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ old('to_date') }}">
                    <small class="text-muted">اترك الحقول فارغة لتشغيل الحساب على الشهر الحالي.</small>
                </div>
                <button type="submit" class="btn btn-success w-100">تشغيل الحساب</button>
            </form>

            @if(isset($output))
                <div class="mt-4">
                    <h5>نتيجة الحساب:</h5>
                    <pre style="background:#f8f9fa; padding:15px;">{!! $output !!}</pre>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

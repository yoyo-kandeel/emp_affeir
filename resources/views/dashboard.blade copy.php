@extends('layouts.master')
@section('css')
<!-- CSS إضافي لدعم RTL إذا لم يكن موجود -->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
<style>
    body, .breadcrumb-header, .card { direction: rtl; text-align: right; }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بعودتك!</h2>
            <p class="mg-b-0">نظرة عامة على لوحة تحكم الموظفين.</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row row-sm">
    <!-- إجمالي الموظفين -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white">إجمالي الموظفين</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalEmployees }}</h4>
            </div>
        </div>
    </div>

    <!-- الموظفين اليوم -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white"> موظفين مضافين اليوم</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $todayEmployees }}</h4>
            </div>
        </div>
    </div>

    <!-- أذونات اليوم -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white">أذونات اليوم</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $todayPermissions }}</h4>
            </div>
        </div>
    </div>

    <!-- خصومات الشهر -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white">خصومات الشهر</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $monthDeductions }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- آخر 5 موظفين -->
<div class="row row-sm mt-4">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">أحدث الموظفين</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($latestEmployees as $employee)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $employee->full_name }}</strong> - {{ $employee->status ?? 'غير محدد' }}
                        </div>
                        <span class="text-muted">{{ $employee->created_at->format('d M Y') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/index.js')}}"></script>
@endsection

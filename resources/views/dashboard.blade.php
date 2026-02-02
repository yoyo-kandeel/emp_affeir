@extends('layouts.master')

@section('css')
<link href="{{URL::asset('assets/plugins/apexcharts/apexcharts.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
<style>
    body, .breadcrumb-header, .card { direction: rtl; text-align: right; }
    .chart-container { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    h3.chart-title { margin-bottom: 10px; }
    
    .access-card {
        background-color: #dc3545; /* أحمر Bootstrap */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
        border-radius: 10px;
        animation: pulse-red 1.5s infinite;
    }

    .access-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    /* تأثير نبض / تومض */
    @keyframes pulse-red {
        0%   { background-color: #e71025; }
        50%  { background-color: #bb3946; } 
        100% { background-color: #e71025; }
    }

</style>

@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بعودتك!</h2>
            @can('نظرة عامة')
            <p class="mg-b-0">نظرة عامة على لوحة تحكم الموظفين.</p>
            @endcan
        </div>
    </div>  
</div>
@endsection

@section('content')
@can('نظرة عامة')
<div class="row row-sm">

    <!-- بطاقة الإحصائيات -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white">إجمالي الموظفين</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalEmployees }}</h4>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <h6 class="mb-3 tx-12 text-white">موظفين مضافين اليوم</h6>
                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $todayEmployees }}</h4>
            </div>
        </div>
    </div>

</div>

<!-- الرسوم البيانية -->
<div class="row row-sm mt-4">
    <div class="col-xl-6 col-md-12">
        <div class="chart-container">
            <h3 class="chart-title">أذونات اليوم</h3>
            <div id="chartTodayPermissions" style="height: 300px;"></div>
        </div>
    </div>

    <div class="col-xl-6 col-md-12">
        <div class="chart-container">
            <h3 class="chart-title">خصومات الشهر حسب النوع</h3>
            <div id="chartMonthDeductions" style="height: 350px;"></div>
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
@else
{{-- بطاقة صلاحية الوصول مع تأثير نبض / تومض --}}
<div class="row mt-5">
    <div class="col-12">
        <div class="access-card text-white text-center p-4">
            <div class="access-body">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h3 class="mb-2" style="font-weight: bold;">
                    ليس لك صلاحية الوصول
                </h3>
                <p>
                    الرجاء التواصل مع المسؤول إذا كنت بحاجة إلى الوصول لهذه الصفحة.
                </p>
            </div>
        </div>
    </div>
</div>

@endcan



@endsection


@section('js')
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== أذونات اليوم =====
    new ApexCharts(document.querySelector("#chartTodayPermissions"), {
        chart: { type: 'donut', height: 400 },
        series: [{{ $todayPermissions }}, {{ max(0, 20 - $todayPermissions) }}],
        labels: ['اليوم', 'أخرى'],
        colors: ['#28a745', '#c0e6c2'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true },
        tooltip: { y: { formatter: function(val){ return val + " إذن"; } } }
    }).render();

    // ===== خصومات الشهر - Stacked Bar =====
    var monthDeductionsCategories = @json($weeks);
    var seriesData = [
        @foreach($dataByType as $typeName => $values)
        {
            name: "{{ $typeName }}",
            data: @json($values)
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
    ];

   new ApexCharts(document.querySelector("#chartMonthDeductions"), {
    chart: { type: 'bar', height: 350, stacked: true, toolbar: { show: true } },
    series: seriesData,
    xaxis: { categories: monthDeductionsCategories, title: { text: 'أسبوع الشهر' } },
    yaxis: { title: { text: 'القيمة' } },
    plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 5 } },
    colors: ['#ffc107', '#28a745', '#17a2b8'],
    dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
            let type = opts.w.config.series[opts.seriesIndex].name;

            if (type === 'غياب') {
                return val + ' يوم';
            } else if (type === 'تأخير') {
                return val + ' ساعة';
            } else {
                return val + ' مبلغ';
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val, opts) {
                let type = opts.w.config.series[opts.seriesIndex].name;

                if (type === 'غياب') {
                    return val + ' يوم';
                } else if (type === 'تأخير') {
                    return val + ' ساعة';
                } else {
                    return val + ' مبلغ';
                }
            }
        }
    },
    legend: { position: 'bottom' }
}).render();


});
</script>
@endsection

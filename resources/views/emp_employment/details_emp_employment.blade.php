@extends('layouts.master')

@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('title','تفاصيل بيانات التوظيف')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ url('emp_employment') }}">بيانات التوظيف</a></h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل بيانات التوظيف</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row row-sm">
    @include('layouts.maseg')

    <div class="col-xl-12">
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-3">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">بيانات التوظيف</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    <!-- Tab 1: بيانات التوظيف -->
                                    <div class="tab-pane active" id="tab1">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped text-center">
                                                <tbody>
                                                    <tr>
                                                        <th>اسم الموظف</th>
                                                        <td>{{ $emp_employment->full_name ?? '-' }}</td>
                                                        <th>الراتب الأساسي</th>
                                                        <td>{{ $emp_employment->basic_salary ?? '-' }}</td>
                                                        <th>مؤمن عليه</th>
                                                        <td>{{ $emp_employment->insured ? 'نعم' : 'لا' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاريخ التأمين</th>
                                                        <td>{{ $emp_employment->insurance_date ?? '-' }}</td>
                                                        <th>نسبة التأمين</th>
                                                        <td>{{ $emp_employment->insurance_rate ?? '-' }}</td>
                                                        <th>مبلغ التأمين</th>
                                                        <td>{{ $emp_employment->insurance_amount ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الرقم التأميني</th>
                                                        <td>{{ $emp_employment->insurance_number ?? '-' }}</td>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div> <!-- tab-content -->
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div>
                </div>

                <div class="btn-group" role="group" style="gap:5px;">
                    @can('تعديل بيانات التوظيف')
                    <a href="{{ route('emp_employment.edit', $emp_employment->id) }}"
                       class="btn btn-sm btn-primary" title="تعديل بيانات التوظيف">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    @endcan


            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-xl-12 -->
</div> <!-- row -->
@endsection

@section('js')

@endsection

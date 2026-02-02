@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('title','تفاصيل المنشأة')

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المنشآت</h4>
               
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل المنشأة</span>
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
                        <div class="panel panel-primary tabs-style-2">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">المعلومات الأساسية</a></li>
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">المعلومات الإضافية</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    <!-- Tab 1: المعلومات الأساسية -->
                                    <div class="tab-pane active" id="tab1">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped text-center">
                                                <tbody>
                                                    <tr>
                                                        <th>اسم المنشأة</th>
                                                        <td>{{ $organization->name ?? '-' }}</td>
                                                        <th>الاسم بالإنجليزي</th>
                                                        <td>{{ $organization->english_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>السجل التجاري</th>
                                                        <td>{{ $organization->commercial_register ?? '-' }}</td>
                                                        <th>رقم التسجيل الضريبي</th>
                                                        <td>{{ $organization->tax_number ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الهاتف</th>
                                                        <td>{{ $organization->phone ?? '-' }}</td>
                                                        <th>البريد الإلكتروني</th>
                                                        <td>{{ $organization->email ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الموقع الإلكتروني</th>
                                                        <td>{{ $organization->website ?? '-' }}</td>
                                                        <th>العنوان</th>
                                                        <td colspan="3">{{ $organization->address ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الوصف</th>
                                                        <td colspan="3">{{ $organization->description ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>شعار المنشأة</th>
                                                        <td colspan="3">
                                                            @if($organization->logo)
                                                                <img src="{{ asset('storage/' . $organization->logo) }}" 
                                                                     style="width: 150px; height: 150px;" alt="Logo">
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tab 2: معلومات إضافية -->
                                    <div class="tab-pane" id="tab2">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped text-center">
                                                <tbody>
                                                    <tr>
                                                        <th>تم الإنشاء بواسطة</th>
                                                        <td>{{ $organization->created_by ?? '-' }}</td>
                                                        <th>تاريخ الإنشاء</th>
                                                        <td>{{ $organization->created_at ? $organization->created_at->format('d-m-Y') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاريخ التحديث</th>
                                                        <td>{{ $organization->updated_at ? $organization->updated_at->format('d-m-Y') : '-' }}</td>
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
                    @can('تعديل منشأة')
                        <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> تعديل المنشأة
                        </a>
                    @endcan

                
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#delete_organization').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orgId = button.data('id');
        var form = $(this).find('#deleteForm');
        form.attr('action', '/organizations/' + orgId);
    });
</script>
@endsection

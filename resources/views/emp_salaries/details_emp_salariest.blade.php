@extends('layouts.master')

@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('title','تفاصيل كشف المرتب')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ url('emp_salaries') }}">المرتبات</a></h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل كشف المرتب</span>
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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">المعلومات الأساسية</a></li>
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">البدلات</a></li>
                                        <li><a href="#tab3" class="nav-link" data-toggle="tab">الخصومات</a></li>
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
                                                        <th>اسم الموظف</th>
                                                        <td>{{ $salary->emp->full_name ?? '-' }}</td>
                                                        <th>السنة</th>
                                                        <td>{{ $salary->year->year ?? '-' }}</td>
                                                        <th>الشهر</th>
                                                        <td>{{ $salary->month->month_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الراتب الأساسي</th>
                                                        <td>{{ $salary->basic_salary }}</td>
                                                        <th>أيام العمل</th>
                                                        <td>{{ $salary->working_days }}</td>
                                                        <th>الراتب اليومي</th>
                                                        <td>{{ $salary->daily_rate ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الراتب بالساعة</th>
                                                        <td>{{ $salary->hourly_rate ?? '-' }}</td>
                                                        <th>رقم الدفع</th>
                                                        <td>{{ $salary->payment_number ?? '-' }}</td>
                                                        <th>صافي المرتب</th>
                                                        <td>{{ $salary->net_salary }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tab 2: البدلات -->
                                    <div class="tab-pane" id="tab2">
                                        <div class="table-responsive mt-15">
                                            @if($salary->allowances->count() > 0)
                                            <table class="table table-striped text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>اسم البدل</th>
                                                        <th>المبلغ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($salary->allowances as $allow)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $allow->allowance->name ?? '-' }}</td>
                                                            <td>{{ $allow->amount }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                                <p class="text-center text-muted">لا توجد بدلات لهذا الشهر.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Tab 3: الخصومات -->
                                    <div class="tab-pane" id="tab3">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped text-center">
                                                <tbody>
                                                    <tr>
                                                        <th>غياب</th>
                                                        <td>{{ $salary->absence_days ?? 0 }} يوم</td>
                                                        <th>تأخير</th>
                                                        <td>{{ $salary->delay_hours ?? 0 }} ساعة</td>
                                                        <th>جزاءات</th>
                                                        <td>{{ $salary->penalties ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>إجمالي البدلات</th>
                                                        <td>{{ $salary->total_allowances }}</td>
                                                        <th>إجمالي الخصومات</th>
                                                        <td>{{ $salary->total_deductions }}</td>
                                                        <th>صافي المرتب</th>
                                                        <td>{{ $salary->net_salary }}</td>
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
                    @can('تعديل كشف مرتب')
                    <a href="{{ route('emp_salaries.edit', $salary->id) }}"
                       class="btn btn-sm btn-primary" title="تعديل كشف المرتب">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    @endcan

                    @can('حذف كشف مرتب')
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_salary"
                            data-id="{{ $salary->id }}">
                        <i class="fas fa-trash-alt"></i> حذف
                    </button>
                    @endcan
                </div>

                <!-- حذف كشف المرتب -->
                <div class="modal fade" id="delete_salary" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">حذف كشف المرتب</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    هل انت متأكد من حذف كشف المرتب للموظف <strong>{{ $salary->emp->full_name ?? '-' }}</strong>؟
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-xl-12 -->
</div> <!-- row -->
@endsection

@section('js')
<script>
$('#delete_salary').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var salaryId = button.data('id');
    var form = $(this).find('#deleteForm');
    form.attr('action', '/emp_salaries/' + salaryId);
});
</script>
@endsection

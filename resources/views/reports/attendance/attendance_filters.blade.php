@extends('layouts.master')
@section('title','تقرير الحضور حسب الفترة')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">إدارة الحضور والانصراف</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير الحضور حسب الفترة</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg')

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <form action="{{ route('attendance.report.results') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <label>الإدارة</label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="all">كل الإدارات</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>الوظيفة</label>
                            <select name="job_id" id="job_id" class="form-control">
                                <option value="all">كل الوظائف</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>الموظف</label>
                            <select name="employee_id" class="form-control">
                                <option value="all">كل الموظفين</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>من تاريخ</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#department_id').select2({ placeholder: "اختر الإدارة" });
    $('#job_id').select2({ placeholder: "اختر الوظيفة" });

    $('#department_id').on('change', function() {
        let departmentId = $(this).val();
        $('#job_id').html('<option value="all">كل الوظائف</option>');
        if(departmentId && departmentId !== 'all') {
            $.get('/department/' + departmentId + '/jobs', function(data) {
                $.each(data, function(i, job){
                    $('#job_id').append('<option value="'+job.id+'">'+job.job_name+'</option>');
                });
            });
        }
    });
});
</script>
@endsection

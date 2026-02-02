@extends('layouts.master')
@section('title','فلترة البيانات')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mg-b-20">
            <div class="card-body">
                <form id="filtersForm">

                    <div class="form-group">
                        <label>الإدارة</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">اختر الإدارة</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>الوظيفة</label>
                        <select name="job_id" id="job_id" class="form-control">
                            <option value="">اختر الوظيفة</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" id="applyFilters" class="btn btn-primary">تطبيق الفلاتر</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // عند تغيير الإدارة، جلب الوظائف الخاصة بها
    $('#department_id').on('change', function() {
        let departmentId = $(this).val();
        $('#job_id').html('<option value="">اختر الوظيفة</option>');

        if(departmentId) {
            $.get('/department/' + departmentId + '/jobs', function(data) {
                $.each(data, function(i, job) {
                    $('#job_id').append(`<option value="${job.id}">${job.job_name}</option>`);
                });
            });
        }
    });

    // عند الضغط على تطبيق الفلاتر
    $('#applyFilters').on('click', function() {
        let filters = {
            department_id: $('#department_id').val(),
            job_id: $('#job_id').val()
        };

        // حفظ الفلاتر في localStorage
        localStorage.setItem('filters', JSON.stringify(filters));

        // إعادة التوجيه للصفحة المطلوبة (مثلاً صفحة جدول الموظفين)
        window.location.href = '/employees/status';
    });

});
</script>
@endsection

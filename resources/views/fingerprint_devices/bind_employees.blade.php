@extends('layouts.master')
@section('title','ربط الموظفين بأجهزة البصمة')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">أجهزة البصمة</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ربط الموظفين بالأجهزة</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg') <!-- رسائل النجاح/خطأ -->

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="employeesTable" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الموظف</th>
                                <th>الأجهزة المرتبطة</th>
                                <th>حفظ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                            <tr>
                                <form action="{{ route('fingerprint-devices.saveEmployeeDevices',$emp->id) }}" method="POST">
                                    @csrf
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $emp->full_name }}</td>
                                    <td>
                                        @foreach($devices as $device)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="devices[]" value="{{ $device->id }}" {{ $emp->fingerprintDevices->contains($device->id)?'checked':'' }}>
                                            <label class="form-check-label">{{ $device->ip_address }} ({{ $device->type }})</label>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td><button class="btn btn-primary btn-sm">حفظ</button></td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$(document).ready(function(){
    $('#employeesTable').DataTable({
        responsive:true,
        paging:false, // لأن عندنا Pagination لارافيل
        info:false,
        searching:false,
        ordering:false,
        language:{
            emptyTable:"لا يوجد موظفين"
        }
    });
});
</script>
@endsection

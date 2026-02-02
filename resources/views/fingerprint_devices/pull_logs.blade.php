@extends('layouts.master')
@section('title','سحب سجلات الحضور')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">أجهزة البصمة</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ سحب سجلات الحضور</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @include('layouts.maseg') <!-- رسائل النجاح/خطأ -->

    <div class="col-lg-6">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-title">سحب سجلات الحضور</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('fingerprint-devices.pullLogs', 0) }}" method="POST" id="pullLogsForm">
                    @csrf
                    <div class="form-group">
                        <label>اختر الجهاز</label>
                        <select name="device_id" id="deviceSelect" class="form-control select2" required>
                            <option value="">-- اختر جهاز --</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name ?? $device->ip_address }} ({{ $device->ip_address }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">سحب السجلات</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script>
$(document).ready(function(){
    $('.select2').select2({
        placeholder: "-- اختر جهاز --",
        width: '100%'
    });

    const select = document.getElementById('deviceSelect');
    const form = document.getElementById('pullLogsForm');

    select.addEventListener('change', function(){
        if(this.value){
            form.action = '/fingerprint-devices/pull-logs/' + this.value;
        }
    });
});
</script>
@endsection

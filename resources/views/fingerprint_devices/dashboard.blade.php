@extends('layouts.master')

@section('content')
<div class="row">
    @foreach($devices as $device)
    <div class="col-md-3 mb-3">
        <div class="card p-3">
            <h5>{{ $device->ip_address }} ({{ $device->type }})</h5>
            <p>Port: {{ $device->port ?? 4370 }}</p>

            {{-- حالة الاتصال --}}
            <span id="device-status-{{ $device->id }}" class="badge badge-secondary">لم يتم التحقق بعد</span>

            {{-- اختبار الاتصال --}}
            <button class="btn btn-sm btn-warning mt-2 test-connection-btn" data-id="{{ $device->id }}">
                اختبار الاتصال
            </button>

            {{-- سحب البيانات --}}
            <button class="btn btn-sm btn-info mt-2 pull-logs-btn" data-id="{{ $device->id }}">
                سحب البيانات
            </button>

            {{-- spinner --}}
            <div id="spinner-{{ $device->id }}" class="spinner-border text-primary mt-2" role="status" style="display:none;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){

    // ==========================
    // اختبار الاتصال
    // ==========================
    $('.test-connection-btn').click(function(){
        let deviceId = $(this).data('id');
        let badge = $("#device-status-" + deviceId);
        let spinner = $("#spinner-" + deviceId);

        spinner.show();
        badge.text('جارٍ التحقق...').removeClass('badge-success badge-danger').addClass('badge-secondary');

        $.post('{{ url("fingerprint-devices/test-connection") }}/' + deviceId, {_token: '{{ csrf_token() }}'}, function(res){
            spinner.hide();
            if(res.success){
                badge.text(res.success).removeClass('badge-secondary badge-danger').addClass('badge-success');
            } else if(res.error){
                badge.text(res.error).removeClass('badge-secondary badge-success').addClass('badge-danger');
            }
        }).fail(function(xhr){
            spinner.hide();
            badge.text('خطأ أثناء الاتصال').removeClass('badge-secondary badge-success').addClass('badge-danger');
        });
    });

    // ==========================
    // سحب البيانات
    // ==========================
    $('.pull-logs-btn').click(function(){
        let deviceId = $(this).data('id');
        let spinner = $("#spinner-" + deviceId);

        spinner.show();

        $.post('{{ url("fingerprint-devices/pull-logs") }}/' + deviceId, {_token: '{{ csrf_token() }}'}, function(res){
            spinner.hide();
            alert(res.success || res.error || 'تم الانتهاء');
        }).fail(function(){
            spinner.hide();
            alert('حدث خطأ أثناء سحب البيانات');
        });
    });

});
</script>
@endsection

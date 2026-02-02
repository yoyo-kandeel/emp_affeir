
@php
    $allMessages = [];

    // جميع الرسائل المخزنة في session
    foreach (session()->all() as $key => $value) {
        if (in_array($key, ['_token', '_previous', '_flash', '_old_input'])) {
            continue; // تجاهل البيانات الغير مهمة
        }

        if(is_string($value)) {
            // نوع الرسالة بناءً على اسم المفتاح
            $type = 'info';
            if(str_contains(strtolower($key), 'success')) $type = 'success';
            if(str_contains(strtolower($key), 'error')) $type = 'error';
            if(str_contains(strtolower($key), 'warning')) $type = 'warning';

            $allMessages[] = ['msg' => $value, 'type' => $type];
        }
    }

    // إضافة رسائل الـ Validation Errors
    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            $allMessages[] = ['msg' => $error, 'type' => 'error'];
        }
    }
@endphp

@if(count($allMessages) > 0)
<script>
    window.onload = function () {
        @foreach($allMessages as $message)
            notif({
                msg: "{{ $message['msg'] }}",
                type: "{{ $message['type'] }}"
            });
        @endforeach
    };
</script>
@endif


<!-- main-header -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">

        {{-- ================= Left ================= --}}
        <div class="main-header-left">
            {{-- Logo --}}
            <div class="responsive-logo">
                <a href="{{ url('/dashboard') }}">
                    <img src="{{ asset('assets/img/brand/logo.png') }}" class="logo-1" alt="logo">
                </a>
                <a href="{{ url('/dashboard') }}">
                    <img src="{{ asset('assets/img/brand/logo-white.png') }}" class="dark-logo-1" alt="logo">
                </a>
            </div>

            {{-- Sidebar Toggle --}}
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#">
                    <i class="header-icon fe fe-align-left"></i>
                </a>
            </div>
        </div>

        {{-- ================= Right ================= --}}
        <div class="main-header-right">@php
    $unreadCount   = auth()->user()->unreadNotifications->count();
    $notifications = auth()->user()->unreadNotifications->take(5);

    /*
    |----------------------------------
    | Notification Types Config
    |----------------------------------
    | أضف نوع جديد هنا فقط 👇
    */
    $types = [
        'deduction' => [
            'icon' => 'la-minus-circle',
            'bg'   => 'bg-danger',
        ],
        'employee' => [
            'icon' => 'la-user',
            'bg'   => 'bg-info',
        ],
        'order' => [
            'icon' => 'la-shopping-cart',
            'bg'   => 'bg-success',
        ],
        'warning' => [
            'icon' => 'la-exclamation-triangle',
            'bg'   => 'bg-warning',
        ],
        'default' => [
            'icon' => 'la-bell',
            'bg'   => 'bg-primary',
        ],
    ];
@endphp

<div class="dropdown nav-item main-header-notification">
    <a class="nav-link" href="#" data-toggle="dropdown">
        <i class="fe fe-bell header-icon"></i>
        @if($unreadCount)
            <span class="pulse"></span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right shadow"
         style="width:330px;border-radius:10px">

        {{-- Header --}}
        <div class="px-3 py-2 bg-primary text-right rounded-top">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-white mb-0">الإشعارات</h6>
                @if($unreadCount)
                    <span id="notif-count" class="badge badge-danger">
                        {{ $unreadCount }}
                    </span>
                @endif
            </div>
            <small class="text-white-50">غير مقروءة</small>
        </div>

        {{-- Notifications --}}
        <div style="max-height:300px;overflow-y:auto">

            @forelse($notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'default';
                    $config = $types[$type] ?? $types['default'];
                @endphp

                <a href="javascript:void(0)"
                   class="notification-item d-flex p-2 mb-1 rounded"
                   data-id="{{ $notification->id }}"
                   data-url="{{ $notification->data['url'] ?? '#' }}"
                   style="background:#f8f9fa;color:#333;text-decoration:none">

                    <div class="notifyimg {{ $config['bg'] }} mr-2 rounded-circle
                                d-flex align-items-center justify-content-center"
                         style="width:40px;height:40px">
                        <i class="la {{ $config['icon'] }} text-white"></i>
                    </div>

                    <div class="flex-grow-1">

                        <h6 class="mb-1" style="font-size:14px">
                            {{ $notification->data['title'] ?? 'إشعار جديد' }}
                        </h6>

                        {{-- محتوى مرن حسب النوع --}}
                        @if(isset($notification->data['employee_name']))
                            <p class="mb-0 small">
                                الموظف: {{ $notification->data['employee_name'] }}
                            </p>
                        @endif

                        @if(isset($notification->data['quantity']))
                            <p class="mb-0 small">
                                القيمة: {{ $notification->data['quantity'] }}
                            </p>
                        @endif

                        @if(isset($notification->data['message']))
                            <p class="mb-0 small">
                                {{ $notification->data['message'] }}
                            </p>
                        @endif

                        <small class="text-muted">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </a>
            @empty
                <p class="text-center p-3 text-muted">
                    لا توجد إشعارات
                </p>
            @endforelse
        </div>
    </div>
</div>



            {{-- ===== Full Screen ===== --}}
            <div class="nav-item full-screen fullscreen-button">
                <a class="nav-link full-screen-link" href="#">
                    <i class="fe fe-maximize header-icon"></i>
                </a>
            </div>

            {{-- ===== Profile ===== --}}
            <div class="dropdown main-profile-menu nav-item">
                <a class="profile-user d-flex" href="#" data-toggle="dropdown">
                    <img src="{{ asset('assets/img/faces/6.jpg') }}" alt="user">
                </a>

                <div class="dropdown-menu">
                    <div class="main-header-profile bg-primary p-3 text-center">
                        <img src="{{ asset('assets/img/faces/6.jpg') }}" class="rounded-circle mb-2" width="60">
                        <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-white">{{ Auth::user()->email }}</small>
                    </div>

                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bx bx-user"></i> تعديل الملف الشخصي
                    </a>



                    <a class="dropdown-item text-danger"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out"></i> تسجيل الخروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /main-header -->

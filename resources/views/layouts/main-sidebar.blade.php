<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar sidebar-scroll">
    {{-- Logo --}}
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/dashboard') }}">
            <img src="{{ asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo">
        </a>
        <a class="desktop-logo logo-dark active" href="{{ url('/dashboard') }}">
            <img src="{{ asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme" alt="logo">
        </a>
    </div>

    <div class="main-sidemenu">

        {{-- User Info --}}
        <div class="app-sidebar__user clearfix">
            <div class="user-info text-center">
                <h4 class="font-weight-semibold mt-3 mb-0">
                    {{ auth()->user()->name ?? 'HR Admin' }}
                </h4>
            </div>
        </div>

        <ul class="side-menu">

            {{-- ================= Dashboard ================= --}}
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/dashboard') }}">
                    <i class="fas fa-home side-menu__icon"></i>
                    <span class="side-menu__label">لوحة التحكم</span>
                </a>
            </li>

            {{-- ================= Employees ================= --}}
            @can('الموظفون')
            <li class="side-item side-item-category">الموظفون</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-users side-menu__icon"></i>
                    <span class="side-menu__label">إدارة الموظفين</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('عرض الموظفين')
                    <li><a class="slide-item" href="{{ route('emp_data.index') }}">بيانات الموظفين</a></li>
                    @can('اضافة موظف')
                       <li><a class="slide-item" href="{{ route('emp_data.create') }}"> اضافة موظف</a></li>
                    @endcan
                    @endcan

                    @can('عرض بيانات التوظيف')
                    <li><a class="slide-item" href="{{ route('emp_employment.index') }}">بيانات التوظيف</a></li>
                    @can('اضافة بيانات التوظيف')
                    <li><a class="slide-item" href="{{ route('emp_employment.create') }}">  إضافة بيانات توظيف جديدة</a></li>
                    @endcan
                    @endcan

                    @can('عرض حالات الموظفين')
                    <li><a class="slide-item" href="{{ route('emp_status.index') }}">حالات الموظفين</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ================= Organization ================= --}}
            @can('الهيكل الإداري')
            <li class="side-item side-item-category">الهيكل الإداري</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-building side-menu__icon"></i>
                    <span class="side-menu__label">الأقسام والوظائف</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('عرض الإدارات')
                    <li><a class="slide-item" href="{{ route('departments.index') }}">الإدارات</a></li>
                @can('اضافة إدارة')
                <li><a class="slide-item" href="{{ route('departments.create') }}"> إضافة إدارة</a></li>
                @endcan
                    @endcan

                    @can('عرض الوظائف')
                    <li><a class="slide-item" href="{{ route('jobs.index') }}">الوظائف</a></li>
                    @can('اضافة وظيفة')
                    <li><a class="slide-item" href="{{ route('jobs.create') }}"> إضافة وظيفة</a></li>
                    @endcan
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ================= Attendance ================= --}}
            @can('الحضور والانصراف')
            <li class="side-item side-item-category">الحضور والانصراف</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-clock side-menu__icon"></i>
                    <span class="side-menu__label">الحضور والانصراف</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('القاعدة العامة')
                     <li><a class="slide-item" href="{{ route('lateness_rules.index') }}">القاعدة العامة</a></li>
                    @endcan

                    @can('عرض الورديات')
                        <li><a class="slide-item" href="{{ route('shifts.index') }}">الورديات</a></li>
                    @endcan

                    @can('عرض الورديات')
                        <li><a class="slide-item" href="{{ route('employee-shifts.index') }}">ربط الموظفين بالورديات</a></li>
                    @endcan

                    @can('عرض الحضور')
                        <li><a class="slide-item" href="{{ route('attendance.index') }}">سجلات الحضور</a></li>
                    @endcan

                    @can('اضافة حضور')
                        <li><a class="slide-item" href="{{ route('attendance.form') }}">حساب الخصومات اليومية</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ================= Salaries ================= --}}
            @can('الرواتب')
            <li class="side-item side-item-category">الرواتب</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-money-bill-wave side-menu__icon"></i>
                    <span class="side-menu__label">الرواتب والاستحقاقات</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('عرض الرواتب')
                    <li><a class="slide-item" href="{{ route('emp_salaries.index') }}">الرواتب</a></li>
                    @can('اضافة كشف مرتب')
                     <li><a class="slide-item" href="{{ route('emp_salaries.create') }}"> إضافة كشف مرتب</a></li>
                    @endcan
                    @endcan
                    @can('عرض الأذونات')
                    <li><a class="slide-item" href="{{ route('emp_permissions.index') }}">الأذونات</a></li>
                    @can('اضافة إذن')
                    <li><a class="slide-item" href="{{ route('emp_permissions.create') }}"> إضافة إذن</a></li>
                    @endcan
                    @endcan
                    @can('عرض البدلات')
                    <li><a class="slide-item" href="{{ route('allowances.index') }}">البدلات</a></li>
                    @can('اضافة بدل')
                    <li><a class="slide-item" href="{{ route('allowances.create') }}"> إضافة بدل</a></li>
                    @endcan
                    @endcan

                    @can('عرض الخصومات')
                    <li><a class="slide-item" href="{{ route('emp_deductions.index') }}">الخصومات</a></li>
                    @can('اضافة خصم')
                    <li><a class="slide-item" href="{{ route('emp_deductions.create') }}"> إضافة خصم</a></li>
                    @endcan
                    @endcan
                </ul>
            </li>
            @endcan
{{-- ================= Reports ================= --}}
@can('التقارير')
<li class="side-item side-item-category">التقارير</li>

<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="#">
        <i class="fas fa-chart-bar side-menu__icon"></i>
        <span class="side-menu__label">التقارير</span>
        <i class="angle fe fe-chevron-down"></i>
    </a>

    <ul class="slide-menu">

        @can('تقرير الموظفين')
        <li>
    <a class="slide-item" href="{{ route('reports.employees.filters') }}">
        تقرير الموظفين
    </a>
</li>

        @endcan

        @can('تقرير الحضور')
        <li>
            <a class="slide-item" href="{{ route('attendance.filters') }}">
                تقرير الحضور والانصراف
            </a>
        </li>
        @endcan

        @can('تقرير الرواتب')
        <li>
            <a class="slide-item" href="{{ ('reports.salaries') }}">
                تقرير الرواتب
            </a>
        </li>
        @endcan

        @can('تقرير الخصومات')
        <li>
            <a class="slide-item" href="{{ ('reports.deductions') }}">
                تقرير الخصومات
            </a>
        </li>
        @endcan

        

    </ul>
</li>
@endcan

{{-- أجهزة البصمة --}}
@can('أجهزة البصمة')
<li class="side-item side-item-category">أجهزة البصمة</li>

<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="#">
        <i class="fe fe-fingerprint side-menu__icon"></i>
        <span class="side-menu__label">إدارة البصمة</span>
        <i class="angle fe fe-chevron-down"></i>
    </a>

    <ul class="slide-menu">
        @can('عرض أجهزة البصمة')
            <li><a class="slide-item" href="{{ route('fingerprint-devices.index') }}">إدارة الأجهزة</a></li>
        @endcan

        @can('ربط الأجهزة بالموظفين')
            <li><a class="slide-item" href="{{ route('fingerprint-devices.bindEmployeesView') }}">ربط الموظفين بالأجهزة</a></li>
        @endcan

        @can('سحب بيانات البصمة')
            <li><a class="slide-item" href="{{ route('fingerprint-devices.dashboard') }}">اختبار الاتصال وسحب البيانات</a></li>
        @endcan
    </ul>
</li>
@endcan



            {{-- ================= Years & Months ================= --}}
            @can('إعدادات الوقت')
            <li class="side-item side-item-category">إعدادات الوقت</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-calendar-alt side-menu__icon"></i>
                    <span class="side-menu__label">السنين والشهور</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('عرض السنين')
                    <li><a class="slide-item" href="{{ route('years.index') }}">السنين</a></li>
                    @endcan

                    @can('عرض الشهور')
                    <li><a class="slide-item" href="{{ route('months.index') }}">الشهور</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ================= Settings ================= --}}
            @can('عرض إعدادات النظام')
            <li class="side-item side-item-category">الإعدادات</li>

            @can('عرض مستخدم')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('users.index') }}">
                    <i class="fas fa-user-shield side-menu__icon"></i>
                    <span class="side-menu__label">المستخدمون</span>
                </a>
            </li>
            @endcan

            @can('عرض صلاحية')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('roles.index') }}">
                    <i class="fas fa-user-shield side-menu__icon"></i>
                    <span class="side-menu__label">الصلاحيات</span>
                </a>
            </li>
            @endcan
            @can('تفاصيل المنشأة')
<li class="slide">
    <a class="side-menu__item" href="{{ route('organizations.show', 1) }}">
        <i class="fas fa-building side-menu__icon"></i>
        <span class="side-menu__label">تفاصيل المنشأة</span>
    </a>
</li>
@endcan
     @endcan




            {{-- ================= Logout ================= --}}
            <li class="slide">
                <a class="side-menu__item"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt side-menu__icon"></i>
                    <span class="side-menu__label">تسجيل الخروج</span>
                </a>
            </li>

        </ul>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>
<!-- main-sidebar -->

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmpDataController;
use App\Http\Controllers\EmpAttachmentController;
use App\Http\Controllers\EmpEmploymentController;
use App\Http\Controllers\EmployeeStatusController;
use App\Http\Controllers\EmpSalariesController;
use App\Http\Controllers\YearsController;
use App\Http\Controllers\MonthsController;
use App\Http\Controllers\EmpDeductionsController;
use App\Http\Controllers\EmpAllowancesController;
use App\Http\Controllers\EmpPermissionController;

use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeReportController;
use App\Http\Controllers\FingerprintDeviceController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\LatenessRuleController;

use App\Http\Controllers\ShiftController;
use App\Http\Controllers\EmployeeShiftController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceReportController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// صفحة تسجيل الدخول
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// معالجة تسجيل الدخول
Route::post('/login', [LoginController::class, 'login']);

// تسجيل الخروج
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// الصفحة الرئيسية مفتوحة
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); 
    }
    return view('auth.login'); 
});

// Dashboard محمي فقط للمستخدمين المسجلين 

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth')->name('dashboard');
*/

// جميع الموارد محمية بالـ auth
Route::middleware(['auth'])->group(function() {

    //emp_data
    Route::resource('emp_data', EmpDataController::class);
    Route::get('/department/{id}/jobs', [EmpDataController::class, 'getJobs']);
    // جلب وظائف الإدارة
Route::get('department/{id}/jobs', [DepartmentsController::class, 'jobs']);

    // جلب الموظفين حسب الإدارة والوظيفة
    Route::get('employees/filter', [EmpDataController::class, 'filter']);
Route::post('/empAttachments', [EmpAttachmentController::class, 'store'])->name('empAttachments');
Route::delete('/attachments/{id}', [EmpAttachmentController::class, 'destroy'])->name('attachments.destroy');
Route::get('/employee-card/{id}', [EmpDataController::class, 'printCard'])->name('employee.card');
Route::post('/emp_data/import', [EmpDataController::class, 'import'])->name('emp_data.import');
Route::get('/emp_data/export', [EmpDataController::class, 'export'])->name('emp_data.export');
Route::get('/test-export', [EmpDataController::class, 'testExport']);
Route::get('/employees/status', [EmployeeStatusController::class, 'index']) ->name('emp_status.index');
Route::get('/employees_status/filter', [EmployeeStatusController::class, 'filter']);
Route::put('/employees/{id}/status', [EmployeeStatusController::class, 'updateStatus']);


//بانات التوظيف

Route::resource('emp_employment', EmpEmploymentController::class);
Route::get('/emp/search', [App\Http\Controllers\EmpDataController::class, 'search'])->name('emp.search');
    Route::get('/employment/filter', [EmpEmploymentController::class, 'filter']);


    //المتباااااااااااااااااااااات
Route::resource('emp_salaries', EmpSalariesController::class);
Route::get('employees/search', [EmpSalariesController::class,'search'])->name('emp.search');

    Route::get('/getEmployeeData', [EmpSalariesController::class, 'getEmployeeData'])->name('emp_salaries.getEmployeeData');
Route::get(
    'emp-salaries/{salary}/edit-data',
    [EmpSalariesController::class,'editData']
)->name('emp_salaries.editData');


    //خصومات الموظفين
Route::resource('emp_deductions', EmpDeductionsController::class);
Route::get('/emp-deductions/filter', [EmpDeductionsController::class, 'filter'])
    ->name('emp_deductions.filter');
Route::get('emp-deductions/create', [EmpDeductionsController::class, 'create'])
     ->name('emp_deductions.create');

Route::get('months-by-year', [EmpDeductionsController::class, 'getMonthsByYear'])->name('months.byYear');
//البدلات

Route::resource('allowances', EmpAllowancesController::class);


// أذونات الموظفين
Route::resource('emp_permissions', EmpPermissionController::class);

Route::get('/emp-permissions/filter', [EmpPermissionController::class, 'filter'])
    ->name('emp_permissions.filter');


Route::get('months-by-year', [EmpPermissionController::class, 'getMonthsByYear'])
    ->name('months.byYear');


//سنوات الرواتب
Route::resource('years', YearsController::class);
Route::resource('months', MonthsController::class);


    // User & Role CRUD
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Departments & Jobs CRUD
    Route::resource('departments', DepartmentsController::class);
    Route::resource('jobs', JobsController::class);

    // Profile routes
   
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// أجهزة البصمة

Route::prefix('fingerprint-devices')->group(function() {
    Route::get('/', [FingerprintDeviceController::class, 'index'])->name('fingerprint-devices.index');
    Route::post('/store', [FingerprintDeviceController::class, 'store'])->name('fingerprint-devices.store');
    Route::post('/toggle/{id}', [FingerprintDeviceController::class, 'toggle'])->name('fingerprint-devices.toggle');
    Route::post('/test-connection/{id}', [FingerprintDeviceController::class, 'testConnection'])->name('fingerprint-devices.testConnection');
    Route::get('/dashboard', [FingerprintDeviceController::class, 'dashboard'])->name('fingerprint-devices.dashboard');
    Route::post('/pull-logs/{id}', [FingerprintDeviceController::class, 'pullLogs'])->name('fingerprint-devices.pullLogs');

    Route::get('/status', [FingerprintDeviceController::class, 'status'])->name('fingerprint-devices.status');

    Route::get('/bind-employees', [FingerprintDeviceController::class, 'bindEmployeesView'])->name('fingerprint-devices.bindEmployeesView');
    Route::post('/bind-employees/{id}', [FingerprintDeviceController::class, 'saveEmployeeDevices'])->name('fingerprint-devices.saveEmployeeDevices');
});


// قائمة الأجهزة + إضافة
Route::get('fingerprint-devices', [FingerprintDeviceController::class, 'index'])->name('fingerprint-devices.index');
Route::post('fingerprint-devices', [FingerprintDeviceController::class, 'store'])->name('fingerprint-devices.store');

// تعديل وحذف جهاز
Route::put('fingerprint-devices/{id}', [FingerprintDeviceController::class, 'update'])->name('fingerprint-devices.update');
Route::delete('fingerprint-devices/{id}', [FingerprintDeviceController::class, 'destroy'])->name('fingerprint-devices.destroy');

// اختبار الاتصال وسحب البيانات
Route::post('fingerprint-devices/test-connection/{id}', [FingerprintDeviceController::class, 'testConnection']);
Route::post('fingerprint-devices/pull-logs/{id}', [FingerprintDeviceController::class, 'pullLogs']);


// سجلات الحضور


Route::get('/attendance', [AttendanceLogController::class, 'index'])->name('attendance.index');
Route::get('/attendance/filter', [AttendanceLogController::class, 'filter'])->name('attendance.filter');
Route::get('/attendance/search-employee', [AttendanceLogController::class, 'searchEmployee'])->name('emp.search');



// الورديات (Shifts)
Route::resource('shifts', ShiftController::class);



// ربط الموظف بالورديات


Route::prefix('employee-shifts')->group(function(){

    Route::get('/', [EmployeeShiftController::class,'index'])->name('employee-shifts.index');
    Route::post('/store', [EmployeeShiftController::class, 'store'])->name('employee_shifts.store');
    Route::put('/update/{id}', [EmployeeShiftController::class,'update'])->name('employee-shifts.update');
    Route::delete('/delete/{id}', [EmployeeShiftController::class,'destroy'])->name('employee-shifts.destroy');

});


// الحضور والانصراف

Route::prefix('attendance')->group(function() {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
});



// أجهزة البصمة (Fingerprint Devices)



// routes/web.php


Route::group(['middleware' => ['auth']], function () {
    Route::get('attendance/run-deductions', [AttendanceController::class, 'showForm'])->name('attendance.form');
    Route::post('attendance/run-deductions', [AttendanceController::class, 'run'])->name('attendance.run');
});



//القاعدة العامة 
Route::resource('lateness_rules', LatenessRuleController::class);


// تعليم إشعار واحد كمقروء
Route::post('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()
        ->notifications()
        ->findOrFail($id);

    $notification->markAsRead();

    return response()->json(['success' => true]);
})->name('notifications.read.ajax');


// تعليم كل الإشعارات كمقروء
Route::get('/notifications/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.readAll');

// عرض التفاصيل
Route::get('organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');

// تعديل وحفظ البيانات
Route::get('organizations/{organization}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
Route::put('organizations/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');

//التقارير

Route::prefix('reports')->group(function () {

    // صفحة اختيار الفلاتر
    Route::get('/filters', [EmployeeReportController::class, 'filterPage'])->name('reports.employees.filters');

    // صفحة عرض النتائج
    Route::post('/results', [EmployeeReportController::class, 'results'])->name('reports.employees.results');
});



Route::get('attendance/filters', [AttendanceReportController::class,'filters'])->name('attendance.filters');
Route::post('attendance/results', [AttendanceReportController::class,'results'])->name('attendance.report.results');




    // صفحة Admin العامة (يمكنك التحكم في صلاحياتها لاحقًا)
    Route::get('/{page}', [AdminController::class, 'index'])->name('admin.page');
});

// Authentication routes
require __DIR__.'/auth.php';

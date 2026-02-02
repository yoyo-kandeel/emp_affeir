<?php

namespace App\Http\Controllers;

use App\Models\EmpData;
use App\Models\departments;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\EmpAttachment;
use Illuminate\Support\Facades\DB;
use PDF; 
use Milon\Barcode\Facades\DNS1DFacade as DNS1D; 
use Milon\Barcode\Facades\DNS2DFacade as DNS2D; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use App\Models\emp_employment;
    use App\Models\User;
use App\Notifications\NewEmployeeNotification;
use function Symfony\Component\String\s;


class EmpDataController extends Controller
{
    /**
     * عرض جميع الموظفين
     */
    public function index()
    {
            $this->authorize('عرض الموظفين');

         $departments = departments::all();
        $jobs = jobs::all();
        $emp = EmpData::with(['department', 'job'])->get();
        return view('emp_data.emp_data', compact('emp', 'departments', 'jobs'));
    }


    /**
     * تخزين موظف جديد
     */
    public function create()
    {
            $this->authorize('اضافة موظف');

        $departments = departments::orderBy('department_name')->get();

        // توليد رقم الموظف (آخر رقم + 1)
        $lastEmpNumber = EmpData::max('emp_number');
        $empNumber = $lastEmpNumber ? $lastEmpNumber + 1 : 1;

        return view('emp_data.add_emp_data', compact('departments', 'empNumber'));
    }

    /**
     * ======================
     * Store Employee
     * ======================
     */
public function store(Request $request)
{
        $this->authorize('اضافة موظف');

    $request->validate([
        'full_name' => 'required|string|max:255',
        'english_name' => 'nullable|string|max:255',
        'birth_date' => 'nullable|date',
        'birth_place' => 'nullable|string|max:255',
        'gender' => 'nullable|in:ذكر,أنثى',
        'religion' => 'nullable|string|max:50',
        'nationality' => 'nullable|string|max:100',
        'marital_status' => 'nullable|string|max:50',
        'children_count' => 'nullable|integer|min:0',
        'national_id' => 'nullable|string|unique:emp_datas,national_id',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'status_service' => 'nullable|string|max:255',
        'experience' => 'nullable|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'job_id' => 'nullable|exists:jobs,id',
        'print_id' => 'required|numeric|unique:emp_datas,print_id',
        'hire_date' => 'nullable|date',
        'computer_skills' => 'nullable|string|max:255',
        'english_proficiency' => 'nullable|string|max:255',
        'certificate' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:200048',
    ], [
        'full_name.required' => 'الرجاء إدخال الاسم الكامل',
        'gender.in' => 'الرجاء اختيار النوع بشكل صحيح',
        'department_id.required' => 'الرجاء اختيار الإدارة',
        'department_id.exists' => 'الإدارة المختارة غير موجودة',
        'job_id.exists' => 'الوظيفة المختارة غير موجودة',
        'print_id.required' => 'الرجاء إدخال كود البصمة',
        'print_id.numeric' => 'كود البصمة يجب أن يكون رقم',
        'print_id.unique' => 'كود البصمة مستخدم من قبل',
        'national_id.unique' => 'الرقم القومي مستخدم من قبل',
        'profile_image.image' => 'الملف يجب أن يكون صورة',
        'profile_image.mimes' => 'نوع الصورة يجب أن يكون jpg, jpeg أو png',
        'profile_image.max' => 'حجم الصورة لا يمكن أن يتجاوز 200 ميجابايت',
    ]);

    DB::transaction(function () use ($request, &$employee) {

        // توليد رقم الموظف بشكل آمن
        $lastEmpNumber = EmpData::lockForUpdate()->max('emp_number');
        $empNumber = $lastEmpNumber ? $lastEmpNumber + 1 : 1;

        // رفع الصورة إذا وجدت
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('employees', 'public');
        }

        // إنشاء الموظف الجديد
        $employee = EmpData::create([
            'emp_number' => $empNumber,
            'full_name' => $request->full_name,
            'english_name' => $request->english_name,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'nationality' => $request->nationality,
            'marital_status' => $request->marital_status,
            'children_count' => $request->children_count ?? 0,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'status_service' => $request->status_service,
            'experience' => $request->experience,
            'department_id' => $request->department_id,
            'job_id' => $request->job_id,
            'print_id' => $request->print_id,
            'hire_date' => $request->hire_date,
            'status' => 'غير نشط',
            'computer_skills' => $request->computer_skills,
            'english_proficiency' => $request->english_proficiency,
            'certificate' => $request->certificate,
            'notes' => $request->notes,
            'profile_image' => $imagePath,
            'created_by' => auth()->user()->name ?? 'admin',
        ]);
    });
    
    // إشعار لكل المستخدمين
    $notification = new NewEmployeeNotification($employee);
    User::all()->each(function ($user) use ($notification) {
        $user->notify($notification);
    });

    session()->flash('success', 'تم إضافة الموظف بنجاح');
    return redirect()->route('emp_data.index');
}


    /**
     * جلب الوظائف حسب القسم (AJAX)
     */
    public function getJobs($department_id)
    {
        $jobs = jobs::where('department_id', $department_id)->pluck('job_name', 'id');
        return response()->json($jobs);
    }

    /**
     * عرض نموذج تعديل موظف
     *//**
 * تعديل بيانات الموظف - عرض الفورم
 */
    
    // صفحة تعديل الموظف
    public function edit($id)

    {
        $this->authorize('تعديل موظف');

    $emp = EmpData::findOrFail($id);
        $departments = Departments::all();
        $jobs = jobs::where('department_id', $emp->department_id)->get(); // لجلب الوظائف حسب القسم
        return view('emp_data.edit_emp_data', compact('emp', 'departments', 'jobs'));
    }

    // حفظ تعديل الموظف
    public function update(Request $request, EmpData $emp_data)
    {
            $this->authorize('تعديل موظف');

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'english_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:ذكر,أنثى',
            'religion' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'children_count' => 'nullable|integer|min:0',
            'national_id' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status_service' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'job_id' => 'nullable|exists:jobs,id',
            'print_id' => "required|numeric",
            'hire_date' => 'nullable|date',
            'status' => 'required',
            'computer_skills' => 'nullable|string|max:255',
            'english_proficiency' => 'nullable|string|max:255',
            'certificate' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
         ], [
        'full_name.required' => 'الرجاء إدخال الاسم الكامل',
        'gender.in' => 'الرجاء اختيار النوع بشكل صحيح',
        'department_id.required' => 'الرجاء اختيار الإدارة',
        'department_id.exists' => 'الإدارة المختارة غير موجودة',
        'job_id.exists' => 'الوظيفة المختارة غير موجودة',
        'print_id.required' => 'الرجاء إدخال كود البصمة',
        'print_id.numeric' => 'كود البصمة يجب أن يكون رقم',
        'print_id.unique' => 'كود البصمة مستخدم من قبل',
        'status.required' => 'الرجاء تحديد حالة الموظف',
        'status.in' => 'حالة الموظف غير صحيحة',
        'national_id.unique' => 'الرقم القومي مستخدم من قبل',
        'profile_image.image' => 'الملف يجب أن يكون صورة',
        'profile_image.mimes' => 'نوع الصورة يجب أن يكون jpg, jpeg أو png',
        'profile_image.max' => 'حجم الصورة لا يمكن أن يتجاوز 200 ميجابايت',
    ]);

        // رفع الصورة إذا تم تغييرها
        if ($request->hasFile('profile_image')) {
            if ($emp_data->profile_image) {
                Storage::disk('public')->delete($emp_data->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('employees', 'public');
        }

        $emp_data->update($data);

         session()->flash('success', 'تم تعديل بيانات الموظف بنجاح');
        return redirect()->route('emp_data.index');
    }
    /**
     * حذف موظف
     */
    public function destroy($id)
    {
            $this->authorize('حذف موظف');

        $emp = EmpData::findOrFail($id);

        // حذف المرفقات
        if ($emp->attachments && Storage::exists('public/emp_attachments/' . $emp->attachments)) {
            Storage::delete('public/emp_attachments/' . $emp->attachments);
        }

        $emp->delete();
            session()->flash('success', 'تم حذف الموظف بنجاح');
        return redirect()->route('emp_data.index');
       
    }

    /**
     * عرض تفاصيل موظف
     */
  public function show($id)
{
        $this->authorize('عرض معلومات الموظف');

    // جلب المرفقات الخاصة بالموظف
$emp = EmpData::with(['department','job','attachments'])->findOrFail($id);
$attachments = $emp->attachments;

    return view('emp_data.details_emp_data', compact('emp', 'attachments'));
}

// تصفية الموظفين حسب القسم والوظيفة (AJAX)
public function filter(Request $request)
{
    if (!$request->department_id || !$request->job_id) {
        return response()->json([]);
    }

    // جلب الموظفين مع الوظيفة
    $emps = EmpData::with('job')
        ->where('department_id', $request->department_id)
        ->where('job_id', $request->job_id)
        ->get()
        ->map(function($emp) {
            return [
                'id' => $emp->id,
                'full_name' => $emp->full_name,
                'job_name' => $emp->job?->job_name ?? '-',  // <-- هنا
                'print_id' => $emp->print_id,
                'hire_date' => $emp->hire_date,
                'notes' => $emp->notes,
            ];
        });

    return response()->json($emps);
}



public function employment()
{
    return $this->hasOne(emp_employment::class, 'emp_id');
}

// استيراد بيانات الموظفين من ملف إكسل
public function import(Request $request)
{
        $this->authorize('استيراد اكسيل موظفين');

    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new EmployeesImport, $request->file('file'));
      session()->flash('success', 'تم استيراد بيانات الموظفين بنجاح');
    return redirect()->back();
}
// تصدير بيانات الموظفين إلى ملف إكسل
   public function testExport()
    {
            $this->authorize('تصدير اكسيل موظفين');

        return Excel::download(new EmployeesExport, 'Employees.xlsx');
    }

   public function export()
    {
            $this->authorize('تصدير اكسيل موظفين');

        return Excel::download(new EmployeesExport, 'Employees.xlsx');
    }

public function search(Request $request)
{
    $query = $request->get('search');

    $employees = EmpData::where('full_name', 'LIKE', "%{$query}%")
                    ->orWhere('emp_number', 'LIKE', "%{$query}%")
                    ->limit(10)
                    ->get(['id','emp_number','full_name']);

    return response()->json($employees);
}


// طباعة بطاقة الموظف

public function printCard($id)
{
        $this->authorize('طباعة بطاقة الموظف');

    $employee = EmpData::with('job')->findOrFail($id);

    // اسم الوظيفة (آمن بدون أخطاء)
    $jobTitle = $employee->job?->job_title ?? 'غير محدد';

    // QR Code (بيانات كاملة)
    $qrData = "
رقم الموظف: {$employee->id}
الاسم: {$employee->full_name}
الوظيفة: {$jobTitle}
";

    $qrCode = DNS2D::getBarcodePNG($qrData, 'QRCODE');

    // Barcode رقمي (لازم String)
    $barcode = DNS1D::getBarcodePNG((string)$employee->id, 'C128');

    return PDF::loadView(
        'emp_data.card',
        compact('employee', 'qrCode', 'barcode', 'jobTitle')
    )
    ->stream('بطاقة_الموظف.pdf');
}
}

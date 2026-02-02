<?php

namespace App\Http\Controllers;

use App\Models\EmpAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmpAttachmentController extends Controller
{
    /**
     * عرض جميع المرفقات
     */
    public function index()
    {
        $this->authorize('عرض مرفق موظف'); // التحقق من صلاحية عرض المرفقات

        $attachments = EmpAttachment::all();
        return view('attachments.index', compact('attachments'));
    }

    /**
     * رفع مرفق جديد
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة مرفق موظف'); // التحقق من صلاحية إضافة مرفق

        $request->validate([
            'emp_id'     => 'required|exists:emp_datas,id',
            'attachment' => 'required|file|mimes:pdf,xlsx,xls,docx,jpg,png,jpeg|max:200048',
        ]);

        if ($request->hasFile('attachment')) {
            $file      = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename  = Str::uuid() . '.' . $extension;
            $file->storeAs('attachments', $filename, 'public');

            EmpAttachment::create([
                'emp_data_id' => $request->emp_id,
                'file_name'   => $filename,
                'file_path'   => 'attachments/' . $filename,
                'created_by'  => auth()->user()->name,
            ]);

            session()->flash('success', 'تم رفع المرفق بنجاح');
            return redirect('emp_data/' . $request->emp_id);
        }

        session()->flash('error', 'فشل رفع المرفق');
        return redirect()->back();
    }

    /**
     * حذف مرفق
     */
    public function destroy($id)
    {
        $this->authorize('حذف مرفق موظف'); // التحقق من صلاحية حذف مرفق

        $attachment = EmpAttachment::findOrFail($id);

        // حذف الملف من السيرفر
        if (file_exists(public_path('attachments/' . $attachment->file_name))) {
            unlink(public_path('attachments/' . $attachment->file_name));
        }

        // حذف السجل من قاعدة البيانات
        $attachment->delete();

        session()->flash('success', 'تم حذف المرفق بنجاح');
        return redirect()->back();
    }

    /**
     * عرض مرفق معين
     */
    public function show(EmpAttachment $emp_attachment)
    {
        $this->authorize('عرض مرفق موظف'); // التحقق من صلاحية عرض المرفق
        return view('attachments.show', compact('emp_attachment'));
    }

    // إذا في تعديل مرفق مستقبلاً
    public function edit(EmpAttachment $emp_attachment)
    {
        $this->authorize('تعديل مرفق موظف'); // إذا أضفت صلاحية تعديل مستقبلية
        return view('attachments.edit', compact('emp_attachment'));
    }

    public function update(Request $request, EmpAttachment $emp_attachment)
    {
        $this->authorize('تعديل مرفق موظف'); // إذا أضفت صلاحية تعديل مستقبلية
        // كود التحديث لو موجود
    }
}

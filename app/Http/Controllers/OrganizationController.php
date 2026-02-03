<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    // عرض تفاصيل المنشأة
    public function show(Organization $organization)
    {
        // التحقق من صلاحية "عرض المنشأة"
        $this->authorize('تفاصيل المنشأة');

        return view('organizations.show', compact('organization'));
    }

    // شاشة تعديل المنشأة
    public function edit(Organization $organization)
    {
        // التحقق من صلاحية "تعديل المنشأة"
        $this->authorize('تعديل منشأة');

        return view('organizations.edit', compact('organization'));
    }

    // حفظ التعديلات
    public function update(Request $request, Organization $organization)
    {
        // التحقق من صلاحية "تعديل المنشأة"
        $this->authorize('تعديل منشأة');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'english_name' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'commercial_register' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // حذف اللوجو القديم إذا موجود
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $organization->update($data);

        return redirect()->route('organizations.show', $organization->id)
                         ->with('success', 'تم تحديث بيانات المنشأة بنجاح.');
    }
}

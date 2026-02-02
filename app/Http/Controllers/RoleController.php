<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('عرض صلاحية'), 403);

        $roles = Role::orderByDesc('id')->paginate(5);

        return view('roles.index', compact('roles'))
            ->with('i', ($request->integer('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        abort_unless(auth()->user()->can('اضافة صلاحية'), 403);

        $permission = Permission::all();

        return view('roles.create', compact('permission'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('اضافة صلاحية'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:roles,name'],
            'permission' => ['required', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $permissions = Permission::whereIn('id', $validated['permission'])->get();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function show(int $id): View
    {
        abort_unless(auth()->user()->can('عرض صلاحية'), 403);

        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions;

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit(int $id): View
    {
        abort_unless(auth()->user()->can('تعديل صلاحية'), 403);

        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        abort_unless(auth()->user()->can('تعديل صلاحية'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'permission' => ['required', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $validated['name'],
        ]);

        $permissions = Permission::whereIn('id', $validated['permission'])->get();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy(int $id): RedirectResponse
    {
        abort_unless(auth()->user()->can('حذف صلاحية'), 403);

        Role::findOrFail($id)->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}

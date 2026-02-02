<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('عرض مستخدم'), 403);

        $data = User::orderByDesc('id')->paginate(5);

        return view('users.show_users', compact('data'))
            ->with('i', ($request->integer('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        abort_unless(auth()->user()->can('اضافة مستخدم'), 403);

        $roles = Role::pluck('name', 'id')->all();

        return view('users.Add_user', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('اضافة مستخدم'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ], [
            'roles.required' => 'يرجى اختيار دور للمستخدم',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $roles = Role::whereIn('id', $validated['roles'])->get();
        $user->syncRoles($roles);

        return redirect()->route('users.index')
            ->with('success', 'تم اضافة المستخدم بنجاح');
    }

    public function show(int $id): View
    {
        abort_unless(auth()->user()->can('عرض مستخدم'), 403);

        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function edit(int $id): View
    {
        abort_unless(auth()->user()->can('تعديل مستخدم'), 403);

        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        abort_unless(auth()->user()->can('تعديل مستخدم'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'password' => ['nullable', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        $roles = Role::whereIn('id', $validated['roles'])->get();
        $user->syncRoles($roles);

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }

    public function destroy(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('حذف مستخدم'), 403);

        User::findOrFail($request->user_id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}

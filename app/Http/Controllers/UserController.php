<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $user = User::find(1);
        if ($user) {
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            if (!$user->roles()->where('role_id', $adminRole->id)->exists()) {
                $user->roles()->attach($adminRole->id);
            }
        }
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|exists:roles,name', // جعل الدور اختياريًا
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_image.image' => 'The profile image must be an image file.',
            'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profile_image.max' => 'The profile image must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to create user', ['data' => $validated]);

            $profileImagePath = null;
            if ($request->hasFile('profile_image')) {
                // إنشاء المجلد إذا لم يكن موجودًا
                $storagePath = public_path('uploads/images');
                if (!File::isDirectory($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                // تخزين الصورة باستخدام move
                $imageName = time() . '_' . uniqid() . '.' . $request->file('profile_image')->getClientOriginalExtension();
                $request->file('profile_image')->move($storagePath, $imageName);
                $profileImagePath = 'uploads/images/' . $imageName;
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'profile_image' => $profileImagePath,
            ]);

            // السماح لنموذج User بتعيين الدور الافتراضي 'user' تلقائيًا
            if (!empty($validated['role'])) {
                $role = Role::where('name', $validated['role'])->first();
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }

            Log::info('User created successfully', ['user_id' => $user->id, 'profile_image' => $profileImagePath]);
            return redirect()->route('users.index')->with('success', 'User created and role assigned successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create user', ['error' => $e->getMessage(), 'data' => $validated]);
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'nullable|exists:roles,name', // جعل الدور اختياريًا
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_image.image' => 'The profile image must be an image file.',
            'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profile_image.max' => 'The profile image must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to update user', ['user_id' => $id, 'data' => $validated]);

            $user = User::findOrFail($id);

            if ($request->hasFile('profile_image')) {
                // حذف الصورة القديمة إذا وجدت
                if ($user->profile_image && File::exists(public_path($user->profile_image))) {
                    File::delete(public_path($user->profile_image));
                }

                // إنشاء المجلد إذا لم يكن موجودًا
                $storagePath = public_path('uploads/images');
                if (!File::isDirectory($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                // تخزين الصورة الجديدة
                $imageName = time() . '_' . uniqid() . '.' . $request->file('profile_image')->getClientOriginalExtension();
                $request->file('profile_image')->move($storagePath, $imageName);
                $validated['profile_image'] = 'uploads/images/' . $imageName;
            }

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                'profile_image' => $validated['profile_image'] ?? $user->profile_image,
            ]);

            if (!empty($validated['role'])) {
                $role = Role::where('name', $validated['role'])->first();
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }

            Log::info('User updated successfully', ['user_id' => $user->id, 'profile_image' => $validated['profile_image']]);
            return redirect()->route('users.index')->with('success', 'User updated and role changed successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update user', ['user_id' => $id, 'error' => $e->getMessage(), 'data' => $validated]);
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete user', ['user_id' => $id]);

            $user = User::findOrFail($id);
            if ($user->roles->contains('name', 'admin')) {
                Log::warning('Attempted to delete admin user', ['user_id' => $id]);
                return redirect()->route('users.index')->with('error', 'Cannot delete an ADMIN user.');
            }

            if ($user->profile_image && File::exists(public_path($user->profile_image))) {
                File::delete(public_path($user->profile_image));
            }

            $user->delete();
            Log::info('User deleted successfully', ['user_id' => $id]);
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete user', ['user_id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        if ($role) {
            $user->assignRole($role->name);
            return back()->with('success', "تم إسناد الدور {$role->name} للمستخدم {$user->name} بنجاح.");
        }

        return back()->with('error', 'حدث خطأ أثناء إسناد الدور.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role->name)) {
            $user->removeRole($role->name);
            return back()->with('success', "تم إزالة الدور {$role->name} من المستخدم {$user->name} بنجاح.");
        }

        return back()->with('error', 'لا يمكن إزالة دور غير موجود.');
    }

    public function assignRoleToUser($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->assignRole($roleName);
        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    public function assignPermissionToUser($userId, $permissionName)
    {
        $user = User::findOrFail($userId);
        $user->givePermissionTo($permissionName);
        return redirect()->back()->with('success', 'Permission assigned successfully.');
    }

    public function removeRoleFromUser($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->removeRole($roleName);
        return redirect()->back()->with('success', 'Role removed successfully.');
    }

    public function removePermissionFromUser($userId, $permissionName)
    {
        $user = User::findOrFail($userId);
        $user->revokePermissionTo($permissionName);
        return redirect()->back()->with('success', 'Permission removed successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function show()
    {
        if (! auth()->user() || ! auth()->user()->roles->some(fn ($role) => $role->name === 'admin')) {
            abort(403, 'Unauthorized');
        }
        $users = User::all();
        $users = $users->load('roles');

        return Inertia::render('Admin/Admin', ['users' => $users]);
    }

    public function delete($id)
    {
        try {
            User::destroy($id);
            $user = User::where('id', '=', $id)->get();

            return redirect()->route('admin.show')->with('success', 'User has been deleted');
        } catch (\Exception $exception) {
            return redirect()->route('admin.show')->with('Error', $exception->getMessage());
        }

    }

    public function edit($id)
    {
        $user = User::where('id', '=', $id)->first();
        $userRoles = $user->roles;
        $roles = Role::all();
        return Inertia::render('Admin/Edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('id', '=', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()
            ->route('admin.edit', ['id' => $user->id]);
    }

    public function dropPass($id)
    {
        $currentUser = Auth::user();
        if(! $currentUser || ! $currentUser->roles->some(fn ($role) => $role->name === 'Admin')){
            return redirect()->route('home');
        }

        $user = User::where('id', '=', $id)->first();
        $user->password = Hash::make('password');
        $user->save();

        return redirect()
            ->route('admin.edit', ['id' => $user->id]);
    }

    public function updateRoles(Request $request, $id)
    {
        $currentUser = Auth::user();

        if (! $currentUser || ! $currentUser->roles->some(fn ($role) => $role->name === 'admin')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'roles' => ['array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::where('id', '=', $id)->firstOrFail();

        // Пример защиты от “сам себе снять Admin” (опционально)
        if ($currentUser->id === $user->id) {
            abort(403, 'You cannot change your own roles');
        }

        $roleIds = $validated['roles'] ?? [];
        $user->roles()->sync($roleIds);

        return redirect()
            ->route('admin.edit', ['id' => $user->id])
            ->with('success', 'Roles updated');
    }

    public function showRoles()
    {
        $roles = Role::all();

        return Inertia::render('Admin/Roles', ['roles' => $roles]);
    }

    // public function createRoles(){
    //     $adminRole = Role::firstOrCreate(['name' => 'admin','slug' => 'admin']);
    //     $userRole = Role::firstOrCreate(['name' => 'user','slug' => 'user']);
    // }
}

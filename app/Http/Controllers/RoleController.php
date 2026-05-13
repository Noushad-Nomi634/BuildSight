<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\User;
class RoleController extends Controller
{
    // public function index()
    // {
    //     $roles = Role::with(['permissions', 'users'])->get();
    //     $permissions = Permission::all();
    //     $permissionGroups = $permissions->groupBy(fn($p) => explode('.', $p->name)[0]);
    //     $rolePermissions = $roles->mapWithKeys(fn($r) => [
    //         $r->id => $r->permissions->pluck('id')->toArray()
    //     ]);

    //     return view('admin.roles.index', compact(
    //         'roles',
    //         'permissions',
    //         'permissionGroups',
    //         'rolePermissions'
    //     ));
    // }

    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->get();
        $permissions = Permission::all();
        $permissionGroups = $permissions->groupBy('group');
        $rolePermissions = $roles->mapWithKeys(fn($r) => [
            $r->id => $r->permissions->pluck('id')->toArray()
        ]);

        // All users with their roles for the drawer
        $users = User::with('roles', 'company')->get(['id', 'name', 'email']); // adjust columns to match your schema

        return view('admin.roles.index', compact(
            'roles',
            'permissions',
            'permissionGroups',
            'rolePermissions',
            'users'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        Role::create(['name' => $request->name, 'guard_name' => $request->guard_name ?? 'web']);
        return back()->with('success', 'Role created successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|string|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);
        return back()->with('success', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted.');
    }

    // AJAX endpoint for permission toggling
    public function updatePermissions(Request $request, Role $role)
    {
        // dd($request->all());
        $role->syncPermissions($request->permissions ?? []);
        return response()->json(['message' => 'Permissions updated for ' . $role->name]);
    }

    public function updateUsers(Request $request, Role $role)
    {
        $request->validate(['users' => 'array', 'users.*' => 'integer|exists:users,id']);

        $userIds = $request->input('users', []);
        // Sync: remove role from users no longer in list, add to new ones
        $current = $role->users->pluck('id');
        $toAdd = collect($userIds)->diff($current);
        $toRemove = $current->diff($userIds);

        User::whereIn('id', $toAdd)->each(fn($u) => $u->assignRole($role));
        User::whereIn('id', $toRemove)->each(fn($u) => $u->removeRole($role));

        return response()->json(['message' => 'Users updated.']);
    }
}

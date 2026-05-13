<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;




class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'group' => 'nullable|string',
            'guard_name' => 'required|in:web,api',
        ]);

        Permission::create($request->only('name', 'group', 'guard_name'));

        return back()->with('success', 'Permission created.');
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'group' => 'nullable|string',
            'guard_name' => 'required|in:web,api',
        ]);

        $permission->update($request->only('name', 'group', 'guard_name'));

        return back()->with('success', 'Permission updated.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['ok' => true]);
    }
}
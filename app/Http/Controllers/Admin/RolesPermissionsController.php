<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as SPermission;
use Spatie\Permission\Models\Role as SRole;

class RolesPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.list', ['roles' => $roles]);
    }


    public function indexPermissions()
    {
        return view('admin.roles.permissions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $credentials = $request->validate([
            'name' => 'required|unique:roles,name|min:4',
            'permissions.*' => ['nullable', 'integer', 'exists:permissions,id'],

        ]);
        $role = SRole::create(['name' => $request->get('name')]);

        foreach ($request->get('permissions') as $key => $value) {
            $permission = SPermission::find($value);
            $role->givePermissionTo($permission);
        }

        return redirect()->route('roles.index')->with(['status' => 'Role ajouter']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', [
            'param' => $role->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'param' => $role->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}

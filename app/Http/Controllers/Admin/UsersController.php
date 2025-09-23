<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SRole;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.list', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'lastname' => ['required'],
            'firstname' => ['required'],
            'roles.*' => ['nullable', 'integer', 'exists:roles,id'],

        ]);

        $new_user = User::create([
            'email' => $request->get('email'),
            'lastname' => $request->get('lastname'),
            'firstname' => $request->get('lastname'),
            'password' => $request->has('password') ? Hash::make($request->get('password')) : Hash::make(uniqid()),
        ]);

        foreach ($request->get('roles') as $key => $value) {
            $role = SRole::find($value);
            $new_user->assignRole($role->name);
        }

        return redirect()->route('roles.index')->with(['status' => 'Utilisateur ajouter']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'param' => $user->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'param' => $user->id,
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        return view('admin.users.password', [
            'param' => $user->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuEmplacement;
use Illuminate\Http\Request;

class MenuEmplacementController extends Controller
{
    //
    public function index()
    {
        return view('admin.menus.emplacement-list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.emplacement-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuEmplacement $menuEmplacement)
    {
        //
        return view('admin.menus.emplacement-show', ['param' => $menuEmplacement->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuEmplacement $menuEmplacement)
    {
        //

        return view('admin.menus.emplacement-edit', ['param' => $menuEmplacement->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuEmplacement $menuEmplacement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuEmplacement $menuEmplacement)
    {
        //
    }
}

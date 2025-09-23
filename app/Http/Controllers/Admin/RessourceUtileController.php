<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RessourcesUtile;
use App\Models\RessourcesUtils;
use Illuminate\Http\Request;

class RessourceUtileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.documentation.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documentation.create');
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
    public function show(RessourcesUtils $ressourcesUtile)
    {
        //
        return view('admin.documentation.show', ['param' => $ressourcesUtile->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RessourcesUtils $ressourcesUtile)
    {
        //
        return view('admin.documentation.edit', ['param' => $ressourcesUtile->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(Request $request, $docId)
    {
        $res = RessourcesUtils::where('doc_id', $docId)->first();
        if ($res) {
            $filePath = public_path('storage/'.$res->doc_file);

            return response()->download($filePath);
        } else {
            exit();
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $paramAuthorize = [
            'site_name',
            'site_description',
            'site_keywords',
            'site_author',
            'site_logo',
            'site_favicon',
            'site_maintenance',
            'copyright',
            'site_whatsapp',
            'site_instagram',
            'site_linkedin',
            'site_x',
            'site_youtube',
            'site_facebook',
            'site_email',
            'site_telephone',
            'localisation_name',
            'localisation_iframe_src',
            'site_adresse',
            'site_map_link',
            'president_title',
            'president_name',

        ];

        $params = Setting::whereIn('key', $paramAuthorize)->where('type', '<>', 'password')->get();

        return response()->json($params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
}

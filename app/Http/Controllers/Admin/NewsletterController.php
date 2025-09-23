<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterMessage;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.newsletter.followers');
    }

    public function createFollower()
    {
        return view('admin.newsletter.create-followers');
    }

    public function campaign()
    {
        return view('admin.newsletter.campaigns');
    }

    public function createCampaign(Request $request)
    {
        return view('admin.newsletter.create-campaigns');
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
    public function show(NewsletterMessage $campaign)
    {
        //
        return view('admin.newsletter.show-campaigns', ['param' => $campaign->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsletterMessage $campaign)
    {
        //
        return view('admin.newsletter.edit-campaigns', ['param' => $campaign->id]);

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

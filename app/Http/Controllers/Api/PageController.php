<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $validator = $request->validate([
            'searchQuery' => ['nullable', 'string'],
            'orderBy' => ['nullable', 'string'],
            'direction' => ['nullable', 'string'],
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
        ]);

        $searchQuery = $validator['searchQuery'] ?? '';
        $orderBy = $validator['orderBy'] ?? 'id';
        $direction = $validator['direction'] ?? 'asc';
        $page = $validator['page'] ?? 1;
        $perPage = $validator['perPage'] ?? 10;

        $pages = Page::where('is_published', 1)
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where(function ($q) use ($searchQuery) {
                    $q->where('title', 'like', '%'.$searchQuery.'%')
                        ->orWhere('content', 'like', '%'.$searchQuery.'%')
                        ->orWhere('resume', 'like', '%'.$searchQuery.'%');
                });
            })
            ->orderBy($orderBy, $direction)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($pages);
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
    public function show(string $slug)
    {
        $page = Page::where('is_published', 1)->where('slug', $slug)->with('poster_media')->first();

        return response()->json($page);
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

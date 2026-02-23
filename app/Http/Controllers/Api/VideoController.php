<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'pageSize' => ['nullable', 'integer'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['pageSize'] ?? 10;

            $videos = Video::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('video_description', 'like', '%' . $search . '%');
                });
            })
                ->with(['categories', 'activities'])
                ->where('is_published', true)
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($videos);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
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

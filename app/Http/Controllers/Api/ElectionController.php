<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validator = $request->validate([
                'search' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'pageSize' => ['nullable', 'integer'],
                'category' => ['nullable', 'string'],
                'year' => ['nullable', 'string'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['pageSize'] ?? 10;
            $category = $validator['category'] ?? null;
            $year = $validator['year'] ?? null;



            $elections = Election::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            });

            if ($year) {
                $elections = $elections->where('year', $year);
            }

            if ($category) {
                $elections = $elections->whereHas('categories', function ($query) use ($category) {
                    $query->where('label', $category);
                });
            }

            $elections = $elections->with(['categories', 'resultats'])
                ->where('is_published', true)
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($elections);
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

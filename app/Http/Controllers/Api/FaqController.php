<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Get search query, order by, direction and pagination from request
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'direction' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['direction'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;

            $ressourcesUtiles = Faq::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', '%'.$search.'%')
                        ->orWhere('answer', 'like', '%'.$search.'%');
                });
            })->with('categories')
                ->where('is_active', true)
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($ressourcesUtiles);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/projects/teams",
     *     summary="Get a paginated list of teams",
     *     tags={"Project/Teams"},
     *
     *     @OA\Parameter(
     *         name="searchQuery",
     *         in="query",
     *         description="Search query for title or content",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="Field to order the results by",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="orderDirection",
     *         in="query",
     *         description="Direction of the order",
     *         required=false,
     *
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/Team")
     *             ),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 ref="#/components/schemas/PaginationLinks"
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *
     *      )
     * )
     *
     * */
    public function index(Request $request)
    {
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

            $teams = Team::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%'.$search.'%')
                        ->orWhere('lastname', 'like', '%'.$search.'%')
                        ->orWhere('firstname', 'like', '%'.$search.'%');
                });
            })
                ->with('media')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($teams);
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

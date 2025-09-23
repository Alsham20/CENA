<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get a paginated list of categories",
     *     tags={"Categories"},
     *
     *      @OA\Parameter(
     *          name="type",
     *          in="query",
     *          description="Type of category",
     *          required=false,
     *
     *          @OA\Schema(type="string", enum={"FAQ","Page", "Article", "Ressource"})
     *      ),
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
     *                 @OA\Items(ref="#/components/schemas/Category")
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
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index(Request $request)
    {
        //

        try {
            $validator = $request->validate([
                'type' => ['nullable', 'string'],
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'direction' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer'],
            ]);
            $type = $validator['type'] ?? '';
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['direction'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;

            $categories = Category::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('label', 'like', '%'.$search.'%')
                        ->orWhere('type', 'like', '%'.$search.'%');
                });
            });
            if (! empty($type)) {
                $categories = $categories->where('type', $type);
            }
            $categories = $categories->with('parents')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($categories);

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

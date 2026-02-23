<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RessourcesUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RessourceUtileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/ressources",
     *     summary="Get a paginated list of ressources",
     *     tags={"Ressources"},
     *
     *     @OA\Parameter(
     *          name="category",
     *          in="query",
     *          description="Category label ",
     *          required=false,
     *
     *          @OA\Schema(type="string")
     *      ),
     *
     *      @OA\Parameter(
     *          name="categoryName",
     *          in="query",
     *          description="Category Name ",
     *          required=false,
     *
     *          @OA\Schema(type="array", @OA\Items(type="string"))
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
     *                 @OA\Items(ref="#/components/schemas/RessourcesUtile")
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
        // Get search query, order by, direction and pagination from request
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'direction' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer'],
                'category' => ['nullable', 'string'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['direction'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;
            $category = $validator['category'] ?? null;

            $ressourcesUtiles = RessourcesUtils::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('object', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('doc_type', 'like', '%' . $search . '%');
                });
            });

            if ($category) {
                $ressourcesUtiles = $ressourcesUtiles->whereHas('categories', function ($query) use ($category) {
                    $query->where('label', $category);
                });
            }

            $ressourcesUtiles = $ressourcesUtiles->with('categories')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($ressourcesUtiles);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/documentation",
     *     summary="Get a paginated list of ressources",
     *     tags={"Ressources"},
     *
     *     @OA\Parameter(
     *          name="category",
     *          in="query",
     *          description="Category label ",
     *          required=false,
     *
     *          @OA\Schema(type="string")
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
     *                 @OA\Items(ref="#/components/schemas/RessourcesUtile")
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
    public function documentation(Request $request)
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
                'category' => ['nullable', 'string'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['direction'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;
            $category = $validator['category'] ?? null;

            $ressourcesUtiles = RessourcesUtils::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('object', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('doc_type', 'like', '%' . $search . '%');
                });
            });

            $cat = Category::where(['type' => 'Documentation', 'label' => 'Décision'])->first();

            $ressourcesUtiles = RessourcesUtils::query()
                ->whereHas('categories', function ($query) use ($cat) {
                    $query->where('type', 'Documentation')
                        ->where('parent', $cat->id);
                })
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('doc_type', 'like', "%{$search}%");
                    });
                });

            // if ($category) {
            //     $ressourcesUtiles = $ressourcesUtiles->whereHas('categories', function ($query) use ($category) {
            //         $query->where('label', $category);
            //     });
            // }
            $ressourcesUtiles = $ressourcesUtiles->with('categories')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($ressourcesUtiles);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/ressources/ressourcesByCategorie",
     *     summary="Get a paginated list of ressources",
     *     tags={"Ressources"},
     *
     *     @OA\Parameter(
     *          name="categorieId",
     *          in="query",
     *          description="Search query for title or content",
     *          required=true,
     *
     *          @OA\Schema(type="string")
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
     *                 @OA\Items(ref="#/components/schemas/RessourcesUtile")
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
    public function ressourceByCategorie(Request $request)
    {
        //
        // Get search query, order by, direction and pagination from request
        try {
            $validator = $request->validate([
                'categorieId' => ['required', 'string'],
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

            $ressourcesUtiles = RessourcesUtils::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('doc_type', 'like', '%' . $search . '%');
                });
            })->where('categorie_id', $request->categorieId)->with('categorie')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($ressourcesUtiles);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
    }

    public function getDecisions(Request $request)
    {
        try {
            $validator = $request->validate([
                'search' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'pageSize' => ['nullable', 'integer'],
                'category' => ['nullable', 'string'],
                'number' => ['nullable', 'string'],
                'requester' => ['nullable', 'string'],
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date'],

            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['pageSize'] ?? 10;
            $category = $validator['category'] ?? null;
            $number = $validator['number'] ?? null;
            $requester = $validator['requester'] ?? null;
            $from = $validator['from'] ?? null;
            $to = $validator['to'] ?? null;

            $cat = Category::where(['type' => 'Documentation', 'label' => 'Décision'])->first();

            $decisions = RessourcesUtils::query()
                ->whereHas('categories', function ($query) use ($cat) {
                    $query->where('type', 'Documentation')
                        ->where('parent', $cat->id);
                })
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('doc_type', 'like', "%{$search}%");
                    });
                });

            if ($number) {
                $decisions = $decisions->where('name', 'like', "%{$number}%");
            }

            if ($requester) {
                $decisions = $decisions->where('requester', 'like', "%{$requester}%");
            }

            if ($from) {
                $decisions = $decisions->whereDate('date_creation', '>=', $from);
            }

            if ($to) {
                $decisions = $decisions->whereDate('date_creation', '<=', $to);
            }

            if ($category && $category != 'Tous les types') {
                $decisions = $decisions->whereHas('categories', function ($query) use ($category) {
                    $query->where('label', $category);
                });
            }

            $decisions = $decisions->with(['categories'])
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($decisions);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
    }


    public function getLois(Request $request)
    {
        try {
            $validator = $request->validate([
                'search' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'pageSize' => ['nullable', 'integer'],
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date'],

            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['pageSize'] ?? 10;
            $from = $validator['from'] ?? null;
            $to = $validator['to'] ?? null;



            $lois = RessourcesUtils::query()
                ->whereHas('categories', function ($query) {
                    $query->where('type', 'Documentation')
                        ->where('label', 'Textes et lois');
                })
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('doc_type', 'like', "%{$search}%");
                    });
                });

            if ($from) {
                $lois = $lois->whereDate('date_creation', '>=', $from);
            }

            if ($to) {
                $lois = $lois->whereDate('date_creation', '<=', $to);
            }

            $lois = $lois->with(['categories'])
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($lois);
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ArticlesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/articles",
     *     summary="Get a paginated list of articles",
     *     tags={"Articles"},
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
     *     @OA\Parameter(
     *         name="isPrivate",
     *         in="query",
     *         description="Show only private articles",
     *         required=false,
     *
     *         @OA\Schema(type="integer", enum={0, 1}),
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
     *                 @OA\Items(ref="#/components/schemas/Article")
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
        // Get search query, order by, direction and pagination from request
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'pageSize' => ['nullable', 'integer'],
                'isPrivate' => ['nullable', 'boolean'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['pageSize'] ?? 10;

            $articles = Article::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%'.$search.'%')
                        ->orWhere('content', 'like', '%'.$search.'%')
                        ->orWhere('content_keywords', 'like', '%'.$search.'%')
                        ->orWhere('content_description', 'like', '%'.$search.'%')
                        ->orWhere('tags', 'like', '%'.$search.'%');
                });
            })
                ->when(isset($validator['isPrivate']) && $validator['isPrivate'], function ($query) {
                    return $query->where('is_private', 1);
                })
                ->with('categories')
                ->where('is_published', true)
                ->where('is_archive', false)
                ->where('is_deleted', false)
                ->with('image')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($articles);

        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }

    }

    /**
     * @OA\Get(
     *     path="/articles/archives",
     *     summary="Get a paginated list of articles",
     *     tags={"Articles"},
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
     *     @OA\Parameter(
     *         name="isPrivate",
     *         in="query",
     *         description="Show only private articles",
     *         required=false,
     *
     *         @OA\Schema(type="integer", enum={0, 1}),
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
     *                 @OA\Items(ref="#/components/schemas/Article")
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
    public function archive(Request $request)
    {
        // Get search query, order by, direction and pagination from request
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer'],
                'isPrivate' => ['nullable', 'boolean'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;

            $articles = Article::when($search, function ($query, $search) {
                return $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%')
                    ->orWhere('content_keywords', 'like', '%'.$search.'%')
                    ->orWhere('content_description', 'like', '%'.$search.'%')
                    ->orWhere('tags', 'like', '%'.$search.'%');
            })
                ->when(isset($validator['isPrivate']) && $validator['isPrivate'], function ($query) {
                    return $query->where('is_private', 1);
                })
                ->with('categories')
                ->where('is_published', true)
                ->where('is_archive', true)
                ->where('is_deleted', false)
                ->with('image')
                ->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($articles);

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
     *
     * @OA\Get(
     *     path="/articles/{article_id}",
     *     summary="Get an article",
     *     tags={"Articles"},
     *
     *     @OA\Parameter(
     *         name="article_id",
     *         in="path",
     *         description="ID of the article",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Item not found"
     *                 )
     *             )
     *         )
     *     )
     * )
     * */
    public function show(string $article_id)
    {
        try {

            $article = Article::with('categories')
                ->with('image')->where('id', $article_id)->first();
            if ($article === null) {
                return response()->json(['error' => [__('Item not found')]], 404);
            }

            return response()->json($article);

        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/articles/{slug}/show",
     *     summary="Get an article",
     *     tags={"Articles"},
     *
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug of the article",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Item not found"
     *                 )
     *             )
     *         )
     *     )
     * )
     * */
    public function showBySlug(string $slug)
    {
        try {

            $article = Article::with('categories')
                ->with('image')->where('slug', $slug)->first();
            if ($article === null) {
                return response()->json(['error' => [__('Item not found')]], 404);
            }

            return response()->json($article);

        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
        }

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

    public function sliderArticles()
    {
        // Get search query, order by, direction and pagination from request
        try {

            $limit = config('article_slider_limit');
            $articles = Article::with('categories')
                ->where('is_private', false)
                ->where('is_published', true)
                ->where('is_archive', false)
                ->where('is_deleted', false)
                ->with('image')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json($articles);

        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        }
    }
}

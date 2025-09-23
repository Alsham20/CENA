<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/events",
     *     summary="Get a paginated list of events",
     *     tags={"Events"},
     *
     *     @OA\Parameter(
     *         name="searchQuery",
     *         in="query",
     *         description="Search query for event name, description, place, start and end",
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
     *         response=200,
     *         description="Returns a paginated list of events",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Event")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
     *         )
     *     ),
     *
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index(Request $request)
    {
        try {
            $validator = $request->validate([
                'searchQuery' => ['nullable', 'string'],
                'orderBy' => ['nullable', 'string'],
                'orderDirection' => ['nullable', 'string'],
                'page' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer'],
            ]);
            $search = $validator['searchQuery'] ?? '';
            $orderBy = $validator['orderBy'] ?? 'id';
            $direction = $validator['orderDirection'] ?? 'asc';
            $page = $validator['page'] ?? 1;
            $perPage = $validator['perPage'] ?? 10;

            $events = Event::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('event_name', 'like', '%'.$search.'%')
                        ->orWhere('event_description', 'like', '%'.$search.'%')
                        ->orWhere('place', 'like', '%'.$search.'%')
                        ->orWhere('event_start', 'like', '%'.$search.'%')
                        ->orWhere('event_end', 'like', '%'.$search.'%');
                });
            })->orderBy($orderBy, $direction)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($events);
        } catch (ValidationException $th) {

            return response()->json(['error' => $th->errors()], 400);
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
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
     * @OA\Get(
     *     path="/events/{id}",
     *     summary="Get a specific event",
     *     tags={"Events"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Event object",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *
     *     @OA\Response(
     *         response="404",
     *         description="Event not found"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     */
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $event = Event::findOrFail($id);

            return response()->json($event);
        } catch (\Exception $th) {
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
}

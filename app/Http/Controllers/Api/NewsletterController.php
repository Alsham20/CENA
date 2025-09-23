<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NotifNewsletterMail;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/news-letter",
     *     summary="Create a new newsletter",
     *     tags={"Newsletters"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"email"},
     *
     *             @OA\Property(property="email", type="string", example="a@b.com"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/NewsLetter"),
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="The email field is required."),
     *         ),
     *     ),
     * )
     * */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'email' => 'required|email',
            ]);
            $newsLetter = NewsLetter::where('email', $validated['email'])->whereNull('categorie_abonne_id')->first();
            if ($newsLetter !== null) {
                $newsLetter->email = $validated['email'];
                $newsLetter->is_active = true;
                $newsLetter->save();
                DB::commit();

                return response()->json(['message' => 'Vous êtes déjà abonné à notre newsletters.', 'data' => $newsLetter], 201);
            } else {
                $newsLetter = NewsLetter::create($validated);
                $follower = NewsLetter::where('email', $validated['email'])->whereNull('categorie_abonne_id')->first();
                Mail::to($follower->email)->send(new NotifNewsletterMail($follower));
            }
            DB::commit();

            return response()->json(['message' => 'Merci de votre inscription! Vous recevrez nos prochaines newsletters.', 'data' => $newsLetter], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/news-letter/unsubscribe",
     *     summary="Unsubscribe from newsletter",
     *     tags={"Newsletters"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"email"},
     *
     *             @OA\Property(property="email", type="string", example="a@b.com"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/NewsLetter"),
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="The email field is required."),
     *         ),
     *     ),
     * )
     * */
    public function unsubscribe(Request $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'email' => 'required|email',
            ]);
            $newsLetter = NewsLetter::where('email', $validated['email'])->whereNull('categorie_abonne_id')->first();
            if ($newsLetter !== null) {
                $newsLetter->email = $validated['email'];
                $newsLetter->is_active = false;
                $newsLetter->save();
                DB::commit();
                Mail::to($newsLetter->email)->send(new NotifNewsletterMail($newsLetter));
                return response()->json(['message' => 'Vous n\'êtes plus abonné à notre newsletters.', 'data' => $newsLetter], 201);
            }

            return response()->json(['message' => 'Vous n\'êtes pas abonné à notre newsletters.', 'data' => $newsLetter], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsLetter $newsLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsLetter $newsLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsLetter $newsLetter)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ConactMail;
use App\Models\ContactMail;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactMailController extends Controller
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
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'mail' => 'required',
                'message' => 'required',
                'object' => 'required',
                'phone' => 'required',
                'recaptchaResponse' => 'required|string'
            ]);
            $recaptchaVerify = Http::asForm()->post(env('FRONT_RECAPTCHA_SITE'), [
                'secret' => env('FRONT_RECAPTCHA_SECRET_KEY'),
                'response' => $request->recaptchaResponse,
            ]);

            if (!$recaptchaVerify->successful() || !$recaptchaVerify->json()['success']) {

                //Log::info("".json_encode($recaptchaVerify->json())." - ".$request->recaptchaResponse);
                return response()->json(['message' => "Recaptcha invalide"], 500);
            }
            $recipient = [config('contact_mail.recipient')];
            $validated['recipients'] = json_encode($recipient);
            unset($validated['recaptchaResponse']);
            $contact = ContactMail::create($validated);

            if (Mail::to(config('contact_mail.recipient'))->send(new ConactMail($contact, false, false))) {
                $contact->update(['sent_at' => now()]);
                Mail::to($validated['mail'])->send(new ConactMail($contact, false, true));

                return response()->json(['message' => 'Contact mail sent successfully.']);
            }


            return response()->json(['message' => 'Contact mail sent successfully.']);
        } catch (\Throwable $th) {
            AuditService::logError('Contact | Erreur lors de la soumission du message de contact | ' . $th->getMessage(), $th->getTraceAsString());

            return response()->json(['message' => $th->getMessage()], 500);
        }
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

<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Auth\SendOtpMail;
use App\Models\ErrorLog;
use App\Models\Setting;
use App\Models\User;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
        //
    public function login()
    {
        // ajouter le recaptcha si actif dans les parametres
        $recaptcha = false;
        if (Setting::where('key', 'login_recaptcha_active')->first()->value == 1) {
            $recaptcha = true;
        }

        return view('auth.login', ['recaptcha' => $recaptcha]);
    }

        /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        if ($request->has('otp_token')) {
            $request->validate([
                'otp' => 'required|string|size:6',
                'otp_token' => 'required',
            ]);
            $token = Crypt::decrypt($request->otp_token);
            $email = json_decode($token)->email;
            $created_at = json_decode($token)->created_at;
            if ($created_at < Carbon::now()->subHours(2)) {
                return response()->json(['status' => 'error', 'message' => 'Le lien est expire']);
            }
            $user = User::where('email', $email)->first();
            if ($user) {
                if ($user->otp !== null && Hash::check($request->otp, $user->otp)) {
                    $user->otp = null;
                    // generater jwt token
                    $token = Auth::login($user);
                    AuditService::log('CONNEXION REUSSIE', json_encode(['last_login' => $user->last_login]), json_encode(['last_login' => date('Y-m-d H:i:s')]), 'date de connexion '.date('Y-m-d H:i:s'));

                    // mettre a jour la date de derniere connexion
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();

                    return redirect()->intended('dashboard');
                } else {
                    return back()->withErrors(['otp' => 'The provided otp is incorrect.'])->onlyInput('otp');
                }
            } else {
                return back()->withErrors(['email' => 'The provided email is incorrect.'])->onlyInput('email');
            }
        } else {

            $rules = [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ];

            // ajouter le recaptcha si actif dans les parametres
            if (Setting::where('key', 'login_recaptcha_active')->first()->value == 1) {
                $rules[recaptchaFieldName()] = recaptchaRuleName();
            }

            $credentials = $request->validate($rules);

            // retier le recaptcha
            $credentials = $request->only('email', 'password');

            // verrifier le nombre de tentative de connexion echoues dans la periode de parametre
            // recuperer la periode de parametre par defaut 60 minutes
            $login_attemp_duration = Setting::where('key', 'login_attempt_duration')->first();
            if ($login_attemp_duration) {
                $login_attemp_duration = $login_attemp_duration->value;
            } else {
                $login_attemp_duration = 60; // en minutes
            }

            $attempts = ErrorLog::where('user_id', $request->email)
                ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-'.$login_attemp_duration.' minutes')))
                ->where('message', 'Error de connexion')
                ->count();

            // recuperer le nombre de tentative autorisees par defaut 5
            $login_attempts = Setting::where('key', 'login_attempts')->first();

            if ($login_attempts) {
                $login_attempts = $login_attempts->value;
            } else {
                $login_attempts = 1;
            }

            if ($attempts >= $login_attempts) {
                return back()->withErrors([
                    'email' => 'Trop de tentative de connexion echoue. Veuillez reessayer dans '.$login_attemp_duration.' minutes',
                ])->onlyInput('email');
            }
            $user = User::where('email', $request->email)->first();
            $opt = random_int(111111, 999999);
            if ($user && Hash::check($request->password, $user->password)) {
                // $request->session()->regenerate();
                // envoyer otp

                if (App::environment('local')) {
                    // The environment is local
                    $opt = '123456';
                }
                $user->otp = Hash::make($opt);
                // ajouter un audit
                $user->save();
                if (! App::environment('local')) {
                    $chan = Setting::where('key', 'otp_channel')->first();
                    if ($chan->value == 'sms') {
                        $r = Helper::sendSms($user->phone, "Votre code OTP est : $opt");
                        Log::info(''.json_encode($r));
                    } else {
                        Mail::to($user->email)->send(new SendOtpMail($opt));
                    }

                }
                $email = Crypt::encrypt(json_encode(['email' => $user->email, 'created_at' => date('Y-m-d H:i:s')]));

                return back()->with('otp_token', $email);
            }

            // ajouter le message d'erreur
            AuditService::logError('Error de connexion', null, $request->email);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {

        AuditService::log('DECONNEXION REUSSIE', null, null, 'date de deconnexion '.date('Y-m-d H:i:s'));
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('app_login'));
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.password_request');
    }

    public function resetPassword(Request $request, string $email, string $token)
    {
        // decrypter le mail
        $email = Crypt::decrypt($email);

        return view('auth.password_reset', ['token' => $token, 'email' => $email]);
    }

    public function sendForgotPasswordMail(Request $request)
    {

        $request->validate(['email' => 'required|email']);
        try {
            DB::beginTransaction();
            // envoyer le lien de recuperation du mot de passe
            $status = Password::sendResetLink(
                $request->only('email')
            );
            AuditService::logAnonyme('ENVOI DU LIEN DE REINITIALISATION DU MOT DE PASSE', null, null, $request->email);
            DB::commit();

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $th) {
            DB::rollBack();
            AuditService::logError('Envoi du lien de reinitialisation du mot de passe', $th, $request->email);

            return redirect()->back()->withErrors(['email' => 'Une erreur est survenue']);
        }
    }

    public function passwordUpdate(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'password' => [
                'required',
                'min:12',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[^a-zA-Z0-9]/',
            ],
            'email' => 'required|email',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un caractère spécial.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'email.required' => 'L\'email est requis.',
            'password.required' => 'Le mot de passe est requis.',
            'email.email' => 'L\'email doit être valide.',
            'token.required' => 'Le token est requis.',
        ]);


        // verifier si une demande d'activation est en cours ( dans les 48h) avec ce mail
        $set_password_expire = 60 * 48; // en minutes
        $requested = DB::table('password_set_tokens')->where('email', $request->email)->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-'.$set_password_expire.' minutes')))->first();
        if ($requested) {
            // il sagit d'une tentative de premier changement de mot de passe
            // valider le token

            if (Hash::check($request->token, $requested->token)) {
                // mettre a jour le mot de passe
                try {
                    DB::beginTransaction();

                    $user = User::where('email', $request->email)->first();
                    $user->password = Hash::make($request->password);
                    $user->must_change_password = false;
                    $user->is_active = true;
                    $user->save();

                    // supprimer le token
                    DB::table('password_set_tokens')->where('email', $request->email)->delete();

                    // ajouter un audit
                    AuditService::log('CHANGEMENT MOT DE PASSE', null, null, 'Changement du mot de passe pour '.$user->email, $user);

                    DB::commit();

                    return redirect()->route('app_login')->with('status', 'Mot de passe mis a jour avec succes');
                } catch (\Throwable $th) {

                    DB::rollBack();
                    AuditService::logError('Echec du changement du mot de passe', $th->getMessage(), $request->email);

                    return back()->withErrors(['email' => [__('Une erreur est survenue lors de la mise a jour du mot de passe')]]);
                }
            }
        } else {
            // il sagit d'une tentative de reinitialisation de mot de passe
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));
                    $user->must_change_password = false;
                    $user->is_active = true;
                    $user->save();

                    // ajouter un audit pour le changement de mot de passe
                    AuditService::log('NOUVEAU MOT DE PASSE', null, null, 'Nouveau mot de passe pour ', $user);

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect()->route('app_login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
        }
    }
}

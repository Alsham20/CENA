<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\Auth\ResetPasswordMail;
use App\Mail\Auth\SetPasswordMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'password',
        'must_change_password',
        'is_active',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sroles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    /**
     * envoyer le lien de recuperation du mot de passe
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        try {
            $email = Crypt::encrypt($this->email);
            $link = route('password.reset', ['token' => $token, 'email' => $email]);
            Mail::to($this->email)->send(new ResetPasswordMail($token, $email, $link));
        } catch (\Throwable $th) {
            // throw $th;

            AuditService::logError('Envoi du lien de reinitialisation du mot de passe', $th, $this->email);
            // throw $th;
        }
    }

    public function sendPasswordActivationMail()
    {
        // verifier si l'utilisateur a deja changer son mot de passe
        if ($this->must_change_password) {

            try {
                // generer un token d'activation
                $token = md5(rand());
                $this->activation_token = Hash::make($token);

                // inserer dans la table password_set_tokens
                DB::table('password_set_tokens')->insert([
                    'email' => $this->email,
                    'token' => $this->activation_token,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $email = Crypt::encrypt($this->email);
                Mail::to($this->email)->send(new SetPasswordMail($token, $email));
            } catch (\Throwable $th) {
                // throw $th;

                AuditService::logError('Envoi du lien d\'activation du compte', $th->getMessage(), $this->email);
            }
        }
    }

    public function sendApiPasswordActivationMail($link)
    {
        $email = $this->email;
        $token = Crypt::encryptString(json_encode(['email' => $email, 'created_at' => date('Y-m-d H:i:s')]));
        $link = $link . '?token=' . $token . '&email=' . $email;
        Mail::to($this->email)->send(new ResetPasswordMail($token, $email, $link));
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'author_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

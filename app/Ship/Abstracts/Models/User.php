<?php

namespace App\Ship\Abstracts\Models;

use App\Ship\Abstracts\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\{HasApiTokens, Token};
use Spatie\Permission\Traits\HasRoles;

abstract class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, HasFactory, SoftDeletes, HasRoles, Notifiable;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];

    public function revokeAllToken(?Token $currentToken = null)
    {
        $this->tokens()->each(function (Token $token) use ($currentToken) {
            if ($currentToken && $currentToken->id == $token->id) {
                return;
            }

            $token->revoke();
            $this->revokeRefreshToken($token->id);
        });
    }

    public function revokeRefreshToken(string $tokenId): void
    {
        $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }

    public function generateVerificationToken(): string
    {
        $verificationToken = Str::random(64);

        while ($this->where('verification_token', $verificationToken)->exists()) {
            $verificationToken = Str::random(64);
        }

        return (string) $verificationToken;
    }
}

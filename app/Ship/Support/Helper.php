<?php

namespace App\Ship\Support;

use App\Containers\v1\Authentication\Models\PasswordReset;
use App\Containers\v1\User\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 *
 * @method string generatePasswordResetToken()
 * @method bool isLoggedInAndHasRole(...$roles)
 * @method bool isGuestOrNotHasRole(...$roles)
 * @method void hasAnyPermission(...$permissions)
 * @method array idsStringToArray(string $ids)
 * @method bool compare($targetValue, $compareValue, string $operator)
 * @method string generateVerificationToken(bool $isChangeEmail = false)
 */
class Helper
{
    /**
     * Generate Password Reset Token
     *
     * @return string
     */
    public function generatePasswordResetToken(): string
    {
        $token = Str::random(64);

        while (PasswordReset::where('token', $token)->exists()) {
            $token = Str::random(64); // @codeCoverageIgnore
        }

        return $token;
    }

    /**
     * Is Logged In And Has Role
     *
     * @param mixed ...$roles
     * @return boolean
     */
    public function isLoggedInAndHasRole(...$roles): bool
    {
        return Auth::user() && Auth::user()->hasAnyRole($roles);
    }

    /**
     * Is Guest Or Not Has Role
     *
     * @param mixed ...$roles
     * @return boolean
     */
    public function isGuestOrNotHasRole(...$roles): bool
    {
        return Auth::guest() || (Auth::user() && !Auth::user()->hasAnyRole($roles));
    }

    /**
     * Has Any Permission
     *
     * @param mixed ...$permissions
     * @return void
     * @throws AuthorizationException
     */
    public function hasAnyPermission(...$permissions): void
    {
        if (Auth::guest()) {
            goto throwError;
        }

        $user = Request::user();

        if ($user && ($user->hasAnyDirectPermission($permissions) || $user->hasAnyPermission($permissions))) {
            return;
        }

        throwError:
        throw new AuthorizationException();
    }

    /**
     * Ids String To Array
     *
     * @param string $ids
     * @return array
     */
    public function idsStringToArray(string $ids): array
    {
        $idCollection = Collection::make(explode(",", trim($ids, "\t\n\r\,")))->map(function ($id) {
            return trim($id);
        });

        return $idCollection->toArray();
    }


    /**
     * Compare
     *
     * @param mixed $targetValue
     * @param mixed $compareValue
     * @return boolean
     */
    public function compare($targetValue, $compareValue, string $operator): bool
    {
        switch ($operator) {
            case '>=':
                return (bool) ($compareValue >= $targetValue);
                break;
            case ">":
                return (bool) ($compareValue > $targetValue);
                break;
            case "=":
                return (bool) ($compareValue == $targetValue);
                break;
            case "<=":
                return (bool) ($compareValue <= $targetValue);
                break;
            case "<":
                return (bool) ($compareValue < $targetValue);
                break;
            default:
                return false;
        }
    }

    /**
     * Generate Verification Token
     *
     * @param bool $isChangeEmail
     * @return string
     */
    public function generateVerificationToken(bool $isChangeEmail = false): string
    {
        do {
            $length = 64;
            $token = Str::random($length); // @codeCoverageIgnore

            if ($isChangeEmail) {
                $token .= "update";
            }
        } while (User::where('verification_token', $token)->exists());

        return $token;
    }
}

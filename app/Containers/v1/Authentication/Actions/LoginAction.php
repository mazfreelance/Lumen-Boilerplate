<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\LoginDTO;
use App\Containers\v1\User\Enums\{UserOnlineStatus, UserStatus, UserVerifyStatus};
use App\Containers\v1\User\Models\User;
use App\Ship\Exceptions\GeneralHttpException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Laravel\Passport\Client;

class LoginAction
{
    public function execute(LoginDTO $loginDTO)
    {
        $user = $this->getUser($loginDTO->email);
        $this->isActive($user);
        $this->isValidPassword($loginDTO->password, $user);
        $this->isEmailVerified($user);

        return $this->getAccessToken($user, $loginDTO->only('password', 'force'));
    }

    private function getUser(string $email): User
    {
        $user = User::filter(['email' => $email])->first();

        if (!$user) throw new GeneralHttpException(__('message.invalid_login'));

        return $user;
    }

    private function isActive(User $user): void
    {
        if ($user->status->value === UserStatus::Inactive) {
            throw new GeneralHttpException(__('message.inactive_account'));
        }
    }

    private function isValidPassword(string $password, User $user): void
    {
        if (!Hash::check($password, $user->password)) {
            throw new GeneralHttpException(__('message.invalid_login'));
        }
    }
    private function isOnline(User $user, bool $isForce): void
    {
        if ($user->online_status->value === UserOnlineStatus::Online && !$isForce) {
            throw new GeneralHttpException(__('message.currently_online'), 400, null, 2);
        }
    }

    private function isEmailVerified(User $user): void
    {
        if ($user->verify_status->value === UserVerifyStatus::No) {
            throw new GeneralHttpException(__('message.verify_email'));
        }
    }

    private function getAccessToken(User $user, LoginDTO $loginDTO) : array
    {

        if (!config('app.allow_login_multiple_token')) {
            $this->isOnline($user, $loginDTO->force);
            $accessToken = $this->generatePersonalAccessToken($user);
        } else $accessToken = $this->generatePasswordAccessToken($user, $loginDTO->password);

        $user->update([
            'online_status' => UserOnlineStatus::Online(),
            'last_login_at' => Carbon::now(),
            'last_login_ip' => Request::ip()
        ]);

        return $accessToken;
    }

    /**
     *  Authenticated user have multiple access token
     */
    private function generatePasswordAccessToken(User $user, string $password): array
    {
        $url = config('app.url') . "/oauth/token";
        $response = Http::asForm()->post($url, [
            'grant_type' => 'password',
            'client_id' => config('passport.password_access_client.id'),
            'client_secret' => config('passport.password_access_client.secret'),
            'username' => $user->email,
            'password' => $password,
            'scope' => [],
        ]);

        return $this->handleResponse($response);
    }

    /**
     *  Authenticated user have one access token
     */
    private function generatePersonalAccessToken(User $user) : array
    {
        $personalAccessToken = $user->createToken($user->name);
        if (!$user->hasAnyRole('admin')) {
            $user->revokeAllToken($personalAccessToken->token);
        }

        return [
            'token_type' => 'Bearer',
            'expires_in' => strtotime(Carbon::parse($personalAccessToken->token->expires_at)->toDateTimeString()),
            'access_token' => $personalAccessToken->accessToken
        ];
    }

    private function handleResponse(Response $response): array
    {
        if ($response->status() == 200) {
            $tokenData = $response->json();
        } else {
            throw new GeneralHttpException(($response->toException()->getMessage()), $response->getStatusCode());
            // throw $response->toException();
        }

        return $tokenData;
    }
}

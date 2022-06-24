<?php

namespace App\Containers\v1\Authentication\Actions;

use App\Containers\v1\Authentication\DTO\RefreshTokenDTO;
use App\Ship\Exceptions\GeneralHttpException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class RefreshTokenAction
{
    public function execute(RefreshTokenDTO $refreshTokenDTO): array
    {
        return $this->getRefreshToken($refreshTokenDTO->refresh_token);
    }

    private function getRefreshToken(string $refreshToken): array
    {
        $url = config('app.url') . "/oauth/token";
        $response = Http::asForm()->post($url, [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('passport.password_access_client.id'),
            'client_secret' => config('passport.password_access_client.secret'),
            'scope' => [],
        ]);

        return $this->handleResponse($response);
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

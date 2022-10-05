<?php

namespace App\Containers\v1\Example\Actions;

use App\Containers\v1\Example\DTO\ExampleAllDTO;
use PragmaRX\Google2FALaravel\Facade as Google2FAFacade;
use PragmaRX\Google2FAQRCode\Google2FA;

class ExampleAllAction
{
    public function execute(ExampleAllDTO $dto)
    {
        $userId = 8;
        $facade =  Google2FAFacade::generateSecretKey(64);
        $generatefacade = Google2FAFacade::setQRCodeBackend('svg');


        $google2faIOC = app('pragmarx.google2fa');
        $ioc = $google2faIOC->generateSecretKey(64);

        $google2fa = new Google2FA();
        // $directly = $google2fa->generateSecretKey(64);
        $inlineUrl = $google2fa->getQRCodeInline(
            "companyName",
            "companyEmail",
            "secretKey"
        );

        return [
            'facade' => $facade,
            'generatefacade' => $generatefacade,
            // 'Google2FA::logout();' => Google2FAFacade::logout(),
            'ioc' => $ioc,
            'inlineUrl' => $inlineUrl,
        ];
    }
}

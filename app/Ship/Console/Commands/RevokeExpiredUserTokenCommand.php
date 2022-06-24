<?php

namespace App\Ship\Console\Commands;

use App\Containers\v1\Authentication\Enums\AccessTokenRevokeStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token;

class RevokeExpiredUserTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:revoke-expired-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke all expired user token command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Token::where('revoked', AccessTokenRevokeStatus::Available)
            ->where('expires_at', '<=', Carbon::now())
            ->chunkById(200, function ($tokens) {
                $tokens->each(function ($token) {
                    $token->revoke();
                });
            });
    }
}

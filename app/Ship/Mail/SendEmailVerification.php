<?php

namespace App\Ship\Mail;

use App\Containers\v1\User\Models\User;
use App\Ship\Enums\QueueType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class SendEmailVerification extends Mailable implements ShouldQueue
{
    use Queueable;

    private $token;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token, User $user)
    {
        $this->onQueue(QueueType::Authentication);

        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-verify')
                    ->subject('Email Verification')
                    ->with([
                        'url' => config('app.frontend.url') . "/emailVerification?token={$this->token}",
                        'user' => $this->user,
                    ]);
    }
}

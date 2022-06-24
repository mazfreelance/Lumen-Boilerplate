<?php

namespace App\Ship\Mail;

use App\Containers\v1\User\Models\User;
use App\Ship\Enums\QueueType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class SendWelcome extends Mailable implements ShouldQueue
{
    use Queueable;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->onQueue(QueueType::Notification);

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.welcome')
        ->subject('Email Verification')
        ->with([
            'user' => $this->user,
        ]);
    }
}

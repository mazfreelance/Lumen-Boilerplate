<?php

namespace App\Containers\v1\Notification\Notifications;

use App\Ship\Enums\QueueType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActionUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $enTitle;

    protected $enBody;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $enTitle, string $enBody)
    {
        $this->onQueue(QueueType::Notification);

        $this->enTitle = $enTitle;
        $this->enBody = $enBody;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'en' => [
                'title' => $this->enTitle,
                'body' => $this->enBody
            ]
        ];
    }
}

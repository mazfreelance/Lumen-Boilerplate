<?php

namespace App\Ship\Mail;

use App\Containers\v1\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class SendEmailExport extends Mailable implements ShouldQueue
{
    use Queueable;

    private $user;

    private $path;

    private $moduleName;

    private $fileName;

    private $email;

    public function __construct(?User $user, string $path, string $moduleName, string $fileName, ?string $email)
    {
        $this->user = $user;
        $this->path = $path;
        $this->moduleName = $moduleName;
        $this->fileName = $fileName;
        $this->email = $email;
    }

    public function build()
    {
        return $this->markdown('emails.export')
                ->subject($this->moduleName)->with([
                    'user' => $this->user,
                    'moduleName' => $this->moduleName
                ])
                ->attach($this->path, ['as' => $this->fileName]);
    }
}

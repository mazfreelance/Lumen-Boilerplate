<?php

namespace App\Containers\v1\User\Jobs;

use App\Containers\v1\User\Exports\UserListExport;
use App\Containers\v1\User\Models\User;
use App\Ship\Abstracts\Jobs\Job;
use App\Ship\Enums\QueueType;
use App\Ship\Mail\SendEmailExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ExportUserList extends Job
{
    public $tries = 1;

    public $timeout = 0;

    private $filterData;

    protected $user;

    public function __construct(array $filterData, User $user)
    {
        $this->onQueue(QueueType::Export);

        $this->filterData = $filterData;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = 'UserList_' . date('YmdHis') . '.csv';
        $zipFileName = "{$fileName}.zip";
        $moduleName = 'User Export';
        $path = storage_path("app/public/exports/{$this->user->id}/{$fileName}");
        $zipPath = storage_path("app/public/exports/{$this->user->id}/{$zipFileName}");

        Excel::store(new UserListExport($this->filterData), $this->user->id . '/' . $fileName, 'export');

        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE) == true) {
            $zip->addFile($path, $fileName);
            $zip->close();

            Mail::to($this->user->email)
                ->cc(explode(',', config('mail.recipient_cc')))
                ->bcc(explode(',', config('mail.recipient_bcc')))
                ->send(new SendEmailExport($this->user, $zipPath, $moduleName, $zipFileName, null));
        }
    }
}

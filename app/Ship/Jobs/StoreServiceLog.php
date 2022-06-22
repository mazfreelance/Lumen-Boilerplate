<?php

namespace App\Ship\Jobs;

use App\Ship\Abstracts\Jobs\Job;
use App\Ship\Enums\QueueType;
use App\Ship\Models\ServiceLog;
use Illuminate\Support\Carbon;

class StoreServiceLog extends Job
{
    protected $userId;

    protected $serviceType;

    protected $path;

    protected $headers;

    protected $payload;

    protected $statusCode;

    protected $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?int $userId = null, string $serviceType, string $path, ?array $headers = [], ?array $payload = [], int $statusCode, ?array $response = [])
    {
        $this->onQueue(QueueType::Log);

        $this->userId = $userId;
        $this->serviceType = $serviceType;
        $this->path = $path;
        $this->headers = $headers;
        $this->payload = $payload;
        $this->statusCode = $statusCode;
        $this->response = $response;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ServiceLog::create([
            'user_id' => $this->userId,
            'service_type' => $this->serviceType,
            'path' => $this->path,
            'header' => $this->headers,
            'payload' => $this->payload,
            'status_code' => $this->statusCode,
            'response' => $this->response,
            'created_at' => Carbon::now()
        ]);
    }
}

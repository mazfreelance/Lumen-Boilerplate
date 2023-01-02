<?php

namespace App\Ship\Console;

use App\Ship\Console\Commands\RevokeExpiredUserTokenCommand;
use BenSampo\Enum\Commands\MakeEnumCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use Mazfreelance\LumenVendorPublish\VendorPublishCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        VendorPublishCommand::class,
        MakeEnumCommand::class,
        RevokeExpiredUserTokenCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RevokeExpiredUserTokenCommand::class)->everyMinute()->withoutOverlapping();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Plugin\Saas\Services\SaasNotification;

class SubscriptionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-subscription:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send subscription related notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notification_service = new SaasNotification();
        $notification_service->subscriptionScheduleNotification();
    }
}

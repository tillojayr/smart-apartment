<?php

namespace App\Console\Commands;

use App\Models\Room;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReminderTimeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an sms notification to tenants reminding them of their payment due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Executing reminder:send command');

        $currentTime = now()->format('H:i'); // Get current time in 24-hour format
        $rooms = Room::all();

        $smsService = new SmsService();

        foreach ($rooms as $room) {
            if ($room->reminder_time === $currentTime) {
                Log::info('SMS sent to tenant: ' . $room->contact_number);
                $smsService->sendSms(
                    $room->contact_number,
                    "Reminder: It's time for your scheduled activity in room {$room->id}."
                );
            }
        }

        Log::info('Reminder sent to tenants at ' . $currentTime);
    }
}

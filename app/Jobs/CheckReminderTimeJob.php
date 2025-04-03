<?php

namespace App\Jobs;

use App\Services\SmsService;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckReminderTimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $roomIds;

    /**
     * Create a new job instance.
     *
     * @param array $roomIds
     */
    public function __construct(array $roomIds)
    {
        $this->roomIds = $roomIds;
        Log::info('CheckReminderTimeJob instantiated.', ['roomIds' => $roomIds]);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('CheckReminderTimeJob started.', ['roomIds' => $this->roomIds]);

        $currentTime = now()->format('Hi'); // Get current time in 24-hour format
        $rooms = Room::whereIn('id', $this->roomIds)->get();

        $smsService = new SmsService();

        foreach ($rooms as $room) {
            if ($room->reminderTime === $currentTime || $room->reminderTime < $currentTime) {
                $smsService->sendSms(
                    $room->contact_number,
                    "Reminder: It's time for your scheduled activity in room {$room->id}."
                );
            }
        }

        Log::info('CheckReminderTimeJob completed.');
    }
}

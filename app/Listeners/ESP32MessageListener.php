<?php

namespace App\Listeners;

use App\Events\SwitchControlEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ESP32MessageListener
{
    /**
     * Handle the event.
     */
    public function handle(SwitchControlEvent $event)
    {
        // Log the received message
        Log::info('Received data from ESP32a: ' . json_encode($event->message));

        // Process the received message
        if ($event->message === 'turn_on') {
            Log::info('Turning ON the appliance');
            // Add code here to update database or trigger some action
        } elseif ($event->message === 'turn_off') {
            Log::info('Turning OFF the appliance');
        }
    }
}

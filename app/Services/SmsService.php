<?php

namespace App\Services;

class SmsService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('SEMAPHORE_API_KEY');
    }

    public function sendSms(string $number, string $message, string $senderName = 'SmartWatt')
    {
        $ch = curl_init();
        $parameters = [
            'apikey' => $this->apiKey,
            'number' => $number,
            'message' => $message,
            'sendername' => $senderName,
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        return true;
    }
}

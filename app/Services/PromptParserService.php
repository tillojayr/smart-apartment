<?php

namespace App\Services;

class PromptParserService
{
    public function extractRoomNumber(string $message): ?int
    {
        if (preg_match('/room\s+(\d+)/i', $message, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }

    public function extractDeviceType(string $message): string
    {
        $devices = [
            'light' => ['light', 'lights', 'lighting'],
            'outlet' => ['outlet', 'socket', 'plug'],
            'ac' => ['ac', 'air conditioning', 'aircon'],
            'fan' => ['fan', 'ventilator'],
        ];

        $lowercaseMessage = strtolower($message);
        foreach ($devices as $device => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($lowercaseMessage, $keyword)) {
                    return $device;
                }
            }
        }
        return 'device';
    }

    public function extractState(string $message): string
    {
        $lowercaseMessage = strtolower($message);
        
        if (str_contains($lowercaseMessage, 'turn off') || 
            str_contains($lowercaseMessage, 'switch off') || 
            str_contains($lowercaseMessage, 'off')) {
            return 'off';
        }
        
        if (str_contains($lowercaseMessage, 'turn on') || 
            str_contains($lowercaseMessage, 'switch on') || 
            str_contains($lowercaseMessage, 'on')) {
            return 'on';
        }
        
        return 'unknown';
    }
}

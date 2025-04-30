<?php

namespace App\Services;

class ChatResponseService
{
    protected $conversationalKeywords = [
        'hello' => 'Hello! I\'m your smart apartment assistant. How can I help you today?',
        'hi' => 'Hi there! I can help you control your apartment or answer questions about power usage.',
        'help' => 'I can help you with:\n- Controlling lights and appliances\n- Checking power usage\n- Setting power budgets\n- General information about your apartment',
        'thank' => 'You\'re welcome! Let me know if you need anything else.',
    ];

    public function isConversational(string $message): bool
    {
        $message = strtolower($message);
        foreach ($this->conversationalKeywords as $keyword => $response) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }

    public function getResponse(string $message): string
    {
        $message = strtolower($message);
        foreach ($this->conversationalKeywords as $keyword => $response) {
            if (str_contains($message, $keyword)) {
                return $response;
            }
        }
        return "I understand you're asking a question. However, I'm primarily designed to help with apartment control and power management. Could you please ask something related to those topics?";
    }
}

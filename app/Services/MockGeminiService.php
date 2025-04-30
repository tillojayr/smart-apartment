<?php

namespace App\Services;

class MockGeminiService extends GeminiService
{
    protected $chatService;
    protected $promptParser;

    public function __construct()
    {
        $this->chatService = new ChatResponseService();
        $this->promptParser = new PromptParserService();
    }

    public function processMessage(string $message): array
    {
        $lowercaseMessage = strtolower($message);

        // Handle conversational messages
        if ($this->chatService->isConversational($message)) {
            return [
                'intent' => 'conversation',
                'message' => $this->chatService->getResponse($message),
                'entities' => []
            ];
        }

        // Handle control commands
        if (str_contains($lowercaseMessage, 'turn') || 
            str_contains($lowercaseMessage, 'switch')) {
            
            $roomId = $this->promptParser->extractRoomNumber($message);
            if (!$roomId) {
                return [
                    'intent' => 'conversation',
                    'message' => "I couldn't identify which room you're referring to. Could you please specify the room number?",
                    'entities' => []
                ];
            }

            return [
                'intent' => 'control_switch',
                'entities' => [
                    'room_id' => $roomId,
                    'relay' => $this->promptParser->extractDeviceType($message),
                    'state' => $this->promptParser->extractState($message)
                ]
            ];
        }

        if (str_contains($lowercaseMessage, 'usage') || str_contains($lowercaseMessage, 'consumption')) {
            return [
                'intent' => 'get_usage',
                'entities' => [
                    'room_id' => 1,
                    'date_range' => ['start' => 'last_week']
                ]
            ];
        }

        if (str_contains($lowercaseMessage, 'budget')) {
            return [
                'intent' => 'set_budget',
                'entities' => [
                    'room_id' => 1,
                    'amount' => 50
                ]
            ];
        }

        // If no specific command is recognized, treat as a general question
        return [
            'intent' => 'conversation',
            'message' => "I understand you're asking about: \"$message\". Could you please rephrase that as a specific command about apartment control or power usage?",
            'entities' => []
        ];
    }
}

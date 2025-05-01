<?php

namespace App\Livewire;

use App\Services\WattAi\SendPromptService;
use Livewire\Component;

class WattAi extends Component
{
    public $message = '';
    public $chatHistory = [];
    public $contents = [];
    public function render()
    {
        $this->contents[] = [
                'role' => 'user',
                'parts' => [[
                    'text' => 'You are a helpful assistant. Please respond directly to the following user message with only the plain text reply — no formatting, no JSON, no metadata.'
                ]]
            ];

        return view('livewire.watt-ai');
    }

    public function sendMessage()
    {
        if(empty($this->message)) {
            return;
        }

        $this->chatHistory[] = [
            'type' => 'user',
            'message' => $this->message,
            'timestamp' => now()->format('H:i')
        ];

        $this->contents[] = [
            'role' => 'user',
            'parts' => [[
                'text' => $this->message
            ]]
        ];

        $request = new SendPromptService();

        $response = $request->processMessage($this->contents);

        $this->contents[] = [
            'role' => 'model',
            'parts' => [[
                'text' => $response
            ]]
        ];

        $this->chatHistory[] = [
            'type' => 'ai',
            'message' => $response,
            'timestamp' => now()->format('H:i')
        ];
        $this->message = '';
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Http\Controllers\NLPController;
use Illuminate\Http\Request;

class WattAiChat extends Component
{
    public $message = '';
    public $chatHistory = [];
    public $isLoading = false;

    protected $nlpController;

    public function boot(NLPController $nlpController)
    {
        $this->nlpController = $nlpController;
    }

    public function sendMessage()
    {
        if (empty($this->message)) {
            return;
        }

        $this->chatHistory[] = [
            'type' => 'user',
            'message' => $this->message,
            'timestamp' => now()->format('H:i')
        ];

        $this->isLoading = true;

        try {
            $request = new Request();
            $request->merge(['message' => $this->message]);
            
            $response = $this->nlpController->handleNLP($request);
            $data = $response->getData(true);

            $aiMessage = match($data['intent']) {
                'conversation' => $data['message'],
                'error' => 'Sorry, I encountered an error: ' . ($data['message'] ?? 'Unknown error'),
                default => $data['action'] ?? $data['message']
            };

            $this->chatHistory[] = [
                'type' => 'ai',
                'message' => $aiMessage,
                'timestamp' => now()->format('H:i')
            ];

        } catch (\Exception $e) {
            $this->chatHistory[] = [
                'type' => 'error',
                'message' => 'Sorry, I encountered an error processing your request.',
                'timestamp' => now()->format('H:i')
            ];
            
            logger()->error('Chat processing failed:', [
                'error' => $e->getMessage(),
                'message' => $this->message
            ]);
        }

        $this->message = '123123';
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.watt-ai-chat');
    }
}

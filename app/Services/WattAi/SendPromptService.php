<?php

namespace App\Services\WattAi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendPromptService
{
    protected $apiKey;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->apiEndpoint = config('services.gemini.endpoint');
    }

    public function processMessage(array $message)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiEndpoint . $this->apiKey, [
                'contents' => [[
                    $message
                ]]
            ]);

            $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!$response->successful()) {
                throw new \Exception('Gemini API request failed');
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function buildPrompt(string $message): string
    {
        return "You are a helpful assistant. Please respond directly to the following user message with only the plain text reply — no formatting, no JSON, no metadata, and no explanation.\n\n" .
               "User: \"$message\"\n\n";
    }
}

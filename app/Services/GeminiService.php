<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->apiEndpoint = config('services.gemini.endpoint');
    }

    public function processMessage(string $message)
    {
        try {
            $cacheKey = 'nlp_' . md5($message);
            
            // Check cache first
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey
            ])->post($this->apiEndpoint, [
                'contents' => [[
                    'parts' => [[
                        'text' => $this->buildPrompt($message)
                    ]]
                ]]
            ]);

            if (!$response->successful()) {
                throw new \Exception('Gemini API request failed');
            }

            $result = $this->parseGeminiResponse($response->json());
            
            // Cache the result for 5 minutes
            Cache::put($cacheKey, $result, now()->addMinutes(5));

            return $result;

        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function buildPrompt(string $message): string
    {
        return "Parse this smart home command and return JSON with intent and entities:\n\n" .
               "Message: \"$message\"\n\n" .
               "Return only valid JSON matching this structure:\n" .
               "{\n" .
               "  \"intent\": \"control_switch|get_usage|set_budget\",\n" .
               "  \"entities\": {\n" .
               "    \"room_id\": number,\n" .
               "    \"relay\": string,\n" .
               "    \"state\": string,\n" .
               "    \"amount\": number,\n" .
               "    ... other relevant entities\n" .
               "  }\n" .
               "}";
    }

    private function parseGeminiResponse($response): array
    {
        // Extract the JSON from Gemini's response
        $text = $response['candidates'][0]['content']['parts'][0]['text'];
        return json_decode($text, true);
    }
}

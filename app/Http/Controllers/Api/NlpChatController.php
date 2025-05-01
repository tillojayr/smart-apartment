<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NlpChatController extends Controller
{
    // ...existing code...

    public function handleNLP(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        // Send message to Gemini API
        $geminiApiKey = config('services.gemini.api_key');
        $geminiEndpoint = config('services.gemini.endpoint'); // e.g., https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent

        $geminiPayload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $userMessage]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$geminiApiKey}",
        ])->post($geminiEndpoint, $geminiPayload);

        if (!$response->ok()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to connect to Gemini API.',
            ], 500);
        }

        // Parse Gemini response
        $geminiData = $response->json();

        // Assume Gemini returns a JSON string in the first candidate's content
        $rawReply = $geminiData['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if (!$rawReply) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid response from Gemini API.',
            ], 500);
        }

        // Try to decode the JSON structure from Gemini's reply
        $nlpResult = json_decode($rawReply, true);

        if (!$nlpResult || !isset($nlpResult['intent'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not parse intent from Gemini response.',
            ], 500);
        }

        // Handle actionable intents
        switch ($nlpResult['intent']) {
            case 'control_switch':
                // Example: call a method to control a device
                // You may want to validate entities here
                $entities = $nlpResult['entities'] ?? [];
                // $result = $this->controlSwitch($entities);
                // For now, just return the entities for demonstration
                return response()->json([
                    'status' => 'success',
                    'message' => 'Switch control executed.',
                    'data' => $entities,
                ]);
            case 'get_usage':
                // Example: call a method to get usage
                // $result = $this->getUsage($entities);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Usage data retrieved.',
                    // 'data' => $result,
                ]);
            case 'set_budget':
                // Example: call a method to set budget
                // $result = $this->setBudget($entities);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Budget set.',
                    // 'data' => $result,
                ]);
            case 'none':
            default:
                // General chat reply
                $reply = $nlpResult['reply'] ?? 'Sorry, I did not understand that.';
                return response()->json([
                    'status' => 'success',
                    'message' => $reply,
                ]);
        }
    }

    // ...existing code...
}

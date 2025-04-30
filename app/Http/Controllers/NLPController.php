<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use App\Interfaces\Controllers\IControlController;
use App\Interfaces\Controllers\IUsageController;
use App\Interfaces\Controllers\IBudgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NLPController extends Controller
{
    protected $geminiService;
    protected $controlController;
    protected $usageController;
    protected $budgetController;

    public function __construct(
        GeminiService $geminiService,
        IControlController $controlController,
        IUsageController $usageController,
        IBudgetController $budgetController
    ) {
        $this->geminiService = $geminiService;
        $this->controlController = $controlController;
        $this->usageController = $usageController;
        $this->budgetController = $budgetController;
    }

    public function handleNLP(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        try {
            $nlpResponse = $this->geminiService->processMessage($request->message);
            
            // Ensure we have an intent
            $intent = $nlpResponse['intent'] ?? 'conversation';
            
            // Format response based on intent
            $response = [
                'success' => true,
                'intent' => $intent,
                'message' => $nlpResponse['message'] ?? 'Processed successfully',
                'action' => null,
                'data' => null
            ];

            // Add action for command intents
            if ($intent !== 'conversation') {
                $response['action'] = $this->generateActionMessage($nlpResponse);
                $response['data'] = $nlpResponse['entities'] ?? null;
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('NLP processing failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'intent' => 'error',
                'message' => 'Failed to process command',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateActionMessage($nlpResponse)
    {
        return match ($nlpResponse['intent']) {
            'control_switch' => sprintf(
                '%s turned %s in Room %d',
                ucfirst($nlpResponse['entities']['relay'] ?? 'device'),
                $nlpResponse['entities']['state'] ?? 'unknown',
                $nlpResponse['entities']['room_id'] ?? 0
            ),
            'get_usage' => 'Retrieved electricity usage data',
            'set_budget' => sprintf(
                'Budget set to $%d for Room %d',
                $nlpResponse['entities']['amount'] ?? 0,
                $nlpResponse['entities']['room_id'] ?? 0
            ),
            default => $nlpResponse['message'] ?? 'Command processed'
        };
    }
}

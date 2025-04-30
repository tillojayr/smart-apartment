<div class="flex flex-col h-[600px] bg-white rounded-lg shadow-lg">
    <!-- Chat Header -->
    <div class="px-6 py-4 bg-electric-orange-500 rounded-t-lg">
        <h3 class="text-lg font-semibold text-white">Watt AI Assistant</h3>
        <p class="text-sm text-indigo-200">Ask me about your apartment's power usage or control</p>
    </div>

    <!-- Sample Prompts -->
    <div class="px-6 py-2 bg-indigo-50 border-b">
        <p class="text-sm text-gray-600 mb-2">Try these commands:</p>
        <div class="flex flex-wrap gap-2">
            <button wire:click="$set('message', 'Turn off the lights in Room 3')" 
                    class="text-xs px-3 py-1 bg-white rounded-full border hover:bg-indigo-50">
                Turn off lights in Room 3
            </button>
            <button wire:click="$set('message', 'What is my power usage this week?')"
                    class="text-xs px-3 py-1 bg-white rounded-full border hover:bg-indigo-50">
                Check power usage
            </button>
            <button wire:click="$set('message', 'Set power budget to $50 for Room 1')"
                    class="text-xs px-3 py-1 bg-white rounded-full border hover:bg-indigo-50">
                Set power budget
            </button>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 p-4 overflow-y-auto" id="chat-messages">
        @foreach($chatHistory as $chat)
            <div class="mb-4 {{ $chat['type'] === 'user' ? 'text-right' : 'text-left' }}">
                <div class="inline-block max-w-[80%] rounded-lg px-4 py-2 
                    {{ $chat['type'] === 'user' ? 'bg-electric-orange-500 text-white' : 
                       ($chat['type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-800') }}">
                    <p class="text-sm">{{ $chat['message'] }}</p>
                    <span class="text-xs opacity-75">{{ $chat['timestamp'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chat Input -->
    <div class="p-4 border-t">
        <form wire:submit.prevent="sendMessage" class="flex gap-2">
            <input 
                type="text" 
                wire:model="message" 
                class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-electric-orange-500"
                placeholder="Type your message..."
            >
            <button 
                type="submit"
                class="px-4 py-2 text-white bg-electric-orange-500 rounded-lg hover:bg-electric-orange-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50"
                :disabled="$isLoading"
            >
                <span wire:loading.remove>Send</span>
                <span wire:loading>
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                </span>
            </button>
        </form>
    </div>
</div>

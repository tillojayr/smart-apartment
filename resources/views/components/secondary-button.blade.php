<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-electric-orange-300 rounded-md font-semibold text-xs text-electric-orange-700 uppercase tracking-widest shadow-sm hover:bg-electric-orange-50 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

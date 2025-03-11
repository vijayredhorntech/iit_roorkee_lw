<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full mt-8 px-4 py-3 bg-primary/80 border-[2px] border-primary/90 text-white/80 font-semibold hover:bg-primary/90 hover:text-white rounded-[3px] inline-flex items-center justify-center whitespace-nowrap transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 transition ease-in duration-200']) }}>
    {{ $slot }}
</button>

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#FFC209] border border-transparent rounded-md font-orbitron font-bold text-sm text-[#0a0f1d] uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-[#FFC209] focus:ring-offset-2 focus:ring-offset-[#111827] transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,194,9,0.5)]']) }}>

    {{ $slot }}
</button>

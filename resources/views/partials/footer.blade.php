<!-- ENGINEERING FOOTER -->
<footer class="border-t border-white/10 bg-[#03071E] relative z-10 py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
    
    <!-- Logo & Brand Info -->
    <div class="flex items-center gap-3">
      <img 
        src="{{ asset('images/Logo.png') }}" 
        alt="InnoElectrica Logo" 
        class="h-8 w-8 rounded-full object-cover ring-1 ring-cyan-400/40"
      />
      <div class="flex flex-col">
        <div class="flex items-center gap-1.5 font-['Space_Grotesk'] font-bold text-sm text-white">
          <span>InnoElectrica EXPO</span>
          <span class="text-[#FACC15] font-['Orbitron']">2026</span>
        </div>
        <span class="text-[11px] text-slate-400">
          &copy; 2026 IEEE Student Branch Universitas Riau. All rights reserved.
        </span>
      </div>
    </div>

    <!-- Legal Links -->
    <div class="flex items-center gap-6 text-xs font-['JetBrains_Mono'] text-slate-400">
      <a href="{{ route('privacy') }}" class="hover:text-cyan-400 transition-colors">Privacy Policy</a>
      <a href="{{ route('terms') }}" class="hover:text-cyan-400 transition-colors">Terms of Service</a>
      <a href="{{ request()->is('/') ? '#about' : url('/#about') }}" class="hover:text-cyan-400 transition-colors">Contact Support</a>
    </div>

  </div>
</footer>

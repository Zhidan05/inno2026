<!-- Aceternity Expandable Card Modal Component (Shared-Element Morph Transition) -->
<div 
  id="expandable-card-backdrop" 
  class="fixed inset-0 bg-[#03071E]/80 backdrop-blur-md z-[100] opacity-0 pointer-events-none transition-opacity duration-300"
  onclick="closeExpandableCard()"
></div>

<div 
  id="expandable-card-container" 
  class="fixed inset-0 z-[101] grid place-items-center p-4 sm:p-6 pointer-events-none opacity-0 overflow-y-auto"
  onclick="closeExpandableCard()"
>
  <!-- Aceternity Modal Card Dialog -->
  <div 
    id="expandable-card-dialog" 
    class="relative w-full max-w-[520px] max-h-[90vh] bg-[#070F2B] border border-cyan-500/30 rounded-3xl overflow-hidden shadow-[0_25px_60px_-15px_rgba(37,99,235,0.4)] flex flex-col my-auto backdrop-blur-2xl will-change-transform"
    onclick="event.stopPropagation()"
  >
    <!-- Close Button (Matching Aceternity CloseIcon) -->
    <button 
      type="button" 
      onclick="closeExpandableCard()" 
      class="exp-fade-item absolute top-3.5 right-3.5 sm:top-4 sm:right-4 z-30 flex items-center justify-center bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-white/20 rounded-full h-8 w-8 sm:h-9 sm:w-9 backdrop-blur-md transition-colors shadow-lg cursor-pointer"
      aria-label="Close"
    >
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M18 6l-12 12" />
        <path d="M6 6l12 12" />
      </svg>
    </button>

    <!-- Visual Header / Banner matching card visual -->
    <div id="exp-banner" class="relative w-full h-44 sm:h-52 bg-gradient-to-br from-blue-950 via-[#070F2B] to-[#0A1438] border-b border-white/[0.08] flex items-center justify-center overflow-hidden shrink-0">
      <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-cyan-500/20 via-transparent to-transparent"></div>
      <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:20px_20px]"></div>
      
      <div id="exp-icon-container" class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/10 border border-cyan-400/30 flex items-center justify-center text-cyan-300 shadow-[0_0_30px_rgba(56,189,248,0.25)]"></div>

      <div class="absolute top-4 left-4 flex items-center gap-2">
        <span id="exp-status" class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold border backdrop-blur-md whitespace-nowrap"></span>
        <span id="exp-badge" class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold bg-blue-950/80 text-cyan-300 border border-cyan-500/30 uppercase font-['JetBrains_Mono'] backdrop-blur-md whitespace-nowrap shrink-0"></span>
      </div>
    </div>

    <!-- Aceternity Header: Title on left, CTA Button on right -->
    <div class="p-4 sm:p-5 flex justify-between items-start gap-4 border-b border-white/[0.06] shrink-0">
      <div class="min-w-0 pr-1">
        <h3 id="exp-title" class="font-['Space_Grotesk'] font-bold text-xl sm:text-2xl text-white tracking-tight leading-snug"></h3>
        <div class="flex items-center gap-2.5 mt-1">
          <span id="exp-fee-badge" class="font-['Space_Grotesk'] font-bold text-xs sm:text-sm text-[#FACC15]"></span>
        </div>
      </div>

      <a 
        id="exp-register-btn" 
        href="#" 
        class="exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white shadow-[0_4px_16px_rgba(37,99,235,0.4)] transition-all shrink-0 cursor-pointer inline-flex items-center gap-1.5"
      >
        <span>Register Now</span>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
      </a>
    </div>

    <!-- Aceternity Scrollable Body Content (Real DB Only) -->
    <div class="pt-3 pb-6 px-4 sm:px-5 relative flex-1 overflow-hidden flex flex-col">
      <div 
        id="exp-scroll-body" 
        class="exp-fade-item text-slate-300 text-xs sm:text-sm overflow-y-auto pr-1 flex flex-col gap-4 max-h-[42vh] [mask:linear-gradient(to_bottom,white_85%,transparent)] [scrollbar-width:none] [-ms-overflow-style:none] [-webkit-overflow-scrolling:touch]"
      >
        <!-- Deskripsi Real DB -->
        <div id="exp-desc-wrapper">
          <h4 class="text-[11px] font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold mb-1.5">
            Competition Overview
          </h4>
          <p id="exp-description" class="text-slate-300 text-xs sm:text-sm leading-relaxed whitespace-pre-line"></p>
        </div>

        <!-- Info Extended Banner Real DB -->
        <div id="exp-extended-banner" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-amber-500/10 border border-amber-400/25 text-amber-300 text-xs font-medium shadow-[0_0_12px_rgba(245,158,11,0.08)] hidden">
          <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span id="exp-extended-date"></span>
        </div>

        <!-- Info Stats Real DB -->
        <div class="grid grid-cols-2 gap-2.5 w-full">
          <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3">
            <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Participation Format</span>
            <span id="exp-team" class="text-xs sm:text-sm font-semibold text-white mt-0.5 block"></span>
          </div>
          <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3">
            <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Registration Fee</span>
            <span id="exp-fee" class="text-xs sm:text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 block"></span>
          </div>
          <div id="exp-location-wrapper" class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3 hidden">
            <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Event Location</span>
            <span id="exp-location" class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 block"></span>
          </div>
          <div id="exp-submission-wrapper" class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3 hidden">
            <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Submission Method</span>
            <span id="exp-submission" class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 block"></span>
          </div>
        </div>

        <!-- Real DB Schedule -->
        <div id="exp-timeline-wrapper" class="space-y-2.5 pt-1 hidden w-full">
          <h4 class="text-[11px] font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span>Official Timeline & Schedule</span>
          </h4>
          <div id="exp-timeline-list" class="grid grid-cols-1 sm:grid-cols-2 gap-2 w-full"></div>
        </div>
      </div>
    </div>
  </div>
</div>

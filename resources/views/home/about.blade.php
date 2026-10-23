<!-- ABOUT & CONTACT SECTION -->
<section id="about" class="py-24 relative border-t border-blue-500/15 bg-[#050B24]/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center max-w-3xl mx-auto mb-16">
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
        <span>Official Center</span>
      </div>
      <h2 class="mt-2 text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
        About & Contact
      </h2>
      <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
        Everything you need to know about InnoElectrica 26.
      </p>
    </div>

    <!-- Equal-Height 3-Column Core Information Architectural Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Card 1: CONTACT US (Interactive Clickable Rows + Copy Action) -->
      <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Contact Us</h3>
          </div>

          <div class="space-y-3">
            <!-- Email Row with Interactive Copy Button -->
            <div class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row">
              <div class="flex items-center gap-3 truncate mr-2">
                <span class="text-cyan-400 shrink-0">@</span>
                <div class="truncate">
                  <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">Email</div>
                  <a href="mailto:inno-ieee.sb@unri.ac.id" class="text-xs font-medium text-slate-200 hover:text-cyan-400 transition truncate block">
                    inno-ieee.sb@unri.ac.id
                  </a>
                </div>
              </div>
              <button 
                onclick="copyToClipboard('inno-ieee.sb@unri.ac.id', this)"
                type="button" 
                title="Copy Email"
                class="p-1.5 rounded-lg bg-white/5 hover:bg-cyan-400/20 text-slate-400 hover:text-cyan-300 transition shrink-0 cursor-pointer"
              >
                <svg class="w-4 h-4 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke-width="2"></rect>
                  <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke-width="2"></path>
                </svg>
              </button>
            </div>

            <!-- Instagram Row -->
            <a 
              href="https://instagram.com/innoelectricaunri" 
              target="_blank" 
              rel="noopener noreferrer" 
              class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
            >
              <div class="flex items-center gap-3">
                <span class="text-pink-400 shrink-0">#</span>
                <div>
                  <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">Instagram</div>
                  <span class="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">@innoelectricaunri</span>
                </div>
              </div>
              <svg class="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
            </a>

            <!-- WhatsApp Row -->
            <a 
              href="https://wa.me/6282268863544" 
              target="_blank" 
              rel="noopener noreferrer" 
              class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
            >
              <div class="flex items-center gap-3">
                <span class="text-emerald-400 shrink-0">✆</span>
                <div>
                  <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">WhatsApp (Phone)</div>
                  <span class="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">+62 822-6886-3544</span>
                </div>
              </div>
              <svg class="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
            </a>
          </div>
        </div>

        <div class="mt-6 pt-4 border-t border-white/10 text-[11px] font-['JetBrains_Mono'] text-slate-500">
          Active response: Mon - Sat 08:00 - 17:00 WIB
        </div>
      </div>

      <!-- Card 2: ORGANIZER (Verified Branch Architecture) -->
      <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Organizer</h3>
          </div>

          <div class="space-y-4">
            <div>
              <h4 class="font-['Space_Grotesk'] font-bold text-base text-white">
                IEEE Student Branch Universitas Riau
              </h4>
              <p class="text-xs sm:text-sm text-slate-400 mt-1 leading-relaxed">
                Faculty of Engineering, Universitas Riau
              </p>
            </div>

            <p class="text-xs text-slate-400/90 leading-relaxed">
              A professional student engineering community fostering technological breakthroughs, global technical standards, and scientific leadership.
            </p>
          </div>
        </div>

        <!-- Verified Official Branch Badge -->
        <div class="mt-6 pt-4 border-t border-white/10">
          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600/15 border border-cyan-400/30 text-cyan-300 font-['JetBrains_Mono'] text-xs font-semibold">
            <svg class="w-4 h-4 text-cyan-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>Official IEEE Student Branch</span>
          </div>
        </div>
      </div>

      <!-- Card 3: LOCATION & EVENT FORMAT -->
      <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Location</h3>
          </div>

          <div>
            <h4 class="font-['Space_Grotesk'] font-bold text-base text-white">
              Faculty of Engineering - Universitas Riau
            </h4>
            <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
              Kampus Bina Widya, Jl. HR. Soebrantas KM. 12.5, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293
            </p>
          </div>
        </div>

        <!-- Distinct Technical Format Status Box -->
        <div class="mt-6 pt-4 border-t border-white/10">
          <div class="rounded-xl bg-[#03071E]/80 border border-blue-500/20 p-3.5 flex items-center justify-between">
            <div>
              <div class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400">EVENT FORMAT</div>
              <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-0.5">Hybrid (Online & Offline)</div>
            </div>
            <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 shadow-[0_0_8px_#38BDF8]"></span>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

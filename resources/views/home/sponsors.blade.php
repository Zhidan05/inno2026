@props(['sponsors' => []])

<!-- SECTION 1: OFFICIAL SPONSORS (Aceternity Minimalist Style) -->
<section id="sponsors" class="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header matching User Screenshot -->
    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-['Space_Grotesk'] font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style="background-image: linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Trusted by Industry Leaders
      </h2>
      <p class="mt-2.5 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
        Forward-thinking organizations powering engineering, energy, and digital breakthroughs.
      </p>
    </div>

    <!-- Frameless Horizontal Brand Logos Row (Logo Gambar Saja Tanpa Box, Nama Dibawah Logo) -->
    <div class="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
      @php
        $dbSponsors = $sponsors ?? [];
        $sponsorCount = count($dbSponsors);
      @endphp

      {{-- Render Dynamic Sponsors from Database --}}
      @foreach($dbSponsors as $sponsor)
        @php
          $link = $sponsor->link ?? $sponsor['link'] ?? null;
          $name = $sponsor->name ?? $sponsor['name'] ?? 'Sponsor';
          $logo = $sponsor->logo ?? $sponsor['logo'] ?? null;
          $isGold = !empty($sponsor->is_gold) || !empty($sponsor['is_gold']);
        @endphp
        @if($link)
          <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1">
        @else
          <div class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
        @endif
          @if(!empty($logo))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="{{ $name }}" class="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300">
          @else
            <div class="w-10 h-10 flex items-center justify-center text-cyan-400 font-bold font-['Space_Grotesk'] text-xl">
              {{ substr($name, 0, 1) }}
            </div>
          @endif
          <span class="font-['Space_Grotesk'] font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center flex items-center justify-center gap-1.5">
            {{ $name }}
            @if($isGold)
              <span class="text-[9px] font-['JetBrains_Mono'] px-1.5 py-0.2 rounded bg-amber-400/10 text-amber-400 border border-amber-400/30 font-semibold tracking-wider uppercase">GOLD</span>
            @endif
          </span>
        @if($link)
          </a>
        @else
          </div>
        @endif
      @endforeach

      @if($sponsorCount === 0)
        <div class="text-center py-4 px-4 w-full">
          <p class="text-slate-400 text-sm max-w-md mx-auto">Official sponsor announcements will be published soon.</p>
        </div>
      @endif
    </div>

    <div class="mt-10 text-center">
      <a href="mailto:inno-ieee.sb@unri.ac.id?subject=Sponsorship%20Inquiry%20IEE%202026" class="inline-flex items-center gap-1.5 text-xs font-['JetBrains_Mono'] text-slate-500 hover:text-cyan-400 transition-colors">
        <span>Interested in empowering future innovators?</span>
        <span class="text-cyan-400 font-medium">Become an Official Sponsor →</span>
      </a>
    </div>
  </div>
</section>

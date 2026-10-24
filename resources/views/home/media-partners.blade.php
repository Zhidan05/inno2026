@props(['mediaPartners' => []])

<!-- SECTION 2: MEDIA PARTNERS (Aceternity Minimalist Style - SEPARATED) -->
<section id="media-partners" class="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header matching User Screenshot -->
    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-['Space_Grotesk'] font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style="background-image: linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Supported by Media Networks
      </h2>
      <p class="mt-2.5 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
        National press, broadcast channels, and student media networks amplifying IEE 2026 across Indonesia.
      </p>
    </div>

    <!-- Frameless Horizontal Brand Logos Row (Logo Gambar Saja Tanpa Box, Nama Dibawah Logo) -->
    <div class="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
      @php
        $dbMedia = $mediaPartners ?? [];
        $mediaCount = count($dbMedia);
      @endphp

      {{-- Render Dynamic Media Partners from Database --}}
      @foreach($dbMedia as $partner)
        @php
          $link = $partner->link ?? $partner['link'] ?? null;
          $name = $partner->name ?? $partner['name'] ?? 'Media Partner';
          $logo = $partner->logo ?? $partner['logo'] ?? null;
        @endphp
        @if($link)
          <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1">
        @else
          <div class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
        @endif
          @if(!empty($logo))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="{{ $name }}" class="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300">
          @else
            <div class="w-10 h-10 flex items-center justify-center text-indigo-400 font-bold font-['Space_Grotesk'] text-xl">
              {{ substr($name, 0, 1) }}
            </div>
          @endif
          <span class="font-['Space_Grotesk'] font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
            {{ $name }}
          </span>
        @if($link)
          </a>
        @else
          </div>
        @endif
      @endforeach

      @if($mediaCount === 0)
        <div class="text-center py-4 px-4 w-full">
          <p class="text-slate-400 text-sm max-w-md mx-auto">Official media partner announcements will be published soon.</p>
        </div>
      @endif
    </div>

    <div class="mt-10 text-center">
      <a href="mailto:inno-ieee.sb@unri.ac.id?subject=Media%20Partnership%20IEE%202026" class="inline-flex items-center gap-1.5 text-xs font-['JetBrains_Mono'] text-slate-500 hover:text-cyan-400 transition-colors">
        <span>Broadcasting student technology & events?</span>
        <span class="text-cyan-400 font-medium">Join as Media Partner →</span>
      </a>
    </div>
  </div>
</section>

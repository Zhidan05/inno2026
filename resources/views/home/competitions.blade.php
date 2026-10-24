@props(['competitions' => []])

@php
  $compCount = count($competitions ?? []);
@endphp

<!-- COMPETITIONS SECTION -->
<section id="competitions" class="py-24 relative border-t border-blue-500/15 bg-[#050B24]/40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header without Cliché AI Pulse -->
    <div class="text-center max-w-3xl mx-auto mb-16">
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
        <span>Competitions & Challenges</span>
      </div>
      <h2 class="text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
        Competitions
      </h2>
      <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
        Explore official engineering and technology innovation competitions at InnoElectrica EXPO 2026.
      </p>
    </div>

    <!-- Flexible Dynamic Bento Grid: Perfectly centered based on real competition count from database -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
      @forelse($competitions ?? [] as $index => $competition)
        @include('components.competition-card', [
          'competition' => $competition,
          'index' => $index,
          'compCount' => $compCount,
        ])
      @empty
        <div class="col-span-full py-16 px-6 text-center rounded-3xl bg-[#070F2B]/50 border border-white/10 backdrop-blur-xl">
          <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
          </div>
          <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white mb-2">No Competitions Available</h3>
          <p class="text-slate-400 text-sm max-w-md mx-auto">
            Competitions are currently being prepared by the committee. Please check back regularly for the latest registration updates.
          </p>
        </div>
      @endforelse
    </div>

  </div>
</section>

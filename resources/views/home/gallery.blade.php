@props(['galleries' => []])

<!-- GALLERY SECTION -->
<section id="gallery" class="py-24 relative border-t border-blue-500/15 bg-[#03071E]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center max-w-3xl mx-auto mb-16">
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
        <span>Event Highlights</span>
      </div>
      <h2 class="mt-2 text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
        Gallery
      </h2>
      <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
        Highlights from past InnoElectrica editions.
      </p>
    </div>

    @php
      $galleryItems = [];
      foreach(($galleries ?? []) as $idx => $gallery) {
        $imgUrl = !empty($gallery->image) ? \Illuminate\Support\Facades\Storage::url($gallery->image) : null;
        if ($imgUrl) {
          $galleryItems[] = [
            'id' => $gallery->id ?? ($idx + 1),
            'url' => $imgUrl,
            'title' => $gallery->title ?? 'InnoElectrica Highlight',
            'number' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
            'tag' => 'IEE MOMENTS',
          ];
        }
      }
    @endphp

    <!-- React Framer Motion Thumbnail Carousel Container -->
    <div id="gallery-carousel-root" data-items="{{ json_encode($galleryItems) }}">
      @if(count($galleryItems) === 0)
        <div class="py-16 px-6 text-center rounded-2xl bg-[#070F2B]/40 border border-white/10 backdrop-blur-md max-w-lg mx-auto">
          <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-blue-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <p class="text-slate-300 font-['Space_Grotesk'] font-medium text-sm">Official event documentation will be updated regularly.</p>
          <p class="text-slate-500 text-xs mt-1">Event highlights will be published by the organizing committee.</p>
        </div>
      @else
        {{-- Initial server-rendered carousel structure for instant visual appearance and graceful degradation --}}
        <div class="w-full max-w-5xl mx-auto px-2 sm:px-4">
          <div class="flex flex-col gap-6">
            <div class="relative overflow-hidden rounded-2xl bg-[#0A122C]/80 border border-white/10 shadow-[0_12px_40px_rgba(0,0,0,0.6)] backdrop-blur-sm">
              <div class="relative w-full h-[320px] sm:h-[420px] md:h-[500px]">
                <img 
                  src="{{ $galleryItems[0]['url'] }}" 
                  alt="{{ $galleryItems[0]['title'] }}" 
                  class="w-full h-full object-cover select-none"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-[#03071E] via-[#03071E]/30 to-transparent"></div>
                <div class="absolute top-4 left-4 font-['JetBrains_Mono'] text-xs font-semibold px-3 py-1 rounded-md bg-[#03071E]/80 border border-white/15 text-cyan-300 backdrop-blur-md shadow-sm">
                  {{ $galleryItems[0]['number'] }}
                </div>
                <div class="absolute bottom-4 left-4 right-4 md:left-6 md:right-6 p-3.5 sm:p-4 rounded-xl bg-[#050B24]/85 border border-white/10 backdrop-blur-md flex items-center justify-between text-white shadow-lg">
                  <h3 class="font-['Space_Grotesk'] font-bold text-sm sm:text-base md:text-lg text-white truncate mr-3">
                    {{ $galleryItems[0]['title'] }}
                  </h3>
                  <span class="font-['JetBrains_Mono'] text-[10px] sm:text-xs font-semibold text-cyan-400 shrink-0 tracking-wider">
                    {{ $galleryItems[0]['tag'] }}
                  </span>
                </div>
                <div class="absolute top-4 right-4 bg-[#03071E]/80 border border-white/15 text-cyan-300 px-3 py-1 rounded-full text-xs font-['JetBrains_Mono'] backdrop-blur-md shadow-sm">
                  1 / {{ count($galleryItems) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

  </div>
</section>

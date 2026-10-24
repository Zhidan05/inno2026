<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnoElectrica EXPO 2026</title>
  
  @include('partials.head-assets')
  @include('home.styles')
</head>

<body class="bg-[#03071E] text-slate-100 antialiased selection:bg-[#FACC15] selection:text-[#03071E] relative">

  @include('partials.ambient-background')
  @include('partials.navbar')

  <main class="relative z-10">
    @include('home.hero', ['eventSetting' => $eventSetting ?? null])
    @include('home.competitions', ['competitions' => $competitions ?? []])
    @include('home.competition-modal')
    @include('home.gallery', ['galleries' => $galleries ?? []])
    @include('home.sponsors', ['sponsors' => $sponsors ?? []])
    @include('home.media-partners', ['mediaPartners' => $mediaPartners ?? []])
    @include('home.about')
  </main>

  @include('partials.footer')
  @include('partials.toast')
  @include('home.scripts')

</body>

</html>
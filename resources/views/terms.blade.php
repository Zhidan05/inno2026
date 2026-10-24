<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terms and Conditions | InnoElectrica EXPO 2026</title>
  
  @include('partials.head-assets')
</head>

<body class="bg-[#03071E] text-slate-100 antialiased selection:bg-[#FACC15] selection:text-[#03071E] relative">

  @include('partials.ambient-background')
  @include('partials.navbar')

  <main class="relative z-10 pt-10 sm:pt-16 pb-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

    <!-- TOP BREADCRUMB & STATUS BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-['JetBrains_Mono'] text-slate-400 hover:text-cyan-400 transition-colors group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Home</span>
      </a>

      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#050B24]/90 border border-cyan-400/30 text-cyan-300 text-[11px] font-['JetBrains_Mono'] backdrop-blur-md self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>VERSION 2026.1 • EFFECTIVE: {{ strtoupper(date('F Y')) }}</span>
      </div>
    </div>

    <!-- PAGE HERO HEADER -->
    <div class="mb-12 border-b border-white/10 pb-8">
      <div class="font-['JetBrains_Mono'] text-xs font-bold uppercase tracking-widest text-[#FACC15] mb-2 flex items-center gap-2">
        <span class="inline-block w-4 h-[2px] bg-[#FACC15]"></span>
        <span>OFFICIAL COMPETITION TERMS</span>
      </div>
      <h1 class="font-['Space_Grotesk'] font-black text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight">
        Terms and Conditions
      </h1>
      <p class="mt-4 text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed">
        Rules, guidelines, intellectual property protocols, and terms of participation governing all entrants of InnoElectrica EXPO 2026.
      </p>

      <!-- Meta Grid Pill -->
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">HOST</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-1">IEEE SB UNRI</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">BINDING LEVEL</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-cyan-300 mt-1">All Registered Teams</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">JUDGMENT</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-[#FACC15] mt-1">Final & Irrevocable</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">EDITION</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-emerald-400 mt-1">InnoElectrica 2026</div>
        </div>
      </div>
    </div>

    <!-- TWO-COLUMN CONTENT WITH STICKY TABLE OF CONTENTS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- STICKY TABLE OF CONTENTS -->
      <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
        <div class="rounded-2xl border border-blue-500/20 bg-[#050B24]/80 backdrop-blur-xl p-5 shadow-xl">
          <div class="font-['Space_Grotesk'] font-bold text-sm text-white mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>
            <span>Table of Contents</span>
          </div>

          <nav class="space-y-1.5 text-xs font-medium">
            <a href="#term-1" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">01</span>
              <span>Introduction & Agreement</span>
            </a>
            <a href="#term-2" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">02</span>
              <span>Competition Regulations</span>
            </a>
            <a href="#term-3" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">03</span>
              <span>User Accounts & Security</span>
            </a>
            <a href="#term-4" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">04</span>
              <span>Intellectual Property</span>
            </a>
            <a href="#term-5" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">05</span>
              <span>Amendments to Terms</span>
            </a>
          </nav>
        </div>

        <!-- Committee Notice Card -->
        <div class="rounded-2xl border border-white/10 bg-[#0A122C]/70 backdrop-blur-xl p-5 text-xs text-slate-300">
          <div class="font-['Space_Grotesk'] font-bold text-sm text-white mb-2">Rules Inquiries</div>
          <p class="text-slate-400 leading-relaxed mb-3">
            Have questions regarding specific competition rulebooks or judging criteria?
          </p>
          <a 
            href="{{ url('/') }}#about" 
            class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 font-['JetBrains_Mono'] font-medium"
          >
            <span>Contact Competition Committee</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
        </div>
      </aside>

      <!-- MAIN LEGAL ARTICLES -->
      <article class="lg:col-span-8 rounded-3xl border border-blue-500/20 bg-[#050B24]/85 backdrop-blur-xl p-6 sm:p-10 shadow-2xl space-y-12">

        <!-- Article 1 -->
        <section id="term-1" class="scroll-mt-28 space-y-4">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              01
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Introduction & Acceptance of Terms
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Welcome to <strong class="text-white">InnoElectrica EXPO 2026</strong>. By registering for our competitions, submitting project documentation, accessing the dashboard portal, or using this platform, you agree to be bound unconditionally by these Terms and Conditions and all associated competition guidebooks.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            If you disagree with any portion of these terms, you must refrain from registering or submitting materials to the competition.
          </p>
        </section>

        <!-- Article 2 -->
        <section id="term-2" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              02
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Competition Rules & Academic Integrity
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Every registered team and individual must abide by the following core competition regulations:
          </p>

          <div class="space-y-3 pt-2">
            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Official Verification</strong>
                All participants must be active students officially registered, paid (if applicable), and verified by the committee prior to technical evaluation.
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Original Work & Anti-Plagiarism</strong>
                Submissions must be original work created specifically by the participant team. Any form of intellectual theft, unauthorized code duplication, or plagiarism results in immediate, irreversible disqualification.
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Finality of Judges' Decision</strong>
                The decisions rendered by the judging panel and IEEE faculty advisory board are final, non-negotiable, and binding in all technical and scoring matters.
              </div>
            </div>
          </div>
        </section>

        <!-- Article 3 -->
        <section id="term-3" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              03
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              User Accounts & Security Responsibility
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Team leaders are solely responsible for preserving the confidentiality of their portal access credentials and for all submission revisions executed under their account session.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            The committee assumes no liability for unauthorized account modifications stemming from compromised passwords on the user's end. Notify our web team immediately if any security breach is suspected.
          </p>
        </section>

        <!-- Article 4 -->
        <section id="term-4" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              04
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Intellectual Property & Exhibition License
            </h2>
          </div>

          <div class="rounded-2xl border border-blue-500/20 bg-blue-950/20 p-5 space-y-3">
            <div class="flex items-center gap-2 text-cyan-300 font-['Space_Grotesk'] font-bold text-sm">
              <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              <span>IP Ownership Retained by Creators</span>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
              Participants retain 100% full intellectual property ownership of their inventions, codebases, hardware designs, and scientific papers.
            </p>
            <p class="text-xs text-slate-400 leading-relaxed border-t border-white/10 pt-2">
              By participating, you grant InnoElectrica EXPO and IEEE Student Branch Universitas Riau a non-exclusive, perpetual, royalty-free license to showcase your project titles, abstracts, demo media, and photographs across official public event exhibitions, press releases, social media, and academic journals.
            </p>
          </div>
        </section>

        <!-- Article 5 -->
        <section id="term-5" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              05
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Modifications to Rules & Guidelines
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            The organizing committee reserves the right to amend competition timetables, submission deadlines, or technical guidelines should force majeure or extraordinary technical circumstances arise.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            All registered participants will receive immediate notifications via verified email and the official dashboard notification center.
          </p>
        </section>

      </article>

    </div>

    <!-- BOTTOM BACK TO HOME CTA -->
    <div class="mt-16 text-center">
      <a 
        href="{{ url('/') }}" 
        class="inline-flex items-center gap-2.5 px-6 py-3 rounded-xl bg-blue-600/20 hover:bg-blue-600/30 border border-cyan-400/30 text-cyan-300 font-['JetBrains_Mono'] text-xs font-semibold uppercase tracking-wider transition-all"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Portal</span>
      </a>
    </div>

  </main>

  @include('partials.footer')

</body>

</html>

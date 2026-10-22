import React, { useState, useEffect, useRef } from 'react';
import { motion } from 'framer-motion';
import SideRays from './SideRays';
import ThumbnailCarousel from './ui/thumbnail-carousel';
import { 
  Terminal, 
  FileText, 
  Bot, 
  Layers, 
  Lightbulb, 
  Cpu, 
  ArrowRight, 
  Mail, 
  Instagram, 
  Phone, 
  MapPin, 
  Building2, 
  ShieldCheck, 
  Radio, 
  Copy, 
  Check, 
  Menu, 
  X,
  ExternalLink,
  Users
} from 'lucide-react';

export function getCategoryLabel(titleOrSlug = '') {
  const query = (titleOrSlug || '').toLowerCase();
  if (query.includes('code') || query.includes('program') || query.includes('algoritma')) {
    return 'Algorithmic Challenge';
  }
  if (query.includes('paper') || query.includes('future') || query.includes('ilmiah') || query.includes('tulis')) {
    return 'Scientific Paper';
  }
  if (query.includes('race') || query.includes('line') || query.includes('robot') || query.includes('follower')) {
    return 'Robotics & Automation';
  }
  if (query.includes('visual') || query.includes('poster') || query.includes('design') || query.includes('desain')) {
    return 'Visual & Infographic';
  }
  return 'Hardware & Innovation';
}

/**
 * Helper: Dynamically maps competition titles or slugs to specialized Lucide icons
 */
export function getCompetitionIcon(titleOrSlug = '') {
  const query = (titleOrSlug || '').toLowerCase();
  if (query.includes('code') || query.includes('program') || query.includes('algoritma')) {
    return <Terminal className="w-6 h-6 text-cyan-400" />;
  }
  if (query.includes('paper') || query.includes('future') || query.includes('ilmiah') || query.includes('tulis')) {
    return <FileText className="w-6 h-6 text-cyan-400" />;
  }
  if (query.includes('race') || query.includes('line') || query.includes('robot') || query.includes('follower')) {
    return <Bot className="w-6 h-6 text-cyan-400" />;
  }
  if (query.includes('visual') || query.includes('poster') || query.includes('design') || query.includes('desain')) {
    return <Layers className="w-6 h-6 text-cyan-400" />;
  }
  return <Lightbulb className="w-6 h-6 text-cyan-400" />;
}

/**
 * InnoElectrica EXPO 2026 Landing Page Component
 * Preserves all dynamic data loops, routing links, props, and states.
 */
export default function LandingPage({
  competitions = [],
  galleries = [],
  sponsors = [],
  mediaPartners = [],
  eventSetting = {},
  user = null,
  routes = {
    login: '/login',
    register: '/register',
    dashboard: '/dashboard',
    privacy: '/privacy',
    terms: '/terms',
    competitionRegister: (slug) => `/dashboard/register/${slug}`
  }
}) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [copiedKey, setCopiedKey] = useState(null);
  const [countdown, setCountdown] = useState({ days: '00', hours: '00', mins: '00', secs: '00' });

  // Handle Spotlight Cursor Card tracking
  const handleMouseMove = (e) => {
    const card = e.currentTarget;
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    card.style.setProperty('--mouse-x', `${x}px`);
    card.style.setProperty('--mouse-y', `${y}px`);
  };

  const handleMouseLeave = (e) => {
    const card = e.currentTarget;
    card.style.setProperty('--mouse-x', `-999px`);
    card.style.setProperty('--mouse-y', `-999px`);
  };

  // Copy to clipboard helper
  const handleCopy = (text, key) => {
    navigator.clipboard.writeText(text);
    setCopiedKey(key);
    setTimeout(() => setCopiedKey(null), 2200);
  };

  // Dynamic Countdown HUD Timer
  useEffect(() => {
    const targetStr = eventSetting?.countdown_target_at;
    if (!targetStr || !eventSetting?.countdown_enabled) return;

    const target = new Date(targetStr).getTime();
    if (isNaN(target)) return;

    const interval = setInterval(() => {
      const diff = target - Date.now();
      if (diff <= 0) {
        setCountdown({ days: '00', hours: '00', mins: '00', secs: '00' });
        clearInterval(interval);
        return;
      }
      const pad = (n) => String(n).padStart(2, '0');
      setCountdown({
        days: pad(Math.floor(diff / (1000 * 60 * 60 * 24))),
        hours: pad(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))),
        mins: pad(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))),
        secs: pad(Math.floor((diff % (1000 * 60)) / 1000))
      });
    }, 1000);

    return () => clearInterval(interval);
  }, [eventSetting]);

  const compCount = competitions.length;

  return (
    <div className="min-h-screen bg-[#03071E] text-slate-100 font-sans antialiased selection:bg-[#FACC15] selection:text-[#03071E] relative overflow-x-hidden">
      
      {/* Blueprint Grid & Ambient Backdrop */}
      <div className="fixed inset-0 pointer-events-none z-0">
        <div className="absolute inset-0 bg-[linear-gradient(to_right,#1e293b1a_1px,transparent_1px),linear-gradient(to_bottom,#1e293b1a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_90%_70%_at_50%_30%,#000_60%,transparent_100%)]" />
        <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[1100px] h-[550px] bg-gradient-to-b from-blue-600/15 via-cyan-500/5 to-transparent blur-[120px] rounded-full" />
        <div className="absolute bottom-0 right-1/4 w-[600px] h-[350px] bg-blue-900/10 blur-[140px] rounded-full" />
      </div>

      {/* FLOATING GLASS NAVBAR */}
      <header className="sticky top-4 z-50 mx-auto max-w-6xl px-4 sm:px-6">
        <nav className="rounded-2xl border border-white/15 bg-slate-900/35 backdrop-blur-xl px-5 py-3.5 flex items-center justify-between shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.1)] relative" style={{ WebkitBackdropFilter: 'blur(20px)', backdropFilter: 'blur(20px)' }}>
          
          {/* Brand Logo */}
          <a href="#home" className="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl">
            <div className="relative">
              <div className="h-9 w-9 rounded-full bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center ring-2 ring-cyan-400/40 group-hover:ring-cyan-400 transition-all shadow-[0_0_15px_rgba(56,189,248,0.3)]">
                <span className="font-brand font-black text-xs text-white">IE</span>
              </div>
            </div>
            <div className="flex flex-col">
              <div className="flex items-center gap-1.5 leading-none">
                <span className="font-['Orbitron'] font-extrabold text-base tracking-wider text-white">IEE</span>
                <span className="font-['Orbitron'] font-black text-base text-[#FACC15]">2026</span>
              </div>
              <span className="font-mono text-[9px] uppercase tracking-widest text-slate-400 group-hover:text-slate-300 transition-colors">
                IEEE SB UNRI
              </span>
            </div>
          </a>

          {/* Navigation Links */}
          <div className="hidden md:flex items-center gap-8">
            <a href="#competitions" className="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
              Competitions
              <span className="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200" />
            </a>
            <a href="#gallery" className="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
              Gallery
              <span className="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200" />
            </a>
            <a href="#about" className="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
              Contact
              <span className="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200" />
            </a>
          </div>

          {/* Right Action Buttons */}
          <div className="hidden sm:flex items-center gap-4">
            {user ? (
              <a
                href={routes.dashboard}
                className="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] shadow-[0_0_20px_rgba(250,204,21,0.25)] hover:shadow-[0_0_25px_rgba(250,204,21,0.4)] active:scale-95 transition-all"
              >
                Dashboard
              </a>
            ) : (
              <>
                <a href={routes.login} className="text-sm font-medium text-slate-300 hover:text-white transition-colors px-3 py-1.5">
                  Login
                </a>
                <a
                  href={routes.register}
                  className="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] shadow-[0_0_20px_rgba(250,204,21,0.25)] hover:shadow-[0_0_25px_rgba(250,204,21,0.4)] active:scale-95 transition-all"
                >
                  Register
                </a>
              </>
            )}
          </div>

          {/* Mobile Menu Toggle Button */}
          <button
            type="button"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className="md:hidden p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 backdrop-blur-md text-slate-300 hover:text-white transition-all focus:outline-none shadow-sm"
            style={{ WebkitBackdropFilter: 'blur(12px)', backdropFilter: 'blur(12px)' }}
            aria-label="Toggle navigation menu"
          >
            {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>

          {/* Mobile Drawer */}
          {mobileMenuOpen && (
            <div className="absolute top-full left-0 right-0 mt-3 p-5 rounded-2xl border border-white/15 bg-slate-950/60 backdrop-blur-2xl shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.08)] flex flex-col gap-4 md:hidden" style={{ WebkitBackdropFilter: 'blur(24px)', backdropFilter: 'blur(24px)' }}>
              <a href="#competitions" onClick={() => setMobileMenuOpen(false)} className="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5">
                Competitions
              </a>
              <a href="#gallery" onClick={() => setMobileMenuOpen(false)} className="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5">
                Gallery
              </a>
              <a href="#about" onClick={() => setMobileMenuOpen(false)} className="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5">
                Contact
              </a>
              <div className="pt-2 flex flex-col gap-2">
                {user ? (
                  <a href={routes.dashboard} className="w-full text-center py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] transition-all">
                    Dashboard
                  </a>
                ) : (
                  <>
                    <a href={routes.login} className="w-full text-center py-2 rounded-xl text-sm font-medium text-slate-200 hover:bg-white/5">
                      Login
                    </a>
                    <a href={routes.register} className="w-full text-center py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#FACC15] text-[#03071E]">
                      Register
                    </a>
                  </>
                )}
              </div>
            </div>
          )}

        </nav>
      </header>

      <main className="relative z-10">

        {/* HERO SECTION */}
        <section id="home" className="relative -mt-20 sm:-mt-24 pt-28 sm:pt-36 pb-20 sm:pb-28 px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center justify-center overflow-hidden">
          
          {/* React Bits SideRays Canvas Background */}
          <div className="absolute inset-0 pointer-events-none overflow-hidden -z-10">
            <SideRays
              rayColor1="#FFC46B"
              rayColor2="#96c8ff"
              origin="top-right"
              speed={2.5}
              intensity={2}
              spread={2}
              density={5}
              followMouse={true}
            />
          </div>

          <div className="max-w-7xl mx-auto w-full flex flex-col items-center">

            {/* 2-Column Responsive Hero Grid (Desktop: Mascot Left, Text Right; Mobile: Centered Mascot Above Text) */}
            <div className="w-full flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-10 lg:gap-12 xl:gap-16">

              {/* MASCOT (Left on Desktop, Top on Mobile) */}
              <div className="relative flex justify-center items-center shrink-0 order-1">
                <style>{`
                  @keyframes mascot-float {
                    0%, 100% {
                      transform: translate3d(0px, 0px, 0) rotate(0deg);
                    }
                    25% {
                      transform: translate3d(6px, -10px, 0) rotate(1.5deg);
                    }
                    50% {
                      transform: translate3d(-4px, -16px, 0) rotate(-1deg);
                    }
                    75% {
                      transform: translate3d(-6px, -6px, 0) rotate(1deg);
                    }
                  }

                  .animate-mascot-float {
                    animation: mascot-float 5s ease-in-out infinite !important;
                    will-change: transform;
                  }
                `}</style>

                {/* Glow Effect behind Mascot */}
                <div className="absolute w-48 h-48 sm:w-60 sm:h-60 md:w-72 md:h-72 lg:w-80 lg:h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none" />

                {/* Floating Mascot Image */}
                <img
                  src="/images/mascot.png"
                  alt="IEE 2026 Mascot"
                  className="relative z-10 w-48 sm:w-60 md:w-72 lg:w-80 xl:w-96 h-auto object-contain drop-shadow-[0_15px_30px_rgba(59,130,246,0.3)] select-none pointer-events-none animate-mascot-float"
                  style={{ animation: 'mascot-float 5s ease-in-out infinite', willChange: 'transform' }}
                  draggable={false}
                />
              </div>

              {/* HERO CONTENT (Right on Desktop, Below Mascot on Mobile) */}
              <div className="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left max-w-2xl xl:max-w-3xl order-2">

                {/* Typography Lockup Headline */}
                <h1 className="font-heading font-black text-4xl sm:text-6xl lg:text-6xl xl:text-7xl tracking-tight leading-[1.05] text-white">
                  InnoElectrica
                  <span className="block mt-1 sm:mt-2 text-3xl sm:text-5xl lg:text-5xl xl:text-6xl font-extrabold">
                    <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-slate-200">EXPO</span>
                    <span className="font-['Orbitron'] text-[#FACC15] ml-2 tracking-wider drop-shadow-[0_0_25px_rgba(250,204,21,0.4)]">2026</span>
                  </span>
                </h1>

                {/* Tagline */}
                <p className="mt-4 sm:mt-5 font-mono font-bold text-xs sm:text-sm tracking-[0.22em] text-[#FACC15]/95 uppercase max-w-2xl">
                  NEXT GEN INNOVATORS: WHERE SCIENCE MEETS THE FUTURE
                </p>

                {/* Subtitle */}
                <p className="mt-4 text-slate-300 text-sm sm:text-base lg:text-lg max-w-xl font-normal leading-relaxed">
                  Push the limits of smart systems, electrical innovation, and technological breakthroughs. The premier university technology competition of 2026.
                </p>

                {/* CTA Buttons */}
                <div className="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center lg:items-start gap-4 w-full sm:w-auto">
                  <a
                    href="#competitions"
                    className="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 font-bold text-sm tracking-wide text-white shadow-[0_0_25px_rgba(37,99,235,0.4)] hover:shadow-[0_0_35px_rgba(56,189,248,0.5)] border border-blue-400/30 flex items-center justify-center gap-2.5 active:scale-95 transition-all"
                  >
                    <span>Explore Competitions</span>
                    <ArrowRight className="w-4 h-4 text-cyan-300" />
                  </a>
                  <a
                    href={user ? routes.dashboard : routes.register}
                    className="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-[#0A122C]/80 hover:bg-[#101c44] border border-blue-500/30 hover:border-blue-400/60 text-slate-200 font-semibold text-sm tracking-wide flex items-center justify-center active:scale-95 transition-all"
                  >
                    {user ? 'Go to Dashboard' : 'Register Now'}
                  </a>
                </div>

                {/* Event Countdown HUD */}
                {eventSetting?.countdown_enabled && (
                  <div className="mt-10 sm:mt-12 w-full max-w-lg">
                    <div className="font-mono text-[11px] tracking-widest text-slate-400 uppercase text-center lg:text-left mb-3 flex items-center justify-center lg:justify-start gap-2">
                      <span className="w-1.5 h-1.5 rounded-full bg-cyan-400" />
                      <span>{eventSetting.countdown_label || 'EVENT COUNTDOWN'}</span>
                    </div>
                    <div className="rounded-2xl border border-blue-500/20 bg-[#0A122C]/75 backdrop-blur-xl p-5 shadow-2xl">
                      <div className="grid grid-cols-4 gap-2 text-center items-center">
                        <div className="flex flex-col items-center">
                          <span className="font-heading font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight">{countdown.days}</span>
                          <span className="font-mono text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Days</span>
                        </div>
                        <div className="flex flex-col items-center">
                          <span className="font-heading font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight">{countdown.hours}</span>
                          <span className="font-mono text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Hours</span>
                        </div>
                        <div className="flex flex-col items-center">
                          <span className="font-heading font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight">{countdown.mins}</span>
                          <span className="font-mono text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Mins</span>
                        </div>
                        <div className="flex flex-col items-center">
                          <span className="font-heading font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight">{countdown.secs}</span>
                          <span className="font-mono text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Secs</span>
                        </div>
                      </div>
                    </div>
                  </div>
                )}

              </div>

            </div>

            {/* Scroll Indicator */}
            <a href="#competitions" className="mt-12 sm:mt-16 inline-flex flex-col items-center gap-2 text-slate-400 hover:text-cyan-400 transition-colors group">
              <span className="font-mono text-[10px] tracking-[0.25em] uppercase text-slate-500 group-hover:text-cyan-400 transition-colors">SCROLL</span>
              <svg className="w-4 h-4 text-cyan-400/80 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
              </svg>
            </a>

          </div>
        </section>

        {/* COMPETITIONS SECTION */}
        <section id="competitions" className="py-24 relative border-t border-blue-500/15 bg-[#050B24]/40">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div className="text-center max-w-3xl mx-auto mb-16">
              <div className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-mono mb-3">
                <span>Competitions & Challenges</span>
              </div>
              <h2 className="text-3xl sm:text-5xl font-heading font-bold text-white tracking-tight">
                Competitions
              </h2>
              <p className="mt-3 text-slate-400 text-sm sm:text-base font-normal">
                Five arenas of innovation. One ultimate challenge.
              </p>
            </div>

            {/* Auto-Centering Symmetrical Bento Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
              {competitions.map((competition, index) => {
                const isOpen = competition.status === 'registration_open';
                const teamMax = competition.max_team_members || 1;
                const teamLabel = teamMax <= 1 ? '1 Member' : `1 - ${teamMax} Members`;
                const feeFormatted = competition.registration_fee > 0 
                  ? `IDR ${Number(competition.registration_fee).toLocaleString('id-ID')}`
                  : 'Free';

                // Responsive symmetric span logic
                let colSpan = 'lg:col-span-2';
                if (compCount === 5) {
                  colSpan = index < 3 ? 'lg:col-span-2' : 'lg:col-span-3';
                } else if (compCount === 4 || compCount === 2) {
                  colSpan = 'lg:col-span-3';
                }

                return (
                  <div
                    key={competition.id || competition.slug || index}
                    onMouseMove={handleMouseMove}
                    onMouseLeave={handleMouseLeave}
                    className={`${colSpan} relative bg-[#070F2B]/70 hover:bg-[#0A1438]/80 backdrop-blur-xl border border-blue-500/20 hover:border-cyan-400/50 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 group hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(37,99,235,0.3)] overflow-hidden`}
                  >
                    {/* Top Card Accent Line */}
                    <div className="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent group-hover:via-cyan-300 transition-all" />

                    <div>
                      <div className="flex items-center justify-between gap-3 mb-5">
                        <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/15 to-cyan-500/10 border border-cyan-400/25 flex items-center justify-center text-cyan-300 group-hover:scale-105 group-hover:border-cyan-300/50 group-hover:shadow-[0_0_20px_rgba(56,189,248,0.25)] transition-all">
                          {getCompetitionIcon(competition.name || competition.slug)}
                        </div>
                        <div className="flex items-center gap-2">
                          {isOpen && (
                            <span className="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wide bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                              OPEN
                            </span>
                          )}
                          <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase bg-blue-950/60 text-cyan-300 border border-cyan-500/25">
                            <Users className="w-3 h-3 text-cyan-400 shrink-0" />
                            <span>{competition.registration_type === 'individual' ? 'SOLO' : 'TEAM'}</span>
                          </span>
                        </div>
                      </div>

                      <div className="space-y-1.5">
                        <span className="font-mono text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase text-cyan-400/90 block">
                          {getCategoryLabel(competition.name || competition.slug)}
                        </span>
                        <h3 className="font-heading font-bold text-xl sm:text-2xl text-white group-hover:text-cyan-300 transition-colors tracking-tight">
                          {competition.name}
                        </h3>
                      </div>
                      <p className="text-xs sm:text-sm text-slate-400 mt-2.5 leading-relaxed line-clamp-3 min-h-[4.2rem]">
                        {competition.description}
                      </p>
                    </div>

                    <div className="mt-6 pt-5 border-t border-white/[0.08]">
                      <div className="grid grid-cols-2 gap-2.5 mb-4">
                        <div className="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                          <span className="font-mono text-[10px] uppercase tracking-wider text-slate-400 font-medium">Team Size</span>
                          <span className="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 truncate">{teamLabel}</span>
                        </div>
                        <div className="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                          <span className="font-mono text-[10px] uppercase tracking-wider text-slate-400 font-medium">Fee</span>
                          <span className="text-xs sm:text-sm font-bold text-[#FACC15] font-heading mt-0.5 truncate">{feeFormatted}</span>
                        </div>
                      </div>

                      {isOpen ? (
                        <a
                          href={routes.competitionRegister(competition.slug)}
                          className="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-heading font-bold text-xs sm:text-sm tracking-wide shadow-[0_4px_16px_rgba(37,99,235,0.3)] hover:shadow-[0_6px_22px_rgba(56,189,248,0.4)] transition-all duration-200 active:scale-[0.98] group/btn"
                        >
                          <span>Register Now</span>
                          <ArrowRight className="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-1" />
                        </a>
                      ) : (
                        <button
                          type="button"
                          disabled
                          className="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/[0.04] text-slate-400 border border-white/10 font-heading font-bold text-xs sm:text-sm tracking-wide cursor-not-allowed opacity-75"
                        >
                          <span>{competition.status === 'completed' ? 'Competition Ended' : 'Registration Closed'}</span>
                        </button>
                      )}
                    </div>
                  </div>
                );
              })}
            </div>

          </div>
        </section>

        {/* GALLERY SECTION */}
        <section id="gallery" className="py-24 relative border-t border-blue-500/15 bg-[#03071E]">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div className="text-center max-w-3xl mx-auto mb-16">
              <div className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-mono mb-3">
                <span>Event Highlights</span>
              </div>
              <h2 className="mt-2 text-3xl sm:text-5xl font-heading font-bold text-white tracking-tight">
                Gallery
              </h2>
              <p className="mt-3 text-slate-400 text-sm sm:text-base font-normal">
                Highlights from past InnoElectrica editions.
              </p>
            </div>

            {/* Thumbnail Carousel Component */}
            <ThumbnailCarousel
              items={galleries.map((gallery, idx) => ({
                id: gallery.id || idx,
                url: gallery.image_url || gallery.image || (gallery.image ? `/storage/${gallery.image}` : ''),
                title: gallery.title || 'InnoElectrica Highlight',
                number: String(idx + 1).padStart(2, '0'),
                tag: 'IEE MOMENTS',
              }))}
            />

          </div>
        </section>

        {/* SECTION 1: SPONSORS (Aceternity Minimalist Style) */}
        <section id="sponsors" className="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
              <h2 className="text-3xl sm:text-4xl md:text-5xl font-heading font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style={{ backgroundImage: 'linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%)', WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
                Trusted by Industry Leaders
              </h2>
              <p className="mt-3 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
                Visionary organizations and partners empowering electrical engineering and technology innovation.
              </p>
            </div>

            <div className="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
              {sponsors && sponsors.length > 0 ? (
                sponsors.map((sponsor, idx) => (
                  <div
                    key={sponsor.id || idx}
                    className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer"
                  >
                    {sponsor.logo ? (
                      <img src={sponsor.logo} alt={sponsor.name || 'Sponsor'} className="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300" />
                    ) : (
                      <div className="w-10 h-10 flex items-center justify-center text-cyan-400 font-bold font-heading text-xl">
                        {sponsor.name ? sponsor.name.charAt(0) : 'S'}
                      </div>
                    )}
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center flex items-center justify-center gap-1.5">
                      {sponsor.name}
                      {sponsor.is_gold && (
                        <span className="text-[9px] font-mono px-1.5 py-0.2 rounded bg-amber-400/10 text-amber-400 border border-amber-400/30 font-semibold tracking-wider uppercase">GOLD</span>
                      )}
                    </span>
                  </div>
                ))
              ) : (
                <>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-cyan-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M12 2L3 12l9 10 9-10L12 2z" />
                      <path strokeLinecap="round" strokeLinejoin="round" d="M8 12c1.5-2 2.5-2 4 0s2.5 2 4 0" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      IEEE Indonesia
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-[#FACC15] group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      PLN Nusantara
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-blue-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <circle cx="12" cy="12" r="9" />
                      <path strokeLinecap="round" d="M12 7v10M8 12l4-5 4 5" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Universitas Riau
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-emerald-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Schneider Tech
                    </span>
                  </div>
                </>
              )}
            </div>

            <div className="mt-10 text-center">
              <a href="mailto:innoelectrica@unri.ac.id?subject=Sponsorship%20Inquiry%20IEE%202026" className="inline-flex items-center gap-1.5 text-xs font-mono text-slate-500 hover:text-cyan-400 transition-colors">
                <span>Interested in empowering future innovators?</span>
                <span className="text-cyan-400 font-medium">Become an Official Sponsor →</span>
              </a>
            </div>
          </div>
        </section>

        {/* SECTION 2: MEDIA PARTNERS (Aceternity Minimalist Style - SEPARATED) */}
        <section id="media-partners" className="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
              <h2 className="text-3xl sm:text-4xl md:text-5xl font-heading font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style={{ backgroundImage: 'linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%)', WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
                Supported by Media Networks
              </h2>
              <p className="mt-3 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
                National press, broadcast channels, and student media networks amplifying IEE 2026 across Indonesia.
              </p>
            </div>

            <div className="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
              {mediaPartners && mediaPartners.length > 0 ? (
                mediaPartners.map((partner, idx) => (
                  <div
                    key={partner.id || idx}
                    className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer"
                  >
                    {partner.logo ? (
                      <img src={partner.logo} alt={partner.name || 'Media Partner'} className="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300" />
                    ) : (
                      <div className="w-10 h-10 flex items-center justify-center text-indigo-400 font-bold font-heading text-xl">
                        {partner.name ? partner.name.charAt(0) : 'M'}
                      </div>
                    )}
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      {partner.name}
                    </span>
                  </div>
                ))
              ) : (
                <>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-sky-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Riau Pos Media
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-indigo-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4-6.2-4.6-6.2 4.6 2.4-7.4L2 9.4h7.6L12 2z" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Kumparan Tech
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-amber-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.343 9.344c5.857-5.858 15.355-5.858 21.213 0" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Antara News
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-pink-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Event Kampus
                    </span>
                  </div>
                  <div className="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
                    <svg className="w-10 h-10 sm:w-11 sm:h-11 text-teal-400 group-hover:scale-105 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M12 2l8 4.5v9l-8 4.5-8-4.5v-9L12 2z" />
                      <path strokeLinecap="round" strokeLinejoin="round" d="M12 12l8-4.5M12 12v9M12 12L4 7.5" />
                    </svg>
                    <span className="font-heading font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                      Tribun Network
                    </span>
                  </div>
                </>
              )}
            </div>

            <div className="mt-10 text-center">
              <a href="mailto:innoelectrica@unri.ac.id?subject=Media%20Partnership%20IEE%202026" className="inline-flex items-center gap-1.5 text-xs font-mono text-slate-500 hover:text-cyan-400 transition-colors">
                <span>Broadcasting student technology & events?</span>
                <span className="text-cyan-400 font-medium">Join as Media Partner →</span>
              </a>
            </div>
          </div>
        </section>

        {/* ABOUT & CONTACT SECTION */}
        <section id="about" className="py-24 relative border-t border-blue-500/15 bg-[#050B24]/50">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div className="text-center max-w-3xl mx-auto mb-16">
              <div className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-mono mb-3">
                <span>Official Center</span>
              </div>
              <h2 className="mt-2 text-3xl sm:text-5xl font-heading font-bold text-white tracking-tight">
                About & Contact
              </h2>
              <p className="mt-3 text-slate-400 text-sm sm:text-base font-normal">
                Everything you need to know about InnoElectrica 26.
              </p>
            </div>

            {/* 3-Column Architectural Information Grid */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">

              {/* Card 1: Contact Us */}
              <div
                onMouseMove={handleMouseMove}
                onMouseLeave={handleMouseLeave}
                className="relative bg-[#0A122C]/75 backdrop-blur-xl border border-blue-500/18 hover:border-cyan-400/50 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all group"
              >
                <div>
                  <div className="flex items-center gap-3 mb-6">
                    <div className="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                      <Mail className="w-5 h-5" />
                    </div>
                    <h3 className="font-heading font-bold text-xl text-white">Contact Us</h3>
                  </div>

                  <div className="space-y-3">
                    {/* Email Row */}
                    <div className="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between">
                      <div className="flex items-center gap-3 truncate mr-2">
                        <span className="text-cyan-400 shrink-0">@</span>
                        <div className="truncate">
                          <div className="font-mono text-[10px] text-slate-400 uppercase">Email</div>
                          <a href="mailto:innoelectrica@unri.ac.id" className="text-xs font-medium text-slate-200 hover:text-cyan-400 transition truncate block">
                            innoelectrica@unri.ac.id
                          </a>
                        </div>
                      </div>
                      <button
                        type="button"
                        onClick={() => handleCopy('innoelectrica@unri.ac.id', 'email')}
                        className="p-1.5 rounded-lg bg-white/5 hover:bg-cyan-400/20 text-slate-400 hover:text-cyan-300 transition shrink-0"
                        title="Copy Email"
                      >
                        {copiedKey === 'email' ? <Check className="w-4 h-4 text-emerald-400" /> : <Copy className="w-4 h-4" />}
                      </button>
                    </div>

                    {/* Instagram Row */}
                    <a
                      href="https://instagram.com/innoelectricaunri"
                      target="_blank"
                      rel="noopener noreferrer"
                      className="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
                    >
                      <div className="flex items-center gap-3">
                        <span className="text-pink-400 shrink-0">#</span>
                        <div>
                          <div className="font-mono text-[10px] text-slate-400 uppercase">Instagram</div>
                          <span className="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">@innoelectricaunri</span>
                        </div>
                      </div>
                      <ExternalLink className="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" />
                    </a>

                    {/* WhatsApp Row */}
                    <a
                      href="https://wa.me/6281234567890"
                      target="_blank"
                      rel="noopener noreferrer"
                      className="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
                    >
                      <div className="flex items-center gap-3">
                        <Phone className="w-4 h-4 text-emerald-400 shrink-0" />
                        <div>
                          <div className="font-mono text-[10px] text-slate-400 uppercase">WhatsApp (Phone)</div>
                          <span className="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">+62 812-3456-7890</span>
                        </div>
                      </div>
                      <ExternalLink className="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" />
                    </a>
                  </div>
                </div>

                <div className="mt-6 pt-4 border-t border-white/10 text-[11px] font-mono text-slate-500">
                  Active response: Mon - Sat 08:00 - 17:00 WIB
                </div>
              </div>

              {/* Card 2: Organizer */}
              <div
                onMouseMove={handleMouseMove}
                onMouseLeave={handleMouseLeave}
                className="relative bg-[#0A122C]/75 backdrop-blur-xl border border-blue-500/18 hover:border-cyan-400/50 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all group"
              >
                <div>
                  <div className="flex items-center gap-3 mb-6">
                    <div className="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                      <Building2 className="w-5 h-5" />
                    </div>
                    <h3 className="font-heading font-bold text-xl text-white">Organizer</h3>
                  </div>

                  <div className="space-y-4">
                    <div>
                      <h4 className="font-heading font-bold text-base text-white">
                        IEEE Student Branch Universitas Riau
                      </h4>
                      <p className="text-xs sm:text-sm text-slate-400 mt-1 leading-relaxed">
                        Faculty of Engineering, Universitas Riau
                      </p>
                    </div>

                    <p className="text-xs text-slate-400/90 leading-relaxed">
                      A professional student engineering community fostering technological breakthroughs, global technical standards, and scientific leadership.
                    </p>
                  </div>
                </div>

                <div className="mt-6 pt-4 border-t border-white/10">
                  <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600/15 border border-cyan-400/30 text-cyan-300 font-mono text-xs font-semibold">
                    <ShieldCheck className="w-4 h-4 text-cyan-400 shrink-0" />
                    <span>Official IEEE Student Branch</span>
                  </div>
                </div>
              </div>

              {/* Card 3: Location */}
              <div
                onMouseMove={handleMouseMove}
                onMouseLeave={handleMouseLeave}
                className="relative bg-[#0A122C]/75 backdrop-blur-xl border border-blue-500/18 hover:border-cyan-400/50 rounded-2xl p-6 sm:p-7 flex flex-col justify-between transition-all group"
              >
                <div>
                  <div className="flex items-center gap-3 mb-6">
                    <div className="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                      <MapPin className="w-5 h-5" />
                    </div>
                    <h3 className="font-heading font-bold text-xl text-white">Location</h3>
                  </div>

                  <div>
                    <h4 className="font-heading font-bold text-base text-white">
                      Fakultas Teknik Universitas Riau
                    </h4>
                    <p className="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                      Kampus Bina Widya, Jl. HR. Soebrantas KM. 12.5, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293
                    </p>
                  </div>
                </div>

                <div className="mt-6 pt-4 border-t border-white/10">
                  <div className="rounded-xl bg-[#03071E]/80 border border-blue-500/20 p-3.5 flex items-center justify-between">
                    <div>
                      <div className="font-mono text-[10px] uppercase tracking-wider text-slate-400">EVENT FORMAT</div>
                      <div className="font-heading font-bold text-xs text-white mt-0.5">Hybrid (Online & Offline)</div>
                    </div>
                    <span className="w-2.5 h-2.5 rounded-full bg-cyan-400 shadow-[0_0_8px_#38BDF8]" />
                  </div>
                </div>
              </div>

            </div>

          </div>
        </section>

      </main>

      {/* FOOTER */}
      <footer className="border-t border-white/10 bg-[#03071E] relative z-10 py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
          <div className="flex items-center gap-3">
            <div className="h-8 w-8 rounded-full bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center ring-1 ring-cyan-400/40">
              <span className="font-brand font-black text-[10px] text-white">IE</span>
            </div>
            <div className="flex flex-col">
              <div className="flex items-center gap-1.5 font-heading font-bold text-sm text-white">
                <span>InnoElectrica EXPO</span>
                <span className="text-[#FACC15] font-['Orbitron']">2026</span>
              </div>
              <span className="text-[11px] text-slate-400">
                &copy; 2026 IEEE Student Branch Universitas Riau. All rights reserved.
              </span>
            </div>
          </div>

          <div className="flex items-center gap-6 text-xs font-mono text-slate-400">
            <a href={routes.privacy} className="hover:text-cyan-400 transition-colors">Privacy Policy</a>
            <a href={routes.terms} className="hover:text-cyan-400 transition-colors">Terms of Service</a>
            <a href="#about" className="hover:text-cyan-400 transition-colors">Contact Support</a>
          </div>
        </div>
      </footer>

    </div>
  );
}

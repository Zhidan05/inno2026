"use client";

import React, { useEffect, useId, useRef, useState } from "react";
import { AnimatePresence, motion } from "motion/react";
import { useOutsideClick } from "@/hooks/use-outside-click";
import { Users, Calendar, Trophy, FileText, ArrowRight, X } from "lucide-react";

export interface CompetitionCardItem {
  id?: string | number;
  name: string;
  slug: string;
  category: string;
  description: string;
  team: string;
  fee: string;
  status?: string;
  badge?: string;
  banner?: string;
  timeline?: { phase: string; date: string }[];
  rules?: string[];
  prizes?: string;
}

const defaultCompetitions: CompetitionCardItem[] = [
  {
    name: "InnoExpo Competition",
    slug: "innoexpo",
    category: "Hardware & Innovation",
    badge: "TEAM",
    status: "registration_open",
    description: "Ajang unjuk kreativitas dan inovasi yang memberikan kesempatan kepada peserta untuk menampilkan karya cipta dan prototipe teknologi tepat guna berbasis elektro, IoT, dan otomasi cerdas.",
    team: "1 - 6 Members",
    fee: "IDR 170.000",
    banner: "/images/gallery/innoexpo.jpg",
    timeline: [
      { phase: "Gelombang Pendaftaran", date: "1 Januari - 28 Februari 2026" },
      { phase: "Pengumpulan Proposal & Video Karya", date: "1 - 10 Maret 2026" },
      { phase: "Pengumuman Finalis Expo", date: "18 Maret 2026" },
      { phase: "Exhibition & Grand Final Presentation", date: "25 Maret 2026" }
    ],
    rules: [
      "Peserta merupakan mahasiswa/i aktif D3/D4/S1 perguruan tinggi se-Indonesia.",
      "Karya berupa prototipe perangkat keras (hardware), sistem embedded, atau integrasi IoT terapan.",
      "Prototipe harus orisinal dan belum pernah menjuarai kompetisi tingkat nasional serupa.",
      "Maksimal 6 anggota per tim didampingi 1 dosen pembimbing (opsional)."
    ],
    prizes: "Total Hadiah Belasan Juta Rupiah + Piala Bergilir + Sertifikat Nasional IEEE"
  },
  {
    name: "InnoCode Competition",
    slug: "innocode",
    category: "Algorithmic Challenge",
    badge: "SOLO / TEAM",
    status: "registration_open",
    description: "Kompetisi pemrograman kompetitif yang menguji ketajaman logika, kecepatan berpikir komputasional, serta optimasi efisiensi algoritma dalam memecahkan permasalahan teknikal kompleks.",
    team: "1 - 2 Members",
    fee: "IDR 120.000",
    banner: "/images/gallery/innocode.jpg",
    timeline: [
      { phase: "Pendaftaran Online", date: "1 Januari - 1 Maret 2026" },
      { phase: "Warm-Up Session", date: "5 Maret 2026" },
      { phase: "Preliminary Online Contest", date: "10 Maret 2026" },
      { phase: "Final Onsite Competitive Arena", date: "24 Maret 2026" }
    ],
    rules: [
      "Terbuka untuk mahasiswa dan siswa SMA/SMK sederajat aktif.",
      "Bahasa yang diperbolehkan: C++, Java, Python 3, Go.",
      "Penilaian berdasarkan jumlah problem solve dan execution runtime penalty.",
      "Dilarang keras menggunakan AI completion tools atau komunikasi eksternal saat contest aktif."
    ],
    prizes: "Total Hadiah Jutaan Rupiah + Medali Kejuaraan + Sertifikat IEEE SB UNRI"
  },
  {
    name: "InnoFuture Paper Competition",
    slug: "innofuture-paper",
    category: "Scientific Paper",
    badge: "SOLO / TEAM",
    status: "registration_open",
    description: "Kompetisi Karya Tulis Ilmiah tingkat nasional yang menantang akademisi muda untuk memaparkan gagasan kritis, riset empiris, dan rekayasa sains mutakhir menuju transisi energi berkelanjutan.",
    team: "1 - 3 Members",
    fee: "IDR 100.000",
    banner: "/images/gallery/innopaper.jpg",
    timeline: [
      { phase: "Pengumpulan Abstrak Gratis", date: "1 Januari - 15 Februari 2026" },
      { phase: "Pengumuman Lolos Abstrak", date: "20 Februari 2026" },
      { phase: "Pengumpulan Full Paper", date: "21 Februari - 12 Maret 2026" },
      { phase: "Presentasi Karya Finalis", date: "24 Maret 2026" }
    ],
    rules: [
      "Format paper mengikuti template standar IEEE Conference Manuscript Style.",
      "Maksimal 3 orang per tim dengan 1 orang sebagai ketua tim.",
      "Tingkat plagiarisme / Turnitin similarity maksimal 20% tanpa filter.",
      "Karya belum pernah dipublikasikan di jurnal atau prosiding ber-ISBN/ISSN."
    ],
    prizes: "Trofi Juara + Uang Pembinaan + Publikasi Prosiding Terindeks"
  },
  {
    name: "InnoRace Line Follower",
    slug: "innorace-line-follower",
    category: "Robotics & Automation",
    badge: "TEAM",
    status: "registration_open",
    description: "Kompetisi balap robot line follower otomatis mikrokontroler berkecepatan tinggi yang dituntut bermanuver presisi melintasi rintangan lintasan rumit, perempatan, dan tanjakan tajam.",
    team: "1 - 5 Members",
    fee: "IDR 170.000",
    banner: "/images/gallery/line_follower.jpg",
    timeline: [
      { phase: "Registrasi Peserta", date: "1 Januari - 5 Maret 2026" },
      { phase: "Technical Meeting & Track Reveal", date: "15 Maret 2026" },
      { phase: "Uji Coba Lintasan (Free Practice)", date: "23 Maret 2026" },
      { phase: "Race Day & Grand Final", date: "25 Maret 2026" }
    ],
    rules: [
      "Robot beroperasi otomatis mandiri tanpa remote control selama race berlangsung.",
      "Dimensi robot maksimal 20 cm x 20 cm dengan berat maksimal 1000 gram.",
      "Tegangan baterai maksimal 12.6V (3S LiPo).",
      "Sistem pertandingan menggunakan babak kualifikasi waktu dan eliminasi Head-to-Head."
    ],
    prizes: "Piala Bergilir IEEE + Hadiah Tunai + Golden Ticket Eksibisi"
  },
  {
    name: "InnoVisual Poster Competition",
    slug: "innovisual-poster",
    category: "Visual & Infographic",
    badge: "SOLO / TEAM",
    status: "registration_open",
    description: "Kompetisi desain poster ilmiah dan infografis teknologi yang memadukan estetika visual mutakhir, kedalaman data sains, dan kemampuan storytelling visual yang komunikatif.",
    team: "1 Member",
    fee: "IDR 70.000",
    banner: "/images/gallery/innovisual.jpg",
    timeline: [
      { phase: "Pendaftaran & Karya", date: "1 Januari - 10 Maret 2026" },
      { phase: "Voting Poster Favorit Online", date: "12 - 20 Maret 2026" },
      { phase: "Penjurian Kurator Desain", date: "22 Maret 2026" },
      { phase: "Pengumuman Pemenang", date: "26 Maret 2026" }
    ],
    rules: [
      "Karya dibuat dalam format digital A3 (portrait), 300 DPI, format PDF dan PNG.",
      "Karya orisinal dan tidak mengandung unsur SARA atau hak cipta pihak ketiga tanpa izin.",
      "Desain mengedepankan keterbacaan data, hierarki informasi, dan estetika visual futuristik."
    ],
    prizes: "Uang Tunai + E-Certificate Prestasi Nasional + Pameran Galeri Virtual"
  }
];

export default function ExpandableCompetitionCardGrid({
  competitions = defaultCompetitions,
  registerRoute = "/register"
}: {
  competitions?: CompetitionCardItem[];
  registerRoute?: string;
}) {
  const [active, setActive] = useState<CompetitionCardItem | null>(null);
  const id = useId();
  const ref = useRef<HTMLDivElement>(null);

  useEffect(() => {
    function onKeyDown(event: KeyboardEvent) {
      if (event.key === "Escape") {
        setActive(null);
      }
    }

    if (active) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "auto";
    }

    window.addEventListener("keydown", onKeyDown);
    return () => {
      window.removeEventListener("keydown", onKeyDown);
      document.body.style.overflow = "auto";
    };
  }, [active]);

  useOutsideClick(ref, () => setActive(null));

  return (
    <>
      {/* Backdrop Overlay */}
      <AnimatePresence>
        {active && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 bg-[#03071E]/80 backdrop-blur-md h-full w-full z-50 pointer-events-auto"
          />
        )}
      </AnimatePresence>

      {/* Expanded Modal View */}
      <AnimatePresence>
        {active ? (
          <div className="fixed inset-0 grid place-items-center z-50 p-4 sm:p-6 overflow-y-auto">
            {/* Close button for mobile and desktop */}
            <motion.button
              key={`close-${active.slug}-${id}`}
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0, scale: 0.8 }}
              onClick={() => setActive(null)}
              className="fixed top-5 right-5 sm:top-8 sm:right-8 z-[60] flex items-center justify-center bg-slate-900/90 text-slate-300 hover:text-white border border-white/20 rounded-full h-10 w-10 backdrop-blur-md hover:bg-slate-800 transition-colors shadow-2xl"
              aria-label="Close details"
            >
              <X className="w-5 h-5" />
            </motion.button>

            <motion.div
              layoutId={`card-${active.slug}-${id}`}
              ref={ref}
              className="w-full max-w-2xl bg-[#070F2B]/95 border border-cyan-500/30 rounded-3xl overflow-hidden shadow-[0_25px_60px_-15px_rgba(37,99,235,0.4)] flex flex-col max-h-[90vh] my-auto backdrop-blur-2xl"
            >
              {/* Header Visual Image Banner */}
              {active.banner && (
                <motion.div 
                  layoutId={`image-${active.slug}-${id}`}
                  className="relative h-48 sm:h-56 w-full overflow-hidden bg-slate-900"
                >
                  <img
                    src={active.banner}
                    alt={active.name}
                    className="w-full h-full object-cover object-center brightness-90 hover:scale-105 transition-transform duration-700"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-[#070F2B] via-[#070F2B]/40 to-transparent" />
                  
                  {/* Category & Status Overlay on Banner */}
                  <div className="absolute top-4 left-4 flex items-center gap-2">
                    <span className="px-3 py-1 rounded-full text-xs font-semibold bg-[#03071E]/80 text-cyan-300 border border-cyan-400/30 backdrop-blur-md">
                      {active.category}
                    </span>
                    <span className="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 backdrop-blur-md">
                      OPEN
                    </span>
                  </div>
                </motion.div>
              )}

              {/* Modal Body Content */}
              <div className="p-6 sm:p-8 flex-1 overflow-y-auto space-y-6">
                <div>
                  <motion.h2
                    layoutId={`title-${active.slug}-${id}`}
                    className="font-['Space_Grotesk'] font-bold text-2xl sm:text-3xl text-white tracking-tight"
                  >
                    {active.name}
                  </motion.h2>
                  <motion.p
                    layoutId={`desc-${active.slug}-${id}`}
                    className="text-slate-300 text-sm sm:text-base mt-2.5 leading-relaxed"
                  >
                    {active.description}
                  </motion.p>
                </div>

                {/* Key Metadata Stats */}
                <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
                  <div className="rounded-xl bg-white/[0.04] border border-white/[0.08] p-3">
                    <span className="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">
                      Team Format
                    </span>
                    <span className="text-sm font-semibold text-white mt-0.5 flex items-center gap-1.5">
                      <Users className="w-3.5 h-3.5 text-cyan-400" />
                      {active.team}
                    </span>
                  </div>

                  <div className="rounded-xl bg-white/[0.04] border border-white/[0.08] p-3">
                    <span className="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">
                      Registration Fee
                    </span>
                    <span className="text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 block">
                      {active.fee}
                    </span>
                  </div>

                  <div className="rounded-xl bg-white/[0.04] border border-white/[0.08] p-3 col-span-2 sm:col-span-1">
                    <span className="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">
                      Level & Format
                    </span>
                    <span className="text-sm font-semibold text-slate-200 mt-0.5 block">
                      {active.badge} • National
                    </span>
                  </div>
                </div>

                {/* Timeline Section */}
                {active.timeline && active.timeline.length > 0 && (
                  <div className="space-y-3 pt-2">
                    <h4 className="text-xs font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold flex items-center gap-2">
                      <Calendar className="w-4 h-4" />
                      <span>Schedule & Timeline</span>
                    </h4>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                      {active.timeline.map((item, idx) => (
                        <div key={idx} className="rounded-xl bg-white/[0.02] border border-white/[0.05] p-3 flex flex-col">
                          <span className="text-xs text-slate-400 font-medium">{item.phase}</span>
                          <span className="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5">{item.date}</span>
                        </div>
                      ))}
                    </div>
                  </div>
                )}

                {/* Rules & Requirements */}
                {active.rules && active.rules.length > 0 && (
                  <div className="space-y-3 pt-2">
                    <h4 className="text-xs font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold flex items-center gap-2">
                      <FileText className="w-4 h-4" />
                      <span>Rules & Requirements</span>
                    </h4>
                    <ul className="space-y-2 text-xs sm:text-sm text-slate-300">
                      {active.rules.map((rule, idx) => (
                        <li key={idx} className="flex items-start gap-2.5">
                          <span className="w-1.5 h-1.5 rounded-full bg-cyan-400 mt-1.5 shrink-0" />
                          <span>{rule}</span>
                        </li>
                      ))}
                    </ul>
                  </div>
                )}

                {/* Prize Pool */}
                {active.prizes && (
                  <div className="rounded-xl bg-gradient-to-r from-blue-900/30 via-cyan-900/20 to-transparent border border-cyan-400/20 p-4 flex items-center gap-3">
                    <Trophy className="w-6 h-6 text-[#FACC15] shrink-0" />
                    <div className="text-xs sm:text-sm text-slate-200">
                      <span className="font-bold text-[#FACC15] block">Prizes & Awards</span>
                      {active.prizes}
                    </div>
                  </div>
                )}
              </div>

              {/* Modal Footer Actions */}
              <div className="p-5 sm:p-6 bg-slate-950/60 border-t border-white/[0.08] flex flex-col sm:flex-row items-center justify-end gap-3">
                <button
                  type="button"
                  onClick={() => setActive(null)}
                  className="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-white/10 hover:border-white/30 text-xs sm:text-sm text-slate-300 hover:text-white transition-colors"
                >
                  Close
                </button>
                <a
                  href={`/dashboard/register/${active.slug}`}
                  className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-['Space_Grotesk'] font-bold text-xs sm:text-sm shadow-[0_4px_20px_rgba(37,99,235,0.4)] transition-all"
                >
                  <span>Register Now</span>
                  <ArrowRight className="w-4 h-4" />
                </a>
              </div>
            </motion.div>
          </div>
        ) : null}
      </AnimatePresence>

      {/* Grid List of Competitions */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
        {competitions.length === 0 ? (
          <div className="col-span-full py-16 px-6 text-center rounded-3xl bg-[#070F2B]/50 border border-white/10 backdrop-blur-xl">
            <Trophy className="w-10 h-10 mx-auto text-cyan-400 mb-3 opacity-60" />
            <h3 className="font-['Space_Grotesk'] font-bold text-xl text-white mb-2">No Competitions Available</h3>
            <p className="text-slate-400 text-sm max-w-md mx-auto">
              Competitions are currently being prepared by the committee. Please check back periodically.
            </p>
          </div>
        ) : (
          competitions.map((competition, index) => {
            let colSpan = "lg:col-span-2";
            if (competitions.length === 5) {
              colSpan = index < 3 ? "lg:col-span-2" : "lg:col-span-3";
            } else if (competitions.length === 4 || competitions.length === 2) {
              colSpan = "lg:col-span-3";
            }

          return (
            <motion.div
              layoutId={`card-${competition.slug}-${id}`}
              key={competition.slug || index}
              onClick={() => setActive(competition)}
              className={`${colSpan} relative rounded-2xl p-6 sm:p-7 flex flex-col justify-between group overflow-hidden transition-all duration-300 hover:-translate-y-1.5 cursor-pointer bg-[#070F2B]/75 hover:bg-[#0A1438]/90 border border-blue-500/20 hover:border-cyan-400/50 backdrop-blur-xl shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_20px_40px_-15px_rgba(37,99,235,0.35)]`}
            >
              <div className="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent group-hover:via-cyan-300 transition-all" />

              <div>
                <div className="flex items-center justify-between gap-3 mb-5">
                  <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/15 to-cyan-500/10 border border-cyan-400/25 flex items-center justify-center text-cyan-300 group-hover:scale-105 group-hover:border-cyan-300/50 group-hover:shadow-[0_0_20px_rgba(56,189,248,0.25)] transition-all">
                    <Trophy className="w-6 h-6 text-cyan-400" />
                  </div>
                  <div className="flex items-center gap-2">
                    <span className="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wide bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                      OPEN
                    </span>
                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase bg-blue-950/60 text-cyan-300 border border-cyan-500/25">
                      <Users className="w-3 h-3 text-cyan-400 shrink-0" />
                      <span>{competition.badge || "TEAM"}</span>
                    </span>
                  </div>
                </div>

                <div className="space-y-1.5">
                  <span className="font-['JetBrains_Mono'] text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase text-cyan-400/90 block">
                    {competition.category}
                  </span>
                  <motion.h3
                    layoutId={`title-${competition.slug}-${id}`}
                    className="font-['Space_Grotesk'] font-bold text-xl sm:text-2xl text-white group-hover:text-cyan-300 transition-colors tracking-tight"
                  >
                    {competition.name}
                  </motion.h3>
                </div>
                <motion.p
                  layoutId={`desc-${competition.slug}-${id}`}
                  className="text-xs sm:text-sm text-slate-400 mt-2.5 leading-relaxed line-clamp-3 min-h-[4.2rem]"
                >
                  {competition.description}
                </motion.p>
              </div>

              <div className="mt-6 pt-5 border-t border-white/[0.08]">
                <div className="grid grid-cols-2 gap-2.5 mb-4">
                  <div className="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                    <span className="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Team Size</span>
                    <span className="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 truncate">{competition.team}</span>
                  </div>
                  <div className="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                    <span className="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Fee</span>
                    <span className="text-xs sm:text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 truncate">{competition.fee}</span>
                  </div>
                </div>

                <div className="flex items-center gap-2">
                  <button
                    type="button"
                    onClick={(e) => {
                      e.stopPropagation();
                      setActive(competition);
                    }}
                    className="flex-1 py-2.5 px-3 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 hover:text-white border border-white/10 font-semibold text-xs transition-colors text-center"
                  >
                    View Details
                  </button>
                  <a
                    href={`/dashboard/register/${competition.slug}`}
                    onClick={(e) => e.stopPropagation()}
                    className="flex-1 py-2.5 px-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-['Space_Grotesk'] font-bold text-xs text-center shadow-[0_4px_16px_rgba(37,99,235,0.3)] transition-all flex items-center justify-center gap-1.5"
                  >
                    <span>Register</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                  </a>
                </div>
              </div>
            </motion.div>
          );
        })
      )}
    </div>
    </>
  );
}

export { ExpandableCompetitionCardGrid as ExpandableCardDemo };


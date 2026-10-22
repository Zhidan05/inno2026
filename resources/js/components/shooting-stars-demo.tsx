"use client";
import React from "react";
import { ShootingStars } from "@/components/ui/shooting-stars";
import { StarsBackground } from "@/components/ui/stars-background";

export default function ShootingStarsDemo() {
  return (
    <div className="h-[40rem] rounded-2xl bg-[#03071E] flex flex-col items-center justify-center relative w-full overflow-hidden">
      <h2 className="relative z-10 text-4xl md:text-7xl font-black text-center tracking-tight text-white font-['Space_Grotesk']">
        <span>InnoElectrica EXPO 2026</span>
      </h2>
      <p className="relative z-10 text-[#FACC15] font-mono text-xs md:text-sm uppercase tracking-[0.22em] mt-4 font-semibold">
        NEXT GEN INNOVATORS: WHERE SCIENCE MEETS THE FUTURE
      </p>
      <ShootingStars starColor="#38BDF8" trailColor="#2563EB" />
      <StarsBackground />
    </div>
  );
}

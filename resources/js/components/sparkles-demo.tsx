"use client";
import React from "react";
import { SparklesCore } from "@/components/ui/sparkles";

export default function SparklesPreview() {
  return (
    <div className="h-[40rem] w-full bg-[#03071E] flex flex-col items-center justify-center overflow-hidden rounded-2xl relative">
      <h1 className="md:text-7xl text-4xl lg:text-8xl font-black text-center text-white relative z-20 font-['Space_Grotesk'] tracking-tight">
        InnoElectrica
      </h1>
      <div className="w-[40rem] max-w-full h-40 relative">
        {/* Gradients */}
        <div className="absolute inset-x-20 top-0 bg-gradient-to-r from-transparent via-blue-500 to-transparent h-[2px] w-3/4 blur-sm" />
        <div className="absolute inset-x-20 top-0 bg-gradient-to-r from-transparent via-blue-500 to-transparent h-px w-3/4" />
        <div className="absolute inset-x-60 top-0 bg-gradient-to-r from-transparent via-cyan-400 to-transparent h-[5px] w-1/4 blur-sm" />
        <div className="absolute inset-x-60 top-0 bg-gradient-to-r from-transparent via-cyan-400 to-transparent h-px w-1/4" />

        {/* Core component */}
        <SparklesCore
          background="transparent"
          minSize={0.4}
          maxSize={1.2}
          particleDensity={1000}
          className="w-full h-full"
          particleColor="#38BDF8"
        />

        {/* Radial Gradient to prevent sharp edges */}
        <div className="absolute inset-0 w-full h-full bg-[#03071E] [mask-image:radial-gradient(350px_200px_at_top,transparent_20%,white)]"></div>
      </div>
    </div>
  );
}

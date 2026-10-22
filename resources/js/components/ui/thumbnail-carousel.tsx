import { useEffect, useRef, useState } from 'react';
import { motion, useMotionValue, animate, PanInfo } from 'framer-motion';

const FULL_WIDTH_PX = 120;
const COLLAPSED_WIDTH_PX = 42;
const GAP_PX = 8;
const MARGIN_PX = 4;

export interface GalleryItem {
  id: number | string;
  url: string;
  title: string;
  number?: string;
  tag?: string;
}

export interface ThumbnailsProps {
  items: GalleryItem[];
  index: number;
  setIndex: (index: number) => void;
}

export function Thumbnails({ items, index, setIndex }: ThumbnailsProps) {
  const thumbnailsRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (thumbnailsRef.current) {
      let scrollPosition = 0;
      for (let i = 0; i < index; i++) {
        scrollPosition += COLLAPSED_WIDTH_PX + GAP_PX;
      }

      scrollPosition += MARGIN_PX;

      const containerWidth = thumbnailsRef.current.offsetWidth;
      const centerOffset = containerWidth / 2 - FULL_WIDTH_PX / 2;
      scrollPosition -= centerOffset;

      thumbnailsRef.current.scrollTo({
        left: scrollPosition,
        behavior: 'smooth',
      });
    }
  }, [index]);

  return (
    <div
      ref={thumbnailsRef}
      className="overflow-x-auto mx-auto max-w-full px-2 py-1 scroll-smooth"
      style={{ scrollbarWidth: 'none', msOverflowStyle: 'none' }}
    >
      <style>{`
        .overflow-x-auto::-webkit-scrollbar {
          display: none;
        }
      `}</style>
      <div className="flex gap-2 h-20 items-center justify-center mx-auto" style={{ width: 'fit-content' }}>
        {items.map((item, i) => (
          <motion.button
            key={item.id}
            type="button"
            onClick={() => setIndex(i)}
            initial={false}
            animate={i === index ? 'active' : 'inactive'}
            variants={{
              active: {
                width: FULL_WIDTH_PX,
                marginLeft: MARGIN_PX,
                marginRight: MARGIN_PX,
              },
              inactive: {
                width: COLLAPSED_WIDTH_PX,
                marginLeft: 0,
                marginRight: 0,
              },
            }}
            transition={{ duration: 0.35, ease: [0.16, 1, 0.3, 1] }}
            className={`relative shrink-0 h-16 md:h-20 overflow-hidden rounded-xl border transition-all duration-300 focus:outline-none ${
              i === index
                ? 'border-cyan-400 ring-2 ring-cyan-400/40 shadow-[0_0_15px_rgba(56,189,248,0.35)] opacity-100 scale-105'
                : 'border-white/10 opacity-40 hover:opacity-85 hover:border-white/25'
            }`}
          >
            <img
              src={item.url}
              alt={item.title}
              className="w-full h-full object-cover pointer-events-none select-none"
              draggable={false}
            />
            {i === index && (
              <div className="absolute inset-0 bg-gradient-to-t from-cyan-950/40 to-transparent pointer-events-none" />
            )}
          </motion.button>
        ))}
      </div>
    </div>
  );
}

export interface ThumbnailCarouselProps {
  items: GalleryItem[];
}

export default function ThumbnailCarousel({ items = [] }: ThumbnailCarouselProps) {
  const [index, setIndex] = useState<number>(0);
  const [isDragging, setIsDragging] = useState<boolean>(false);
  const containerRef = useRef<HTMLDivElement>(null);

  const x = useMotionValue(0);

  useEffect(() => {
    if (!isDragging && containerRef.current) {
      const containerWidth = containerRef.current.offsetWidth || 1;
      const targetX = -index * containerWidth;

      animate(x, targetX, {
        type: 'spring',
        stiffness: 300,
        damping: 32,
      });
    }
  }, [index, x, isDragging]);

  if (!items || items.length === 0) {
    return (
      <div className="py-16 px-6 text-center rounded-2xl bg-[#070F2B]/40 border border-white/10 backdrop-blur-md max-w-lg mx-auto">
        <div className="w-12 h-12 mx-auto mb-3 rounded-xl bg-blue-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <p className="text-slate-300 font-['Space_Grotesk'] font-medium text-sm">
          Official event documentation will be updated regularly.
        </p>
      </div>
    );
  }

  return (
    <div className="w-full max-w-5xl mx-auto px-2 sm:px-4">
      <div className="flex flex-col gap-6">
        {/* Main Carousel Window */}
        <div
          className="relative overflow-hidden rounded-2xl bg-[#0A122C]/80 border border-white/10 shadow-[0_12px_40px_rgba(0,0,0,0.6)] backdrop-blur-sm select-none"
          ref={containerRef}
        >
          <motion.div
            className="flex cursor-grab active:cursor-grabbing"
            drag="x"
            dragElastic={0.15}
            dragMomentum={false}
            onDragStart={() => setIsDragging(true)}
            onDragEnd={(_e: MouseEvent | TouchEvent | PointerEvent, info: PanInfo) => {
              setIsDragging(false);
              const containerWidth = containerRef.current?.offsetWidth || 1;
              const offset = info.offset.x;
              const velocity = info.velocity.x;

              let newIndex = index;

              if (Math.abs(velocity) > 400) {
                newIndex = velocity > 0 ? index - 1 : index + 1;
              } else if (Math.abs(offset) > containerWidth * 0.25) {
                newIndex = offset > 0 ? index - 1 : index + 1;
              }

              newIndex = Math.max(0, Math.min(items.length - 1, newIndex));
              setIndex(newIndex);
            }}
            style={{ x }}
          >
            {items.map((item, idx) => {
              const formattedNumber = item.number || String(idx + 1).padStart(2, '0');
              const tagText = item.tag || 'IEE MOMENTS';

              return (
                <div key={item.id || idx} className="relative shrink-0 w-full h-[320px] sm:h-[420px] md:h-[500px]">
                  <img
                    src={item.url}
                    alt={item.title}
                    className="w-full h-full object-cover select-none pointer-events-none"
                    draggable={false}
                  />

                  {/* Gradient Vignette */}
                  <div className="absolute inset-0 bg-gradient-to-t from-[#03071E] via-[#03071E]/30 to-transparent pointer-events-none" />

                  {/* Monospace Index Badge */}
                  <div className="absolute top-4 left-4 font-['JetBrains_Mono'] text-xs font-semibold px-3 py-1 rounded-md bg-[#03071E]/80 border border-white/15 text-cyan-300 backdrop-blur-md shadow-sm">
                    {formattedNumber}
                  </div>

                  {/* Glassmorphic Caption Bar */}
                  <div className="absolute bottom-4 left-4 right-4 md:left-6 md:right-6 p-3.5 sm:p-4 rounded-xl bg-[#050B24]/85 border border-white/10 backdrop-blur-md flex items-center justify-between text-white pointer-events-none shadow-lg">
                    <h3 className="font-['Space_Grotesk'] font-bold text-sm sm:text-base md:text-lg text-white truncate mr-3">
                      {item.title}
                    </h3>
                    <span className="font-['JetBrains_Mono'] text-[10px] sm:text-xs font-semibold text-cyan-400 shrink-0 tracking-wider">
                      {tagText}
                    </span>
                  </div>
                </div>
              );
            })}
          </motion.div>

          {/* Previous Button */}
          <button
            type="button"
            disabled={index === 0}
            onClick={() => setIndex((i) => Math.max(0, i - 1))}
            aria-label="Previous slide"
            className={`absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center border border-white/15 backdrop-blur-md transition-all duration-200 z-10 focus:outline-none ${
              index === 0
                ? 'opacity-20 cursor-not-allowed bg-[#050B24]/40 text-slate-500'
                : 'bg-[#050B24]/80 text-cyan-300 hover:text-white hover:bg-[#0A122C] hover:scale-110 active:scale-95 shadow-[0_0_15px_rgba(56,189,248,0.25)]'
            }`}
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          {/* Next Button */}
          <button
            type="button"
            disabled={index === items.length - 1}
            onClick={() => setIndex((i) => Math.min(items.length - 1, i + 1))}
            aria-label="Next slide"
            className={`absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center border border-white/15 backdrop-blur-md transition-all duration-200 z-10 focus:outline-none ${
              index === items.length - 1
                ? 'opacity-20 cursor-not-allowed bg-[#050B24]/40 text-slate-500'
                : 'bg-[#050B24]/80 text-cyan-300 hover:text-white hover:bg-[#0A122C] hover:scale-110 active:scale-95 shadow-[0_0_15px_rgba(56,189,248,0.25)]'
            }`}
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </button>

          {/* Image Counter Badge */}
          <div className="absolute top-4 right-4 bg-[#03071E]/80 border border-white/15 text-cyan-300 px-3 py-1 rounded-full text-xs font-['JetBrains_Mono'] backdrop-blur-md shadow-sm">
            {index + 1} / {items.length}
          </div>
        </div>

        {/* Thumbnail Strip */}
        <Thumbnails index={index} items={items} setIndex={setIndex} />
      </div>
    </div>
  );
}

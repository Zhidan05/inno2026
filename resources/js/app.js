import Alpine from 'alpinejs';
import React from 'react';
import { createRoot } from 'react-dom/client';
import ThumbnailCarousel from './components/ui/thumbnail-carousel';

window.Alpine = Alpine;
Alpine.start();

// Mount Thumbnail Carousel in Gallery section if present
const galleryRoot = document.getElementById('gallery-carousel-root');
if (galleryRoot) {
  try {
    const rawData = galleryRoot.getAttribute('data-items');
    const items = rawData ? JSON.parse(rawData) : [];
    const root = createRoot(galleryRoot);
    root.render(React.createElement(ThumbnailCarousel, { items }));
  } catch (err) {
    console.error('Failed to mount ThumbnailCarousel:', err);
  }
}

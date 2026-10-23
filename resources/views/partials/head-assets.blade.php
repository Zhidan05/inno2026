<!-- Fonts: Space Grotesk (Headings), Plus Jakarta Sans & Inter (Body), JetBrains Mono (Tech Metadata), Orbitron (Accent/Brand) -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Orbitron:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
  rel="stylesheet" />

<!-- Vite Scripts for React / Thumbnail Carousel and Frontend Assets -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Tailwind CSS Play CDN for instant, guaranteed zero-runtime-error styling -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          midnight: '#03071E',
          abyss: '#050B24',
          cyber: {
            cyan: '#38BDF8',
            blue: '#2563EB',
            cobalt: '#1D4ED8',
            amber: '#FACC15',
            gold: '#F59E0B',
          }
        },
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', '"Inter"', 'sans-serif'],
          heading: ['"Space Grotesk"', 'sans-serif'],
          display: ['"Space Grotesk"', 'sans-serif'],
          brand: ['"Orbitron"', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'monospace'],
        }
      }
    }
  }
</script>

<style>
  /* Architectural Blueprint & Spotlight System Tokens */
  :root {
    --bg-abyss: #03071E;
    --card-navy: rgba(10, 18, 44, 0.72);
    --border-tech: rgba(59, 130, 246, 0.18);
    --accent-blue: #2563EB;
    --accent-cyan: #38BDF8;
    --accent-amber: #FACC15;
  }

  body {
    background-color: var(--bg-abyss);
    color: #F8FAFC;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    overflow-x: hidden;
    min-height: 100vh;
  }

  /* 1px Engineering Blueprint Grid with radial decay */
  .blueprint-grid {
    background-size: 48px 48px;
    background-image: 
      linear-gradient(to right, rgba(56, 189, 248, 0.04) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(56, 189, 248, 0.04) 1px, transparent 1px);
    mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
    -webkit-mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
  }

  /* Glowing Accents */
  .glow-amber-btn {
    box-shadow: 0 0 25px -4px rgba(250, 204, 21, 0.35);
  }
  .glow-amber-btn:hover {
    box-shadow: 0 0 35px -2px rgba(250, 204, 21, 0.55);
  }

  .glow-blue-btn {
    box-shadow: 0 0 25px -4px rgba(37, 99, 235, 0.4);
  }
  .glow-blue-btn:hover {
    box-shadow: 0 0 35px -2px rgba(56, 189, 248, 0.55);
  }

  /* Custom Scrollbar */
  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: #03071E;
  }
  ::-webkit-scrollbar-thumb {
    background: #1E293B;
    border-radius: 9999px;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #334155;
  }
</style>

<style>
  /* Linear / Raycast Style Spotlight Card Effect */
  .spotlight-card {
    position: relative;
    background: var(--card-navy);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--border-tech);
    border-radius: 1rem;
    transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
  }

  .spotlight-card:hover {
    border-color: rgba(56, 189, 248, 0.45);
    box-shadow: 0 10px 30px -10px rgba(37, 99, 235, 0.2);
  }

  .spotlight-card::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: inherit;
    padding: 1px;
    background: radial-gradient(400px circle at var(--mouse-x, -999px) var(--mouse-y, -999px), rgba(56, 189, 248, 0.5), transparent 60%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 2;
  }

  .spotlight-card:hover::before {
    opacity: 1;
  }

  .spotlight-card::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: radial-gradient(500px circle at var(--mouse-x, -999px) var(--mouse-y, -999px), rgba(37, 99, 235, 0.08), transparent 70%);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
  }

  .spotlight-card:hover::after {
    opacity: 1;
  }

  /* SideRays (React Bits) WebGL Styles */
  .side-rays {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
  }
  .side-rays__canvas {
    position: absolute;
    inset: 0;
    display: block;
    width: 100%;
    height: 100%;
  }

  /* Mascot Floating & Entrance Animations */
  @keyframes mascotEntrance {
    from {
      opacity: 0;
      transform: translateX(-30px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  .animate-mascot-entrance {
    animation: mascotEntrance 0.8s ease-out forwards;
  }

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
</style>

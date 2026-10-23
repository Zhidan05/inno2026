<style>
  :root {
    --bg-primary: #050816;
    --bg-secondary: #0a0f24;
    --bg-tertiary: #0f172a;
    --surface: rgba(15, 23, 42, 0.50);
    --surface-elevated: rgba(15, 23, 42, 0.70);
    --border-subtle: rgba(255, 255, 255, 0.08);
    --border-default: rgba(255, 255, 255, 0.12);
  }
  body {
    background-color: #050816 !important;
    color: #f8fafc;
  }
  .details-block {
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 2rem;
    background: rgba(15, 23, 42, 0.50);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
  }
  .det-header {
    background: rgba(255, 255, 255, 0.03);
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  }
  .det-header h2 {
    font-family: var(--font-display);
    font-size: 1.3rem;
    color: #38bdf8;
  }
  .det-body {
    padding: 1.75rem;
  }
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .info-item {
    background: rgba(2, 6, 23, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.10);
    padding: 1.25rem;
    border-radius: 12px;
  }
  .info-label {
    color: #94a3b8;
    font-size: 0.85rem;
    margin-bottom: 0.35rem;
    display: block;
  }
  .info-value {
    color: #f8fafc;
    font-weight: 600;
    font-size: 1.05rem;
  }
  .btn-secondary {
    background: rgba(255, 255, 255, 0.06);
    color: #94a3b8;
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-family: var(--font-body);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
  }
  .btn-secondary:hover {
    border-color: rgba(255, 255, 255, 0.3);
    color: #ffffff;
    background: rgba(255, 255, 255, 0.12);
  }
</style>

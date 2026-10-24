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
    background: #050816 !important;
    color: #f8fafc;
  }
  .comp-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  .available-comp-card {
    background: rgba(15, 23, 42, 0.50);
    border: 1px solid rgba(255, 255, 255, 0.10);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 1.5rem;
    border-radius: 16px;
    text-align: left;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
  }
  .available-comp-card:hover {
    border-color: rgba(56, 189, 248, 0.4);
    background: rgba(15, 23, 42, 0.70);
  }
  .available-comp-card h4 {
    color: #f8fafc;
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 1.15rem;
    margin-bottom: 0.25rem;
  }
  .available-comp-card .desc {
    color: #94a3b8;
    font-size: 0.85rem;
    margin-bottom: 1.25rem;
    line-height: 1.5;
    flex-grow: 1;
  }
  .available-comp-card .meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 0.8rem;
    color: #64748b;
  }
  .available-comp-card .meta div {
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
  .dash-action-row {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    margin-top: auto;
  }
  .btn-dash-primary {
    background: #2563eb;
    color: #fff;
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 600;
    height: 42px;
    padding: 0 1.25rem;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
    border: none;
    flex: 1;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }
  .btn-dash-primary:hover:not(:disabled) {
    background: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
  }
  .btn-dash-secondary {
    background: rgba(255, 255, 255, 0.05);
    color: #94a3b8;
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 500;
    height: 42px;
    padding: 0 1.25rem;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.2s;
    border: 1px solid rgba(255, 255, 255, 0.12);
  }
  .btn-dash-secondary:hover {
    border-color: rgba(255, 255, 255, 0.3);
    color: #f8fafc;
    background: rgba(255, 255, 255, 0.1);
  }
  @media (max-width: 640px) {
    .dash-action-row {
      flex-direction: column;
    }
    .dash-action-row .btn-dash-secondary, 
    .dash-action-row .btn-dash-primary {
      width: 100%;
    }
  }
  .registration-block {
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 2rem;
    background: rgba(15, 23, 42, 0.40);
  }
  .reg-header {
    background: rgba(255, 255, 255, 0.03);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .reg-header h2 {
    font-family: var(--font-display);
    font-size: 1.2rem;
    color: #38bdf8;
  }
  .reg-body {
    padding: 1.5rem;
  }
  .reg-body .dash-grid {
    margin-top: 0;
  }
</style>

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
  .registration-block {
    border: 1px solid var(--border-subtle);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 2rem;
    background: rgba(0,0,0,0.1);
  }
  .reg-header {
    background: rgba(255,255,255,0.02);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-subtle);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .reg-header h2 {
    font-family: var(--font-display);
    font-size: 1.2rem;
    color: var(--accent-blue-light);
  }
  .reg-body {
    padding: 1.5rem;
  }
  .form-section-title {
    font-family: var(--font-display);
    color: var(--accent-blue-light);
    margin-bottom: 1rem;
    font-size: 1.05rem;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    padding-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .radio-group {
    display: flex;
    gap: 1rem;
  }
  .radio-option {
    flex: 1;
    background: var(--surface);
    border: 1px solid var(--border-default);
    border-radius: 8px;
    padding: 1rem;
    cursor: pointer;
    transition: 0.3s;
    text-align: center;
  }
  .radio-option:hover {
    border-color: var(--accent-blue);
  }
  .radio-option input[type="radio"] {
    display: none;
  }
  .radio-option input[type="radio"]:checked + .radio-label {
    color: var(--accent-yellow);
    font-weight: bold;
  }
  .radio-option:has(input[type="radio"]:checked) {
    border-color: var(--accent-yellow);
    background: rgba(255, 194, 9, 0.1);
  }
  .radio-label {
    color: var(--text-secondary);
    font-family: var(--font-display);
    display: block;
    pointer-events: none;
  }
  .member-block {
    background: rgba(255,255,255,0.02);
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
    border-left: 3px solid var(--accent-blue);
  }
  .remove-member-btn {
    background: rgba(255, 77, 77, 0.1);
    color: #ff4d4d;
    border: 1px solid rgba(255, 77, 77, 0.3);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    cursor: pointer;
    margin-top: 0.5rem;
    transition: background-color 0.2s;
  }
  .remove-member-btn:hover {
    background: rgba(255, 77, 77, 0.2);
  }
  .add-member-btn {
    background: transparent;
    color: var(--accent-blue-light);
    border: 1px dashed var(--accent-blue);
    padding: 0.75rem;
    width: 100%;
    border-radius: 6px;
    cursor: pointer;
    font-family: var(--font-display);
    transition: 0.3s;
  }
  .add-member-btn:hover {
    background: rgba(63, 128, 239, 0.1);
  }
  .btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-default);
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-family: var(--font-display);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
  }
  .btn-secondary:hover {
    border-color: var(--text-primary);
    color: var(--text-primary);
  }
  .form-input {
    background: var(--surface);
    border: 1px solid var(--border-default);
    color: var(--text-primary);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    width: 100%;
    transition: border-color 0.2s;
  }
  .form-input:focus {
    border-color: var(--accent-blue);
    outline: none;
  }
  .form-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: block;
  }
  .file-upload-wrapper {
    border: 1px dashed var(--border-default);
    padding: 1.5rem;
    border-radius: 8px;
    background: rgba(255,255,255,0.02);
    text-align: center;
    transition: border-color 0.3s;
  }
  .file-upload-wrapper:hover {
    border-color: var(--accent-blue);
  }
  .hidden {
    display: none !important;
  }
</style>

@props(['competition', 'paymentMethods' => null])

@php
    $paymentMethods = $paymentMethods ?? \App\Models\PaymentMethod::active()->get();
@endphp

<!-- PAYMENT PROOF & PAYMENT METHODS -->
@if($competition->requiresPayment())
<div class="dash-card" style="margin-bottom: 1.5rem;">
  <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Payment Method & Proof</h4>

  <!-- Fee Highlight Banner -->
  <div style="background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px; padding: 1rem; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <div>
      <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--accent-blue-light); font-weight: 600;">Total Registration Fee</div>
      <div style="font-size: 1.35rem; font-weight: 700; color: #ffffff; font-family: var(--font-display);">
        IDR {{ number_format($competition->registration_fee, 0, ',', '.') }}
      </div>
    </div>
    <div style="font-size: 0.8rem; color: #94a3b8; background: rgba(15, 23, 42, 0.6); padding: 0.35rem 0.75rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
      <i class="fi fi-rr-clock" style="margin-right: 0.25rem;"></i> Manual Confirmation within 1 × 24 Hours
    </div>
  </div>

  <!-- Important Payment Information Notice -->
  <div class="payment-notice-card" style="background: rgba(245, 158, 11, 0.08); border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 1.25rem; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; color: #f59e0b; font-weight: 700; font-size: 0.95rem;">
      <i class="fi fi-rr-info" style="font-size: 1.1rem;"></i>
      <span>Important Payment Information</span>
    </div>
    <div style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.6;">
      <p style="margin-bottom: 0.6rem;">
        The available QRIS and bank transfer payment methods are static payment methods. Payments are not verified automatically and require manual confirmation by the administrator.
      </p>
      <p style="margin-bottom: 0.6rem;">
        After completing the payment, please wait for the verification and confirmation process from the admin. If your payment has not been confirmed within <strong style="color: #ffffff;">1 × 24 hours</strong>, participants are welcome to contact the committee contact person (CP) for assistance.
      </p>
      <p style="margin-bottom: 0.75rem;">
        Please ensure payment is made according to the specified amount and instructions provided by the committee. Retain your proof of payment as a reference if required during the confirmation process.
      </p>
      <div style="border-top: 1px solid rgba(245, 158, 11, 0.2); padding-top: 0.6rem; display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.8rem; color: #94a3b8;">
        <span><strong style="color: #cbd5e1;">Official Contact Person:</strong></span>
        <a href="mailto:inno-ieee.sb@unri.ac.id" style="color: var(--accent-blue-light); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
          <i class="fi fi-rr-envelope"></i> inno-ieee.sb@unri.ac.id
        </a>
        <a href="https://instagram.com/innoelectricaunri" target="_blank" rel="noopener noreferrer" style="color: var(--accent-blue-light); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
          <i class="fi fi-rr-camera"></i> @innoelectricaunri
        </a>
      </div>
    </div>
  </div>

  <!-- Active Payment Methods Selection -->
  <div style="margin-bottom: 1.5rem;">
    <label class="form-label" style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--text-primary);">
      Select Payment Method
    </label>

    @if($paymentMethods->isEmpty())
      <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 1rem; color: #fca5a5; font-size: 0.85rem;">
        <i class="fi fi-rr-exclamation" style="margin-right: 0.5rem;"></i>
        No active payment methods have been configured by the admin yet. Please contact the committee via email <strong>inno-ieee.sb@unri.ac.id</strong> for payment details.
      </div>
    @else
      <div class="payment-methods-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
        @foreach($paymentMethods as $index => $method)
          <div class="payment-method-card {{ $index === 0 ? 'active' : '' }}" 
               onclick="selectPaymentMethod({{ $method->id }})"
               id="payment-card-{{ $method->id }}"
               style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 1.25rem; cursor: pointer; transition: all 0.2s ease; position: relative;">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
              <div style="display: flex; align-items: center; gap: 0.6rem;">
                <input type="radio" 
                       name="payment_method_id" 
                       value="{{ $method->id }}" 
                       id="method-radio-{{ $method->id }}"
                       {{ (old('payment_method_id') == $method->id || ($loop->first && !old('payment_method_id'))) ? 'checked' : '' }}
                       style="accent-color: var(--accent-blue-light); width: 1.1rem; height: 1.1rem; cursor: pointer;">
                <span style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">{{ $method->name }}</span>
              </div>
              <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 0.2rem 0.5rem; border-radius: 4px; {{ $method->isQris() ? 'background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);' : 'background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);' }}">
                {{ $method->isQris() ? 'QRIS' : 'Bank Transfer' }}
              </span>
            </div>

            @if($method->isQris())
              <!-- QRIS Content -->
              <div style="margin-top: 0.75rem; text-align: center; background: rgba(0, 0, 0, 0.25); border-radius: 8px; padding: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                @if($method->qris_image)
                  <div style="display: inline-block; background: #ffffff; padding: 8px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); max-width: 220px;">
                    <img src="{{ Storage::disk('public')->url($method->qris_image) }}" 
                         alt="{{ $method->name }}" 
                         style="width: 100%; height: auto; display: block; border-radius: 4px; image-rendering: -webkit-optimize-contrast;">
                  </div>
                  <div style="margin-top: 0.75rem;">
                    <a href="{{ Storage::disk('public')->url($method->qris_image) }}" 
                       target="_blank" 
                       download="QRIS-InnoElectrica.webp"
                       onclick="event.stopPropagation();"
                       style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; color: var(--accent-blue-light); text-decoration: none; padding: 0.3rem 0.6rem; border-radius: 4px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.25);">
                      <i class="fi fi-rr-download"></i> Download / Enlarge QRIS
                    </a>
                  </div>
                @else
                  <div style="color: #94a3b8; font-size: 0.8rem; padding: 1.5rem 0;">QRIS code image is being prepared by the committee.</div>
                @endif
                <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 0.75rem; line-height: 1.4;">
                  Scan the QR code using any payment application supporting QRIS (BCA Mobile, Livin' by Mandiri, GoPay, OVO, Dana, ShopeePay, etc.).
                </p>
              </div>
            @else
              <!-- Bank Transfer Content -->
              <div style="margin-top: 0.75rem; background: rgba(0, 0, 0, 0.25); border-radius: 8px; padding: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;">
                  <span style="font-size: 0.8rem; color: #94a3b8;">Bank</span>
                  <span style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">{{ $method->bank_name }}</span>
                </div>
                
                <div style="margin-bottom: 0.5rem;">
                  <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-bottom: 0.2rem;">Account Number</span>
                  <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 0.5rem 0.75rem;">
                    <span id="acc-text-{{ $method->id }}" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; font-weight: 700; color: var(--accent-gold, #fbbf24); letter-spacing: 0.05em;">
                      {{ $method->account_number }}
                    </span>
                    <button type="button" 
                            onclick="copyAccountNumber('{{ $method->account_number }}', this, event)"
                            class="copy-btn-inline"
                            title="Copy Account Number"
                            style="background: rgba(255, 255, 255, 0.08); hover:background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.15); border-radius: 5px; color: #ffffff; padding: 0.3rem 0.6rem; font-size: 0.75rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                      <i class="fi fi-rr-copy"></i> <span>Copy</span>
                    </button>
                  </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; margin-top: 0.5rem;">
                  <span style="color: #94a3b8;">Account Holder (A/N)</span>
                  <span style="color: #e2e8f0; font-weight: 600;">{{ $method->account_holder_name }}</span>
                </div>
              </div>
            @endif

            @if(!empty($method->instructions))
              <div style="margin-top: 0.75rem; font-size: 0.78rem; color: #94a3b8; background: rgba(255,255,255,0.02); padding: 0.5rem 0.75rem; border-radius: 6px; border-left: 2px solid var(--accent-blue-light);">
                <strong>Instructions:</strong> {{ $method->instructions }}
              </div>
            @endif

          </div>
        @endforeach
      </div>
    @endif
  </div>

  <!-- Upload Payment Receipt Form -->
  <div class="form-group" style="margin-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem;">
    <label class="form-label" for="proof_of_payment" style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; display: block;">
      Upload Payment Proof / Transfer Receipt <span style="color: #ef4444;">*</span>
    </label>
    <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.75rem;">
      Upload a screenshot of the transfer receipt or bank mutation document. Supported formats: <strong>PDF, JPG, PNG, WEBP</strong> (Max 10 MB). Images are automatically optimized.
    </p>
    <div class="file-upload-wrapper" style="border: 2px dashed rgba(255,255,255,0.15); border-radius: 8px; padding: 1.5rem; text-align: center; background: rgba(0,0,0,0.15); transition: border-color 0.2s;">
      <i class="fi fi-rr-upload" style="font-size: 2rem; color: var(--accent-blue-light); display: block; margin-bottom: 0.5rem;"></i>
      <input id="proof_of_payment" 
             name="proof_of_payment" 
             type="file" 
             accept=".pdf,.jpg,.jpeg,.png,.webp" 
             required 
             style="color: var(--text-secondary); width: 100%; max-width: 320px; margin: 0 auto; display: block; cursor: pointer;">
    </div>
  </div>
</div>

<script>
  function selectPaymentMethod(id) {
    const radio = document.getElementById('method-radio-' + id);
    if (radio) {
      radio.checked = true;
    }
    document.querySelectorAll('.payment-method-card').forEach(card => {
      card.style.borderColor = 'rgba(255, 255, 255, 0.1)';
      card.style.background = 'rgba(15, 23, 42, 0.6)';
    });
    const activeCard = document.getElementById('payment-card-' + id);
    if (activeCard) {
      activeCard.style.borderColor = 'var(--accent-blue-light, #38bdf8)';
      activeCard.style.background = 'rgba(15, 23, 42, 0.9)';
    }
  }

  function copyAccountNumber(text, btn, event) {
    if (event) {
      event.stopPropagation();
    }
    navigator.clipboard.writeText(text).then(function() {
      const originalHtml = btn.innerHTML;
      btn.innerHTML = '<i class="fi fi-rr-check"></i> <span style="color: #10b981;">Copied!</span>';
      btn.style.borderColor = '#10b981';
      setTimeout(function() {
        btn.innerHTML = originalHtml;
        btn.style.borderColor = 'rgba(255,255,255,0.15)';
      }, 2000);
    }).catch(function(err) {
      // Fallback for older browsers
      const textarea = document.createElement('textarea');
      textarea.value = text;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
      btn.innerHTML = '<i class="fi fi-rr-check"></i> <span style="color: #10b981;">Copied!</span>';
      setTimeout(function() {
        btn.innerHTML = '<i class="fi fi-rr-copy"></i> <span>Copy</span>';
      }, 2000);
    });
  }

  // Initial highlight on load
  document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[name="payment_method_id"]:checked');
    if (checkedRadio) {
      selectPaymentMethod(checkedRadio.value);
    }
  });
</script>
@else
<div class="dash-card" style="margin-bottom: 1.5rem;">
  <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Registration Fee</h4>
  <div class="member-block" style="border-left-color: #10b981; margin-bottom: 0;">
    <div style="font-weight: 600; color: #10b981; margin-bottom: 0.25rem;">FREE</div>
    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
      This competition is free of charge. No proof of payment is required to proceed with registration.
    </p>
  </div>
</div>
@endif

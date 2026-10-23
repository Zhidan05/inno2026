@props(['competition'])

<!-- PAYMENT PROOF -->
@if($competition->requiresPayment())
<div class="dash-card" style="margin-bottom: 1.5rem;">
  <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Payment Proof</h4>
  
  <div class="member-block" style="border-left-color: var(--accent-gold); margin-bottom: 1.5rem;">
    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Payment Instructions</div>
    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
      Please transfer <strong>IDR {{ number_format($competition->registration_fee, 0, ',', '.') }}</strong> to:<br>
      <strong style="color: var(--accent-gold);">Bank XYZ - 123456789 (Account Name: InnoElectrica)</strong><br>
      Upload the transfer receipt below to complete your registration.
    </p>
  </div>
  
  <div class="form-group">
    <label class="form-label" for="proof_of_payment">Upload Receipt</label>
    <div class="file-upload-wrapper">
      <p style="font-size: 0.85rem; color: var(--text-tertiary); margin-bottom: 1rem;">PDF, JPG, PNG — Max 2 MB</p>
      <input id="proof_of_payment" name="proof_of_payment" type="file" accept=".pdf,.jpg,.jpeg,.png" required style="color: var(--text-secondary); width: 100%; max-width: 300px; margin: 0 auto; display: block;">
    </div>
  </div>
</div>
@else
<div class="dash-card" style="margin-bottom: 1.5rem;">
  <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Registration Fee</h4>
  <div class="member-block" style="border-left-color: #10b981; margin-bottom: 0;">
    <div style="font-weight: 600; color: #10b981; margin-bottom: 0.25rem;">FREE</div>
    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
      No proof of payment is required for this competition.
    </p>
  </div>
</div>
@endif

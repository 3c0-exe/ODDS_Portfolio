@props(['settings' => null])

@php
    $settings = $settings ?? \App\Models\OddsSetting::current();
    $contactEmail = !empty($settings->cta_email) ? $settings->cta_email : 'oddsdevph@gmail.com';
@endphp

<!-- ODDS Global Contact Modal -->
<div id="odds-contact-modal" class="odds-modal-overlay" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
    <div class="odds-modal-backdrop" id="odds-modal-backdrop"></div>
    
    <div class="odds-modal-container">
        <div class="odds-modal-window">
            
            <!-- macOS Window Header -->
            <div class="odds-modal-header">
                <div class="odds-modal-dots">
                    <span class="odds-dot odds-dot-red" id="odds-modal-close-btn" title="Close modal"></span>
                    <span class="odds-dot odds-dot-yellow"></span>
                    <span class="odds-dot odds-dot-green"></span>
                </div>
                <div class="odds-modal-title-bar">
                    <span class="odds-modal-term-prompt">client\ODDS_Studio></span>
                    <span class="odds-modal-term-cmd">open_channel --priority=high</span>
                </div>
                <button type="button" class="odds-modal-close-x" id="odds-modal-close-x" aria-label="Close modal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="odds-modal-body">
                
                <!-- Normal Form State -->
                <div id="contact-form-wrapper">
                    <div class="odds-modal-intro">
                        <div class="odds-modal-badge">
                            <span class="odds-pulse-indicator"></span>
                            <span>Direct Studio Channel</span>
                        </div>
                        <h3 class="odds-modal-headline" id="contact-modal-title">Let's Build Something Real.</h3>
                        <p class="odds-modal-subtext">
                            Tell us what you're aiming to solve. Expect a direct response with technical scope and next steps within 24 hours.
                        </p>
                    </div>

                    <form id="odds-contact-form" class="odds-contact-form" novalidate>
                        @csrf
                        <div id="contact-form-error" class="odds-form-alert odds-form-alert-error" style="display: none;"></div>

                        <div class="odds-form-grid">
                            <div class="odds-form-group">
                                <label for="contact-name" class="odds-form-label">
                                    Your Name <span class="text-purple-400">*</span>
                                </label>
                                <input type="text" id="contact-name" name="name" required class="odds-form-input" placeholder="e.g. Alex Vance">
                            </div>

                            <div class="odds-form-group">
                                <label for="contact-email" class="odds-form-label">
                                    Email Address <span class="text-purple-400">*</span>
                                </label>
                                <input type="email" id="contact-email" name="email" required class="odds-form-input" placeholder="alex@company.com" autocomplete="email">
                                <span id="contact-email-hint" class="odds-form-hint" style="display: none;"></span>
                            </div>
                        </div>

                        <div class="odds-form-grid">
                            <div class="odds-form-group">
                                <label for="contact-company" class="odds-form-label">Company / Organization</label>
                                <input type="text" id="contact-company" name="company" class="odds-form-input" placeholder="e.g. Acme Corp (Optional)">
                            </div>

                            <div class="odds-form-group">
                                <label for="contact-service" class="odds-form-label">Service Needed</label>
                                <div class="odds-select-wrapper">
                                    <select id="contact-service" name="service_needed" class="odds-form-select">
                                        <option value="" selected>Select primary focus...</option>
                                        <option value="Software Development">Software Development (Custom Systems)</option>
                                        <option value="Web Development">Web Development (Apps & Portals)</option>
                                        <option value="Mobile Applications">Mobile Applications (iOS / Android)</option>
                                        <option value="Backend & DevOps">Backend & Cloud Infrastructure</option>
                                        <option value="IoT Systems">IoT, Embedded Firmware & Hardware</option>
                                        <option value="General Inquiry">Technical Advisory & Consultation</option>
                                    </select>
                                    <svg class="odds-select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="odds-form-group">
                            <label for="contact-message" class="odds-form-label">
                                Project Brief or Requirements <span class="text-purple-400">*</span>
                            </label>
                            <textarea id="contact-message" name="message" rows="4" required class="odds-form-textarea" placeholder="Tell us about what you want built, your timeline, or any architectural bottlenecks you're currently facing..."></textarea>
                        </div>

                        <div class="odds-form-actions">
                            <button type="submit" id="contact-submit-btn" class="odds-form-submit-btn">
                                <span class="odds-btn-text">Send Transmission</span>
                                <svg class="odds-btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                                <span class="odds-btn-spinner" style="display: none;">
                                    <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                </span>
                            </button>

                            <div class="odds-direct-contact">
                                <span>Prefer direct email?</span>
                                <button type="button" class="odds-copy-email-btn" id="odds-copy-email-btn" data-email="{{ $contactEmail }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                    <span id="copy-email-label">{{ $contactEmail }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Success Confirmation State -->
                <div id="contact-success-wrapper" class="odds-modal-success" style="display: none;">
                    <div class="odds-success-icon-ring">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="odds-success-kicker">TRANSMISSION CONFIRMED</div>
                    <h3 class="odds-success-title">We Received Your Message.</h3>
                    <p class="odds-success-desc">
                        Your project brief has been logged directly into our active dispatch queue. An ODDS technical lead will review your details and respond via email within <strong>24 hours</strong>.
                    </p>
                    <button type="button" class="odds-success-close-btn" id="odds-success-close-btn">
                        Return to Portfolio
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* ─── ODDS CONTACT MODAL STYLES ─── */
.odds-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    box-sizing: border-box;
    overflow-y: auto;
}

.odds-modal-overlay.is-active {
    display: flex;
    animation: oddsModalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.odds-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(8, 11, 20, 0.78);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    transition: opacity 0.25s ease;
}

.odds-modal-container {
    position: relative;
    width: 100%;
    max-width: 660px;
    z-index: 2;
    margin: auto;
}

.odds-modal-window {
    background: #0f1422;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 18px;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 40px -10px rgba(112, 57, 236, 0.25);
    overflow: hidden;
    color: #f1f5f9;
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    transform: translateY(12px) scale(0.98);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.odds-modal-overlay.is-active .odds-modal-window {
    transform: translateY(0) scale(1);
}

/* Header */
.odds-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #090d16;
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}

.odds-modal-dots {
    display: flex;
    align-items: center;
    gap: 7px;
}

.odds-dot {
    width: 11px;
    height: 11px;
    border-radius: 50%;
    display: inline-block;
}

.odds-dot-red { background: #ef4444; cursor: pointer; }
.odds-dot-red:hover { filter: brightness(1.2); }
.odds-dot-yellow { background: #f59e0b; }
.odds-dot-green { background: #10b981; }

.odds-modal-title-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    color: #64748b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.odds-modal-term-prompt { color: #875af5; font-weight: 600; }
.odds-modal-term-cmd { color: #94a3b8; }

.odds-modal-close-x {
    background: transparent;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s, background-color 0.2s;
}

.odds-modal-close-x:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
}

/* Body */
.odds-modal-body {
    padding: 2rem 2.25rem;
}

.odds-modal-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 12px;
    background: rgba(112, 57, 236, 0.14);
    border: 1px solid rgba(135, 90, 245, 0.3);
    border-radius: 9999px;
    font-size: 0.68rem;
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    letter-spacing: 0.05em;
    color: #c4b5fd;
    margin-bottom: 0.85rem;
    text-transform: uppercase;
}

.odds-pulse-indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 8px #10b981;
    animation: pulse 2s infinite;
}

.odds-modal-headline {
    font-size: 1.55rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin: 0 0 0.45rem 0;
    line-height: 1.25;
}

.odds-modal-subtext {
    font-size: 0.85rem;
    color: #94a3b8;
    line-height: 1.5;
    margin: 0 0 1.5rem 0;
}

/* Form inputs */
.odds-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.odds-form-group {
    margin-bottom: 1rem;
}

.odds-form-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 0.35rem;
    letter-spacing: 0.01em;
}

.odds-form-input,
.odds-form-textarea,
.odds-form-select {
    width: 100%;
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;
    padding: 0.65rem 0.95rem;
    font-size: 0.85rem;
    color: #ffffff;
    font-family: inherit;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.odds-form-input:focus,
.odds-form-textarea:focus,
.odds-form-select:focus {
    outline: none;
    border-color: #875af5;
    background: rgba(15, 23, 42, 0.9);
    box-shadow: 0 0 0 3px rgba(135, 90, 245, 0.2);
}

.odds-form-input.is-invalid,
.odds-form-textarea.is-invalid {
    border-color: #ef4444 !important;
    background: rgba(239, 68, 68, 0.08) !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.22) !important;
}

.odds-form-hint {
    display: block;
    font-size: 0.72rem;
    margin-top: 0.35rem;
    color: #94a3b8;
}

.odds-form-hint.is-error {
    color: #f87171;
}

.odds-form-input::placeholder,
.odds-form-textarea::placeholder {
    color: #475569;
}

.odds-form-textarea {
    resize: vertical;
    min-height: 90px;
}

.odds-select-wrapper {
    position: relative;
}

.odds-form-select {
    appearance: none;
    cursor: pointer;
    padding-right: 2rem;
}

.odds-form-select option {
    background: #0f1422;
    color: #f1f5f9;
}

.odds-select-arrow {
    position: absolute;
    right: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #94a3b8;
}

.odds-form-alert {
    padding: 0.65rem 0.95rem;
    border-radius: 8px;
    font-size: 0.8rem;
    margin-bottom: 1rem;
}

.odds-form-alert-error {
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.35);
    color: #fca5a5;
}

/* Actions */
.odds-form-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.25rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.odds-form-submit-btn {
    background: linear-gradient(135deg, #7039ec, #9061f9);
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 1.45rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(112, 57, 236, 0.35);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.odds-form-submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 6px 22px rgba(112, 57, 236, 0.5);
    filter: brightness(1.08);
}

.odds-form-submit-btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.odds-direct-contact {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: #94a3b8;
}

.odds-copy-email-btn {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 6px;
    padding: 4px 10px;
    color: #cbd5e1;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.odds-copy-email-btn:hover {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.25);
}

/* Success View */
.odds-modal-success {
    text-align: center;
    padding: 1.5rem 0.5rem;
}

.odds-success-icon-ring {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(16, 185, 129, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem auto;
}

.odds-success-kicker {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    font-weight: 800;
    color: #10b981;
    letter-spacing: 0.1em;
    margin-bottom: 0.35rem;
}

.odds-success-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 0.75rem 0;
}

.odds-success-desc {
    font-size: 0.88rem;
    color: #94a3b8;
    line-height: 1.6;
    max-width: 460px;
    margin: 0 auto 1.75rem auto;
}

.odds-success-close-btn {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.65rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.odds-success-close-btn:hover {
    background: rgba(255, 255, 255, 0.14);
}

@keyframes oddsModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@media (max-width: 640px) {
    .odds-modal-body {
        padding: 1.4rem 1.2rem;
    }
    .odds-form-grid {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .odds-form-actions {
        flex-direction: column;
        align-items: stretch;
    }
    .odds-form-submit-btn {
        justify-content: center;
        width: 100%;
    }
    .odds-direct-contact {
        justify-content: center;
        flex-direction: column;
    }
}
</style>

<script>
(function() {
    function initContactModal() {
        const modal = document.getElementById('odds-contact-modal');
        const backdrop = document.getElementById('odds-modal-backdrop');
        const closeBtnDot = document.getElementById('odds-modal-close-btn');
        const closeBtnX = document.getElementById('odds-modal-close-x');
        const successCloseBtn = document.getElementById('odds-success-close-btn');
        const form = document.getElementById('odds-contact-form');
        const formWrapper = document.getElementById('contact-form-wrapper');
        const successWrapper = document.getElementById('contact-success-wrapper');
        const submitBtn = document.getElementById('contact-submit-btn');
        const btnText = submitBtn ? submitBtn.querySelector('.odds-btn-text') : null;
        const btnSpinner = submitBtn ? submitBtn.querySelector('.odds-btn-spinner') : null;
        const errorAlert = document.getElementById('contact-form-error');
        const copyEmailBtn = document.getElementById('odds-copy-email-btn');

        if (!modal) return;

        function openModal() {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                const nameInput = document.getElementById('contact-name');
                if (nameInput) nameInput.focus();
            }, 100);
        }

        function closeModal() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Trigger selectors
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('.js-open-contact-modal, [data-open-contact]');
            if (trigger) {
                e.preventDefault();
                if (trigger.dataset.serviceNeeded) {
                    const select = document.getElementById('contact-service');
                    const service = trigger.dataset.serviceNeeded;
                    if (select) {
                        if (!Array.from(select.options).some(option => option.value === service)) {
                            select.add(new Option(service, service));
                        }
                        select.value = service;
                    }
                }
                openModal();
            }
        });

        // Close on backdrop or close buttons
        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (closeBtnDot) closeBtnDot.addEventListener('click', closeModal);
        if (closeBtnX) closeBtnX.addEventListener('click', closeModal);
        if (successCloseBtn) {
            successCloseBtn.addEventListener('click', () => {
                closeModal();
                setTimeout(() => {
                    formWrapper.style.display = 'block';
                    successWrapper.style.display = 'none';
                    if (form) form.reset();
                }, 300);
            });
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });

        // Copy Email Button
        if (copyEmailBtn) {
            copyEmailBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const email = this.getAttribute('data-email');
                const label = document.getElementById('copy-email-label');
                if (navigator.clipboard && email) {
                    navigator.clipboard.writeText(email).then(() => {
                        const originalText = label.textContent;
                        label.textContent = 'Copied to Clipboard!';
                        copyEmailBtn.style.color = '#10b981';
                        copyEmailBtn.style.borderColor = '#10b981';
                        setTimeout(() => {
                            label.textContent = originalText;
                            copyEmailBtn.style.color = '';
                            copyEmailBtn.style.borderColor = '';
                        }, 2200);
                    }).catch(() => {
                        window.location.href = 'mailto:' + email;
                    });
                } else {
                    window.location.href = 'mailto:' + email;
                }
            });
        }

        // AJAX Form Submission
        if (form) {
            const nameInput = document.getElementById('contact-name');
            const emailInput = document.getElementById('contact-email');
            const messageInput = document.getElementById('contact-message');
            const emailHint = document.getElementById('contact-email-hint');

            const disposableList = [
                'mailinator.com', 'tempmail.com', 'temp-mail.org', 'guerrillamail.com',
                '10minutemail.com', 'throwawaymail.com', 'yopmail.com', 'trashmail.com',
                'sharklasers.com', 'dispostable.com', 'getnada.com', 'fakemailgenerator.com',
                'generator.email', 'tempail.com', 'burnermail.io', 'crazymailing.com',
                'maildrop.cc', 'getairmail.com', 'mohmal.com', 'inboxkitten.com',
                'emailondeck.com', 'mytemp.email', 'temp-mail.io', 'zillamail.com',
                'trashmail.net', 'disposablemail.com', 'spam4.me', 'grr.la', 'pokemail.net'
            ];

            const clearErrors = () => {
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                    errorAlert.textContent = '';
                }
                [nameInput, emailInput, messageInput].forEach(el => el && el.classList.remove('is-invalid'));
                if (emailHint) {
                    emailHint.style.display = 'none';
                    emailHint.textContent = '';
                    emailHint.classList.remove('is-error');
                }
            };

            [nameInput, emailInput, messageInput].forEach(input => {
                if (input) {
                    input.addEventListener('input', () => {
                        input.classList.remove('is-invalid');
                        if (input === emailInput && emailHint) {
                            emailHint.style.display = 'none';
                        }
                    });
                }
            });

            // Pre-submit validation feedback on blur
            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    const val = this.value.trim();
                    if (!val) return;
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!emailRegex.test(val)) {
                        this.classList.add('is-invalid');
                        if (emailHint) {
                            emailHint.textContent = 'Please enter a valid email format (e.g. name@company.com)';
                            emailHint.classList.add('is-error');
                            emailHint.style.display = 'block';
                        }
                    } else {
                        const domain = val.split('@')[1]?.toLowerCase() || '';
                        if (disposableList.includes(domain)) {
                            this.classList.add('is-invalid');
                            if (emailHint) {
                                emailHint.textContent = 'Temporary or disposable email domains are not accepted.';
                                emailHint.classList.add('is-error');
                                emailHint.style.display = 'block';
                            }
                        } else {
                            this.classList.remove('is-invalid');
                            if (emailHint) emailHint.style.display = 'none';
                        }
                    }
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();

                const name = nameInput ? nameInput.value.trim() : '';
                const email = emailInput ? emailInput.value.trim() : '';
                const message = messageInput ? messageInput.value.trim() : '';

                if (!name) {
                    if (nameInput) {
                        nameInput.classList.add('is-invalid');
                        nameInput.focus();
                    }
                    if (errorAlert) {
                        errorAlert.textContent = 'Please enter your name.';
                        errorAlert.style.display = 'block';
                    }
                    return;
                }

                if (!email) {
                    if (emailInput) {
                        emailInput.classList.add('is-invalid');
                        emailInput.focus();
                    }
                    if (errorAlert) {
                        errorAlert.textContent = 'Please enter your email address.';
                        errorAlert.style.display = 'block';
                    }
                    return;
                }

                // Strict email format check
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(email)) {
                    if (emailInput) {
                        emailInput.classList.add('is-invalid');
                        emailInput.focus();
                    }
                    if (errorAlert) {
                        errorAlert.textContent = 'Please provide a valid, active email address (e.g. name@company.com).';
                        errorAlert.style.display = 'block';
                    }
                    return;
                }

                // Check disposable domains
                const emailDomain = email.split('@')[1]?.toLowerCase() || '';
                if (disposableList.includes(emailDomain)) {
                    if (emailInput) {
                        emailInput.classList.add('is-invalid');
                        emailInput.focus();
                    }
                    if (errorAlert) {
                        errorAlert.textContent = 'Temporary or disposable email domains are not accepted. Please use an active personal or business email.';
                        errorAlert.style.display = 'block';
                    }
                    return;
                }

                if (!message) {
                    if (messageInput) {
                        messageInput.classList.add('is-invalid');
                        messageInput.focus();
                    }
                    if (errorAlert) {
                        errorAlert.textContent = 'Please include a project brief or requirements.';
                        errorAlert.style.display = 'block';
                    }
                    return;
                }

                if (submitBtn) submitBtn.disabled = true;
                if (btnText) btnText.textContent = 'Verifying & Transmitting...';
                if (btnSpinner) btnSpinner.style.display = 'inline-block';

                const formData = new FormData(form);

                fetch("{{ route('portfolio.contact') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            let msg = '';
                            if (data.errors) {
                                if (data.errors.email && emailInput) {
                                    emailInput.classList.add('is-invalid');
                                    emailInput.focus();
                                }
                                msg = Object.values(data.errors).flat().join(' ');
                            } else if (data.message) {
                                msg = data.message;
                            } else {
                                msg = 'Server verification failed. Please check your email or contact us directly.';
                            }
                            throw new Error(msg);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    formWrapper.style.display = 'none';
                    successWrapper.style.display = 'block';
                })
                .catch(err => {
                    if (errorAlert) {
                        errorAlert.textContent = err.message || 'Transmission failed. Please email us directly.';
                        errorAlert.style.display = 'block';
                    }
                })
                .finally(() => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (btnText) btnText.textContent = 'Send Transmission';
                    if (btnSpinner) btnSpinner.style.display = 'none';
                });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initContactModal);
    } else {
        initContactModal();
    }
})();
</script>

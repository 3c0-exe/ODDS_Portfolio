import { setupPagePosition } from './page-position';
import { createDialogFocus } from './dialog-focus';
window.createDialogFocus = createDialogFocus;
import './bootstrap';
import '../css/service-explorer.css';
import '../css/studio-desktop.css';
import '../css/about-story.css';
import './studio-desktop';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import { SplitText } from 'gsap/SplitText';
import { ScrambleTextPlugin } from 'gsap/ScrambleTextPlugin';
import { DrawSVGPlugin } from 'gsap/DrawSVGPlugin';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother, SplitText, ScrambleTextPlugin, DrawSVGPlugin);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollSmoother = ScrollSmoother;
window.SplitText = SplitText;
window.ScrambleTextPlugin = ScrambleTextPlugin;
window.DrawSVGPlugin = DrawSVGPlugin;

// ─── GSAP ScrollSmoother ─────────────────────────────────
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}
window.scrollTo(0, 0);
if (document.documentElement) document.documentElement.scrollTop = 0;
if (document.body) document.body.scrollTop = 0;

const hasHeroSection = !!document.getElementById('hero');
let smoother = null;
if (document.getElementById('smooth-wrapper') && document.getElementById('smooth-content')) {
    smoother = ScrollSmoother.create({
        wrapper: '#smooth-wrapper',
        content: '#smooth-content',
        smooth: 1.4,          // inertia duration in seconds
        smoothTouch: false,    // native 60/120fps touch momentum on mobile/touchscreens (eliminates lag)
        paused: !!document.getElementById('fp-overlay'), // only pause if legacy cyber blade overlay is present
    });
    if (smoother) {
        smoother.scrollTop(0);
    }
}
window.smoother = smoother;

window.pagePosition = setupPagePosition({ smoother, ScrollTrigger });

// ─── Navbar & Mobile Drawer setup ──────────────────────
const navbar = document.getElementById('navbar');
if (navbar) navbar.classList.add('scrolled');

const mobileToggle = document.getElementById('mobile-toggle');
const mobileDrawer = document.getElementById('mobile-drawer');
const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

if (mobileToggle && mobileDrawer) {
    mobileToggle.addEventListener('click', () => {
        const isOpen = mobileDrawer.classList.contains('active');
        if (isOpen) {
            mobileDrawer.classList.remove('active');
            mobileToggle.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileDrawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        } else {
            mobileDrawer.classList.add('active');
            mobileToggle.classList.add('active');
            mobileToggle.setAttribute('aria-expanded', 'true');
            mobileDrawer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
    });

    mobileNavLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileDrawer.classList.remove('active');
            mobileToggle.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileDrawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        });
    });
}


// ═══════════════════════════════════════════════════════
//  FULL-PAGE ENGINE — mirrors GSAP branch trans-col logic
// ─── Hero entrance ───────────────────────────────────
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const heroP = document.getElementById('hero-p');
const heroBtn = document.getElementById('hero-btn');

if (heroP || heroBtn) {
    if (prefersReducedMotion) {
        const targets = ['#hero-h1', '#hero-p', '#hero-btn'].filter(id => document.querySelector(id));
        if (targets.length) gsap.set(targets, { opacity: 1, y: 0 });
    } else {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 0.85 } });
        if (heroP) tl.to('#hero-p', { opacity: 1, y: 0, delay: 0.28 });
        if (heroBtn) tl.to('#hero-btn', { opacity: 1, y: 0 }, heroP ? '-=0.45' : 0);
    }
}

// ═══════════════════════════════════════════════════════
//  HERO <-> SERVICES SIGNATURE SCROLL TRANSITION ENGINE
//  • Hero <-> Services: Signature Cyber Blade transition
//  • Services downwards (Works -> Testimonials -> Why -> CTA):
//    100% natural, smooth native scrolling experience!
// ═══════════════════════════════════════════════════════
(function pageEngine() {
    const secHero = document.getElementById('hero');
    const secServices = document.getElementById('services');
    if (!secHero || !secServices) return;

    const overlay = document.getElementById('fp-overlay');
    if (!overlay) {
        document.body.classList.remove('hero-active');

        const NAV = {
            hero: { bg: 'rgba(14, 14, 14, 0.65)', border: 'rgba(255, 255, 255, 0.08)', light: false },
            'who-we-are': { bg: 'rgba(255, 255, 255, 0.85)', border: 'rgba(0, 0, 0, 0.06)', light: true },
            services: { bg: 'rgba(24, 24, 24, 0.85)', border: 'rgba(255, 255, 255, 0.08)', light: false },
            works: { bg: 'rgba(255, 255, 255, 0.85)', border: 'rgba(0, 0, 0, 0.06)', light: true },
            testimonials: { bg: 'rgba(243, 89, 176, 0.65)', border: 'rgba(255, 255, 255, 0.08)', light: false },
            why: { bg: 'rgba(240, 240, 245, 0.85)', border: 'rgba(0, 0, 0, 0.06)', light: true },
            process: { bg: 'rgba(240, 240, 245, 0.85)', border: 'rgba(0, 0, 0, 0.06)', light: true },
            faq: { bg: 'rgba(255, 255, 255, 0.85)', border: 'rgba(0, 0, 0, 0.06)', light: true },
            cta: { bg: 'rgba(14, 14, 14, 0.65)', border: 'rgba(255, 255, 255, 0.08)', light: false },
        };

        let currentNavTheme = null;
        function applyNavTheme(key) {
            if (!navbar) return;
            const t = NAV[key] ?? NAV.hero;
            if (currentNavTheme === key) return;
            currentNavTheme = key;
            gsap.to(navbar, { '--nav-bg': t.bg, '--nav-border': t.border, duration: 0.3, ease: 'power2.out', overwrite: 'auto' });
            navbar.classList.toggle('light-theme', !!t.light);
        }

        // Logo smooth scroll to top
        const logoLink = document.getElementById('logo');
        if (logoLink && (window.location.pathname === '/' || window.location.pathname === '')) {
            logoLink.addEventListener('click', e => {
                e.preventDefault();
                window.pagePosition.goToTop();
            });
        }

        // Dynamic navbar theme on scroll
        const observedSections = [
            { id: 'hero', key: 'hero' },
            { id: 'who-we-are', key: 'who-we-are' },
            { id: 'services', key: 'services' },
            { id: 'works', key: 'works' },
            { id: 'why-process-wrapper', fallbackId: 'why', key: 'why' },
            { id: 'faq', key: 'faq' },
            { id: 'cta', key: 'cta' },
        ];

        function updateNavOnScroll() {
            const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);

            // At or near the top: hero section theme
            if (scrollY <= 20) {
                applyNavTheme('hero');
                return;
            }

            const navH = navbar ? navbar.offsetHeight : 70;
            const probeY = Math.max(20, navH * 0.5);

            let activeKey = null;
            for (const item of observedSections) {
                const el = document.getElementById(item.id) || (item.fallbackId ? document.getElementById(item.fallbackId) : null);
                if (!el) continue;
                const rect = el.getBoundingClientRect();
                if (rect.top <= probeY && rect.bottom > probeY) {
                    activeKey = item.key;
                    break;
                }
            }

            // Fallback: pick the last section whose top has passed the probe
            if (!activeKey) {
                for (let i = observedSections.length - 1; i >= 0; i--) {
                    const item = observedSections[i];
                    const el = document.getElementById(item.id) || (item.fallbackId ? document.getElementById(item.fallbackId) : null);
                    if (el && el.getBoundingClientRect().top <= probeY) {
                        activeKey = item.key;
                        break;
                    }
                }
            }

            applyNavTheme(activeKey || 'hero');
        }

        window.addEventListener('scroll', updateNavOnScroll, { passive: true });
        window.addEventListener('resize', updateNavOnScroll, { passive: true });
        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.addEventListener('scroll', updateNavOnScroll);
        }
        updateNavOnScroll();
        return;
    }
    const blades = overlay ? Array.from(overlay.querySelectorAll('.cyber-blade')) : [];
    const rgbCyan = overlay ? overlay.querySelector('.rgb-cyan') : null;
    const rgbPink = overlay ? overlay.querySelector('.rgb-pink') : null;
    const scanlines = overlay ? overlay.querySelector('.cyber-scanlines') : null;

    const secWorks = document.getElementById('works');

    const NAV = {
        hero: { bg: 'rgba(14,14,14,0.65)', border: 'rgba(255,255,255,0.08)', light: false },
        services: { bg: 'rgba(248,250,252,0.85)', border: 'rgba(0,0,0,0.06)', light: true },
        works: { bg: 'rgba(227,227,227,0.65)', border: 'rgba(0,0,0,0.06)', light: true },
        testimonials: { bg: 'rgba(243,89,176,0.65)', border: 'rgba(255,255,255,0.08)', light: false },
        why: { bg: 'rgba(239,239,239,0.65)', border: 'rgba(0,0,0,0.06)', light: true },
        process: { bg: 'rgba(240,240,245,0.65)', border: 'rgba(0,0,0,0.06)', light: true },
        faq: { bg: 'rgba(255,255,255,0.65)', border: 'rgba(0,0,0,0.06)', light: true },
        cta: { bg: 'rgba(0,0,0,0.65)', border: 'rgba(255,255,255,0.08)', light: false },
    };

    let currentMode = 'hero'; // 'hero' | 'services'
    let isTransitioning = false;

    function forceScrollToTop() {
        window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
        // Also reset ScrollSmoother's virtual scroll position
        if (smoother) smoother.scrollTop(0);
    }

    function applyNavTheme(key) {
        if (!navbar) return;
        const t = NAV[key] ?? NAV.hero;
        gsap.to(navbar, { '--nav-bg': t.bg, '--nav-border': t.border, duration: 0.3, ease: 'none' });
        navbar.classList.toggle('light-theme', t.light);
    }

    function getSectionElements(sec) {
        if (!sec) return [];
        const selectors = [
            '.hero-title', '.hero-subtitle', '.btn-hero',
            '.sec-label', '.services-title', '.services-subline', '.services-cards', '.btn-dark',
            '.works-section-label', '.works-heading', '#stats-row', '.works-description', '.works-card-grid > .group', '.works-see-more',
            '.testi-label', '.testi-title', '.testi-right-desc', '.testi-card',
            '.why-title', '.why-desc', '.why-deck-wrap', '.why-card',
            '.process-label', '.process-title', '.process-desc', '.process-phase-block', '.process-footer',
            '.faq-label', '.faq-title', '.faq-desc', '.faq-item',
            '.cta-terminal', '.cta-title', '.cta-desc', '.cta-btn', '.cta-visual'
        ];
        const els = sec.querySelectorAll(selectors.join(', '));
        if (els.length > 0) return Array.from(els);
        const inner = sec.querySelector('.sec-inner, .hero-content, .works-content-wrap, .process-content-wrap, .cta-outer') || sec;
        return Array.from(inner.children);
    }

    // Initialize: Hero is active at top
    document.body.classList.add('hero-active');
    forceScrollToTop();
    gsap.set(secHero, {
        position: 'relative',
        top: 'auto',
        left: 'auto',
        width: '100%',
        zIndex: 10,
        visibility: 'visible',
        opacity: 1,
        pointerEvents: 'auto'
    });
    gsap.set(secServices, {
        position: 'absolute',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        zIndex: 0,
        visibility: 'hidden',
        opacity: 0,
        pointerEvents: 'none'
    });
    if (overlay) gsap.set(overlay, { visibility: 'hidden', opacity: 0, zIndex: 0, pointerEvents: 'none' });
    applyNavTheme('hero');
    if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();

    // ── Transition: Hero -> Services ───────────────────
    function transitionToServices(callback) {
        if (isTransitioning || currentMode === 'services') {
            if (callback) callback();
            return;
        }

        isTransitioning = true;
        forceScrollToTop();
        const fromSec = secHero;
        const toSec = secServices;
        const fromEls = getSectionElements(fromSec);
        const toEls = getSectionElements(toSec);

        blades.forEach(blade => {
            const surf = blade.querySelector('.cyber-blade-surface');
            if (surf) surf.style.background = 'rgba(14, 14, 14, 0.9)';
        });
        if (overlay) gsap.set(overlay, { visibility: 'visible', opacity: 1, zIndex: 99 });

        gsap.set(fromSec, { position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', visibility: 'visible', opacity: 1, scale: 1, zIndex: 10, pointerEvents: 'none' });
        gsap.set(toSec, { position: 'absolute', top: 0, left: 0, width: '100%', minHeight: '100vh', visibility: 'visible', opacity: 0, scale: 1.03, y: 0, zIndex: 20, pointerEvents: 'none' });
        gsap.set(toEls, { opacity: 0, y: 35, skewX: -5 });
        gsap.set(blades, { x: '0%', opacity: 1, skewX: 0 });
        if (rgbCyan) gsap.set(rgbCyan, { opacity: 0, x: -18 });
        if (rgbPink) gsap.set(rgbPink, { opacity: 0, x: 18 });
        if (scanlines) gsap.set(scanlines, { opacity: 0 });

        const tl = gsap.timeline({
            onComplete() {
                currentMode = 'services';
                document.body.classList.remove('hero-active');
                forceScrollToTop();

                gsap.set(fromSec, { position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', visibility: 'hidden', opacity: 0, zIndex: 0, scale: 1, pointerEvents: 'none' });
                gsap.set(fromEls, { clearProps: 'transform,opacity,scale,skewX,x,y' });

                if (overlay) gsap.set(overlay, { visibility: 'hidden', opacity: 0, zIndex: 0 });
                gsap.set(blades, { clearProps: 'transform,opacity,skewX,x,y' });
                if (rgbCyan) gsap.set(rgbCyan, { opacity: 0 });
                if (rgbPink) gsap.set(rgbPink, { opacity: 0 });
                if (scanlines) gsap.set(scanlines, { opacity: 0 });

                gsap.set(toSec, { position: 'relative', top: 'auto', left: 'auto', width: '100%', height: 'auto', zIndex: 5, opacity: 1, scale: 1, pointerEvents: 'auto' });
                gsap.set(toEls, { clearProps: 'transform,opacity,scale,skewX,x,y' });

                applyNavTheme('services');

                // ── Activate ScrollSmoother once Services mode is live ──
                if (smoother) {
                    smoother.scrollTop(0);
                    smoother.paused(false);
                    ScrollTrigger.refresh();
                }

                setTimeout(() => {
                    isTransitioning = false;
                    if (callback) callback();
                }, 80);
            }
        });

        tl.to(fromEls, {
            opacity: 0, x: -30, skewX: -4,
            duration: 0.45, ease: 'power2.in', stagger: 0.018
        }, 0);

        tl.to(fromSec, { scale: 0.94, opacity: 0.25, duration: 0.6, ease: 'power2.inOut' }, 0);

        if (rgbCyan && rgbPink && scanlines) {
            tl.to([rgbCyan, rgbPink, scanlines], { opacity: 0.7, duration: 0.3, ease: 'power1.inOut' }, 0.06);
            tl.to([rgbCyan, rgbPink, scanlines], { opacity: 0, duration: 0.38, ease: 'power2.out' }, 0.36);
        }

        tl.to(toSec, { opacity: 1, scale: 1, duration: 0.85, ease: 'power3.out' }, 0.08);

        blades.forEach((blade, i) => {
            const isEven = (i % 2 === 0);
            const shearDir = isEven ? -1 : 1;
            const delay = (i % 4) * 0.035;

            tl.to(blade, {
                x: (shearDir * 140) + '%',
                skewX: shearDir * 14,
                opacity: 0,
                duration: 0.88,
                ease: 'power3.inOut'
            }, 0.06 + delay);
        });

        tl.to(toEls, { opacity: 1, y: 0, skewX: 0, duration: 0.7, ease: 'power3.out', stagger: 0.035 }, 0.22);
        if (navbar) {
            tl.to(navbar, { '--nav-bg': NAV.services.bg, '--nav-border': NAV.services.border, duration: 0.5, ease: 'power2.inOut' }, 0.06);
            navbar.classList.toggle('light-theme', NAV.services.light);
        }
    }

    // ── Transition: Services -> Hero ───────────────────
    function transitionToHero(callback) {
        if (isTransitioning || currentMode === 'hero') {
            if (callback) callback();
            return;
        }

        // Pause ScrollSmoother before resetting scroll so
        // forceScrollToTop() works without fighting momentum
        if (smoother) smoother.paused(true);

        const scrollY = window.scrollY || window.pageYOffset || 0;
        if (scrollY > 5) {
            forceScrollToTop();
        }

        isTransitioning = true;
        forceScrollToTop();
        const fromSec = secServices;
        const toSec = secHero;
        const fromEls = getSectionElements(fromSec);
        const toEls = getSectionElements(toSec);

        blades.forEach(blade => {
            const surf = blade.querySelector('.cyber-blade-surface');
            if (surf) surf.style.background = '#0e0e0e';
        });
        if (overlay) gsap.set(overlay, { visibility: 'visible', opacity: 1, zIndex: 99 });

        gsap.set(fromSec, { position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', visibility: 'visible', opacity: 1, scale: 1, zIndex: 10, pointerEvents: 'none' });
        gsap.set(toSec, { position: 'absolute', top: 0, left: 0, width: '100%', minHeight: '100vh', visibility: 'visible', opacity: 0, scale: 1.03, y: 0, zIndex: 20, pointerEvents: 'none' });
        gsap.set(toEls, { opacity: 0, y: -35, skewX: 5 });
        gsap.set(blades, { x: '0%', opacity: 1, skewX: 0 });
        if (rgbCyan) gsap.set(rgbCyan, { opacity: 0, x: 18 });
        if (rgbPink) gsap.set(rgbPink, { opacity: 0, x: -18 });
        if (scanlines) gsap.set(scanlines, { opacity: 0 });

        const tl = gsap.timeline({
            onComplete() {
                currentMode = 'hero';
                forceScrollToTop();
                document.body.classList.add('hero-active');

                gsap.set(fromSec, { position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', visibility: 'hidden', opacity: 0, zIndex: 0, scale: 1, pointerEvents: 'none' });
                gsap.set(fromEls, { clearProps: 'transform,opacity,scale,skewX,x,y' });

                if (overlay) gsap.set(overlay, { visibility: 'hidden', opacity: 0, zIndex: 0 });
                gsap.set(blades, { clearProps: 'transform,opacity,skewX,x,y' });
                if (rgbCyan) gsap.set(rgbCyan, { opacity: 0 });
                if (rgbPink) gsap.set(rgbPink, { opacity: 0 });
                if (scanlines) gsap.set(scanlines, { opacity: 0 });

                gsap.set(toSec, { position: 'relative', top: 'auto', left: 'auto', width: '100%', height: 'auto', zIndex: 10, opacity: 1, scale: 1, pointerEvents: 'auto' });
                gsap.set(toEls, { clearProps: 'transform,opacity,scale,skewX,x,y' });

                applyNavTheme('hero');
                setTimeout(() => {
                    isTransitioning = false;
                    if (callback) callback();
                }, 80);
            }
        });

        tl.to(fromEls, {
            opacity: 0, x: 30, skewX: 4,
            duration: 0.45, ease: 'power2.in', stagger: 0.018
        }, 0);

        tl.to(fromSec, { scale: 0.94, opacity: 0.25, duration: 0.6, ease: 'power2.inOut' }, 0);

        if (rgbCyan && rgbPink && scanlines) {
            tl.to([rgbCyan, rgbPink, scanlines], { opacity: 0.7, duration: 0.3, ease: 'power1.inOut' }, 0.06);
            tl.to([rgbCyan, rgbPink, scanlines], { opacity: 0, duration: 0.38, ease: 'power2.out' }, 0.36);
        }

        tl.to(toSec, { opacity: 1, scale: 1, duration: 0.85, ease: 'power3.out' }, 0.08);

        blades.forEach((blade, i) => {
            const isEven = (i % 2 === 0);
            const shearDir = isEven ? 1 : -1;
            const delay = (i % 4) * 0.035;

            tl.to(blade, {
                x: (shearDir * 140) + '%',
                skewX: shearDir * 14,
                opacity: 0,
                duration: 0.88,
                ease: 'power3.inOut'
            }, 0.06 + delay);
        });

        tl.to(toEls, { opacity: 1, y: 0, skewX: 0, duration: 0.7, ease: 'power3.out', stagger: 0.035 }, 0.22);
        if (navbar) {
            tl.to(navbar, { '--nav-bg': NAV.hero.bg, '--nav-border': NAV.hero.border, duration: 0.5, ease: 'power2.inOut' }, 0.06);
            navbar.classList.toggle('light-theme', NAV.hero.light);
        }
    }

    // ── Mouse Wheel Input ──────────────────────────────
    window.addEventListener('wheel', e => {
        if (document.body.classList.contains('modal-open')) return;
        if (isTransitioning) {
            e.preventDefault();
            return;
        }
        if (e.target.closest('#chat-window') || e.target.closest('#odds-chat-container')) return;

        if (currentMode === 'hero') {
            if (e.deltaY > 10) {
                e.preventDefault();
                transitionToServices();
            } else {
                e.preventDefault();
            }
            return;
        }

        if (currentMode === 'services') {
            const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);
            if (scrollY <= 2 && e.deltaY < -15) {
                e.preventDefault();
                transitionToHero();
                return;
            }
            // All other scrolling is 100% normal browser scrolling!
        }
    }, { passive: false });

    // ── Touch Swipe Handling & Scroll Cue ──────────────
    let touchY0 = 0;
    let touchX0 = 0;

    window.addEventListener('touchstart', e => {
        if (e.touches && e.touches[0]) {
            touchY0 = e.touches[0].clientY;
            touchX0 = e.touches[0].clientX;
        }
    }, { passive: true });

    window.addEventListener('touchmove', e => {
        if (document.body.classList.contains('modal-open')) return;
        if (isTransitioning) {
            if (e.cancelable) e.preventDefault();
            return;
        }
        if (e.target.closest('#chat-window') || e.target.closest('#odds-chat-container') || e.target.closest('#why-deck')) return;

        if (!e.touches || !e.touches[0]) return;
        const currentY = e.touches[0].clientY;
        const currentX = e.touches[0].clientX;
        const dy = touchY0 - currentY;
        const dx = Math.abs(touchX0 - currentX);

        // Responsive swipe trigger: activate as soon as gesture passes threshold without waiting for finger lift
        if (currentMode === 'hero') {
            if (dy > 45 && dy > dx) {
                if (e.cancelable) e.preventDefault();
                transitionToServices();
            }
            return;
        }

        if (currentMode === 'services') {
            const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);
            if (scrollY <= 2 && dy < -45 && Math.abs(dy) > dx) {
                if (e.cancelable) e.preventDefault();
                transitionToHero();
            }
        }
    }, { passive: false });

    window.addEventListener('touchend', e => {
        if (document.body.classList.contains('modal-open') || isTransitioning) return;
        if (e.target.closest('#chat-window') || e.target.closest('#odds-chat-container') || e.target.closest('#why-deck')) return;

        if (!e.changedTouches || !e.changedTouches[0]) return;
        const touchEndY = e.changedTouches[0].clientY;
        const dy = touchY0 - touchEndY; // dy > 0: swiped up (scrolling down)

        if (currentMode === 'hero') {
            if (dy > 25) {
                transitionToServices();
            }
            return;
        }

        if (currentMode === 'services') {
            const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);
            if (scrollY <= 5 && dy < -25) {
                transitionToHero();
            }
        }
    }, { passive: true });

    // ── Keyboard Navigation ────────────────────────────
    window.addEventListener('keydown', e => {
        // Do not intercept keystrokes when user is typing in form inputs, textareas, or contenteditables
        const targetTag = e.target.tagName;
        if (targetTag === 'INPUT' || targetTag === 'TEXTAREA' || targetTag === 'SELECT' || e.target.isContentEditable) {
            return;
        }

        if (document.body.classList.contains('modal-open')) {
            return;
        }

        if (isTransitioning) {
            if (['ArrowDown', 'ArrowUp', 'PageDown', 'PageUp', ' ', 'Home', 'End'].includes(e.key)) {
                e.preventDefault();
            }
            return;
        }

        if (currentMode === 'hero') {
            if (e.key === 'ArrowDown' || e.key === 'PageDown' || (e.key === ' ' && !e.shiftKey)) {
                e.preventDefault();
                transitionToServices();
            } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                e.preventDefault();
            }
            return;
        }

        if (currentMode === 'services') {
            const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);
            if (scrollY <= 2 && (e.key === 'ArrowUp' || e.key === 'PageUp')) {
                e.preventDefault();
                transitionToHero();
            }
        }
    });

    // ── Anchor Link & Logo Navigation ──────────────────
    const logoLink = document.getElementById('logo');
    if (logoLink) {
        logoLink.addEventListener('click', (e) => {
            if (window.location.pathname === '/' || window.location.pathname === '') {
                e.preventDefault();
                if (currentMode === 'services') {
                    forceScrollToTop();
                    transitionToHero();
                }
            }
        });
    }

    document.querySelectorAll('a[href^="#"], a[href^="/#"]').forEach(link => {
        link.addEventListener('click', e => {
            const rawHref = link.getAttribute('href');
            const hash = rawHref.includes('#') ? rawHref.substring(rawHref.indexOf('#') + 1) : '';
            if (!hash) return;

            e.preventDefault();

            if (hash === 'hero') {
                if (currentMode === 'services') {
                    forceScrollToTop();
                    transitionToHero();
                }
                return;
            }

            if (hash === 'services') {
                if (currentMode === 'hero') {
                    transitionToServices();
                } else {
                    if (smoother) {
                        smoother.scrollTo(0, true);
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
                return;
            }

            const targetEl = document.getElementById(hash);
            if (targetEl) {
                if (currentMode === 'hero') {
                    transitionToServices(() => {
                        setTimeout(() => {
                            if (smoother) {
                                smoother.scrollTo(targetEl, true);
                            } else {
                                targetEl.scrollIntoView({ behavior: 'smooth' });
                            }
                        }, 100);
                    });
                } else {
                    if (smoother) {
                        smoother.scrollTo(targetEl, true);
                    } else {
                        targetEl.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }
        });
    });

    // ── Navbar Dynamic Theme on Scroll ─────────────────
    const observedSections = [
        { id: 'services', key: 'services' },
        { id: 'works', key: 'works' },
        { id: 'testimonials', key: 'testimonials' },
        { id: 'why', key: 'why' },
        { id: 'process', key: 'process' },
        { id: 'faq', key: 'faq' },
        { id: 'cta', key: 'cta' },
    ];

    function updateNavOnScroll() {
        if (currentMode === 'hero') {
            applyNavTheme('hero');
            return;
        }

        const scrollY = smoother ? smoother.scrollTop() : (window.scrollY || window.pageYOffset || 0);
        const vh = window.innerHeight;
        const probe = scrollY + vh * 0.35;

        let activeKey = 'services';
        for (const item of observedSections) {
            const el = document.getElementById(item.id);
            if (el) {
                const top = el.offsetTop;
                if (probe >= top) {
                    activeKey = item.key;
                }
            }
        }
        applyNavTheme(activeKey);
    }

    window.addEventListener('scroll', updateNavOnScroll, { passive: true });
    if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.addEventListener('scroll', updateNavOnScroll);
    }

    window.fp = {
        transitionToServices,
        transitionToHero,
        current: () => (currentMode === 'hero' ? 0 : 1)
    };
})();


// ─── Service card selection ─────────────────────────────
// Cards now open a modal instead of pausing the marquee.
// Clear any lingering selection state so the track always resumes.
function clearCarouselSelection() {
    document.querySelectorAll('.svc-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.services-track').forEach(t => t.classList.remove('has-selected'));
}

// ─── CTA Terminal ASCII "ODDS" Cyber Animation Controller ───
(function initCtaAsciiAnimation() {
    const asciiEl = document.querySelector('.cta-ascii-art');
    if (!asciiEl) return;

    const originalText = asciiEl.textContent;
    const glitchChars = '01XY#%&*+=/~^░▒▓█@!$?';
    let isAnimating = false;
    let hasPlayedInitial = false;

    function scrambleDecode(duration = 1000) {
        if (isAnimating) return;
        isAnimating = true;

        const startTime = performance.now();
        const originalChars = originalText.split('');
        const nonWhitespaceIndices = [];

        originalChars.forEach((ch, idx) => {
            if (ch !== ' ' && ch !== '\n') {
                nonWhitespaceIndices.push(idx);
            }
        });

        function step(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const revealedCount = Math.floor(eased * nonWhitespaceIndices.length);
            const resolvedSet = new Set(nonWhitespaceIndices.slice(0, revealedCount));

            const rendered = originalChars.map((char, i) => {
                if (char === ' ' || char === '\n') return char;
                if (resolvedSet.has(i)) return char;
                return glitchChars[Math.floor(Math.random() * glitchChars.length)];
            }).join('');

            asciiEl.textContent = rendered;

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                asciiEl.textContent = originalText;
                isAnimating = false;
            }
        }

        requestAnimationFrame(step);
    }

    // Trigger when scrolled into view
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasPlayedInitial) {
                    hasPlayedInitial = true;
                    setTimeout(() => scrambleDecode(1100), 250);
                }
            });
        }, { threshold: 0.2 });
        observer.observe(asciiEl);
    } else {
        setTimeout(() => scrambleDecode(1100), 500);
    }

    // Trigger micro-glitch on hover
    asciiEl.addEventListener('mouseenter', () => {
        if (!isAnimating) {
            scrambleDecode(650);
        }
    });

    // Periodic subtle cyber glitch every 9 seconds if in view
    setInterval(() => {
        if (!isAnimating && document.visibilityState === 'visible') {
            const rect = asciiEl.getBoundingClientRect();
            const inView = rect.top < window.innerHeight && rect.bottom > 0;
            if (inView) {
                scrambleDecode(750);
            }
        }
    }, 9000);
})();

// ─── CTA Telemetry Interactive Actions (Option 4) ───────────
(function initCtaTelemetryActions() {
    // 1. Open Lorenzo Chat Widget
    const chatBtn = document.getElementById('cta-open-chat-btn');
    if (chatBtn) {
        chatBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const chatToggle = document.getElementById('chat-toggle-btn');
            const chatWindow = document.getElementById('chat-window');
            if (chatToggle) {
                if (!chatWindow || chatWindow.classList.contains('hidden')) {
                    chatToggle.click();
                }
                const input = document.getElementById('chat-input');
                if (input) {
                    setTimeout(() => input.focus(), 300);
                }
            }
        });
    }

    // 2. 1-Click Email Copy with Terminal Feedback
    const copyBtn = document.getElementById('cta-copy-email-btn');
    if (copyBtn) {
        copyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const email = copyBtn.getAttribute('data-email') || 'oddsdevph@gmail.com';
            navigator.clipboard.writeText(email).then(() => {
                const label = copyBtn.querySelector('.cta-copy-label');
                if (label) label.textContent = '[ ✔ Copied! ]';
                copyBtn.classList.add('copied');
                setTimeout(() => {
                    if (label) label.textContent = '[ Copy ]';
                    copyBtn.classList.remove('copied');
                }, 2200);
            }).catch(() => {
                window.location.href = `mailto:${email}`;
            });
        });
    }

    // 3. Live Real-Time Network Ping
    const pingEl = document.getElementById('cta-live-ping');
    if (pingEl) {
        function updatePing() {
            const start = performance.now();
            fetch('/favicon.png?_t=' + Date.now(), { method: 'HEAD', cache: 'no-store' })
                .then(() => {
                    const elapsed = Math.round(performance.now() - start);
                    const clamped = Math.max(8, Math.min(elapsed, 95));
                    pingEl.textContent = `${clamped}ms`;
                })
                .catch(() => {
                    const sim = Math.floor(Math.random() * 8) + 12;
                    pingEl.textContent = `${sim}ms`;
                });
        }
        updatePing();
        setInterval(updatePing, 15000);
    }
})();

// ─── Project Detail Modal Controller ────────────────────
(function projectModalController() {
    const modal = document.getElementById('project-modal');
    if (!modal) return;

    // Teleport modal to document.body so ScrollSmoother transform on #smooth-content does not trap position: fixed
    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    const closeBtn = document.getElementById('project-modal-close-btn');
    const pathEl = document.getElementById('project-modal-path');
    const titleEl = document.getElementById('project-modal-title');
    const categoryEl = document.getElementById('project-modal-category');
    const yearEl = document.getElementById('project-modal-year');
    const clientWrapEl = document.getElementById('project-modal-client-wrap');
    const clientEl = document.getElementById('project-modal-client');
    const roleWrapEl = document.getElementById('project-modal-role-wrap');
    const roleEl = document.getElementById('project-modal-role');
    const descEl = document.getElementById('project-modal-desc');
    const primaryMediaEl = document.getElementById('project-modal-primary-media');
    const blocksContainer = document.getElementById('project-modal-blocks');
    const linksContainer = document.getElementById('project-modal-links');
    const modalCard = modal.querySelector('.project-modal-card');
    const dialogFocus = createDialogFocus(modal, () => closeBtn);

    // Parse pre-rendered JSON payload
    let projectsData = [];
    const projectsDataScript = document.getElementById('odds-projects-data');
    if (projectsDataScript) {
        try {
            projectsData = JSON.parse(projectsDataScript.textContent);
        } catch (e) {
            console.error('Failed to parse odds-projects-data:', e);
        }
    }

    function renderNotionBlocks(blocksData, fallbackStory) {
        if (!blocksContainer) return;
        blocksContainer.innerHTML = '';

        let blocks = [];
        if (Array.isArray(blocksData)) {
            blocks = blocksData;
        } else if (typeof blocksData === 'string' && blocksData.trim() !== '') {
            try {
                let parsed = blocksData;
                if (parsed.includes('&quot;') || parsed.includes('&#039;')) {
                    const txt = document.createElement('textarea');
                    txt.innerHTML = parsed;
                    parsed = txt.value;
                }
                blocks = JSON.parse(parsed);
            } catch (e) {
                blocks = [];
            }
        }

        if (Array.isArray(blocks) && blocks.length > 0) {
            let currentList = null;
            let currentListType = null;

            blocks.forEach(b => {
                const type = b.type || 'paragraph';
                const content = b.content !== undefined ? b.content : '';

                // Close list container if current block is of different type
                if (currentList && currentListType !== type) {
                    currentList = null;
                    currentListType = null;
                }

                if (type === 'heading2') {
                    const h2 = document.createElement('h2');
                    h2.className = 'frame46-block-h2';
                    h2.innerHTML = content;
                    blocksContainer.appendChild(h2);
                } else if (type === 'heading3') {
                    const h3 = document.createElement('h3');
                    h3.className = 'frame46-block-h3';
                    h3.innerHTML = content;
                    blocksContainer.appendChild(h3);
                } else if (type === 'bullet') {
                    if (!currentList || currentListType !== 'bullet') {
                        currentList = document.createElement('ul');
                        currentList.className = 'frame46-block-bullet-list';
                        blocksContainer.appendChild(currentList);
                        currentListType = 'bullet';
                    }
                    const li = document.createElement('li');
                    li.className = 'frame46-block-bullet-item';
                    li.innerHTML = `<span class="frame46-block-bullet-dot">•</span><div class="flex-1">${content}</div>`;
                    currentList.appendChild(li);
                } else if (type === 'numbered') {
                    if (!currentList || currentListType !== 'numbered') {
                        currentList = document.createElement('ol');
                        currentList.className = 'frame46-block-num-list';
                        blocksContainer.appendChild(currentList);
                        currentListType = 'numbered';
                    }
                    const count = currentList.children.length + 1;
                    const li = document.createElement('li');
                    li.className = 'frame46-block-num-item';
                    li.innerHTML = `<span class="frame46-block-num-badge">${count}.</span><div class="flex-1">${content}</div>`;
                    currentList.appendChild(li);
                } else if (type === 'quote') {
                    const blockquote = document.createElement('blockquote');
                    blockquote.className = 'frame46-block-quote';
                    blockquote.innerHTML = content;
                    blocksContainer.appendChild(blockquote);
                } else if (type === 'callout') {
                    const callout = document.createElement('div');
                    callout.className = 'frame46-block-callout';
                    callout.innerHTML = `
                        <div class="frame46-block-callout-icon"><i class="fa-solid fa-lightbulb"></i></div>
                        <div class="flex-1">${content}</div>
                    `;
                    blocksContainer.appendChild(callout);
                } else if (type === 'code') {
                    const pre = document.createElement('pre');
                    pre.className = 'frame46-block-code';
                    pre.textContent = content;
                    blocksContainer.appendChild(pre);
                } else if (type === 'divider') {
                    const hr = document.createElement('hr');
                    hr.className = 'frame46-block-divider';
                    blocksContainer.appendChild(hr);
                } else if (type === 'image' && b.src) {
                    const card = document.createElement('div');
                    card.className = 'frame46-block-image-card';
                    card.innerHTML = `
                        <div class="frame46-block-image-inner">
                            <img src="${b.src}" alt="${b.caption || 'Project visual'}" loading="lazy">
                        </div>
                        ${b.caption ? `<div class="frame46-block-image-caption">${b.caption}</div>` : ''}
                    `;
                    blocksContainer.appendChild(card);
                } else {
                    if (content.toString().trim() !== '') {
                        const p = document.createElement('p');
                        p.className = 'frame46-block-p';
                        p.innerHTML = content;
                        blocksContainer.appendChild(p);
                    }
                }
            });
        } else if (fallbackStory && fallbackStory.trim() !== '') {
            const p = document.createElement('p');
            p.className = 'frame46-block-p';
            p.innerHTML = fallbackStory;
            blocksContainer.appendChild(p);
        } else {
            blocksContainer.innerHTML = '';
        }
    }

    function openProjectModal(meta) {
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        if (titleEl) titleEl.textContent = meta.title || 'PROJECT';
        if (pathEl) pathEl.textContent = meta.pathStr || `ODDS_Project/${meta.title}/Project_Story`;
        if (categoryEl) categoryEl.textContent = meta.category || 'Architecture';
        if (yearEl) yearEl.textContent = meta.year || '2024';
        if (descEl) descEl.textContent = meta.desc || 'Comprehensive project overview, technical architecture, and implementation details.';

        if (clientEl && clientWrapEl) {
            if (meta.client) {
                clientEl.textContent = `Client: ${meta.client}`;
                clientWrapEl.classList.remove('hidden');
            } else {
                clientWrapEl.classList.add('hidden');
            }
        }

        if (roleEl && roleWrapEl) {
            if (meta.role) {
                roleEl.textContent = `Role: ${meta.role}`;
                roleWrapEl.classList.remove('hidden');
            } else {
                roleWrapEl.classList.add('hidden');
            }
        }

        if (primaryMediaEl) {
            if (meta.showcaseVideo) {
                primaryMediaEl.innerHTML = `
                    <video src="${meta.showcaseVideo}" controls playsinline autoplay muted loop class="w-full h-full object-cover"></video>
                `;
            } else if (meta.cover) {
                primaryMediaEl.innerHTML = `<img src="${meta.cover}" alt="${meta.title}" class="w-full h-full object-cover">`;
            } else {
                primaryMediaEl.innerHTML = `
                    <div class="flex flex-col items-center justify-center text-white/40 space-y-3">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                            <circle cx="9" cy="9" r="2"/>
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                        </svg>
                        <span class="font-mono text-xs tracking-wider uppercase">${meta.title} Visual Overview</span>
                    </div>
                `;
            }
        }

        if (linksContainer) {
            linksContainer.innerHTML = '';
            if (meta.demoUrl) {
                linksContainer.innerHTML += `<a href="${meta.demoUrl}" target="_blank" class="frame46-action-btn"><i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>Live Demo</a>`;
            }
            if (meta.githubUrl) {
                linksContainer.innerHTML += `<a href="${meta.githubUrl}" target="_blank" class="frame46-action-btn"><i class="fa-brands fa-github text-[11px]"></i>Repository</a>`;
            }
        }

        renderNotionBlocks(meta.blocks, meta.story);

        modal.scrollTop = 0;
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');

        dialogFocus.open();
    }

    function closeProjectModal() {
        if (!dialogFocus.isTop()) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        dialogFocus.close();
        // Pause any video inside the modal when closed
        const modalVideo = modal.querySelector('video');
        if (modalVideo) {
            modalVideo.pause();
        }
        setTimeout(() => {
            if (!modal.classList.contains('is-active')) {
                modal.classList.add('hidden');
            }
        }, 250);
    }

    // Attach trigger to every project card in works grid
    document.querySelectorAll('.project-card-trigger').forEach(trigger => {
        trigger.tabIndex = 0;
        trigger.setAttribute('role', 'button');
        trigger.setAttribute('aria-haspopup', 'dialog');
        trigger.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); trigger.click(); }
        });
        trigger.addEventListener('click', e => {
            e.stopPropagation();
            const index = trigger.getAttribute('data-project-index');
            let meta = null;

            if (index !== null && projectsData && projectsData[index]) {
                const item = projectsData[index];
                meta = {
                    title: item.title,
                    category: item.category,
                    year: item.year,
                    client: item.client,
                    role: item.role,
                    desc: item.description,
                    blocks: item.body_content,
                    story: item.story_content,
                    cover: item.cover_image,
                    showcaseVideo: item.showcase_video,
                    demoUrl: item.demo_url,
                    githubUrl: item.github_url,
                    pathStr: item.path_str
                };
            } else {
                meta = {
                    title: trigger.getAttribute('data-project-title') || 'PROJECT',
                    category: trigger.getAttribute('data-project-category'),
                    year: trigger.getAttribute('data-project-year'),
                    client: trigger.getAttribute('data-project-client') || '',
                    role: trigger.getAttribute('data-project-role') || '',
                    desc: trigger.getAttribute('data-project-desc'),
                    blocks: trigger.getAttribute('data-project-blocks'),
                    story: trigger.getAttribute('data-project-story'),
                    cover: trigger.getAttribute('data-project-cover'),
                    showcaseVideo: trigger.getAttribute('data-project-video') || trigger.getAttribute('data-project-showcase-video'),
                    demoUrl: trigger.getAttribute('data-project-demo'),
                    githubUrl: trigger.getAttribute('data-project-github'),
                    pathStr: trigger.getAttribute('data-project-path')
                };
            }

            trigger.focus({ preventScroll: true });
            openProjectModal(meta);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', e => {
            e.stopPropagation();
            closeProjectModal();
        });
    }

    modal.addEventListener('click', e => {
        if (modalCard && !modalCard.contains(e.target)) {
            closeProjectModal();
        }
    });

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.classList.contains('is-active') && dialogFocus.isTop()) {
            e.preventDefault();
            e.stopImmediatePropagation();
            closeProjectModal();
        }
    });

    window.openProjectModal = openProjectModal;
    window.closeProjectModal = closeProjectModal;
})();

// ─── Service Detail Modal Controller ────────────────────
(function serviceModalController() {
    const modal = document.getElementById('service-modal');
    if (!modal) return;

    // Teleport modal to document.body so ScrollSmoother transform on #smooth-content does not trap position: fixed
    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    const closeBtn = document.getElementById('service-modal-close-btn');
    const pathEl = document.getElementById('service-modal-path');
    const titleEl = document.getElementById('service-modal-title');
    const taglineEl = document.getElementById('service-modal-tagline');
    const iconWrapEl = document.getElementById('service-modal-icon-wrap');
    const featuresWrapEl = document.getElementById('service-modal-features-wrap');
    const descEl = document.getElementById('service-modal-desc');
    const primaryMediaEl = document.getElementById('service-modal-primary-media');
    const blocksContainer = document.getElementById('service-modal-blocks');
    const linksContainer = document.getElementById('service-modal-links');
    const ctaActionBtn = document.getElementById('service-modal-cta-action');
    const ctaLabelEl = document.getElementById('service-modal-cta-label');
    const modalCard = modal.querySelector('.service-modal-card');
    let serviceOpener = null;
    let previousServiceOverflow = '';
    let previousServicePaused = false;
    let serviceBackground = [];
    const escapeServiceText = value => String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));

    // Parse pre-rendered JSON payload for services
    let servicesData = [];
    const servicesDataScript = document.getElementById('odds-services-data');
    if (servicesDataScript) {
        try {
            servicesData = JSON.parse(servicesDataScript.textContent);
        } catch (e) {
            console.error('Failed to parse odds-services-data:', e);
        }
    }

    function renderNotionBlocks(blocksData, fallbackDesc) {
        if (!blocksContainer) return;
        blocksContainer.innerHTML = '';

        let blocks = [];
        if (Array.isArray(blocksData)) {
            blocks = blocksData;
        } else if (typeof blocksData === 'string' && blocksData.trim() !== '') {
            try {
                let parsed = blocksData;
                if (parsed.includes('&quot;') || parsed.includes('&#039;')) {
                    const txt = document.createElement('textarea');
                    txt.innerHTML = parsed;
                    parsed = txt.value;
                }
                blocks = JSON.parse(parsed);
            } catch (e) {
                blocks = [];
            }
        }

        if (Array.isArray(blocks) && blocks.length > 0) {
            let currentList = null;
            let currentListType = null;

            blocks.forEach(b => {
                const type = b.type || 'paragraph';
                const content = b.content !== undefined ? b.content : '';

                if (currentList && currentListType !== type) {
                    currentList = null;
                    currentListType = null;
                }

                if (type === 'heading2') {
                    const h2 = document.createElement('h2');
                    h2.className = 'frame46-block-h2';
                    h2.innerHTML = content;
                    blocksContainer.appendChild(h2);
                } else if (type === 'heading3') {
                    const h3 = document.createElement('h3');
                    h3.className = 'frame46-block-h3';
                    h3.innerHTML = content;
                    blocksContainer.appendChild(h3);
                } else if (type === 'bullet') {
                    if (!currentList || currentListType !== 'bullet') {
                        currentList = document.createElement('ul');
                        currentList.className = 'frame46-block-bullet-list';
                        blocksContainer.appendChild(currentList);
                        currentListType = 'bullet';
                    }
                    const li = document.createElement('li');
                    li.className = 'frame46-block-bullet-item';
                    li.innerHTML = `<span class="frame46-block-bullet-dot">•</span><div class="flex-1">${content}</div>`;
                    currentList.appendChild(li);
                } else if (type === 'numbered') {
                    if (!currentList || currentListType !== 'numbered') {
                        currentList = document.createElement('ol');
                        currentList.className = 'frame46-block-num-list';
                        blocksContainer.appendChild(currentList);
                        currentListType = 'numbered';
                    }
                    const count = currentList.children.length + 1;
                    const li = document.createElement('li');
                    li.className = 'frame46-block-num-item';
                    li.innerHTML = `<span class="frame46-block-num-badge">${count}.</span><div class="flex-1">${content}</div>`;
                    currentList.appendChild(li);
                } else if (type === 'quote') {
                    const blockquote = document.createElement('blockquote');
                    blockquote.className = 'frame46-block-quote';
                    blockquote.innerHTML = content;
                    blocksContainer.appendChild(blockquote);
                } else if (type === 'callout') {
                    const callout = document.createElement('div');
                    callout.className = 'frame46-block-callout';
                    callout.innerHTML = `
                        <div class="frame46-block-callout-icon"><i class="fa-solid fa-lightbulb"></i></div>
                        <div class="flex-1">${content}</div>
                    `;
                    blocksContainer.appendChild(callout);
                } else if (type === 'code') {
                    const pre = document.createElement('pre');
                    pre.className = 'frame46-block-code';
                    pre.textContent = content;
                    blocksContainer.appendChild(pre);
                } else if (type === 'divider') {
                    const hr = document.createElement('hr');
                    hr.className = 'frame46-block-divider';
                    blocksContainer.appendChild(hr);
                } else if (type === 'image' && b.src) {
                    const card = document.createElement('div');
                    card.className = 'frame46-block-image-card';
                    card.innerHTML = `
                        <div class="frame46-block-image-inner">
                            <img src="${b.src}" alt="${b.caption || 'Service visual'}" loading="lazy">
                        </div>
                        ${b.caption ? `<div class="frame46-block-image-caption">${b.caption}</div>` : ''}
                    `;
                    blocksContainer.appendChild(card);
                } else {
                    if (content.toString().trim() !== '') {
                        const p = document.createElement('p');
                        p.className = 'frame46-block-p';
                        p.innerHTML = content;
                        blocksContainer.appendChild(p);
                    }
                }
            });
        } else if (fallbackDesc && fallbackDesc.trim() !== '') {
            const p = document.createElement('p');
            p.className = 'frame46-block-p';
            p.innerHTML = fallbackDesc;
            blocksContainer.appendChild(p);
        } else {
            blocksContainer.innerHTML = '';
        }
    }

    function openServiceModal(meta) {
        serviceOpener = document.activeElement;
        previousServiceOverflow = document.body.style.overflow;
        previousServicePaused = smoother ? smoother.paused() : false;
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        // Immediately clear carousel selection so the marquee keeps flowing
        clearCarouselSelection();

        if (titleEl) titleEl.textContent = (meta.name || 'SERVICE').replace(/\n/g, ' ');
        if (pathEl) pathEl.textContent = meta.pathStr || `ODDS_Studio/Services/${meta.name}/Overview`;
        if (taglineEl) taglineEl.textContent = meta.tagline || 'Engineering Capability';
        if (descEl) descEl.textContent = meta.desc || 'High-performance engineering and custom software architecture.';

        if (iconWrapEl) {
            if (meta.iconSvg && meta.iconSvg.trim() !== '') {
                iconWrapEl.innerHTML = meta.iconSvg;
                const svgEl = iconWrapEl.querySelector('svg');
                if (svgEl) {
                    svgEl.style.width = '28px';
                    svgEl.style.height = '28px';
                    svgEl.style.stroke = '#875af5';
                }
            } else {
                iconWrapEl.innerHTML = '<i class="fa-solid fa-cube" style="font-size:20px;color:#875af5;"></i>';
            }
        }

        if (featuresWrapEl) {
            featuresWrapEl.innerHTML = '';
            if (Array.isArray(meta.features) && meta.features.length > 0) {
                meta.features.forEach(f => {
                    if (f && f.trim() !== '') {
                        const chip = document.createElement('span');
                        chip.className = 'svc-modal-feature-chip';
                        chip.innerHTML = `<i class="fa-solid fa-check" style="font-size:8px;"></i>${f.trim()}`;
                        featuresWrapEl.appendChild(chip);
                    }
                });
                featuresWrapEl.style.display = 'flex';
            } else {
                featuresWrapEl.style.display = 'none';
            }
        }

        if (primaryMediaEl) {
            if (meta.cover) {
                primaryMediaEl.innerHTML = `<img src="${meta.cover}" alt="${meta.name}" style="width:100%;height:100%;object-fit:cover;">`;
                primaryMediaEl.style.display = 'flex';
            } else {
                primaryMediaEl.innerHTML = '';
                primaryMediaEl.style.display = 'none';
            }
        }

        const actionText = meta.actionBtnText || "Let's Build";
        const actionUrl = meta.actionBtnUrl || '#cta';

        if (ctaActionBtn) {
            ctaActionBtn.setAttribute('href', actionUrl);
            ctaActionBtn.classList.toggle('js-open-contact-modal', actionUrl === '#contact');
            ctaActionBtn.dataset.serviceNeeded = meta.contact || meta.name;
        }
        if (ctaLabelEl) {
            ctaLabelEl.textContent = actionText;
        }

        if (linksContainer) {
            linksContainer.innerHTML = `<a href="${actionUrl}" class="frame46-action-btn service-modal-header-cta ${actionUrl === '#contact' ? 'js-open-contact-modal' : ''}"><i class="fa-solid fa-arrow-right text-[10px]"></i><span>${escapeServiceText(actionText)}</span></a>`;
            const headerCta = linksContainer.querySelector('.service-modal-header-cta');
            if (headerCta) {
                headerCta.dataset.serviceNeeded = meta.contact || meta.name;
                headerCta.addEventListener('click', (e) => {
                    if (actionUrl === '#contact') closeServiceModal();
                    if (actionUrl === '#cta') {
                        e.preventDefault();
                        closeServiceModal();
                        const ctaSec = document.getElementById('cta');
                        if (ctaSec) {
                            ctaSec.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                });
            }
        }

        renderNotionBlocks(meta.blocks, meta.desc);
        if (meta.project && blocksContainer) {
            const related = document.createElement('a');
            related.className = 'service-related-work';
            related.href = '/our-work';
            related.innerHTML = `<small>Related work</small><strong>${escapeServiceText(meta.project)} ↗</strong><p>${escapeServiceText(meta.proof)}</p><span>Explore our work</span>`;
            related.addEventListener('click', closeServiceModal);
            blocksContainer.appendChild(related);
        }

        modal.scrollTop = 0;
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');

        serviceBackground = Array.from(document.body.children)
            .filter(el => el !== modal && !['SCRIPT', 'STYLE', 'LINK'].includes(el.tagName))
            .map(el => [el, el.inert]);
        serviceBackground.forEach(([el]) => { el.inert = true; });
        document.body.style.overflow = 'hidden';
        closeBtn?.focus({ preventScroll: true });

        document.body.classList.add('modal-open');
        // Pause ScrollSmoother so page doesn't scroll behind the modal
        if (smoother) smoother.paused(true);
    }

    function closeServiceModal() {
        if (!modal.classList.contains('is-active')) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        // Resume ScrollSmoother if we're in services mode
        if (smoother) smoother.paused(previousServicePaused);
        document.body.style.overflow = previousServiceOverflow;
        serviceBackground.forEach(([el, inert]) => { el.inert = inert; });
        serviceBackground = [];
        serviceOpener?.focus({ preventScroll: true });

        // Always clear selection state so the marquee animation resumes
        clearCarouselSelection();

        setTimeout(() => {
            if (!modal.classList.contains('is-active')) {
                modal.classList.add('hidden');
            }
        }, 250);
    }

    // Attach trigger to every service card in marquee
    document.querySelectorAll('.service-card-trigger').forEach(trigger => {
        trigger.addEventListener('click', e => {
            e.stopPropagation();
            const index = trigger.getAttribute('data-service-index');
            let meta = null;

            if (index !== null && servicesData && servicesData[index]) {
                const item = servicesData[index];
                meta = {
                    name: item.name,
                    tagline: item.tagline,
                    desc: item.description,
                    iconSvg: item.icon_svg,
                    cover: item.cover_image,
                    features: item.features,
                    blocks: item.body_content,
                    actionBtnText: item.action_btn_text,
                    actionBtnUrl: item.action_btn_url,
                    contact: item.contact,
                    project: item.project,
                    proof: item.proof,
                    pathStr: item.path_str
                };
            } else {
                const iconEl = trigger.querySelector('.svc-icon');
                meta = {
                    name: trigger.getAttribute('data-service-name') || trigger.querySelector('.svc-card-name')?.textContent || 'SERVICE',
                    tagline: trigger.getAttribute('data-service-tagline') || 'Engineering Service',
                    desc: trigger.getAttribute('data-service-desc') || '',
                    iconSvg: iconEl ? iconEl.innerHTML : '',
                    cover: trigger.getAttribute('data-service-cover') || '',
                    features: [],
                    blocks: [],
                    actionBtnText: "Let's Build",
                    actionBtnUrl: '#cta',
                    pathStr: trigger.getAttribute('data-service-path') || 'ODDS_Studio/Services/Overview'
                };
            }

            openServiceModal(meta);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', e => {
            e.stopPropagation();
            closeServiceModal();
        });
    }

    if (ctaActionBtn) {
        ctaActionBtn.addEventListener('click', (e) => {
            const href = ctaActionBtn.getAttribute('href');
            if (href === '#contact') closeServiceModal();
            if (href === '#cta') {
                e.preventDefault();
                closeServiceModal();
                const ctaSec = document.getElementById('cta');
                if (ctaSec) {
                    ctaSec.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    }

    modal.addEventListener('click', e => {
        if (modalCard && !modalCard.contains(e.target)) {
            closeServiceModal();
        }
    });

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.classList.contains('is-active')) {
            closeServiceModal();
        }
        if (e.key === 'Tab' && modal.classList.contains('is-active')) {
            const targets = Array.from(modal.querySelectorAll('a[href], button, input, select, textarea, [tabindex]'))
                .filter(el => !el.disabled && el.tabIndex >= 0 && el.getClientRects().length);
            const first = targets[0], last = targets.at(-1);
            if (first && ((e.shiftKey && document.activeElement === first) || (!e.shiftKey && document.activeElement === last))) {
                e.preventDefault();
                (e.shiftKey ? last : first).focus();
            }
        }
    });

    window.openServiceModal = openServiceModal;
    window.closeServiceModal = closeServiceModal;
})();

// ─── Why Bet on ODDS: Interactive 3D Playing Card Deck & Flip ───
(function initWhyDeckController() {
    const deckWrap = document.getElementById('why-deck-wrap');
    const deck = document.getElementById('why-deck');
    if (!deck) return;

    const cards = Array.from(deck.querySelectorAll('.why-card'));
    const total = cards.length;

    if (total === 0) return;

    function shouldRunPinnedDeal() {
        // Only run horizontal pinning sequence on wide desktop viewports (>= 992px)
        return window.innerWidth >= 992 && cards.length >= 3;
    }

    // ── 3D Playing Card Flip Animation with GSAP ──
    function flipCard(card, targetState = null) {
        const inner = card.querySelector('.why-card-inner');
        if (!inner) return;

        const isCurrentlyFlipped = card.classList.contains('is-flipped');
        const willBeFlipped = targetState !== null ? targetState : !isCurrentlyFlipped;

        if (targetState !== null && willBeFlipped === isCurrentlyFlipped) return;

        if (willBeFlipped) {
            card.classList.add('is-flipped');
            card.setAttribute('aria-expanded', 'true');
        } else {
            card.classList.remove('is-flipped');
            card.setAttribute('aria-expanded', 'false');
        }

        gsap.killTweensOf(inner);

        // Realistic playing card flip: lifts towards user, spins 180deg, lands softly
        const tl = gsap.timeline();
        tl.to(inner, {
            z: 48,
            scale: 1.03,
            duration: 0.22,
            ease: 'power1.out'
        })
        .to(inner, {
            rotationY: willBeFlipped ? 180 : 0,
            duration: 0.58,
            ease: 'power2.inOut'
        }, '<')
        .to(inner, {
            z: 0,
            scale: 1,
            duration: 0.26,
            ease: 'power2.out'
        }, '-=0.18');
    }

    // ── Interactive Hover & Click Behaviors ──
    cards.forEach((card) => {
        const inner = card.querySelector('.why-card-inner');
        if (!inner) return;

        // Subtle 3D tilt following mouse on desktop
        card.addEventListener('mousemove', (e) => {
            if (window.innerWidth < 992 || !window.matchMedia('(hover: hover)').matches) return;
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = ((y - centerY) / centerY) * -5;
            const rotateY = ((x - centerX) / centerX) * 5;

            gsap.to(card, {
                rotationX: rotateX,
                rotationY: rotateY,
                duration: 0.3,
                ease: 'power1.out',
                transformPerspective: 1000
            });
        });

        card.addEventListener('mouseleave', () => {
            if (window.innerWidth < 992 || !window.matchMedia('(hover: hover)').matches) return;
            gsap.to(card, {
                rotationX: 0,
                rotationY: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        // Click or tap to flip card (prevent triggering flip on thumb swipe)
        let ptrDownX = 0;
        let ptrDownY = 0;
        let wasDragging = false;

        card.addEventListener('pointerdown', (e) => {
            ptrDownX = e.clientX;
            ptrDownY = e.clientY;
            wasDragging = false;
        });

        card.addEventListener('pointermove', (e) => {
            if (Math.abs(e.clientX - ptrDownX) > 10 || Math.abs(e.clientY - ptrDownY) > 10) {
                wasDragging = true;
            }
        });

        card.addEventListener('click', (e) => {
            if (wasDragging) {
                wasDragging = false;
                return;
            }
            flipCard(card);
            syncRevealButtonState();
        });

        // Keyboard accessibility
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                flipCard(card);
                syncRevealButtonState();
            }
        });
    });

    // ── Dealer Controls: Shuffle Deck & Flip All ──
    const shuffleBtn = document.getElementById('why-shuffle-btn');
    const revealBtn = document.getElementById('why-reveal-btn');
    const revealLabel = document.getElementById('why-reveal-label');
    let isShuffling = false;

    function syncRevealButtonState() {
        if (!revealBtn || !revealLabel) return;
        const allFlipped = cards.every(c => c.classList.contains('is-flipped'));
        if (allFlipped) {
            revealBtn.classList.add('is-active');
            revealLabel.textContent = 'Flip Back';
        } else {
            revealBtn.classList.remove('is-active');
            revealLabel.textContent = 'Flip All';
        }
    }

    function shuffleDeck() {
        if (isShuffling) return;
        isShuffling = true;
        hasDealtOnce = true;

        if (shuffleBtn) {
            shuffleBtn.disabled = true;
            shuffleBtn.classList.add('is-active');
            const icon = shuffleBtn.querySelector('.why-dealer-icon');
            if (icon) gsap.to(icon, { rotation: '+=360', duration: 0.7, ease: 'power2.inOut' });
        }

        // 1. Flip any face-up cards face-down first
        cards.forEach(card => {
            if (card.classList.contains('is-flipped')) {
                flipCard(card, false);
            }
        });
        syncRevealButtonState();

        const isDesktop = window.innerWidth >= 992;

        if (isDesktop && cards.length >= 3) {
            const card0 = cards[0];
            const card1 = cards[1];
            const card2 = cards[2];

            const tl = gsap.timeline({
                onComplete: () => {
                    isShuffling = false;
                    if (shuffleBtn) {
                        shuffleBtn.disabled = false;
                        shuffleBtn.classList.remove('is-active');
                    }
                    cards.forEach(card => {
                        card.style.zIndex = '';
                    });
                }
            });

            // Phase 1: Pull inward from 3 columns into 1 central stacked deck
            tl.to(card0, { x: 405, y: -6, rotation: -4, zIndex: 10, duration: 0.32, ease: 'power2.inOut' }, 0)
              .to(card1, { x: 0, y: 0, rotation: 0, zIndex: 11, duration: 0.32, ease: 'power2.inOut' }, 0)
              .to(card2, { x: -405, y: 6, rotation: 4, zIndex: 12, duration: 0.32, ease: 'power2.inOut' }, 0);

            // Phase 2: 3D Riffle / Cut split
            tl.to(card0, { x: 330, y: -45, rotationZ: -9, rotationX: 12, duration: 0.22, ease: 'power1.out' }, '+=0.04')
              .to(card2, { x: -330, y: 40, rotationZ: 8, rotationX: -8, duration: 0.22, ease: 'power1.out' }, '<')
              .to(card1, { scale: 1.05, duration: 0.22, ease: 'power1.out' }, '<');

            // Phase 3: Interleave snap back to center stack with new layer order
            tl.to(card0, { x: 405, y: 0, rotationZ: 2, rotationX: 0, zIndex: 13, duration: 0.24, ease: 'back.out(1.4)' }, '+=0.02')
              .to(card2, { x: -405, y: 0, rotationZ: -2, rotationX: 0, zIndex: 11, duration: 0.24, ease: 'back.out(1.4)' }, '<')
              .to(card1, { scale: 1, zIndex: 12, duration: 0.24, ease: 'back.out(1.4)' }, '<');

            // Phase 4: Fan back out into respective columns with crisp landing
            tl.to(card0, { x: 0, y: 0, rotation: 0, duration: 0.46, ease: 'power3.out' }, '+=0.06')
              .to(card1, { x: 0, y: 0, rotation: 0, duration: 0.46, ease: 'power3.out' }, '<+=0.04')
              .to(card2, { x: 0, y: 0, rotation: 0, duration: 0.46, ease: 'power3.out' }, '<+=0.06');

        } else {
            // Mobile: spring lift & card ripple
            const tl = gsap.timeline({
                onComplete: () => {
                    isShuffling = false;
                    if (shuffleBtn) {
                        shuffleBtn.disabled = false;
                        shuffleBtn.classList.remove('is-active');
                    }
                }
            });

            tl.to(cards, {
                y: -18,
                scale: 1.03,
                stagger: 0.08,
                duration: 0.22,
                ease: 'power2.out'
            })
            .to(cards, {
                rotation: (i) => (i % 2 === 0 ? -3 : 3),
                duration: 0.16,
                ease: 'power1.inOut'
            })
            .to(cards, {
                y: 0,
                scale: 1,
                rotation: 0,
                stagger: 0.06,
                duration: 0.32,
                ease: 'elastic.out(1, 0.5)'
            });
        }
    }

    function toggleRevealAll() {
        if (isShuffling) return;
        const allFlipped = cards.every(c => c.classList.contains('is-flipped'));
        const targetState = !allFlipped;

        cards.forEach((card, idx) => {
            setTimeout(() => {
                flipCard(card, targetState);
                if (idx === cards.length - 1) {
                    setTimeout(syncRevealButtonState, 150);
                }
            }, idx * 110);
        });
    }

    if (shuffleBtn) {
        shuffleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            shuffleDeck();
        });
    }

    if (revealBtn) {
        revealBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleRevealAll();
        });
    }

    // ─── ScrollTrigger 4-Frame Playing Card Deal & Horizontal Transition to Process ───
    let dealScrollTrigger = null;
    let dealIntroTrigger = null;
    let pathLength = 3600;
    let horizLen = 1200;
    let yToLengthTable = [];
    let hasDealtOnce = false;
    const SAMPLES_COUNT = 300;

    const PATH_TAIL_D = "L 380 24 C 450 24 472 42 467.332 65.742 C 454.431 127.953 404.689 176.83 342.376 182.085 L 114.38 201.314 C 89.7562 203.391 66.5806 213.818 48.6935 230.868 C -13.312 289.973 14.502 394.256 97.7059 414.631 L 505.918 514.595 C 512.476 516.201 518.697 518.955 524.295 522.729 C 573.667 556.018 545.675 633.188 486.442 627.082 L 127.407 590.071 C 108.352 588.107 89.2368 593.184 73.668 604.345 C 11.7091 648.76 43.1302 746.523 119.364 746.523 H 150.72 C 201.364 746.523 241.681 788.937 239.117 839.515 L 234.832 924.023";

    function calibratePathStartX() {
        const path = document.getElementById('process-line-path');
        const wrapEl = document.querySelector('.process-linepath-wrap');
        const card2 = cards[2] || cards[cards.length - 1];
        if (!path) return { startX: -1200, horizLen: 1580, pathLength: 4000 };

        const winWidth = window.innerWidth;
        const isHorizontalTrack = window.innerWidth >= 992;

        if (!isHorizontalTrack) {
            path.setAttribute('d', `M 467.332 65.742 C 454.431 127.953 404.689 176.83 342.376 182.085 L 114.38 201.314 C 89.7562 203.391 66.5806 213.818 48.6935 230.868 C -13.312 289.973 14.502 394.256 97.7059 414.631 L 505.918 514.595 C 512.476 516.201 518.697 518.955 524.295 522.729 C 573.667 556.018 545.675 633.188 486.442 627.082 L 127.407 590.071 C 108.352 588.107 89.2368 593.184 73.668 604.345 C 11.7091 648.76 43.1302 746.523 119.364 746.523 H 150.72 C 201.364 746.523 241.681 788.937 239.117 839.515 L 234.832 924.023`);
            try {
                pathLength = path.getTotalLength() || 2600;
            } catch (e) {
                pathLength = 2600;
            }
            horizLen = 0;
            path.style.strokeDasharray = `${pathLength} ${pathLength}`;
            return { startX: 467, horizLen: 0, pathLength };
        }

        const wrapWidth = wrapEl ? wrapEl.offsetWidth : Math.min(1100, winWidth);
        let startX = -300;

        const gapVw = 0.6; // 60vw transition space between Why and Process
        const gapPx = winWidth * gapVw;

        if (card2 && wrapEl) {
            // Dynamically calculate Card 2 right edge relative to wrapEl left edge in track space
            const deckEl = document.getElementById('why-deck');
            const deckWidth = deckEl ? deckEl.offsetWidth : Math.min(1195, winWidth);
            const deckLeft = (winWidth - deckWidth) / 2;
            const card2Width = card2.offsetWidth || 385;
            const card2RightInWhy = deckLeft + (card2.offsetLeft || (deckWidth - card2Width)) + card2Width;
            const wrapLeftInTrack = winWidth + gapPx + (winWidth - wrapWidth) / 2;
            const deltaPx = card2RightInWhy - wrapLeftInTrack + 16;
            startX = Math.round((deltaPx / wrapWidth) * 565);
        } else {
            const distancePx = winWidth + gapPx + Math.max(0, (winWidth - wrapWidth) / 2);
            startX = Math.round((-distancePx / wrapWidth) * 565 + 24);
        }

        path.setAttribute('d', `M ${startX} 24 ${PATH_TAIL_D}`);

        try {
            pathLength = path.getTotalLength() || 4000;
        } catch (e) {
            pathLength = 4000;
        }

        horizLen = Math.max(10, 380 - startX);
        path.style.strokeDasharray = `${pathLength} ${pathLength}`;

        return { startX, horizLen, pathLength };
    }

    function buildSampleTable() {
        const path = document.getElementById('process-line-path');
        if (!path) return;

        yToLengthTable = [];
        let maxY = -Infinity;
        const verticalLength = Math.max(10, pathLength - horizLen);

        for (let i = 0; i <= SAMPLES_COUNT; i++) {
            const len = horizLen + (i / SAMPLES_COUNT) * verticalLength;
            try {
                const pt = path.getPointAtLength(len);
                if (pt.y > maxY) maxY = pt.y;
                yToLengthTable.push({ len, y: pt.y, maxSoFar: maxY });
            } catch (e) {}
        }
    }

    function getVerticalLengthForY(targetSvgY) {
        const verticalLen = pathLength - horizLen;
        if (!yToLengthTable.length) return 0;
        if (targetSvgY <= 24) return 0;
        if (targetSvgY >= 925) return verticalLen;

        let bestLen = 0;
        for (let i = 0; i < yToLengthTable.length; i++) {
            if (yToLengthTable[i].y <= targetSvgY) {
                bestLen = yToLengthTable[i].len - horizLen;
            }
        }
        return Math.max(0, Math.min(verticalLen, bestLen));
    }

    function initCardDealScrollTrigger() {
        if (dealScrollTrigger) {
            dealScrollTrigger.kill(true);
            dealScrollTrigger = null;
        }
        if (dealIntroTrigger) {
            dealIntroTrigger.kill(true);
            dealIntroTrigger = null;
        }

        const wrapper = document.getElementById('why-process-wrapper') || document.getElementById('why');
        const track = document.getElementById('why-process-track');
        const whyMain = document.getElementById('why-main-stage');
        const path = document.getElementById('process-line-path');

        if (!shouldRunPinnedDeal()) {
            if (track) gsap.set(track, { clearProps: 'x,transform' });
            if (whyMain) gsap.set(whyMain, { clearProps: 'all' });
            cards.forEach(card => gsap.set(card, { clearProps: 'all' }));
            calibratePathStartX();
            buildSampleTable();
            return;
        }

        if (!wrapper) return;

        const card0 = cards[0];
        const card1 = cards[1];
        const card2 = cards[2];

        const dist = 405;
        const entryOffset = -(Math.max(window.innerWidth, 1400) + 400);

        if (!hasDealtOnce) {
            // Frame 1: Cards start off-screen left and fade in on first scroll approach
            gsap.set(card0, { x: entryOffset, rotation: -6, opacity: 0 });
            gsap.set(card1, { x: entryOffset - dist, rotation: -4, opacity: 0 });
            gsap.set(card2, { x: entryOffset - (dist * 2), rotation: -2, opacity: 0 });

            dealIntroTrigger = ScrollTrigger.create({
                trigger: wrapper,
                start: 'top 82%',
                once: true,
                onEnter: () => {
                    hasDealtOnce = true;
                    const introTL = gsap.timeline();
                    // Stage 1: Slide stacked deck in from left to Column 0 & fade in
                    introTL
                        .to([card0, card1, card2], { opacity: 1, duration: 0.4, ease: 'power2.out' }, 0)
                        .to(card0, { x: 0, rotation: -4, ease: 'power2.out', duration: 0.7 }, 0)
                        .to(card1, { x: -dist, rotation: -2, ease: 'power2.out', duration: 0.7 }, 0)
                        .to(card2, { x: -(dist * 2), rotation: 0, ease: 'power2.out', duration: 0.7 }, 0)
                        // Stage 2: Deal cards across into Columns 1 & 2
                        .to(card0, { rotation: 0, ease: 'power2.out', duration: 0.6 }, '+=0.08')
                        .to(card1, { x: 0, rotation: 0, ease: 'power2.out', duration: 0.75 }, '<')
                        .to(card2, { x: 0, rotation: 0, ease: 'power2.out', duration: 0.9 }, '<+=0.1');
                }
            });
        } else {
            // Once cards have dealt, permanently maintain settled 3-column placement
            gsap.set([card0, card1, card2], { x: 0, y: 0, rotation: 0, opacity: 1 });
        }

        if (track) gsap.set(track, { x: 0 });
        if (whyMain) gsap.set(whyMain, { x: 0, y: 0, opacity: 1, scale: 1 });

        const res = calibratePathStartX();
        buildSampleTable();

        if (path) {
            gsap.set(path, { opacity: 0 });
            path.style.strokeDashoffset = res.pathLength;
        }

        // Pinned Horizontal Scrub: Why -> Process (Direct 1:1 linear scroll without double-smoothing bounce)
        const dealTL = gsap.timeline({
            scrollTrigger: {
                trigger: wrapper,
                start: 'top top',
                end: '+=2000',
                pin: true,
                scrub: true,
                invalidateOnRefresh: true,
                onRefresh: () => {
                    calibratePathStartX();
                    buildSampleTable();
                }
            }
        });

        dealScrollTrigger = dealTL.scrollTrigger;

        // Stage 1: Rest Window for cards exploration at center
        dealTL.to({}, { duration: 0.4 });

        // Stage 2: Why section slides smoothly to the left, through the 60vw space into Process
        if (track) {
            dealTL.to(track, {
                x: '-160vw',
                ease: 'none',
                duration: 2.0
            });
        }

        if (path) {
            dealTL.to(path, {
                opacity: 1,
                duration: 0.08,
                ease: 'none'
            }, '<')
            .to(path, {
                strokeDashoffset: () => pathLength - horizLen,
                ease: 'none',
                duration: 2.0
            }, '<');
        }

        // Stage 3: Short buffer before unpinning cleanly into Process section
        dealTL.to({}, { duration: 0.3 });
    }

    initCardDealScrollTrigger();

    window.__getDealScrollTrigger = () => dealScrollTrigger;
    window.__getPathMetrics = () => ({ pathLength, horizLen, getVerticalLengthForY });

    function updateStack() {
        cards.forEach(card => {
            card.classList.remove('is-active', 'is-next', 'is-back', 'is-hidden');
            card.style.zIndex = '';
            card.style.pointerEvents = '';
        });
    }

    // ── Responsive Scroll Reveal (Mobile & Tablet) ──
    // Ensures cards only show upon scrolling down into the section, NOT already sitting in place
    let responsiveRevealTriggers = [];

    function initResponsiveReveal() {
        if (responsiveRevealTriggers && responsiveRevealTriggers.length) {
            responsiveRevealTriggers.forEach(t => t.kill());
            responsiveRevealTriggers = [];
        }

        if (shouldRunPinnedDeal()) {
            // Wide desktop (>= 992px) is managed by initCardDealScrollTrigger pinned deal
            return;
        }

        if (prefersReducedMotion) {
            cards.forEach(card => gsap.set(card, { opacity: 1, y: 0, scale: 1 }));
            return;
        }

        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            // Mobile (<=768px): Horizontal carousel — cards always visible, no scroll-trigger reveal needed.
            cards.forEach(card => gsap.set(card, { clearProps: 'all' }));
        } else {
            // Tablet (769px - 991px): 3-column grid of cards
            const wrap = document.getElementById('why-deck-wrap') || document.querySelector('.why-deck-wrap');
            if (!wrap) return;

            gsap.set(cards, { opacity: 0, y: 56, scale: 0.94 });

            const st = ScrollTrigger.create({
                trigger: wrap,
                start: 'top 76%',
                once: true,
                onEnter: () => {
                    gsap.to(cards, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.8,
                        stagger: 0.14,
                        ease: 'power3.out',
                        clearProps: 'transform,scale,y,opacity'
                    });
                }
            });
            responsiveRevealTriggers.push(st);
        }
    }

    // ── Mobile Carousel Controller (prev/next arrows + segmented dots) ──
    let carouselCleanup = null;

    function initMobileCarousel() {
        if (carouselCleanup) { carouselCleanup(); carouselCleanup = null; }
        if (window.innerWidth > 768) return;

        const deckEl = document.getElementById('why-deck');
        const pillText = document.getElementById('why-swipe-text');
        const iconLeft = document.getElementById('why-swipe-icon-left');
        const iconRight = document.getElementById('why-swipe-icon-right');
        if (!deckEl) return;

        // Clear any GSAP residual position transforms so slide dimensions and positions are clean
        cards.forEach(card => {
            gsap.killTweensOf(card);
            card.style.transform = '';
            card.style.opacity = '';
        });

        let currentIdx = 0;

        function updateSwipePill(idx) {
            if (!pillText) return;
            if (idx === 0) {
                pillText.textContent = 'Swipe left to see other cards';
                if (iconLeft) iconLeft.style.display = 'none';
                if (iconRight) iconRight.style.display = 'inline-block';
            } else if (idx >= cards.length - 1) {
                pillText.textContent = 'Swipe right to see other cards';
                if (iconLeft) iconLeft.style.display = 'inline-block';
                if (iconRight) iconRight.style.display = 'none';
            } else {
                pillText.textContent = 'Swipe left or right to see other cards';
                if (iconLeft) iconLeft.style.display = 'inline-block';
                if (iconRight) iconRight.style.display = 'inline-block';
            }
        }

        let scrollTimer = null;
        function onScroll() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                const scrollCenter = deckEl.scrollLeft + deckEl.clientWidth / 2;
                let closest = 0;
                let minDiff = Infinity;
                cards.forEach((card, idx) => {
                    const cardCenter = card.offsetLeft + card.offsetWidth / 2;
                    const diff = Math.abs(scrollCenter - cardCenter);
                    if (diff < minDiff) {
                        minDiff = diff;
                        closest = idx;
                    }
                });
                if (closest !== currentIdx) {
                    currentIdx = closest;
                    updateSwipePill(currentIdx);
                }
            }, 50);
        }

        deckEl.addEventListener('scroll', onScroll, { passive: true });

        // Fluid thumb / mouse drag support
        let isPointerDown = false;
        let dragStartX = 0;
        let dragScrollLeft = 0;

        const handlePointerDown = (e) => {
            isPointerDown = true;
            dragStartX = e.pageX || (e.touches && e.touches[0] ? e.touches[0].pageX : 0);
            dragScrollLeft = deckEl.scrollLeft;
            deckEl.style.scrollSnapType = 'none'; // Temporarily disable snap during active drag for fluid thumb movement
        };

        const handlePointerMove = (e) => {
            if (!isPointerDown) return;
            const x = e.pageX || (e.touches && e.touches[0] ? e.touches[0].pageX : 0);
            const walk = (x - dragStartX) * 1.15;
            deckEl.scrollLeft = dragScrollLeft - walk;
        };

        const handlePointerUp = () => {
            if (!isPointerDown) return;
            isPointerDown = false;
            deckEl.style.scrollSnapType = 'x mandatory'; // Re-enable snap when thumb releases
        };

        deckEl.addEventListener('mousedown', handlePointerDown);
        window.addEventListener('mousemove', handlePointerMove);
        window.addEventListener('mouseup', handlePointerUp);

        // Reset to first card and update initial pill state
        currentIdx = 0;
        updateSwipePill(0);
        deckEl.scrollLeft = 0;
        try { deckEl.scrollTo({ left: 0, behavior: 'instant' }); } catch (e) {}

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                deckEl.scrollLeft = 0;
            });
        });
        setTimeout(() => {
            if (currentIdx === 0 && deckEl.scrollLeft !== 0) {
                deckEl.scrollLeft = 0;
            }
        }, 120);

        carouselCleanup = () => {
            deckEl.removeEventListener('scroll', onScroll);
            deckEl.removeEventListener('mousedown', handlePointerDown);
            window.removeEventListener('mousemove', handlePointerMove);
            window.removeEventListener('mouseup', handlePointerUp);
        };
    }

    // Handle viewport resize & device orientation changes smoothly
    let resizeTimer = null;
    function handleViewportChange() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateStack();
            initCardDealScrollTrigger();
            initResponsiveReveal();
            initMobileCarousel();
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
        }, 150);
    }
    window.addEventListener('resize', handleViewportChange);
    window.addEventListener('orientationchange', handleViewportChange);

    // Initialize initial view
    updateStack();
    initResponsiveReveal();
    initMobileCarousel();
})();


// ─── FAQ Accordion Controller ───────────────────────────
(function initFaqAccordion() {
    const accordion = document.getElementById('faq-accordion');
    if (!accordion) return;

    const items = Array.from(accordion.querySelectorAll('.faq-item'));

    function closeItem(item) {
        item.classList.remove('is-open');
        const btn = item.querySelector('.faq-question-btn');
        const collapse = item.querySelector('.faq-answer-collapse');
        if (btn) btn.setAttribute('aria-expanded', 'false');
        if (collapse) collapse.style.maxHeight = null;
    }

    function openItem(item) {
        item.classList.add('is-open');
        const btn = item.querySelector('.faq-question-btn');
        const collapse = item.querySelector('.faq-answer-collapse');
        if (btn) btn.setAttribute('aria-expanded', 'true');
        if (collapse) {
            collapse.style.maxHeight = collapse.scrollHeight + 'px';
        }
    }

    items.forEach((item) => {
        const btn = item.querySelector('.faq-question-btn');
        if (!btn) return;

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = item.classList.contains('is-open');

            // Close all other items for a clean single-open accordion feel
            items.forEach((other) => {
                if (other !== item) closeItem(other);
            });

            // Toggle current item
            if (isOpen) {
                closeItem(item);
            } else {
                openItem(item);
            }
        });
    });

    window.addEventListener('resize', () => {
        const openItemEl = accordion.querySelector('.faq-item.is-open');
        if (openItemEl) {
            const collapse = openItemEl.querySelector('.faq-answer-collapse');
            if (collapse) collapse.style.maxHeight = collapse.scrollHeight + 'px';
        }
    });
})();


// ─── Process Section Line Path Scroll Trail ─────────────
(function initProcessLineTrail() {
    const path = document.getElementById('process-line-path');
    const svgWrap = document.querySelector('.process-linepath-wrap');
    if (!path || !svgWrap) return;

    let targetLengthToDraw = 0;
    let currentLengthToDraw = 0;

    function calcTargetProgress() {
        const feed = document.querySelector('.process-editorial-feed') || svgWrap;
        const processSec = document.getElementById('process') || svgWrap;
        const feedRect = feed.getBoundingClientRect();
        const processRect = processSec.getBoundingClientRect();
        const winHeight = window.innerHeight;

        // The user's active focal viewing eye line in the viewport
        const eyeLineY = winHeight * 0.5;

        // The process section starts at processRect.top and finishes when Phase 03 is in view
        const processStart = processRect.top + (winHeight * 0.2);
        const feedEnd = feedRect.bottom - (winHeight * 0.35);
        const totalDist = Math.max(1, feedEnd - processStart);

        // Progress from 0.0 (entering Process) to 1.0 (Phase 3)
        const scrollProgress = Math.max(0, Math.min(1, (eyeLineY - processStart) / totalDist));
        const targetSvgY = 24 + scrollProgress * (925 - 24);

        const dealST = window.__getDealScrollTrigger ? window.__getDealScrollTrigger() : null;
        const metrics = window.__getPathMetrics ? window.__getPathMetrics() : { pathLength: 3600, horizLen: 1200, getVerticalLengthForY: () => 0 };
        const { pathLength, horizLen, getVerticalLengthForY } = metrics;

        if (dealST && dealST.isActive) {
            // GSAP dealTL is actively scrubbing during Why pin
            const curOffset = parseFloat(path.style.strokeDashoffset);
            if (!isNaN(curOffset)) {
                currentLengthToDraw = pathLength - curOffset;
            }
            return;
        }

        if (dealST && dealST.progress >= 1) {
            // Pinned transition completed -> user scrolling down through Process
            path.style.opacity = '1';
            const extra = getVerticalLengthForY(targetSvgY);
            targetLengthToDraw = horizLen + extra;
        } else if (dealST && dealST.progress <= 0) {
            // Above Why section
            path.style.opacity = '0';
            targetLengthToDraw = 0;
        } else if (!dealST) {
            // Mobile or tablet fallback (vertical layout)
            const processSec = document.getElementById('process');
            if (processSec) {
                const pRect = processSec.getBoundingClientRect();
                const inView = pRect.top < winHeight && pRect.bottom > 0;
                path.style.opacity = inView ? '1' : '0';
            } else {
                path.style.opacity = '1';
            }
            targetLengthToDraw = horizLen + getVerticalLengthForY(targetSvgY);
        }
    }

    function loop() {
        calcTargetProgress();

        const dealST = window.__getDealScrollTrigger ? window.__getDealScrollTrigger() : null;
        const metrics = window.__getPathMetrics ? window.__getPathMetrics() : { pathLength: 3600 };
        const pathLen = metrics.pathLength || 3600;

        if (!dealST || !dealST.isActive) {
            currentLengthToDraw += (targetLengthToDraw - currentLengthToDraw) * 0.15;
            if (Math.abs(targetLengthToDraw - currentLengthToDraw) < 0.5) {
                currentLengthToDraw = targetLengthToDraw;
            }
            const offset = Math.max(0, Math.min(pathLen, pathLen - currentLengthToDraw));
            path.style.strokeDashoffset = offset;
        }

        requestAnimationFrame(loop);
    }

    window.addEventListener('scroll', calcTargetProgress, { passive: true });
    window.addEventListener('resize', () => {
        calcTargetProgress();
    });

    if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.addEventListener('refresh', () => {
            calcTargetProgress();
        });
    }

    requestAnimationFrame(loop);
})();


// ═══════════════════════════════════════════════════════
//  SITE-WIDE TEXT ANIMATION SYSTEM (OFFICIAL GSAP PLUGINS)
//  Rule 1: Heading Reveal (SplitText, word-level stagger)
//  Rule 2: Reserved Scramble Effect (ScrambleTextPlugin)
//  Rule 3: Single Draw-In Highlight Per Page (DrawSVGPlugin)
// ═══════════════════════════════════════════════════════

// ─── Rule 1: Site-Wide Heading Reveal ──────────────────
function initHeadingReveals() {
    // 1. Hero Headline (Special Case: Plays on load rather than scroll)
    const heroH1 = document.getElementById('hero-h1');
    if (heroH1) {
        if (prefersReducedMotion) {
            gsap.set(heroH1, { opacity: 1, y: 0 });
        } else {
            const heroSplit = new SplitText(heroH1, { type: 'words', wordsClass: 'split-word' });
            gsap.fromTo(heroSplit.words,
                { opacity: 0, y: 18 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.52,
                    ease: 'power3.out',
                    stagger: 0.05,
                    delay: 0.1
                }
            );
        }
    }

    // 2. All Major Section Headings Across The Site (Hero & Services are managed by cyber blade stage)
    const headingSelectors = [
        '.who-we-are-heading',
        '.why-title',
        '.works-heading',
        '.testi-title',
        '.process-title',
        '.faq-title',
        '.about-massive-headline',
        '.our-work-closing-title'
    ];

    const headings = document.querySelectorAll(headingSelectors.join(', '));
    headings.forEach(heading => {
        // Skip hero & services headings if selected (their animation is managed by the stage transition)
        if (heading.id === 'hero-h1' || heading.classList.contains('hero-title') || heading.classList.contains('services-title') || heading.closest('#hero') || heading.closest('#services')) return;

        if (prefersReducedMotion) {
            gsap.set(heading, { opacity: 1, y: 0 });
            return;
        }

        const split = new SplitText(heading, { type: 'words', wordsClass: 'split-word' });

        gsap.fromTo(split.words,
            { opacity: 0, y: 20 },
            {
                opacity: 1,
                y: 0,
                duration: 0.52,
                ease: 'power3.out',
                stagger: 0.045,
                scrollTrigger: {
                    trigger: heading,
                    start: 'top 85%',
                    once: true
                }
            }
        );
    });
}

// ─── Rule 2: Reserved Scramble Effect for Metrics ONLY ───
function initScrambleCounters() {
    const statsRows = document.querySelectorAll('#stats-row, .works-stats-row');
    statsRows.forEach(row => {
        let statsFired = false;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !statsFired) {
                    statsFired = true;
                    const statEls = row.querySelectorAll('[data-target]');
                    statEls.forEach((el, i) => {
                        const rawTarget = el.dataset.target ?? '0';
                        const suffix = el.dataset.suffix ?? '';
                        const isFloat = rawTarget.includes('.');
                        const targetFormatted = (isFloat ? parseFloat(rawTarget).toFixed(1) : rawTarget) + suffix;

                        if (prefersReducedMotion) {
                            el.textContent = targetFormatted;
                            return;
                        }

                        gsap.to(el, {
                            duration: 1.15,
                            scrambleText: {
                                text: targetFormatted,
                                chars: '0123456789!#$*+-~',
                                speed: 0.45,
                                revealDelay: 0.12 + (i * 0.08)
                            },
                            ease: 'power2.out'
                        });
                    });
                }
            });
        }, { threshold: 0.2 });
        observer.observe(row);
    });
}

// ─── Rule 3: Single Draw-In Highlight Per Page ─────────
function initDrawHighlights() {
    const paths = document.querySelectorAll('.draw-highlight-svg path');
    paths.forEach(path => {
        if (prefersReducedMotion) {
            gsap.set(path, { drawSVG: '100%' });
            return;
        }

        gsap.set(path, { drawSVG: '0%' });
        gsap.to(path, {
            drawSVG: '100%',
            duration: 0.95,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: path.closest('.draw-highlight-wrap') || path,
                start: 'top 85%',
                once: true
            }
        });
    });
}

// ─── Initialize Site-Wide Animations ───────────────────
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initHeadingReveals();
        initScrambleCounters();
        initDrawHighlights();
        initConsoleEasterEgg();
    });
} else {
    initHeadingReveals();
    initScrambleCounters();
    initDrawHighlights();
    initConsoleEasterEgg();
}

// ─── DevTools Console Easter Egg ──────────────────────
function initConsoleEasterEgg() {
    const ascii = [
        "  ██████╗  ██████╗  ██████╗  ███████╗",
        " ██╔═══██╗ ██╔══██╗ ██╔══██╗ ██╔════╝",
        " ██║   ██║ ██║  ██║ ██║  ██║ ███████╗",
        " ██║   ██║ ██║  ██║ ██║  ██║ ╚════██║",
        " ╚██████╔╝ ██████╔╝ ██████╔╝ ███████║",
        "  ╚═════╝  ╚═════╝  ╚═════╝  ╚══════╝"
    ].join('\n');

    const purpleStyle = 'color: #a855f7; font-family: monospace; font-size: 13px; font-weight: 800; line-height: 1.15; white-space: pre;';
    const bodyStyle = 'color: #94a3b8; font-family: sans-serif; font-size: 12px; line-height: 1.6; margin-top: 6px;';
    const cmdStyle = 'color: #38bdf8; font-family: monospace; font-weight: 700; font-size: 12px;';
    const descStyle = 'color: #cbd5e1; font-family: sans-serif; font-size: 12px;';

    console.log(`%c\n${ascii}\n`, purpleStyle);
    console.log(
        '%cInspecting our code? We like you already.\nWe build what your business actually runs on — no jargon, pure velocity.\n\nType any command below:',
        bodyStyle
    );
    console.log('%codds.roster()%c  -> Inspect the 8 operators & dossiers', cmdStyle, descStyle);
    console.log('%codds.quote()%c   -> Open direct scoping channel', cmdStyle, descStyle);
    console.log('%codds.secret()%c  -> Why does Jherald have no photos?', cmdStyle, descStyle);
    console.log('%codds.coffee()%c  -> Fuel the dev team with espresso', cmdStyle, descStyle);
    console.log('%codds.stack()%c   -> View our core engineering stack', cmdStyle, descStyle);
    console.log('%codds.help()%c    -> Show this command manual again\n', cmdStyle, descStyle);

    let coffeeCount = 142;

    window.odds = {
        roster: () => {
            console.log('%cTHE ODDS ROSTER (8 OPERATORS):', 'color: #a855f7; font-weight: 800; font-size: 13px;');
            console.table([
                { Name: 'Jerico Sanchez', Role: 'Co-Founder / Software Dev', Handle: '3c0-exe', Quip: 'asleep or yearning.. probably both' },
                { Name: 'Jherald Vibar', Role: 'Co-Founder / Database Dev', Handle: 'Jherald-Vibar', Quip: 'the most technical person really has no photos' },
                { Name: 'Robert Santiago', Role: 'Developer / Hardware Specialist', Handle: 'Robert-1hash', Quip: 'might break a couple of PCBs, but gets the job done' },
                { Name: 'Brix Jorie Cura', Role: 'Co-Founder, Lead Designer / CMO', Handle: 'ixDev018', Quip: "i-jira natin 'to" },
                { Name: 'Jazam Laranio', Role: 'Developer / Lead Gen Specialist', Handle: '—', Quip: 'hates commuting' },
                { Name: 'Mark Paulo Franco', Role: 'Developer / Field Logistics', Handle: 'itsFrancss619', Quip: 'cocoooo!' },
                { Name: 'John Cedric Abaloyan', Role: 'Lead Developer', Handle: 'Ggwepq', Quip: 'performative (based on the matcha pic)' },
                { Name: 'Sherwin Ramirez', Role: 'QA Specialist / Web Developer', Handle: 'sheerwiiin', Quip: 'wanted to have the same shirt as jerico' }
            ]);
            return '8 operators stand ready to build your systems.';
        },
        quote: () => {
            const btn = document.querySelector('.js-open-contact-modal, [data-open-contact]');
            if (btn) {
                btn.click();
                return "Direct studio channel opened. Let's talk scope.";
            } else {
                window.location.href = '#contact';
                return 'Redirecting to contact...';
            }
        },
        secret: () => {
            console.log(
                '%c[CLASSIFIED DOSSIER: JHERALD VIBAR]\n%cStatus: ENCRYPTED // 404 FACE NOT FOUND\nReason: "the most technical person really has no photos."\nLegend says camera lenses shatter when aimed in his direction.\nHis true avatar exists only in compiled binary.',
                'color: #f43f5e; font-weight: 800; font-size: 13px; font-family: monospace;',
                'color: #cbd5e1; font-size: 12px; font-family: monospace;'
            );
            return 'Dossier sealed by ODDS Security.';
        },
        coffee: () => {
            coffeeCount++;
            console.log(`%cCoffee Count: ${coffeeCount} cups served`, 'color: #f59e0b; font-weight: 800; font-size: 13px;');
            console.log('%cBrix is currently designing at 400 WPM. Jerico just refactored another backend microservice.', 'color: #94a3b8; font-size: 12px;');
            return 'Caffeine level: MAXIMUM.';
        },
        stack: () => {
            console.log('%cTHE ODDS CORE STACK:', 'color: #a855f7; font-weight: 800; font-size: 13px;');
            console.log('  * Frontend: Modern Vanilla JS, GSAP ScrollSmoother, Tailwind, Blade');
            console.log('  * Backend: Laravel 11, PHP 8.3, RESTful APIs, Queues');
            console.log('  * Systems: Embedded C++, IoT Hardware, Custom Cloud Infra');
            console.log('  * Rule: If it breaks in production, it was never finished.');
            return 'Battle-tested stack loaded.';
        },
        help: () => {
            console.log('%codds.roster()%c  -> Inspect the 8 operators & dossiers', cmdStyle, descStyle);
            console.log('%codds.quote()%c   -> Open direct scoping channel', cmdStyle, descStyle);
            console.log('%codds.secret()%c  -> Why does Jherald have no photos?', cmdStyle, descStyle);
            console.log('%codds.coffee()%c  -> Fuel the dev team with espresso', cmdStyle, descStyle);
            console.log('%codds.stack()%c   -> View our core engineering stack', cmdStyle, descStyle);
            return 'Available commands listed above.';
        }
    };
}

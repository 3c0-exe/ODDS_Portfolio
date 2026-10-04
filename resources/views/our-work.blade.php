<x-layout>
@push('styles')
<style>
    /* test */
    /* ─── STANDALONE OUR WORK PAGE THEME OVERRIDES ─── */
    body:has(.our-work-universe) .navbar {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.07) !important;
        color: #111111 !important;
    }
    body:has(.our-work-universe) .navbar .nav-logo {
        color: #111111 !important;
    }
    body:has(.our-work-universe) .navbar .nav-links a {
        color: rgba(17, 17, 17, 0.7) !important;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.2s ease;
    }
    body:has(.our-work-universe) .navbar .nav-links a:hover,
    body:has(.our-work-universe) .navbar .nav-links a.active {
        color: #f359b0 !important;
    }
    body:has(.our-work-universe) .navbar .btn-nav {
        background: #111111 !important;
        color: #ffffff !important;
    }
    body:has(.our-work-universe) .navbar .btn-nav:hover {
        background: #f359b0 !important;
        color: #ffffff !important;
    }
    body:has(.our-work-universe) .nav-toggle .hamburger-bar {
        background-color: #111111 !important;
    }

    /* ─── STANDALONE WORK PAGE LAYOUT ─── */
    .our-work-universe {
        min-height: 100vh;
        width: 100%;
        background: radial-gradient(ellipse 55% 70% at 0% 40%, rgba(185, 155, 235, 0.45) 0%, transparent 100%),
                    radial-gradient(ellipse 55% 70% at 100% 40%, rgba(185, 155, 235, 0.45) 0%, transparent 100%),
                    #ffffff;
        padding-top: calc(var(--nav-height, 72px) + 32px);
        padding-bottom: 96px;
        font-family: var(--font-primary), sans-serif;
        overflow-x: hidden;
    }

    .our-work-universe .works-content-wrap {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ─── CINEMATIC SHOWCASE CAROUSEL STYLES ─── */
    .showcase-carousel-section {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-top: 48px;
        overflow: hidden;
    }

    .showcase-stage-viewport {
        position: relative;
        width: 100%;
        overflow: hidden;
        padding: 20px 0 10px;
    }

    .showcase-stage-track {
        display: flex;
        align-items: center;
        transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }

    .showcase-stage-slide {
        flex: 0 0 auto;
        width: clamp(320px, 72vw, 1020px);
        height: clamp(320px, 42vw, 550px);
        margin-right: clamp(16px, 2.5vw, 36px);
        position: relative;
        border-radius: 26px;
        background: radial-gradient(120% 120% at 50% 10%, #1a1a24 0%, #0c0c11 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.35);
        overflow: hidden;
        cursor: pointer;
        user-select: none;
        transition: transform 0.55s cubic-bezier(0.2, 0.8, 0.2, 1),
                    opacity 0.55s ease,
                    filter 0.55s ease,
                    box-shadow 0.55s ease;
    }

    .showcase-stage-slide.is-active {
        transform: scale(1);
        opacity: 1;
        filter: none;
        z-index: 10;
        cursor: pointer;
        box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.16);
    }

    .showcase-stage-slide.is-peeking {
        transform: scale(0.91);
        opacity: 0.45;
        filter: brightness(0.85) grayscale(25%);
        z-index: 5;
        cursor: pointer;
    }

    .showcase-stage-slide.is-peeking:hover {
        opacity: 0.72;
        transform: scale(0.93);
        filter: brightness(0.95) grayscale(10%);
    }

    .showcase-stage-slide.is-distant {
        transform: scale(0.82);
        opacity: 0.12;
        pointer-events: none;
    }

    /* Ambient stage lighting & grid watermark */
    .stage-ambient-glow {
        position: absolute;
        inset: 0;
        background: radial-gradient(60% 60% at 50% 50%, rgba(135, 90, 245, 0.12) 0%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }

    .stage-grid-watermark {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        opacity: 0.6;
        z-index: 1;
    }

    /* Stage Canvas Area */
    .stage-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px;
        z-index: 2;
    }

    /* Stage Split Layout with Text Excerpt (Fix 1) */
    .stage-inner-split {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 3;
    }

    .stage-media-col {
        flex: 1 1 60%;
        min-width: 0;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .stage-excerpt-col {
        flex: 0 0 38%;
        max-width: 360px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 4;
    }

    .stage-excerpt-box {
        background: rgba(255, 255, 255, 0.035);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        padding: 24px 26px;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.35);
        transition: transform 0.4s ease, border-color 0.4s ease;
    }

    .showcase-stage-slide.is-active:hover .stage-excerpt-box {
        border-color: rgba(135, 90, 245, 0.3);
        background: rgba(255, 255, 255, 0.05);
    }

    .stage-excerpt-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--font-mono);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #875af5;
        margin-bottom: 12px;
    }

    .stage-excerpt-text {
        font-family: var(--font-primary), sans-serif;
        font-size: clamp(13px, 1.1vw, 15px);
        line-height: 1.68;
        color: rgba(243, 244, 246, 0.85);
        margin: 0;
        font-weight: 400;
        letter-spacing: -0.01em;
    }

    /* 1. Video Artifact */
    .stage-video-box {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: #000;
    }

    .stage-video-el {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .stage-media-pill {
        position: absolute;
        top: 14px;
        left: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(14, 14, 18, 0.78);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 9999px;
        font-family: var(--font-mono);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #f3f3f6;
        z-index: 5;
    }

    .stage-pulse-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #875af5;
        box-shadow: 0 0 8px #875af5;
        animation: pulseDot 1.8s infinite;
    }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.6; }
    }

    /* 2. Scattered Collage Artifacts */
    .stage-collage-box {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .stage-collage-item {
        position: absolute;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 22px 55px rgba(0, 0, 0, 0.48);
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: #14141c;
        transform-origin: center center;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .stage-collage-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Organic scattered positions for 1 to 4 images */
    .stage-collage-item.pos-1 {
        width: 58%;
        max-width: 540px;
        aspect-ratio: 16/10;
        top: 10%;
        left: 6%;
        z-index: 2;
        transform: rotate(-2.2deg);
    }

    .stage-collage-item.pos-2 {
        width: 52%;
        max-width: 480px;
        aspect-ratio: 16/10;
        bottom: 10%;
        right: 6%;
        z-index: 3;
        transform: rotate(2.4deg);
    }

    .stage-collage-item.pos-3 {
        width: 42%;
        max-width: 380px;
        aspect-ratio: 16/10;
        top: 22%;
        right: 28%;
        z-index: 4;
        transform: rotate(-1.2deg);
    }

    .stage-collage-item.pos-4 {
        width: 36%;
        max-width: 320px;
        aspect-ratio: 16/10;
        bottom: 18%;
        left: 26%;
        z-index: 5;
        transform: rotate(1.5deg);
    }

    /* 3. Single Centered Cover Image Artifact */
    .stage-single-box {
        position: relative;
        width: 90%;
        max-width: 860px;
        aspect-ratio: 16/9.5;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 26px 65px rgba(0, 0, 0, 0.48);
        border: 1px solid rgba(255, 255, 255, 0.14);
        transform: rotate(-0.5deg);
        background: #15151e;
        transition: transform 0.4s ease;
    }

    .stage-single-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* 4. Placeholder Fallback */
    .stage-placeholder-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        width: 90%;
        max-width: 860px;
        aspect-ratio: 16/9.5;
        border-radius: 18px;
        border: 1px dashed rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.02);
    }

    /* Floating Hover Explore Pill on Active Stage */
    .stage-hover-pill {
        position: absolute;
        bottom: 24px;
        right: 24px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        background: rgba(255, 255, 255, 0.95);
        color: #111111;
        border-radius: 9999px;
        font-family: var(--font-mono);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.25s ease;
        z-index: 10;
        pointer-events: none;
    }

    .showcase-stage-slide.is-active:hover .stage-hover-pill {
        opacity: 1;
        transform: translateY(0);
    }

    /* ─── CONTROLS & CAPTION BAR BELOW STAGE ─── */
    .showcase-controls-bar {
        max-width: clamp(320px, 72vw, 1020px);
        margin: 24px auto 0;
        padding: 0 6px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
    }

    .showcase-meta-col {
        flex: 1 1 0;
        min-width: 0;
    }

    .showcase-title {
        font-size: clamp(28px, 3.2vw, 42px);
        font-weight: 800;
        color: #111111;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin: 0;
    }

    .showcase-subtitle {
        font-size: clamp(14px, 1.2vw, 16px);
        color: #6b7280;
        font-style: italic;
        font-weight: 500;
        margin-top: 6px;
        line-height: 1.5;
    }

    .showcase-story-trigger {
        margin-top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 9999px;
        background: #111111;
        color: #ffffff;
        font-family: var(--font-mono);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .showcase-story-trigger:hover {
        background: #875af5;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(135, 90, 245, 0.25);
    }

    .showcase-story-trigger:active {
        transform: scale(0.96);
    }

    /* Nav Arrows & Counter Group */
    .showcase-nav-group {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .showcase-counter {
        font-family: var(--font-mono);
        font-size: 14px;
        font-weight: 700;
        color: #111111;
        letter-spacing: 0.05em;
        user-select: none;
    }

    .showcase-arrow-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.12);
        color: #111111;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .showcase-arrow-btn:hover {
        background: #111111;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .showcase-arrow-btn:active {
        transform: scale(0.92);
    }

    /* ─── Calmer Closing Section ─── */
    .our-work-closing {
        text-align: center;
        max-width: 600px;
        margin: 64px auto 0 auto;
        padding: 0 20px;
    }

    .our-work-closing-title {
        font-size: clamp(26px, 3.5vw, 38px);
        font-weight: 800;
        color: #111111;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin-bottom: 12px;
    }

    .our-work-closing-desc {
        font-size: 15px;
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 28px;
    }

    /* ─── MOBILE RESPONSIVE LAYOUT (<= 768px) ─── */
    @media (max-width: 768px) {
        .showcase-carousel-section {
            width: 100%;
            left: 0;
            right: 0;
            margin-left: 0;
            margin-right: 0;
            margin-top: 32px;
            padding: 0 16px;
        }

        .showcase-stage-viewport {
            padding: 8px 0;
        }

        .showcase-stage-slide {
            width: 100% !important;
            height: 260px !important;
            margin-right: 0 !important;
            border-radius: 20px;
            transform: none !important;
            opacity: 1 !important;
            filter: none !important;
        }

        .stage-canvas {
            padding: 12px;
        }

        /* Mobile Layout for Stage Split */
        .stage-inner-split {
            flex-direction: column;
            gap: 0;
        }

        .stage-media-col {
            width: 100% !important;
            height: 100% !important;
            position: absolute !important;
            inset: 0 !important;
        }

        .stage-excerpt-col {
            display: none !important;
        }

        /* Simplified Single Primary Artifact on Mobile */
        .stage-collage-box .stage-collage-item:not(:first-child) {
            display: none !important;
        }

        .stage-collage-box .stage-collage-item:first-child {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            transform: none !important;
            border-radius: 14px !important;
        }

        .stage-single-box {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            transform: none !important;
            border-radius: 14px !important;
        }

        .stage-hover-pill {
            display: none !important;
        }

        .showcase-controls-bar {
            max-width: 100%;
            flex-direction: column;
            gap: 16px;
            margin-top: 18px;
            padding: 0 4px;
        }

        .showcase-nav-group {
            width: 100%;
            justify-content: space-between;
        }

        .showcase-title {
            font-size: 26px;
        }

        .showcase-subtitle {
            font-size: 13px;
        }
    }
</style>
@endpush

@php
$workItems = isset($works) && count($works) > 0 ? $works : collect([
    (object)['id' => 1, 'title' => 'Liberty',      'category' => 'Web & CMS',          'year' => '2023', 'client' => 'Liberty Investigation & Security Agency Inc.', 'role' => 'Full-Stack Web & Client Portal',          'description' => 'High-trust corporate portal and guard dispatch management platform for a licensed corporate security and private investigation firm.',             'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 2, 'title' => 'SPCC Website', 'category' => 'Web Development',    'year' => '2023', 'client' => 'Systems Plus Computer College',               'role' => 'Institutional Web & Admissions Architecture', 'description' => 'High-throughput institutional web portal and academic admissions gateway for multi-campus enrollment and student services.',            'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 3, 'title' => 'AVONIC',       'category' => 'Hardware & IoT',     'year' => '2023', 'client' => 'Agricultural R&D',                            'role' => 'Embedded Firmware & IoT Telemetry',          'description' => 'Embedded IoT telemetry station monitoring vermicompost ecology through real-time soil moisture, gas emissions, and microclimate telemetry.',   'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 4, 'title' => 'MoneySense',   'category' => 'Mobile App',         'year' => '2022', 'client' => 'Accessibility & Assistive Tech',              'role' => 'Mobile App & Edge Neural Vision',            'description' => 'Offline-first assistive mobile app leveraging edge computer vision to scan, identify, and audibly announce Philippine banknotes and coins.',      'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 5, 'title' => 'SIBOL',        'category' => 'IoT & AgriTech',     'year' => '2023', 'client' => 'Smart Agriculture Initiative',               'role' => 'IoT Platform & Automated Irrigation',        'description' => 'Solar-powered smart farming platform delivering soil hydrology analytics, ambient weather tracking, and automated irrigation control.',           'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 6, 'title' => 'THEODORE',     'category' => 'Security & Vision',  'year' => '2024', 'client' => 'Industrial Safety & Facilities',              'role' => 'Computer Vision & Edge AI Surveillance',     'description' => 'Intelligent CCTV surveillance layer with edge-accelerated smoke and flame detection, automated PTZ tracking, and emergency broadcast dispatch.',     'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 7, 'title' => 'HALLET',       'category' => 'Mobile App',         'year' => '2023', 'client' => 'Personal FinTech',                           'role' => 'Mobile App Architecture & Data Security',    'description' => 'Sovereign personal finance companion featuring encrypted multi-wallet balances, categorised cash-flow analytics, and offline-first budget forecasting.', 'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 8, 'title' => 'LITIKS',       'category' => 'Analytics Platform', 'year' => '2024', 'client' => 'Retail Enterprise SaaS',                     'role' => 'Cloud Analytics & Ingestion Pipeline',        'description' => 'Enterprise SaaS platform unifying POS transaction streams across multi-branch retail chains into predictive sales forecasts and cohort heatmaps.',            'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
    (object)['id' => 9, 'title' => 'TRYSEN',       'category' => 'Security & Systems', 'year' => '2024', 'client' => 'Campus & Corporate Security',                 'role' => 'Biometric Firmware & Access Systems',         'description' => 'Contactless facial recognition turnstile and attendance gate terminal featuring anti-spoofing liveness detection and tamper-evident audit logs.',        'cover_image' => null, 'cover_image_url' => null, 'showcase_video' => null, 'showcase_video_url' => null, 'gallery_images' => null, 'demo_url' => '', 'github_url' => '', 'story_content' => '', 'body_content' => []],
]);

$accomplishedCount = isset($works) && $works->count() > 0 ? $works->count() : count($workItems);

// Always start from the first slide (index 0); JS handles infinite wrap-around
$totalSlides = count($workItems);
$startIndex  = 0;

$startingItem = $workItems->get($startIndex) ?: $workItems->first();
@endphp

<div class="our-work-universe">
    <div class="works-content-wrap">

        {{-- Section label --}}
        <p class="works-section-label animate-fade-up fade-up">Our Works</p>

        {{-- Main heading --}}
        <h1 class="works-heading animate-fade-up fade-up">
            <span class="works-heading-lead">Every System We Build.</span><br>
            <span class="works-heading-deliver draw-highlight-wrap">We Deliver.<svg class="draw-highlight-svg" viewBox="0 0 160 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M 2 10 C 40 2, 80 11, 158 4" stroke="#f359b0" stroke-width="3" stroke-linecap="round" vector-effect="non-scaling-stroke"/></svg></span>
        </h1>



        {{-- Description --}}
        <p class="works-description animate-fade-up fade-up">
            Real-world solutions, custom-engineered for rapid deployment and measurable business impact. Explore the complete catalog of systems we've shipped across software, hardware, cloud, and interactive platforms.
        </p>

    </div>

    {{-- Cinematic Showcase Carousel Section --}}
    <section class="showcase-carousel-section" id="showcase-carousel-section" aria-label="Our Work Cinematic Showcase">
        <div class="showcase-stage-viewport" id="showcase-viewport">
            <div class="showcase-stage-track" id="showcase-track" data-start-index="{{ $startIndex }}">
                @foreach($workItems as $index => $item)
                @php
                    $itemTitle = data_get($item, 'title', 'Project');
                    $itemCategory = data_get($item, 'category', 'Software Architecture');
                    $itemYear = data_get($item, 'year', '2024');
                    $itemClient = data_get($item, 'client', '');
                    $itemRole = data_get($item, 'role', '');
                    $itemDesc = data_get($item, 'description', '');
                    $coverSrc = data_get($item, 'cover_image_url') ?: data_get($item, 'cover_image');
                    $videoSrc = data_get($item, 'showcase_video_url') ?: data_get($item, 'showcase_video');
                    $galleryImages = data_get($item, 'gallery_images');
                    if (is_string($galleryImages)) {
                        $decoded = json_decode($galleryImages, true);
                        $galleryImages = is_array($decoded) ? $decoded : null;
                    }
                    $itemId = data_get($item, 'id', $index + 1);

                    // Project context excerpt for stage cards: prioritize distinct description
                    $itemExcerpt = data_get($item, 'description', '');
                    if (empty($itemExcerpt)) {
                        $rawBlocks = data_get($item, 'body_content', []);
                        if (is_string($rawBlocks)) {
                            $decoded = json_decode($rawBlocks, true);
                            $rawBlocks = is_array($decoded) ? $decoded : [];
                        }
                        if (is_array($rawBlocks) && count($rawBlocks) > 0) {
                            foreach ($rawBlocks as $block) {
                                if (($block['type'] ?? '') === 'paragraph') {
                                    $rawText = trim(html_entity_decode(strip_tags($block['content'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                                    $rawText = trim(str_replace("\xc2\xa0", ' ', $rawText));
                                    if (!empty($rawText)) {
                                        $itemExcerpt = \Illuminate\Support\Str::words($rawText, 35, '...');
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    // Fix 2: Initial active / peeking class assignment based on $startIndex
                    $isInitialActive = ($index === $startIndex);
                    $isInitialNext = ($index === ($startIndex + 1) % $totalSlides);
                    $isInitialPrev = ($index === ($startIndex - 1 + $totalSlides) % $totalSlides);
                    $initialClass = $isInitialActive ? 'is-active' : ($isInitialNext ? 'is-peeking is-next' : ($isInitialPrev ? 'is-peeking is-prev' : 'is-distant'));
                @endphp

                <div class="showcase-stage-slide {{ $initialClass }}"
                     data-slide-index="{{ $index }}"
                     data-project-id="{{ $itemId }}"
                     role="button"
                     tabindex="0"
                     aria-label="View {{ $itemTitle }} project details">

                    {{-- Atmospheric Canvas Backdrops --}}
                    <div class="stage-ambient-glow" aria-hidden="true"></div>
                    <div class="stage-grid-watermark" aria-hidden="true"></div>

                    {{-- Stage Visual & Text Canvas Area --}}
                    <div class="stage-canvas">
                        @if(!empty($itemExcerpt))
                            {{-- Side-by-side Split: Visual Artifact + Text Excerpt (Fix 1) --}}
                            <div class="stage-inner-split">
                                <div class="stage-media-col">
                                    @if(!empty($videoSrc))
                                        {{-- Priority 1: Showcase Video --}}
                                        <div class="stage-artifact stage-video-box">
                                            <video class="stage-video-el" muted loop playsinline autoplay preload="metadata">
                                                <source src="{{ $videoSrc }}" type="video/mp4">
                                            </video>
                                            <div class="stage-media-pill">
                                                <span class="stage-pulse-dot"></span>
                                                <span>SHOWCASE CLIP</span>
                                            </div>
                                        </div>
                                    @elseif(is_array($galleryImages) && count($galleryImages) > 0)
                                        {{-- Priority 2: Scattered Collage Gallery Images --}}
                                        <div class="stage-artifact stage-collage-box">
                                            @foreach(array_slice($galleryImages, 0, 4) as $gIdx => $gImg)
                                                <div class="stage-artifact stage-collage-item pos-{{ $gIdx + 1 }}">
                                                    <img src="{{ $gImg }}" alt="{{ $itemTitle }} artifact {{ $gIdx + 1 }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif(!empty($coverSrc))
                                        {{-- Priority 3: Centered Cover Image Artifact --}}
                                        <div class="stage-artifact stage-single-box">
                                            <img src="{{ $coverSrc }}" alt="{{ $itemTitle }}">
                                        </div>
                                    @else
                                        {{-- Fallback: Monogram --}}
                                        <div class="stage-artifact stage-placeholder-box">
                                            <div class="w-12 h-12 rounded-full bg-[#1c1c28] flex items-center justify-center text-[#875af5]">
                                                <i class="fa-solid fa-layer-group text-lg"></i>
                                            </div>
                                            <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">{{ $itemTitle }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="stage-excerpt-col">
                                    <div class="stage-artifact stage-excerpt-box">
                                        <div class="stage-excerpt-tag">
                                            <i class="fa-solid fa-code-commit text-[10px] text-[#875af5]"></i>
                                            <span>PROJECT CONTEXT</span>
                                        </div>
                                        <p class="stage-excerpt-text">{{ $itemExcerpt }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Visual Artifact Only (Fallback when no story/body content exists) --}}
                            @if(!empty($videoSrc))
                                <div class="stage-artifact stage-video-box">
                                    <video class="stage-video-el" muted loop playsinline autoplay preload="metadata">
                                        <source src="{{ $videoSrc }}" type="video/mp4">
                                    </video>
                                    <div class="stage-media-pill">
                                        <span class="stage-pulse-dot"></span>
                                        <span>SHOWCASE CLIP</span>
                                    </div>
                                </div>
                            @elseif(is_array($galleryImages) && count($galleryImages) > 0)
                                <div class="stage-artifact stage-collage-box">
                                    @foreach(array_slice($galleryImages, 0, 4) as $gIdx => $gImg)
                                        <div class="stage-artifact stage-collage-item pos-{{ $gIdx + 1 }}">
                                            <img src="{{ $gImg }}" alt="{{ $itemTitle }} artifact {{ $gIdx + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(!empty($coverSrc))
                                <div class="stage-artifact stage-single-box">
                                    <img src="{{ $coverSrc }}" alt="{{ $itemTitle }}">
                                </div>
                            @else
                                <div class="stage-artifact stage-placeholder-box">
                                    <div class="w-12 h-12 rounded-full bg-[#1c1c28] flex items-center justify-center text-[#875af5]">
                                        <i class="fa-solid fa-layer-group text-lg"></i>
                                    </div>
                                    <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">{{ $itemTitle }}</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Hover Pill Affordance --}}
                    <div class="stage-hover-pill">
                        <span>View Project Story</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- Below-Stage Metadata & Circular Navigation Controls (Fix 2: Uses $startingItem on load) --}}
        <div class="showcase-controls-bar">
            <div class="showcase-meta-col">
                <h2 class="showcase-title" id="showcase-title-display">{{ data_get($startingItem, 'title', 'Project') }}</h2>
                <p class="showcase-subtitle" id="showcase-subtitle-display">
                    {{ data_get($startingItem, 'category', 'Software Architecture') }} • {{ data_get($startingItem, 'year', '2024') }}
                    @if(!empty(data_get($startingItem, 'description')))
                        — {{ data_get($startingItem, 'description') }}
                    @endif
                </p>
                <button type="button" class="showcase-story-trigger" id="showcase-story-btn">
                    <span>View Full Story</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
            </div>

            <div class="showcase-nav-group">
                <button type="button" class="showcase-arrow-btn showcase-arrow-prev" id="showcase-prev-btn" aria-label="Previous project">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>

                <button type="button" class="showcase-arrow-btn showcase-arrow-next" id="showcase-next-btn" aria-label="Next project">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Calmer Closing Block --}}
        <div class="our-work-closing animate-fade-up fade-up">
            <h2 class="our-work-closing-title">Want to see yours here?</h2>
            <p class="our-work-closing-desc">
                Tell us what you're facing. Whether you need a focused module or a full end-to-end architecture, our engineering team executes with velocity.
            </p>
            <a href="#contact" class="works-see-more js-open-contact-modal" data-open-contact>
                Let's Build
            </a>
        </div>
    </section>
</div>

{{-- High-fidelity JSON Data Payload for Modal Stories --}}
<script type="application/json" id="odds-projects-data">
{!! json_encode($workItems->map(function($item, $idx) {
    $rawBlocks = data_get($item, 'body_content', []);
    if (is_string($rawBlocks)) {
        $decoded = json_decode($rawBlocks, true);
        $rawBlocks = is_array($decoded) ? $decoded : [];
    }
    $itemTitle = data_get($item, 'title', 'ODDS Project');
    return [
        'id' => data_get($item, 'id', $idx + 1),
        'title' => $itemTitle,
        'category' => data_get($item, 'category', 'Software Architecture'),
        'year' => data_get($item, 'year', '2024'),
        'client' => data_get($item, 'client', ''),
        'role' => data_get($item, 'role', ''),
        'description' => data_get($item, 'description', ''),
        'story_content' => data_get($item, 'story_content', ''),
        'body_content' => $rawBlocks,
        'cover_image' => data_get($item, 'cover_image_url') ?: data_get($item, 'cover_image', ''),
        'showcase_video' => data_get($item, 'showcase_video_url') ?: data_get($item, 'showcase_video', ''),
        'demo_url' => data_get($item, 'demo_url', ''),
        'github_url' => data_get($item, 'github_url', ''),
        'path_str' => 'ODDS_Project/' . \Illuminate\Support\Str::studly($itemTitle) . '/Project_Story',
    ];
})->values()) !!}
</script>

{{-- Project Detail Modal --}}
@include('components.project-modal')

{{-- Odds Studio Signature Footer --}}
<x-footer :settings="$settings" />

{{-- Lorenzo AI Chat Widget --}}
<x-odds-chat-widget />

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('showcase-track');
    const viewport = document.getElementById('showcase-viewport');
    if (!track || !viewport) return;

    const slides = Array.from(track.querySelectorAll('.showcase-stage-slide'));
    const prevBtn = document.getElementById('showcase-prev-btn');
    const nextBtn = document.getElementById('showcase-next-btn');
    const titleEl = document.getElementById('showcase-title-display');
    const subtitleEl = document.getElementById('showcase-subtitle-display');
    const storyBtn = document.getElementById('showcase-story-btn');
    const currIdxEl = document.getElementById('showcase-current-idx');
    const totalIdxEl = document.getElementById('showcase-total-idx');

    const rawDataEl = document.getElementById('odds-projects-data');
    let projectsData = [];
    if (rawDataEl) {
        try {
            projectsData = JSON.parse(rawDataEl.textContent);
        } catch(e) {
            projectsData = [];
        }
    }

    const totalSlides = slides.length;
    if (totalSlides === 0) return;

    // Fix 2: Initialize activeIndex from server-computed start index
    const startIndexAttr = parseInt(track.dataset.startIndex ?? '0', 10);
    let activeIndex = isNaN(startIndexAttr) ? 0 : startIndexAttr;
    let isAnimating = false;

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function updateTrackPosition(animate = true) {
        if (isMobile()) {
            track.style.transform = `translateX(-${activeIndex * 100}%)`;
            return;
        }

        const activeSlide = slides[activeIndex];
        if (!activeSlide) return;

        const viewportWidth = viewport.offsetWidth || window.innerWidth;
        const slideWidth = activeSlide.offsetWidth;
        const slideGap = 36;
        const offset = (viewportWidth / 2) - (slideWidth / 2) - (activeIndex * (slideWidth + slideGap));

        if (!animate) {
            track.style.transition = 'none';
            track.style.transform = `translateX(${offset}px)`;
            void track.offsetWidth; // force reflow so next transition re-enables cleanly
            track.style.transition = '';
        } else {
            track.style.transform = `translateX(${offset}px)`;
        }
    }

    // Infinite boundary wrap: move last slide to left of first (or first to right of last)
    // so peek slots are never empty. Uses instant CSS transform (no slide-level transition).
    let _boundaryWrappedIdx = null;
    function applyBoundaryWrap() {
        if (isMobile() || totalSlides <= 2) return;

        // Clear previous wrap instantly (slide is distant / off-screen at this point)
        if (_boundaryWrappedIdx !== null) {
            const prev = slides[_boundaryWrappedIdx];
            if (prev) {
                prev.style.transition = 'none';
                prev.style.transform = '';
                void prev.offsetWidth;
                prev.style.transition = '';
            }
            _boundaryWrappedIdx = null;
        }

        const slideWidth = slides[0].offsetWidth;
        const fullWidth  = slideWidth + 36; // slideGap

        if (activeIndex === 0) {
            // Last slide peeks on the LEFT of first
            const wrap = slides[totalSlides - 1];
            wrap.style.transition = 'none';
            wrap.style.transform  = `translateX(-${totalSlides * fullWidth}px)`;
            void wrap.offsetWidth;
            wrap.style.transition = '';
            _boundaryWrappedIdx = totalSlides - 1;
        } else if (activeIndex === totalSlides - 1) {
            // First slide peeks on the RIGHT of last
            const wrap = slides[0];
            wrap.style.transition = 'none';
            wrap.style.transform  = `translateX(${totalSlides * fullWidth}px)`;
            void wrap.offsetWidth;
            wrap.style.transition = '';
            _boundaryWrappedIdx = 0;
        }
    }

    function updateSlideStates(triggerStagger = true) {
        const mobile = isMobile();

        slides.forEach((slide, idx) => {
            slide.classList.remove('is-active', 'is-peeking', 'is-prev', 'is-next', 'is-distant');

            if (idx === activeIndex) {
                slide.classList.add('is-active');
            } else if (!mobile && idx === (activeIndex - 1 + totalSlides) % totalSlides) {
                slide.classList.add('is-peeking', 'is-prev');
            } else if (!mobile && idx === (activeIndex + 1) % totalSlides) {
                slide.classList.add('is-peeking', 'is-next');
            } else {
                slide.classList.add('is-distant');
            }

            // Video management: only play video on active slide
            const video = slide.querySelector('video');
            if (video) {
                if (idx === activeIndex) {
                    video.play().catch(() => {});
                } else {
                    video.pause();
                    video.currentTime = 0;
                }
            }
        });

        // Apply infinite boundary wrapping after classes are set
        applyBoundaryWrap();

        // Update Metadata
        const currData = projectsData[activeIndex] || {};
        const title = currData.title || (slides[activeIndex] ? slides[activeIndex].getAttribute('aria-label') : 'Project');
        const category = currData.category || 'Software Architecture';
        const year = currData.year || '2024';
        const desc = currData.description ? ` — ${currData.description}` : '';

        if (titleEl) titleEl.textContent = title;
        if (subtitleEl) subtitleEl.textContent = `${category} • ${year}${desc}`;
        // counter elements removed — no-op if null
        if (currIdxEl) currIdxEl.textContent = String(activeIndex + 1).padStart(2, '0');
        if (totalIdxEl) totalIdxEl.textContent = String(totalSlides).padStart(2, '0');

        // GSAP Artifact Assembly Stagger Animation
        if (triggerStagger) {
            const activeSlide = slides[activeIndex];
            if (activeSlide) {
                const artifacts = activeSlide.querySelectorAll('.stage-artifact');
                if (window.gsap && artifacts.length > 0) {
                    window.gsap.fromTo(artifacts, 
                        { scale: 0.84, opacity: 0, y: 14 },
                        { scale: 1, opacity: 1, y: 0, duration: 0.52, ease: 'power3.out', stagger: 0.06, overwrite: 'auto' }
                    );
                }
            }
        }
    }

    function goToSlide(index) {
        if (index === activeIndex && !isAnimating) return;
        const prevIndex = activeIndex;
        activeIndex = (index + totalSlides) % totalSlides;

        const isBoundary = !isMobile() && totalSlides > 2 &&
            ((prevIndex === 0 && activeIndex === totalSlides - 1) ||
             (prevIndex === totalSlides - 1 && activeIndex === 0));

        if (isBoundary) {
            // ── Smooth infinite boundary transition ──────────────────────────
            const slideWidth = slides[0].offsetWidth;
            const fullWidth  = slideWidth + 36;
            const viewportWidth = viewport.offsetWidth || window.innerWidth;
            const wrapOffset = totalSlides * fullWidth;

            // Direction: +1 = last→first (track moves left), -1 = first→last (track moves right)
            const goingForward = (prevIndex === totalSlides - 1); // TRYSEN → Liberty
            const wrapSign = goingForward ? 1 : -1;

            // Target track offset: center new activeSlide at its WRAPPED visual position
            //   last→first: Liberty is at +wrapOffset → target = vw/2 - sw/2 - wrapOffset
            //   first→last: TRYSEN is at -wrapOffset + (N-1)*full → visual -fullWidth → target = vw/2 - sw/2 + fullWidth
            const targetOffset = goingForward
                ? (viewportWidth / 2) - (slideWidth / 2) - wrapOffset
                : (viewportWidth / 2) - (slideWidth / 2) + fullWidth;

            // Secondary peek: the slide adjacent to the primary on the SAME side needs the same wrap.
            //   last→first: slide[1] (SPCC Website) wraps RIGHT (+wrapOffset)
            //   first→last: slide[N-2] (HALLET) wraps LEFT (-wrapOffset)
            const secondaryIdx  = goingForward ? 1 : (totalSlides - 2);
            const secondarySlide = slides[secondaryIdx];
            if (secondarySlide) {
                secondarySlide.style.transition = 'none';
                secondarySlide.style.transform  = `translateX(${wrapSign * wrapOffset}px)`;
                void secondarySlide.offsetWidth;
                secondarySlide.style.transition = '';
            }

            // Update slide classes (keep current primary wrap during animation)
            const mob = isMobile();
            slides.forEach((slide, idx) => {
                slide.classList.remove('is-active', 'is-peeking', 'is-prev', 'is-next', 'is-distant');
                if (idx === activeIndex) {
                    slide.classList.add('is-active');
                } else if (!mob && idx === (activeIndex - 1 + totalSlides) % totalSlides) {
                    slide.classList.add('is-peeking', 'is-prev');
                } else if (!mob && idx === (activeIndex + 1) % totalSlides) {
                    slide.classList.add('is-peeking', 'is-next');
                } else {
                    slide.classList.add('is-distant');
                }
            });

            // Animate track toward the wrapped position
            track.style.transform = `translateX(${targetOffset}px)`;

            // Update metadata immediately
            const currData = projectsData[activeIndex] || {};
            if (titleEl) titleEl.textContent = currData.title || '';
            if (subtitleEl) {
                const d = currData.description ? ` — ${currData.description}` : '';
                subtitleEl.textContent = `${currData.category || ''} • ${currData.year || ''}${d}`;
            }

            // After CSS transition: silent snap to natural layout
            setTimeout(() => {
                // 1. Clear secondary wrap
                if (secondarySlide) {
                    secondarySlide.style.transition = 'none';
                    secondarySlide.style.transform  = '';
                    void secondarySlide.offsetWidth;
                    secondarySlide.style.transition = '';
                }

                // 2. Clear primary wrap
                if (_boundaryWrappedIdx !== null) {
                    const ws = slides[_boundaryWrappedIdx];
                    if (ws) {
                        ws.style.transition = 'none';
                        ws.style.transform  = '';
                        void ws.offsetWidth;
                        ws.style.transition = '';
                    }
                    _boundaryWrappedIdx = null;
                }

                // 3. Snap track to natural position (no animation)
                const naturalOffset = (viewportWidth / 2) - (slideWidth / 2) - (activeIndex * fullWidth);
                track.style.transition = 'none';
                track.style.transform  = `translateX(${naturalOffset}px)`;
                void track.offsetWidth;
                track.style.transition = '';

                // 4. Apply boundary wrap for the NEW active slide
                applyBoundaryWrap();

                // 5. GSAP artifact entrance
                const activeSlide = slides[activeIndex];
                if (activeSlide && window.gsap) {
                    const artifacts = activeSlide.querySelectorAll('.stage-artifact');
                    if (artifacts.length > 0) {
                        window.gsap.fromTo(artifacts,
                            { scale: 0.84, opacity: 0, y: 14 },
                            { scale: 1, opacity: 1, y: 0, duration: 0.52, ease: 'power3.out', stagger: 0.06, overwrite: 'auto' }
                        );
                    }
                }
            }, 700);

        } else {
            // ── Normal (non-boundary) transition ─────────────────────────────
            updateTrackPosition(true);
            updateSlideStates(true);
        }
    }


    function openModalForCurrent() {
        const item = projectsData[activeIndex];
        if (item && window.openProjectModal) {
            storyBtn?.focus({ preventScroll: true });
            window.openProjectModal({
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
            });
        }
    }

    // Navigation Arrow Listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            goToSlide(activeIndex - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            goToSlide(activeIndex + 1);
        });
    }

    // Click on slide handling
    slides.forEach((slide, idx) => {
        slide.addEventListener('click', (e) => {
            if (slide.classList.contains('is-active')) {
                openModalForCurrent();
            } else if (slide.classList.contains('is-peeking')) {
                e.stopPropagation();
                goToSlide(idx);
            }
        });
    });

    // Story Trigger Button Click
    if (storyBtn) {
        storyBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            openModalForCurrent();
        });
    }

    // Keyboard Arrow Navigation
    window.addEventListener('keydown', (e) => {
        const targetTag = e.target.tagName;
        if (targetTag === 'INPUT' || targetTag === 'TEXTAREA' || targetTag === 'SELECT' || e.target.isContentEditable) {
            return;
        }

        const modal = document.getElementById('project-modal');
        if (modal && modal.classList.contains('is-active')) return;

        if (e.key === 'ArrowLeft') {
            goToSlide(activeIndex - 1);
        } else if (e.key === 'ArrowRight') {
            goToSlide(activeIndex + 1);
        }
    });

    // Touch Swipe Gesture for Mobile
    let touchStartX = 0;
    let touchStartY = 0;
    let touchDeltaX = 0;
    let touchDeltaY = 0;

    viewport.addEventListener('touchstart', (e) => {
        if (!e.touches || e.touches.length === 0) return;
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
        touchDeltaX = 0;
        touchDeltaY = 0;
    }, { passive: true });

    viewport.addEventListener('touchmove', (e) => {
        if (!e.touches || e.touches.length === 0) return;
        touchDeltaX = e.touches[0].clientX - touchStartX;
        touchDeltaY = e.touches[0].clientY - touchStartY;
    }, { passive: true });

    viewport.addEventListener('touchend', () => {
        if (Math.abs(touchDeltaX) > 40 && Math.abs(touchDeltaX) > Math.abs(touchDeltaY)) {
            if (touchDeltaX < 0) {
                goToSlide(activeIndex + 1);
            } else {
                goToSlide(activeIndex - 1);
            }
        }
    });

    // Window Resize Handler
    let resizeTimer = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateTrackPosition(false);
            updateSlideStates(false);
        }, 80);
    });

    // Initial Layout Setup with Server Starting Index Sync
    setTimeout(() => {
        updateTrackPosition(false);
        updateSlideStates(true);
    }, 40);
});
</script>
@endpush

</x-layout>

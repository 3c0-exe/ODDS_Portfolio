<x-layout>
@php
    // The founder story supersedes these original seeded chapters.
    // Keep CMS records intact and continue showing other authored chapters.
    $sections = $sections->reject(fn ($section) => in_array($section->slug, [
        'the-bet-we-made',
        'we-never-picked-a-specialty',
        'we-didnt-start-here',
    ], true))->values();
@endphp
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Newsreader:ital,opsz,wght@0,6..72,400..700;1,6..72,400..700&family=Pirata+One&family=UnifrakturMaguntia&family=JetBrains+Mono:wght@500;600;700;800&display=swap" rel="stylesheet">
@endpush

<style>
    /* ─── ABOUT PAGE: ROOT THEME OVERRIDES ─── */
    /* Note: overflow is managed by #smooth-wrapper (ScrollSmoother).
       Do NOT set overflow: visible on html/body — it breaks smooth scroll. */
    html:has(.odds-about-universe),
    body:has(.odds-about-universe) {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }

    /* ─── NAVBAR OVERRIDES FOR ABOUT PAGE ─── */
    body:has(.odds-about-universe) .navbar {
        background: rgba(255, 255, 255, 0.94) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.85) !important;
        color: #0f172a !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
    }
    body:has(.odds-about-universe) .navbar .nav-logo {
        color: #0f172a !important;
    }
    body:has(.odds-about-universe) .navbar .nav-links a {
        color: #475569 !important;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.2s ease;
    }
    body:has(.odds-about-universe) .navbar .nav-links a:hover,
    body:has(.odds-about-universe) .navbar .nav-links a.active {
        color: #7039ec !important;
    }
    body:has(.odds-about-universe) .navbar .btn-nav {
        background: #0f172a !important;
        color: #ffffff !important;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    body:has(.odds-about-universe) .navbar .btn-nav:hover {
        background: #7039ec !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(112, 57, 236, 0.25);
    }
    body:has(.odds-about-universe) .nav-toggle .hamburger-bar {
        background-color: #0f172a !important;
    }
    @media (max-width: 768px) {
        body:has(.odds-about-universe) .nav-inner {
            padding: 0 20px !important;
        }
    }

    /* ─── ABOUT PAGE WRAPPER ─── */
    .odds-about-universe {
        min-height: 100vh;
        background: #f8fafc;
        color: #334155;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        padding-top: 6.5rem;
        padding-bottom: 5rem;
        width: 100%;
        max-width: 100vw;
        overflow-x: clip !important;
        box-sizing: border-box;
    }

    @media (max-width: 640px) {
        .odds-about-universe {
            padding-top: 5.5rem;
            padding-bottom: 3.5rem;
        }
        .about-massive-headline {
            font-size: clamp(1.85rem, 8.5vw, 2.5rem);
            word-break: break-word;
            overflow-wrap: break-word;
        }
    }

    /* Ambient Hero Glow & Tech Matrix in isolated overflow container */
    .about-ambient-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 500px;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }

    .about-ambient-glow {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 1000px;
        height: 480px;
        background: radial-gradient(circle at 50% 10%, rgba(112, 57, 236, 0.07) 0%, rgba(243, 89, 176, 0.03) 40%, transparent 70%);
    }

    .about-tech-matrix {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 500px;
        background-image: 
            linear-gradient(to right, rgba(15, 23, 42, 0.025) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(15, 23, 42, 0.025) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse at 50% 20%, black 35%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse at 50% 20%, black 35%, transparent 75%);
    }

    /* ─── TYPOGRAPHIC ONE-LINER HERO: AGAINST ALL ODDS ─── */
    .about-headline-hero {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 1040px;
        margin: 0 auto 2.5rem auto;
        padding: 0 1.25rem;
        width: 100%;
        box-sizing: border-box;
    }

    .header-cont {
        margin: 45px 0;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .about-eyebrow-nav {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        margin-bottom: 1rem;
    }

    .about-eyebrow-nav .eyebrow-accent {
        color: #7039ec;
    }

    .about-eyebrow-nav .eyebrow-divider {
        color: #cbd5e1;
    }

    .about-massive-headline {
        font-size: clamp(2.5rem, 6.8vw, 5.2rem);
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: -0.04em;
        text-transform: uppercase;
        color: #0f172a;
        margin-bottom: 1.15rem;
        word-break: break-word;
    }

    .headline-outline-text {
        -webkit-text-stroke: 2px #0f172a;
        color: transparent;
        transition: all 0.3s ease;
    }

    .headline-gradient-text {
        background: linear-gradient(135deg, #7039ec 0%, #a855f7 50%, #ec4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .about-headline-subtext {
        font-size: clamp(0.95rem, 1.8vw, 1.125rem);
        line-height: 1.7;
        color: #475569;
        max-width: 680px;
        margin: 0 auto 1.85rem auto;
        font-weight: 400;
    }

    /* Meta Filter Ribbon */
    .about-editorial-meta-strip {
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 1.25rem 2rem;
        padding: 0.65rem 1.6rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        color: #64748b;
        max-width: 100%;
    }

    @media (max-width: 640px) {
        .about-editorial-meta-strip {
            border-radius: 1.15rem;
            padding: 0.75rem 1rem;
            gap: 0.65rem 1rem;
        }
    }

    .meta-strip-item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .meta-strip-item strong {
        color: #0f172a;
        font-weight: 800;
    }

    .meta-strip-sep {
        color: #cbd5e1;
    }

    @media (max-width: 640px) {
        .meta-strip-sep {
            display: none;
        }
    }

    /* ─── MAIN CONTENT TWO-COLUMN LAYOUT ─── */
    .about-content-layout {
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
        max-width: 1280px;
        margin: 2.5rem auto 0 auto;
        padding: 0 1.25rem;
        width: 100%;
        box-sizing: border-box;
    }

    @media (min-width: 1024px) {
        .about-content-layout {
            flex-direction: row;
            align-items: flex-start;
            gap: 3.5rem;
            padding: 0 2rem;
        }
    }

    /* ─── LEFT SIDEBAR (STICKY NAVIGATION) ─── */
    .about-sidebar-column {
        display: none;
    }

    @media (min-width: 1024px) {
        .about-sidebar-column {
            display: block;
            width: 340px;
            flex-shrink: 0;
            position: relative;
            z-index: 20;
            align-self: flex-start;
        }
    }

    .about-sidebar-sticky {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
    }

    .sidebar-toc-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.35rem;
        padding: 1.35rem 1.5rem;
        box-shadow: 0 4px 24px -4px rgba(15, 23, 42, 0.04);
    }

    .sidebar-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 0.85rem;
        margin-bottom: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .sidebar-label {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.725rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-label-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #7039ec;
        box-shadow: 0 0 8px rgba(112, 57, 236, 0.6);
    }

    .sidebar-count-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        background: #f5f3ff;
        color: #7039ec;
        padding: 0.15rem 0.55rem;
        border-radius: 9999px;
        border: 1px solid #ede9fe;
    }

    .toc-nav-list {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .toc-link-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0.85rem;
        border-radius: 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        position: relative;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .toc-link-item:hover {
        color: #0f172a;
        background: #f8fafc;
        transform: translateX(3px);
    }

    .toc-link-item.active {
        color: #7039ec;
        background: #f5f3ff;
        font-weight: 700;
    }

    .toc-link-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 25%;
        bottom: 25%;
        width: 3.5px;
        background: #7039ec;
        border-radius: 0 4px 4px 0;
    }

    .toc-chapter-num {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        transition: color 0.2s;
    }

    .toc-link-item.active .toc-chapter-num {
        color: #7039ec;
    }

    /* Sidebar Command / Deploy Card */
    .sidebar-deploy-card {
        background: linear-gradient(145deg, #090d16 0%, #131b2e 100%);
        border: 1px solid #1e293b;
        border-radius: 1.35rem;
        padding: 1.35rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 30px -8px rgba(15, 23, 42, 0.25);
    }

    .sidebar-deploy-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(112, 57, 236, 0.4) 0%, transparent 70%);
        pointer-events: none;
    }

    .deploy-card-tag {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.68rem;
        font-weight: 700;
        color: #c084fc;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.5rem;
    }

    .deploy-card-title {
        font-size: 0.9rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.35rem;
        letter-spacing: -0.01em;
    }

    .deploy-card-p {
        font-size: 0.775rem;
        line-height: 1.5;
        color: #94a3b8;
        margin-bottom: 1rem;
    }

    .deploy-card-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.65rem 1rem;
        background: #ffffff;
        color: #0f172a;
        border-radius: 0.75rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
    }

    .deploy-card-btn:hover {
        background: #f5f3ff;
        color: #7039ec;
        transform: translateY(-1px);
    }

    /* ─── MOBILE CHAPTER SELECTOR ─── */
    .mobile-chapter-selector {
        margin-bottom: 2rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        padding: 0.85rem 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        width: 100%;
        box-sizing: border-box;
    }

    .mobile-selector-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.6rem;
    }

    .mobile-selector-title {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
    }

    .mobile-chip-scroll {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0.25rem;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }
    .mobile-chip-scroll::-webkit-scrollbar {
        display: none;
    }

    .mobile-chip {
        white-space: nowrap;
        padding: 0.5rem 0.9rem;
        border-radius: 0.65rem;
        font-size: 0.825rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .mobile-chip.active,
    .mobile-chip:hover {
        background: #f5f3ff;
        border-color: #d8b4fe;
        color: #7039ec;
    }

    /* ─── RIGHT COLUMN: EDITORIAL CHAPTER CARDS ─── */
    .about-articles-feed {
        display: flex;
        flex-direction: column;
        gap: 3rem;
        width: 100%;
        flex: 1;
        min-width: 0;
    }

    .chapter-article-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.75rem;
        padding: 3rem 3.25rem;
        position: relative;
        box-shadow: 0 10px 35px -10px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02);
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
        scroll-margin-top: 6.5rem;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        overflow: hidden;
    }

    .chapter-article-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 18px 48px -12px rgba(15, 23, 42, 0.08);
    }

    @media (max-width: 768px) {
        .chapter-article-card {
            padding: 1.75rem 1.25rem;
            border-radius: 1.25rem;
        }
    }

    /* Chapter Top Meta Header */
    .chapter-card-topbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding-bottom: 1.35rem;
        margin-bottom: 1.75rem;
        border-bottom: 1px solid #f1f5f9;
        width: 100%;
    }

    .chapter-badge-wrap {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .chapter-index-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 800;
        background: #0f172a;
        color: #ffffff;
        padding: 0.25rem 0.65rem;
        border-radius: 0.5rem;
        letter-spacing: 0.05em;
    }

    .chapter-category-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        background: #f5f3ff;
        color: #7039ec;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid #ede9fe;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .chapter-meta-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.775rem;
        color: #64748b;
    }

    .chapter-author-tag {
        color: #1e293b;
        font-weight: 700;
    }

    /* Chapter Title & Subtitle */
    .chapter-main-title {
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 900;
        color: #0f172a;
        line-height: 1.18;
        letter-spacing: -0.03em;
        margin-bottom: 0.85rem;
        word-break: break-word;
    }

    .chapter-deck-subtitle {
        font-size: 1.05rem;
        line-height: 1.75;
        color: #475569;
        font-weight: 400;
        margin-bottom: 2.25rem;
        padding-bottom: 1.75rem;
        border-bottom: 1px solid #f1f5f9;
        word-break: break-word;
    }

    /* 16:9 Cover Image */
    .chapter-cover-box {
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        aspect-ratio: 16 / 9;
        width: 100%;
        margin-bottom: 2.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .chapter-cover-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ─── STRUCTURED NOTION BLOCKS (EDITORIAL GRADE) ─── */
    .blog-stream-body {
        font-size: 1.025rem;
        line-height: 1.85;
        color: #334155;
        width: 100%;
        min-width: 0;
        word-break: break-word;
    }

    /* H2 Header: Styled Subsection */
    .blog-block-h2 {
        font-size: clamp(1.35rem, 2.3vw, 1.7rem);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.025em;
        margin-top: 2.75rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        word-break: break-word;
    }
    .blog-block-h2::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 1.15em;
        background: linear-gradient(to bottom, #7039ec, #ec4899);
        border-radius: 3px;
        flex-shrink: 0;
    }

    /* H3 Header */
    .blog-block-h3 {
        font-size: 1.18rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.015em;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        word-break: break-word;
    }

    /* Paragraph */
    .blog-block-p {
        font-size: 1.015rem;
        line-height: 1.85;
        color: #334155;
        margin-bottom: 1.4rem;
        word-break: break-word;
    }

    /* Magazine Pullquote */
    .blog-block-quote {
        position: relative;
        border-left: 4px solid #7039ec;
        padding: 1.35rem 1.5rem 1.35rem 1.85rem;
        margin: 2rem 0;
        background: linear-gradient(135deg, rgba(112, 57, 236, 0.05) 0%, rgba(243, 89, 176, 0.03) 100%);
        border-radius: 0 1.25rem 1.25rem 0;
        color: #0f172a;
        font-style: italic;
        font-size: 1.05rem;
        line-height: 1.75;
        box-shadow: 0 2px 10px rgba(112, 57, 236, 0.03);
        word-break: break-word;
    }

    /* High-Tech Callout Box */
    .blog-block-callout {
        background: #fbf9ff;
        border: 1px solid #e9dcfc;
        border-radius: 1.15rem;
        padding: 1.25rem 1.4rem;
        margin: 1.75rem 0;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        color: #1e1b4b;
        font-size: 0.965rem;
        line-height: 1.7;
        box-shadow: 0 2px 12px rgba(112, 57, 236, 0.04);
        width: 100%;
        box-sizing: border-box;
        word-break: break-word;
    }

    .callout-icon-badge {
        width: 36px;
        height: 36px;
        border-radius: 0.65rem;
        background: #7039ec;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(112, 57, 236, 0.3);
    }

    /* Developer Terminal Code Block */
    .blog-code-container {
        margin: 2rem 0;
        border-radius: 1.15rem;
        background: #090d16;
        border: 1px solid #1e293b;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .blog-code-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1.25rem;
        background: #0f172a;
        border-bottom: 1px solid #1e293b;
    }

    .code-window-dots {
        display: flex;
        gap: 7px;
    }
    .code-window-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
    }
    .dot-red { background: #ef4444; }
    .dot-yellow { background: #f59e0b; }
    .dot-green { background: #10b981; }

    .code-tab-label {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.725rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .code-copy-btn {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #94a3b8;
        font-size: 0.725rem;
        font-family: 'JetBrains Mono', monospace;
        padding: 0.3rem 0.75rem;
        border-radius: 0.45rem;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .code-copy-btn:hover {
        background: rgba(255, 255, 255, 0.16);
        color: #ffffff;
    }

    .blog-block-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85rem;
        line-height: 1.7;
        padding: 1.25rem 1.4rem;
        margin: 0;
        white-space: pre-wrap;
        word-break: break-all;
        color: #38bdf8;
        overflow-x: auto;
        max-width: 100%;
    }

    /* List Items */
    .blog-block-bullet-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        font-size: 1rem;
        line-height: 1.75;
        color: #334155;
        margin-bottom: 0.75rem;
        word-break: break-word;
    }

    .blog-bullet-icon {
        color: #7039ec;
        font-size: 1.1rem;
        line-height: 1.4;
        flex-shrink: 0;
    }

    .blog-block-num-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        font-size: 1rem;
        line-height: 1.75;
        color: #334155;
        margin-bottom: 0.75rem;
        word-break: break-word;
    }

    .blog-num-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.725rem;
        font-weight: 800;
        color: #6d28d9;
        background: #ede9fe;
        padding: 0.2rem 0.6rem;
        border-radius: 0.4rem;
        margin-top: 0.15rem;
        flex-shrink: 0;
    }

    .blog-block-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent);
        margin: 2.75rem 0;
        border: none;
    }

    .blog-block-img-card {
        margin: 2.25rem 0;
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        width: 100%;
    }
    .blog-block-img-card img {
        width: 100%;
        height: auto;
        max-height: 540px;
        object-fit: cover;
        display: block;
    }
    .blog-block-img-caption {
        padding: 0.85rem 1.25rem;
        font-size: 0.8rem;
        color: #64748b;
        text-align: center;
        border-top: 1px solid #f1f5f9;
        font-style: italic;
        background: #ffffff;
    }

    /* ─── COLOSSEUM-INSPIRED TEAM GALLERY (4-COLUMN GRID // 8 OPERATORS) ─── */
    .odds-team-gallery-section {
        position: relative;
        z-index: 10;
        max-width: 1200px;
        margin: 0.5rem auto 5rem auto;
        padding: 0 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }

    /* 4-Column Grid (8 Members across 2 rows of 4) */
    .gallery-grid-container {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 2.75rem 1.85rem;
        width: 100%;
        align-items: stretch;
    }

    /* Individual Member Card */
    .gallery-member-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        min-width: 0;
        height: 100%;
        box-sizing: border-box;
        position: relative;
    }

    /* Double-Beveled Picture Frame (Museum Inspo Match) */
    .gallery-frame-outer {
        width: 100%;
        background: #fbfbfb;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 6px;
        box-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.04),
            0 4px 12px -2px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
    }

    .gallery-frame-molding {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 5px;
        padding: 6px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .gallery-frame-matting {
        background: #ffffff;
        border: 1px solid #eceef1;
        border-radius: 3px;
        padding: 8px;
    }

    .gallery-frame-canvas {
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 2px;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #111116;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .gallery-pfp-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        image-rendering: pixelated;
        display: block;
        transition: opacity 0.35s ease, transform 0.35s ease;
        position: relative;
        z-index: 1;
    }

    .gallery-hover-photo {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 20%;
        opacity: 0;
        transition: opacity 0.35s ease, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        transform: scale(1.06);
        display: block;
        pointer-events: none;
        z-index: 2;
    }

    .gallery-hover-mystery {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 40%, #1f1638 0%, #0d0c14 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.35s ease, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        transform: scale(0.95);
        pointer-events: none;
        z-index: 2;
    }

    .pixel-question-svg {
        width: 62%;
        height: 62%;
        max-width: 95px;
        max-height: 95px;
        shape-rendering: crispEdges;
        color: #a855f7;
        filter: drop-shadow(0 0 14px rgba(168, 85, 247, 0.75));
        transition: transform 0.3s ease;
    }

    /* ─── PHOTO REVEAL HINT BADGE ─── */
    .gallery-reveal-hint {
        position: absolute;
        bottom: 7px;
        right: 7px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 5px;
        background: rgba(15, 23, 42, 0.72);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 9999px;
        padding: 4px 9px 4px 6px;
        pointer-events: none;
        transition: opacity 0.4s ease;
        animation: hint-pulse 2.4s ease-in-out infinite;
    }

    .gallery-reveal-hint svg {
        width: 13px;
        height: 13px;
        fill: #fff;
        flex-shrink: 0;
    }

    .gallery-reveal-hint span {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.58rem;
        font-weight: 700;
        color: rgba(255,255,255,0.88);
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    /* Hide the mouse icon / show finger on touch, and vice versa */
    .hint-icon-mouse  { display: block; }
    .hint-icon-touch  { display: none;  }
    .hint-label-mouse { display: inline; }
    .hint-label-touch { display: none;  }

    @media (hover: none) and (pointer: coarse) {
        .hint-icon-mouse  { display: none;   }
        .hint-icon-touch  { display: block;  }
        .hint-label-mouse { display: none;   }
        .hint-label-touch { display: inline; }
    }

    @keyframes hint-pulse {
        0%, 100% { opacity: 0.9; transform: scale(1);    }
        50%       { opacity: 0.6; transform: scale(0.96); }
    }

    /* Hide permanently once JS marks hints as dismissed */
    .gallery-hints-seen .gallery-reveal-hint {
        opacity: 0;
        pointer-events: none;
        animation: none;
    }

    /* Hover Lift & Gallery Lighting */
    .gallery-frame-link {
        display: block;
        width: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .gallery-member-card:hover .gallery-frame-outer {
        transform: translateY(-4px);
        border-color: #cbd5e1;
        box-shadow: 
            0 12px 28px -4px rgba(15, 23, 42, 0.12),
            0 4px 10px -2px rgba(15, 23, 42, 0.04);
    }

    .gallery-member-card:hover .gallery-pfp-img {
        opacity: 0;
        transform: scale(0.94);
    }

    .gallery-member-card:hover .gallery-hover-photo {
        opacity: 1;
        transform: scale(1.01);
    }

    .gallery-member-card:hover .gallery-hover-mystery {
        opacity: 1;
        transform: scale(1);
    }

    .gallery-member-card:hover .pixel-question-svg {
        transform: scale(1.08);
    }

    /* ─── HANDWRITTEN HOVER QUIP DOODLE ─── */
    .gallery-quip-wrap {
        position: absolute;
        bottom: calc(100% - 14px);
        left: 50%;
        transform: translateX(-50%) translateY(10px) scale(0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.28s cubic-bezier(0.16, 1, 0.3, 1),
                    visibility 0.28s;
        z-index: 45;
        width: max-content;
        max-width: 235px;
    }

    .gallery-quip-bubble {
        background: #ffffff;
        border: 1.5px solid #d8b4fe;
        border-radius: 12px;
        padding: 0.35rem 0.8rem;
        box-shadow: 
            0 8px 24px -4px rgba(112, 57, 236, 0.22),
            0 2px 6px rgba(0, 0, 0, 0.04);
        position: relative;
        text-align: center;
    }

    .gallery-quip-text {
        font-family: 'Caveat', 'Newsreader', cursive, serif;
        font-size: 1.08rem;
        font-weight: 700;
        line-height: 1.22;
        color: #1e1b4b;
        text-align: center;
        display: block;
        letter-spacing: -0.01em;
    }

    .gallery-quip-arrow {
        width: 28px;
        height: 20px;
        margin-top: -2px;
        filter: drop-shadow(0 2px 4px rgba(135, 90, 245, 0.25));
        transition: transform 0.28s ease;
    }

    .gallery-member-card:hover .gallery-quip-wrap {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0) scale(1);
    }

    /* Natural Alternating Tilt on Quips */
    .gallery-member-card:nth-child(1) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(-2deg); }
    .gallery-member-card:nth-child(1):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(-2deg); }

    .gallery-member-card:nth-child(2) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(2deg); }
    .gallery-member-card:nth-child(2):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(2deg); }
    .gallery-member-card:nth-child(2) .gallery-quip-arrow { transform: scaleX(-1); }

    .gallery-member-card:nth-child(3) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(-1.5deg); }
    .gallery-member-card:nth-child(3):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(-1.5deg); }

    .gallery-member-card:nth-child(4) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(2deg); }
    .gallery-member-card:nth-child(4):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(2deg); }
    .gallery-member-card:nth-child(4) .gallery-quip-arrow { transform: scaleX(-1); }

    .gallery-member-card:nth-child(5) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(-2deg); }
    .gallery-member-card:nth-child(5):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(-2deg); }

    .gallery-member-card:nth-child(6) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(1.5deg); }
    .gallery-member-card:nth-child(6):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(1.5deg); }
    .gallery-member-card:nth-child(6) .gallery-quip-arrow { transform: scaleX(-1); }

    .gallery-member-card:nth-child(7) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(-2deg); }
    .gallery-member-card:nth-child(7):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(-2deg); }

    .gallery-member-card:nth-child(8) .gallery-quip-wrap { transform: translateX(-50%) translateY(10px) scale(0.9) rotate(2deg); }
    .gallery-member-card:nth-child(8):hover .gallery-quip-wrap { transform: translateX(-50%) translateY(0) scale(1) rotate(2deg); }
    .gallery-member-card:nth-child(8) .gallery-quip-arrow { transform: scaleX(-1); }

    /* Caption Underneath */
    .gallery-card-caption {
        width: 100%;
        min-width: 0;
        flex: 1;
        margin-top: 0.85rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: flex-start;
    }

    .gallery-member-name {
        font-family: 'Newsreader', Georgia, 'Times New Roman', serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: #1e293b;
        letter-spacing: -0.015em;
        line-height: 1.25;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.2rem;
        height: 3rem;
        width: 100%;
        min-width: 0;
        text-align: center;
    }

    .gallery-name-link {
        color: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.2rem;
        transition: color 0.2s ease;
    }

    .gallery-name-link:hover {
        color: #875af5;
    }

    .gallery-member-handle {
        font-family: 'Newsreader', Georgia, serif;
        font-style: italic;
        font-size: 0.92rem;
        font-weight: 400;
        color: #64748b;
    }

    /* Two-Sided Split Metadata: Positions (Left) vs Awards (Right) */
    .gallery-member-meta {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        width: 100%;
        min-width: 0;
        padding-top: 0.6rem;
        border-top: 1px solid #f1f5f9;
        box-sizing: border-box;
        margin-top: 0;
        flex: 1;
    }

    .gallery-meta-col {
        flex: 1 1 50%;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .gallery-meta-col.meta-positions {
        text-align: left;
        align-items: flex-start;
    }

    .gallery-meta-col.meta-awards {
        text-align: right;
        align-items: flex-end;
    }

    .gallery-meta-kicker {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.58rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #991b1b;
        line-height: 1;
        margin-bottom: 0.4rem;
    }

    .gallery-meta-entries {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        width: 100%;
        min-width: 0;
        justify-content: flex-start;
    }

    .gallery-meta-text {
        font-size: 0.72rem;
        font-weight: 600;
        color: #334155;
        line-height: 1.35;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: break-word;
        display: block;
        width: 100%;
    }

    .gallery-meta-sep {
        width: 1px;
        align-self: stretch;
        background: #e2e8f0;
        margin: 0.1rem 0;
        flex-shrink: 0;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1024px) {
        .gallery-grid-container {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 2.25rem 1.5rem;
            max-width: 580px;
            margin: 0 auto;
        }
    }

    @media (max-width: 640px) {
        .odds-team-gallery-section {
            margin: 0.5rem auto 3rem auto;
            padding: 1.25rem 0.85rem 0 0.85rem;
            overflow: visible;
        }

        .gallery-grid-container {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.75rem 0.75rem;
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
        }

        .gallery-frame-outer {
            padding: 4px;
        }

        .gallery-frame-molding {
            padding: 4px;
        }

        .gallery-frame-matting {
            padding: 5px;
        }

        .gallery-member-name {
            font-size: 0.875rem;
            height: 2.5rem;
            line-height: 1.22;
            margin-bottom: 0.35rem;
        }

        .gallery-member-handle {
            font-size: 0.78rem;
        }

        .gallery-member-meta {
            gap: 0.5rem;
            padding-top: 0.45rem;
        }

        .gallery-meta-kicker {
            font-size: 0.52rem;
            margin-bottom: 0.25rem;
        }

        .gallery-meta-entries {
            gap: 0.25rem;
        }

        .gallery-meta-text {
            font-size: 0.65rem;
            line-height: 1.3;
        }

        .gallery-quip-wrap {
            max-width: 160px;
            bottom: calc(100% - 8px);
        }

        .gallery-quip-bubble {
            padding: 0.22rem 0.5rem;
            border-radius: 9px;
        }

        .gallery-quip-text {
            font-size: 0.85rem;
            line-height: 1.18;
        }

        .gallery-quip-arrow {
            width: 22px;
            height: 16px;
        }
    }

    /* ─── ODDS & EVEN (EXPANSION / COMING SOON SECTION) ─── */
    .odds-even-section {
        margin-top: -1rem;
        margin-bottom: 5rem;
        overflow: hidden;
        box-sizing: border-box;
    }

    .odds-even-wrapper {
        position: relative;
        width: 100%;
        max-width: 100%;
        border-radius: 1.25rem;
        overflow: hidden;
        padding: 0.5rem 0;
        box-sizing: border-box;
    }

    .odds-even-blurred-grid {
        filter: blur(8px) saturate(0.8);
        opacity: 0.45;
        pointer-events: none;
        user-select: none;
        transition: all 0.3s ease;
        max-width: 100%;
        transform: translateZ(0);
        will-change: transform;
    }

    .odds-even-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        z-index: 15;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .coming-soon-glass-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(226, 232, 240, 0.95);
        border-radius: 1.5rem;
        padding: 2.25rem 2.5rem;
        text-align: center;
        box-shadow: 
            0 10px 30px -5px rgba(15, 23, 42, 0.08),
            0 20px 48px -12px rgba(112, 57, 236, 0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 440px;
        width: 100%;
        box-sizing: border-box;
        transform: translateZ(0);
        will-change: transform;
        animation: floatGlassCard 4s ease-in-out infinite alternate;
    }

    @keyframes floatGlassCard {
        0% {
            transform: translateY(0px);
        }
        100% {
            transform: translateY(-5px);
        }
    }

    .coming-soon-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(1.85rem, 3.5vw, 2.5rem);
        font-weight: 900;
        letter-spacing: 0.08em;
        color: #0f172a;
        line-height: 1.1;
        margin: 0 0 0.5rem 0;
        word-break: break-word;
        max-width: 100%;
    }

    .coming-soon-dot {
        color: #7039ec;
    }

    .coming-soon-desc {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        line-height: 1.6;
        font-weight: 500;
        word-break: break-word;
        max-width: 100%;
    }

    @media (max-width: 640px) {
        .odds-even-blurred-grid {
            filter: blur(5px) saturate(0.85);
        }
        .odds-even-overlay {
            padding: 0.75rem;
        }
        .coming-soon-glass-card {
            animation: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.08);
            padding: 1.6rem 1.15rem;
            border-radius: 1.25rem;
            max-width: calc(100% - 0.5rem);
        }
        .coming-soon-title {
            font-size: clamp(1.35rem, 6.5vw, 1.75rem);
            letter-spacing: 0.03em;
        }
        .coming-soon-desc {
            font-size: 0.85rem;
        }
    }
</style>

<div class="odds-about-universe">
    {{-- Ambient Lighting & Technical Matrix Canvas in Isolated Container --}}
    <div class="about-ambient-container" aria-hidden="true">
        <div class="about-ambient-glow"></div>
        <div class="about-tech-matrix"></div>
    </div>
<div class="header-cont">
     {{-- TYPOGRAPHIC ONE-LINER HERO: AGAINST ALL ODDS --}}
    <header class="about-headline-hero">
        {{-- Eyebrow Breadcrumb --}}
        <div class="about-eyebrow-nav">
            <span class="eyebrow-accent">About Us</span>
            <span class="eyebrow-divider">/</span>
            <span>the people behind the screen</span>
        </div>

        {{-- Monumental Headline --}}
        <h1 class="about-massive-headline">
            AGAINST ALL <span class="headline-outline-text draw-highlight-wrap">ODDS<svg class="draw-highlight-svg" viewBox="0 0 120 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M 2 10 C 30 2, 60 11, 118 4" stroke="#875af5" stroke-width="3" stroke-linecap="round" vector-effect="non-scaling-stroke"/></svg></span><span class="headline-gradient-text">.</span>
        </h1>
    </header>
</div>

@include('sections.about-story')

{{-- =========================================================================
     THE ODDS TEAM GALLERY // INSPIRATION-MATCHED PYRAMID (8 OPERATORS)
     ========================================================================= --}}
@php
$teamMembers = [
    [
        'name' => 'Jerico Sanchez',
        'handle' => '3c0-exe',
        'github' => 'https://github.com/3c0-exe',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=3c0-exe',
        'real_photo' => asset('storage/odds/team/Jerico_Sanchez.jpg'),
        'quip' => "asleep or yearning.. probably both",
        'positions' => ['Co-Founder', 'Software Developer'],
        'awards' => ['Cum Laude', 'Best in Capstone (Lead Dev)'],
    ],
    [
        'name' => 'Jherald Vibar',
        'handle' => 'Jherald-Vibar',
        'github' => 'https://github.com/Jherald-Vibar',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Jherald-Vibar',
        'is_mystery' => true,
        'quip' => "the most technical person really has no photos",
        'positions' => ['Co-Founder', 'Software / Database Dev'],
        'awards' => ['Magna Cum Laude', 'Outstanding System Developer'],
    ],
    [
        'name' => 'Robert Santiago',
        'handle' => 'Robert-1hash',
        'github' => 'https://github.com/Robert-1hash',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Robert-1hash',
        'real_photo' => asset('storage/odds/team/Robert_Santiago.jpeg'),
        'quip' => "might break a couple of PCBs, but gets the job done",
        'positions' => ['Developer', 'Hardware Specialist'],
        'awards' => ['Magna Cum Laude', 'Best in Capstone'],
    ],
    [
        'name' => 'Brix Jorie Cura',
        'handle' => 'ixDev018',
        'github' => 'https://github.com/ixDev018',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=ixDev018',
        'real_photo' => asset('storage/odds/team/Brix_Cura.jpeg'),
        'quip' => "i-jira natin 'to",
        'positions' => ['Co-Founder, Lead Designer', 'CMO, Web Developer'],
        'awards' => ['Magna Cum Laude', 'Best in Capstone (Dev)'],
    ],
    [
        'name' => 'Jazam Laranio',
        'handle' => '',
        'github' => null,
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=JazamLaranio',
        'real_photo' => asset('storage/odds/team/Jazam_Laranio.jpeg'),
        'quip' => "hates commuting",
        'positions' => ['Developer', 'Lead Gen Specialist'],
        'awards' => ['Cum Laude', 'Outstanding System Developer'],
    ],
    [
        'name' => 'Mark Paulo Franco',
        'handle' => 'itsFrancss619',
        'github' => 'https://github.com/itsFrancss619',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=itsFrancss619',
        'real_photo' => asset('storage/odds/team/Mark_Paulo_Franco.jpeg'),
        'quip' => "cocoooo!",
        'positions' => ['Developer', 'Field Logistics Coord.'],
        'awards' => ['Best in Capstone'],
    ],
    [
        'name' => 'John Cedric Abaloyan',
        'handle' => 'Ggwepq',
        'github' => 'https://github.com/Ggwepq',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=Ggwepq',
        'real_photo' => asset('storage/odds/team/John_Cedric_Abaloyan.jpeg'),
        'quip' => "performative (based on the matcha pic)",
        'positions' => ['Lead Developer'],
        'awards' => ['Best in Capstone'],
    ],
    [
        'name' => 'Sherwin Ramirez',
        'handle' => 'sheerwiiin',
        'github' => 'https://github.com/sheerwiiin',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=sheerwiiin',
        'real_photo' => asset('storage/odds/team/Sherwin_Ramirez.jpeg'),
        'photo_position' => 'center 40%',
        'quip' => "wanted to have the same shirt as jerico",
        'positions' => ['QA Specialist', 'Web Developer'],
        'awards' => ['Top 1 (Rank 1)', 'Best in Capstone'],
    ],
];
@endphp

<section id="meet-the-team" class="odds-team-gallery-section" aria-label="ODDS Team Gallery">
    <div class="gallery-grid-container">
        @foreach($teamMembers as $member)
            <div class="gallery-member-card">
                @if(!empty($member['quip']))
                    <div class="gallery-quip-wrap" aria-hidden="true">
                        <div class="gallery-quip-bubble">
                            <span class="gallery-quip-text">“{{ $member['quip'] }}”</span>
                        </div>
                        <svg class="gallery-quip-arrow" viewBox="0 0 32 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 6 2 C 16 2, 24 8, 22 18" stroke="#875af5" stroke-width="2.2" stroke-linecap="round"/>
                            <path d="M 16 14 L 22 18 L 26 12" stroke="#875af5" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                @endif
                @if(!empty($member['github']))
                    <a href="{{ $member['github'] }}" target="_blank" rel="noopener noreferrer" class="gallery-frame-link" aria-label="{{ $member['name'] }} GitHub Profile">
                @endif
                <div class="gallery-frame-outer">
                    <div class="gallery-frame-molding">
                        <div class="gallery-frame-matting">
                            <div class="gallery-frame-canvas">
                                <img src="{{ $member['pfp'] }}" alt="{{ $member['name'] }}" class="gallery-pfp-img" loading="lazy">
                                @if(!empty($member['real_photo']))
                                    <img src="{{ $member['real_photo'] }}" alt="{{ $member['name'] }}" class="gallery-hover-photo" style="{{ !empty($member['photo_position']) ? 'object-position: ' . $member['photo_position'] . ';' : '' }}" loading="lazy">
                                    {{-- Hint badge: tells users how to see the real photo --}}
                                    <div class="gallery-reveal-hint" aria-hidden="true">
                                        {{-- Mouse icon (desktop) --}}
                                        <svg class="hint-icon-mouse" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2a7 7 0 0 0-7 7v6a7 7 0 0 0 14 0V9a7 7 0 0 0-7-7zm0 2a5 5 0 0 1 5 5v1h-4V4zm-2 0v6H5V9a5 5 0 0 1 5-5z"/></svg>
                                        {{-- Finger / long-press icon (touch) --}}
                                        <svg class="hint-icon-touch" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13 1a4 4 0 0 1 4 4v1.07A4 4 0 0 1 17 14l-.001.126A5 5 0 0 1 12 19a5 5 0 0 1-5-5V9a2 2 0 0 1 3.45-1.382A4 4 0 0 1 13 5V1zm0 2a2 2 0 0 0-2 2v4a1 1 0 0 0-2 0v4a3 3 0 0 0 6 0V9a2 2 0 0 0-4 0V5a2 2 0 0 0 2-2z"/></svg>
                                        <span class="hint-label-mouse">hover</span>
                                        <span class="hint-label-touch">hold</span>
                                    </div>
                                @elseif(!empty($member['is_mystery']))
                                    <div class="gallery-hover-mystery" aria-hidden="true">
                                        <svg viewBox="0 0 16 16" class="pixel-question-svg" fill="currentColor">
                                            <rect x="4" y="2" width="8" height="2"/>
                                            <rect x="10" y="4" width="2" height="3"/>
                                            <rect x="6" y="7" width="6" height="2"/>
                                            <rect x="6" y="9" width="2" height="2"/>
                                            <rect x="6" y="12" width="2" height="2"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($member['github']))
                    </a>
                @endif
                <div class="gallery-card-caption">
                    <h3 class="gallery-member-name">
                        @if(!empty($member['github']))
                            <a href="{{ $member['github'] }}" target="_blank" rel="noopener noreferrer" class="gallery-name-link">
                                {{ $member['name'] }}@if(!empty($member['handle']))<span class="gallery-member-handle">, {{ $member['handle'] }}</span>@endif
                            </a>
                        @else
                            {{ $member['name'] }}@if(!empty($member['handle']))<span class="gallery-member-handle">, {{ $member['handle'] }}</span>@endif
                        @endif
                    </h3>
                    <div class="gallery-member-meta">
                        <div class="gallery-meta-col meta-positions">
                            <span class="gallery-meta-kicker">POSITIONS</span>
                            <div class="gallery-meta-entries">
                                @foreach($member['positions'] as $pos)
                                    <span class="gallery-meta-text" title="{{ $pos }}">{{ $pos }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="gallery-meta-sep" aria-hidden="true"></div>
                        <div class="gallery-meta-col meta-awards">
                            <span class="gallery-meta-kicker">AWARDS</span>
                            <div class="gallery-meta-entries">
                                @foreach($member['awards'] as $aw)
                                    <span class="gallery-meta-text" title="{{ $aw }}">{{ $aw }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- =========================================================================
     ODDS & EVEN // EXPANSION COHORT (4 OPERATORS - COMING SOON)
     ========================================================================= --}}
<div class="header-cont" style="margin: 65px 0 35px 0;">
    {{-- TYPOGRAPHIC ONE-LINER: ODDS & EVEN --}}
    <div class="about-headline-hero">
        {{-- Eyebrow Breadcrumb --}}
        <div class="about-eyebrow-nav">
            <span class="eyebrow-accent">Cohort II</span>
            <span class="eyebrow-divider">/</span>
            <span>the next chapter</span>
        </div>

        {{-- Monumental Headline --}}
        <h2 class="about-massive-headline">
            ODDS & <span class="headline-outline-text draw-highlight-wrap">EVEN<svg class="draw-highlight-svg" viewBox="0 0 120 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M 118 4 C 60 11, 30 2, 2 10" stroke="#875af5" stroke-width="3" stroke-linecap="round" vector-effect="non-scaling-stroke"/></svg></span><span class="headline-gradient-text">.</span>
        </h2>
    </div>
</div>

@php
$evenMembers = [
    [
        'name' => 'Operator IX',
        'handle' => 'stealth',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=EvenMember01',
        'positions' => ['Full-Stack', 'Systems Engineer'],
        'awards' => ['Classified', 'Incoming'],
    ],
    [
        'name' => 'Operator X',
        'handle' => 'stealth',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=EvenMember02',
        'positions' => ['Hardware / IoT', 'Firmware Lead'],
        'awards' => ['Classified', 'Incoming'],
    ],
    [
        'name' => 'Operator XI',
        'handle' => 'stealth',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=EvenMember03',
        'positions' => ['UI/UX Architect', 'Product Design'],
        'awards' => ['Classified', 'Incoming'],
    ],
    [
        'name' => 'Operator XII',
        'handle' => 'stealth',
        'pfp' => 'https://api.dicebear.com/10.x/pixelbot/svg?seed=EvenMember04',
        'positions' => ['Security & Vision', 'AI Researcher'],
        'awards' => ['Classified', 'Incoming'],
    ],
];
@endphp

<section class="odds-team-gallery-section odds-even-section" aria-label="ODDS & EVEN Team Gallery">
    <div class="odds-even-wrapper">
        {{-- 4-Column Grid with 4 Blurred Cards --}}
        <div class="gallery-grid-container odds-even-blurred-grid" aria-hidden="true">
            @foreach($evenMembers as $member)
                <div class="gallery-member-card">
                    <div class="gallery-frame-outer">
                        <div class="gallery-frame-molding">
                            <div class="gallery-frame-matting">
                                <div class="gallery-frame-canvas">
                                    <img src="{{ $member['pfp'] }}" alt="{{ $member['name'] }}" class="gallery-pfp-img" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-card-caption">
                        <h3 class="gallery-member-name">
                            {{ $member['name'] }}@if(!empty($member['handle']))<span class="gallery-member-handle">, {{ $member['handle'] }}</span>@endif
                        </h3>
                        <div class="gallery-member-meta">
                            <div class="gallery-meta-col meta-positions">
                                <span class="gallery-meta-kicker">POSITIONS</span>
                                <div class="gallery-meta-entries">
                                    @foreach($member['positions'] as $pos)
                                        <span class="gallery-meta-text" title="{{ $pos }}">{{ $pos }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="gallery-meta-sep" aria-hidden="true"></div>
                            <div class="gallery-meta-col meta-awards">
                                <span class="gallery-meta-kicker">AWARDS</span>
                                <div class="gallery-meta-entries">
                                    @foreach($member['awards'] as $aw)
                                        <span class="gallery-meta-text" title="{{ $aw }}">{{ $aw }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Centered Coming Soon Overlay --}}
        <div class="odds-even-overlay">
            <div class="coming-soon-glass-card">
                <h3 class="coming-soon-title">COMING SOON<span class="coming-soon-dot">.</span></h3>
                <p class="coming-soon-desc">Even numbers take a little longer to add up.</p>
            </div>
        </div>
    </div>
</section>

    @if($sections->isNotEmpty())
    {{-- MAIN EDITORIAL CONTENT LAYOUT --}}
    <div class="about-content-layout">
        
        {{-- LEFT COLUMN: STICKY CHAPTER NAVIGATOR & COMMAND CONSOLE --}}
        <aside class="about-sidebar-column">
            <div class="about-sidebar-sticky">
                
                {{-- Table of Contents Card --}}
                <div class="sidebar-toc-panel">
                    <div class="sidebar-panel-header">
                        <div class="sidebar-label">
                            <span class="sidebar-label-dot"></span>
                            <span>Studio Chapters</span>
                        </div>
                        <span class="sidebar-count-badge">{{ $sections->isEmpty() ? 3 : $sections->count() }} Chapters</span>
                    </div>

                    <nav class="toc-nav-list" id="toc-nav">
                        @forelse($sections as $idx => $sec)
                            <a href="#section-{{ $sec->id }}" class="toc-link-item {{ $idx === 0 ? 'active' : '' }}">
                                <span class="toc-chapter-num">0{{ $idx + 1 }}.</span>
                                <span class="truncate">{{ $sec->title }}</span>
                            </a>
                        @empty
                            <a href="#section-1" class="toc-link-item active">
                                <span class="toc-chapter-num">01.</span>
                                <span class="truncate">The Bet We Made</span>
                            </a>
                            <a href="#section-2" class="toc-link-item">
                                <span class="toc-chapter-num">02.</span>
                                <span class="truncate">We Never Picked a Specialty</span>
                            </a>
                            <a href="#section-3" class="toc-link-item">
                                <span class="toc-chapter-num">03.</span>
                                <span class="truncate">We Didn't Start Here</span>
                            </a>
                        @endforelse
                    </nav>
                </div>

                {{-- Deploy Studio Terminal Mini-Card --}}
                <div class="sidebar-deploy-card">
                    <div class="deploy-card-tag">
                        <i class="fa-solid fa-terminal text-xs"></i>
                        <span>ODDS // DEPLOY</span>
                    </div>
                    <h4 class="deploy-card-title">Need a Dedicated Sprint?</h4>
                    <p class="deploy-card-p">
                        Deploy our engineering core to build your complete system or eliminate architectural bottlenecks.
                    </p>
                    <a href="#contact" class="deploy-card-btn js-open-contact-modal" data-open-contact>
                        <span>Start a Conversation</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

            </div>
        </aside>

        {{-- RIGHT COLUMN: ARTICLES / CHAPTER STREAM --}}
        <main class="about-articles-feed">

            {{-- Mobile Chapter Selector (Visible only on < lg screens) --}}
            <div class="lg:hidden mobile-chapter-selector">
                <div class="mobile-selector-header">
                    <span class="mobile-selector-title">Chapter Navigation</span>
                    <span class="text-xs font-mono text-purple-600 font-bold">{{ $sections->isEmpty() ? 3 : $sections->count() }} Chapters</span>
                </div>
                <div class="mobile-chip-scroll" id="mobile-toc-nav">
                    @forelse($sections as $idx => $sec)
                        <a href="#section-{{ $sec->id }}" class="mobile-chip {{ $idx === 0 ? 'active' : '' }}">
                            <span class="font-mono text-purple-600 font-bold">0{{ $idx + 1 }}.</span>
                            <span>{{ $sec->title }}</span>
                        </a>
                    @empty
                        <a href="#section-1" class="mobile-chip active">
                            <span class="font-mono text-purple-600 font-bold">01.</span>
                            <span>The Bet We Made</span>
                        </a>
                        <a href="#section-2" class="mobile-chip">
                            <span class="font-mono text-purple-600 font-bold">02.</span>
                            <span>We Never Picked a Specialty</span>
                        </a>
                        <a href="#section-3" class="mobile-chip">
                            <span class="font-mono text-purple-600 font-bold">03.</span>
                            <span>We Didn't Start Here</span>
                        </a>
                    @endforelse
                </div>
            </div>

            @if($sections->isNotEmpty())
                @foreach($sections as $index => $section)
                    @php
                        $blocks = $section->body_content ?? [];
                        if (is_string($blocks)) {
                            $decoded = json_decode($blocks, true);
                            $blocks = is_array($decoded) ? $decoded : [];
                        }
                    @endphp
                    <article class="chapter-article-card" id="section-{{ $section->id }}">
                        
                        {{-- Top Meta Row --}}
                        <div class="chapter-card-topbar">
                            <div class="chapter-badge-wrap">
                                <span class="chapter-index-pill">CH.0{{ $index + 1 }}</span>
                                <span class="chapter-category-pill">{{ $section->category ?? 'ENGINEERING' }}</span>
                            </div>
                            <div class="chapter-meta-right">
                                <span>By <strong class="chapter-author-tag">{{ $section->author ?? 'ODDS Core' }}</strong></span>
                                <span>•</span>
                                <span>{{ strtoupper($section->read_time ?? '3 MIN READ') }}</span>
                            </div>
                        </div>

                        {{-- Main Chapter Title --}}
                        <h2 class="chapter-main-title">{{ $section->title }}</h2>

                        {{-- Subtitle Hook / Deck --}}
                        @if($section->subtitle)
                            <p class="chapter-deck-subtitle">{{ $section->subtitle }}</p>
                        @endif

                        {{-- 16:9 Cover Image --}}
                        @if(!empty($section->cover_image))
                            <div class="chapter-cover-box">
                                <img src="{{ $section->cover_image }}" alt="{{ $section->title }}" loading="lazy">
                            </div>
                        @endif

                        {{-- Stream of Structured Notion Blocks --}}
                        <div class="blog-stream-body">
                            @foreach($blocks as $b)
                                @php
                                    $type = $b['type'] ?? 'paragraph';
                                    $content = $b['content'] ?? '';
                                @endphp

                                @if($type === 'heading2')
                                    <h2 class="blog-block-h2">{!! $content !!}</h2>
                                @elseif($type === 'heading3')
                                    <h3 class="blog-block-h3">{!! $content !!}</h3>
                                @elseif($type === 'bullet')
                                    <div class="blog-block-bullet-item">
                                        <span class="blog-bullet-icon"><i class="fa-solid fa-circle-check"></i></span>
                                        <div class="flex-1 leading-relaxed">{!! $content !!}</div>
                                    </div>
                                @elseif($type === 'numbered')
                                    <div class="blog-block-num-item">
                                        <span class="blog-num-badge">STEP</span>
                                        <div class="flex-1 leading-relaxed">{!! $content !!}</div>
                                    </div>
                                @elseif($type === 'quote')
                                    <blockquote class="blog-block-quote">
                                        {!! $content !!}
                                    </blockquote>
                                @elseif($type === 'callout')
                                    <div class="blog-block-callout">
                                        <div class="callout-icon-badge">
                                            <i class="fa-solid fa-lightbulb"></i>
                                        </div>
                                        <div class="flex-1 font-medium leading-relaxed">{!! $content !!}</div>
                                    </div>
                                @elseif($type === 'code')
                                    <div class="blog-code-container">
                                        <div class="blog-code-header">
                                            <div class="code-window-dots">
                                                <span class="code-window-dot dot-red"></span>
                                                <span class="code-window-dot dot-yellow"></span>
                                                <span class="code-window-dot dot-green"></span>
                                            </div>
                                            <div class="code-tab-label">
                                                <i class="fa-solid fa-code text-[11px] text-purple-400"></i>
                                                <span>architecture.config</span>
                                            </div>
                                            <button type="button" class="code-copy-btn" onclick="copySnippet(this)" aria-label="Copy code">
                                                <i class="fa-regular fa-copy"></i>
                                                <span>Copy</span>
                                            </button>
                                        </div>
                                        <pre class="blog-block-code"><code>{{ $content }}</code></pre>
                                    </div>
                                @elseif($type === 'divider')
                                    <hr class="blog-block-divider">
                                @elseif($type === 'image' && !empty($b['src']))
                                    <div class="blog-block-img-card">
                                        <img src="{{ $b['src'] }}" alt="{{ $b['caption'] ?? 'Story visual' }}" loading="lazy">
                                        @if(!empty($b['caption']))
                                            <div class="blog-block-img-caption">{{ $b['caption'] }}</div>
                                        @endif
                                    </div>
                                @else
                                    @if(!empty(trim(strip_tags($content))))
                                        <p class="blog-block-p">{!! $content !!}</p>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </article>
                @endforeach
            @endif

        </main>
    </div>
    @endif

</div>

{{-- ODDS Studio Footer Component --}}
<x-footer :settings="$settings" />

{{-- Odds Lorenzo AI Chat Widget --}}
<x-odds-chat-widget />

<script>
// Code Snippet Copy Handler
function copySnippet(btn) {
    if (!btn) return;
    const container = btn.closest('.blog-code-container');
    if (!container) return;
    const codeEl = container.querySelector('code');
    if (!codeEl) return;
    const text = codeEl.innerText || codeEl.textContent;
    
    const span = btn.querySelector('span');
    const icon = btn.querySelector('i');
    if (span) span.innerText = 'Copied!';
    if (icon) icon.className = 'fa-solid fa-check text-emerald-400';

    try {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).catch(() => execCopy(text));
        } else {
            execCopy(text);
        }
    } catch(e) {
        execCopy(text);
    }

    setTimeout(() => {
        if (span) span.innerText = 'Copy';
        if (icon) icon.className = 'fa-regular fa-copy';
    }, 2000);
}

function execCopy(text) {
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
        document.execCommand('copy');
    } catch (err) {}
    document.body.removeChild(ta);
}

// Section links and refresh landing are handled by page-position.js.

// ScrollSpy Navigation Tracker
(function initAboutScrollSpy() {
    function setupSpy() {
        const desktopTocLinks = document.querySelectorAll('#toc-nav .toc-link-item');
        const mobileTocLinks = document.querySelectorAll('#mobile-toc-nav .mobile-chip');
        const mobileTocContainer = document.getElementById('mobile-toc-nav');
        const articles = document.querySelectorAll('.chapter-article-card');

        if (articles.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    if (!id) return;
                    
                    desktopTocLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('active');
                        }
                    });

                    mobileTocLinks.forEach(pill => {
                        pill.classList.remove('active');
                        if (pill.getAttribute('href') === `#${id}`) {
                            pill.classList.add('active');
                            if (mobileTocContainer) {
                                const scrollTarget = pill.offsetLeft - (mobileTocContainer.offsetWidth / 2) + (pill.offsetWidth / 2);
                                mobileTocContainer.scrollTo({ left: scrollTarget, behavior: 'smooth' });
                            }
                        }
                    });
                }
            });
        }, {
            root: null,
            rootMargin: '-120px 0px -40% 0px',
            threshold: 0
        });

        articles.forEach(article => observer.observe(article));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupSpy);
    } else {
        setupSpy();
    }
})();

// ScrollTrigger Pin — replaces CSS position:sticky for the sidebar
// (pins the inner .about-sidebar-sticky to avoid flexing column jumps)
(function initAboutSidebarPin() {
    function setupPin() {
        const sidebar = document.querySelector('.about-sidebar-column');
        const feed = document.querySelector('.about-articles-feed');
        const sticky = document.querySelector('.about-sidebar-sticky');
        if (!sidebar || !feed || !sticky) return;

        // If ScrollTrigger is not yet ready, retry shortly
        if (typeof ScrollTrigger === 'undefined') {
            setTimeout(setupPin, 50);
            return;
        }

        // Kill existing triggers for this sidebar to prevent duplicates
        ScrollTrigger.getAll().forEach(st => {
            if (st.pin === sticky || st.pin === sidebar) st.kill();
        });
        if (window.innerWidth < 1024) return;

        const navbar = document.getElementById('navbar');
        // Dynamic top offset: navbar height + comfortable 32px breathing room
        const getTopOffset = () => {
            const navH = navbar ? navbar.offsetHeight : (window.innerHeight * 0.10);
            return navH + 32;
        };

        ScrollTrigger.create({
            trigger: feed,
            start: () => `top ${getTopOffset()}px`,
            end: () => `bottom ${sticky.offsetHeight + getTopOffset()}px`,
            pin: sticky,
            pinSpacing: false,
            anticipatePin: 1
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupPin);
    } else {
        setupPin();
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setupPin, 150);
    });
})();
// ─── GALLERY REVEAL HINT: auto-dismiss once user actually sees the reveal ─────
(function initGalleryRevealHints() {
    function setup() {
        const sections = document.querySelectorAll('.odds-team-gallery-section');
        if (!sections.length) return;

        let dismissed = false;

        function dismiss() {
            if (dismissed) return;
            dismissed = true;
            sections.forEach(s => s.classList.add('gallery-hints-seen'));
        }

        // Desktop: only dismiss after the user has hovered on a card for ≥1.5s
        // (meaning they actually saw the revealed photo, not just moused over)
        document.querySelectorAll('.gallery-member-card').forEach(card => {
            let hoverTimer = null;
            card.addEventListener('mouseenter', () => {
                hoverTimer = setTimeout(dismiss, 1500);
            });
            card.addEventListener('mouseleave', () => {
                clearTimeout(hoverTimer);
            });
        });

        // Mobile: dismiss on first touchstart (they're actively interacting)
        document.querySelectorAll('.gallery-frame-canvas, .gallery-frame-link').forEach(el => {
            el.addEventListener('touchstart', dismiss, { passive: true, once: true });
        });

        // Auto-dismiss after 8 seconds — don't nag indefinitely
        setTimeout(dismiss, 8000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setup);
    } else {
        setup();
    }
})();
</script>
</x-layout>

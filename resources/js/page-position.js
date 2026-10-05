// One owner for initial landing, section links, and browser history.
export function setupPagePosition({ smoother, ScrollTrigger }) {
    const stateKey = 'oddsScrollY';
    const initialSavedY = history.state?.[stateKey];
    const navigationType = performance.getEntriesByType('navigation')[0]?.type;
    const restartAtHero = navigationType === 'reload' && !!document.getElementById('hero') &&
        new URLSearchParams(location.search).get('preview') !== 'services';
    let initialApplied = false;
    let interacted = false;
    let handledUrl = location.href;
    let saveTimer;

    // Native scroll records the destination; the smoother can still be catching up.
    const currentY = () => window.scrollY;
    const savePosition = () => {
        clearTimeout(saveTimer);
        history.replaceState({ ...history.state, [stateKey]: currentY() }, '', location.href);
    };
    const targetForHash = hash => {
        try { return hash ? document.getElementById(decodeURIComponent(hash.slice(1))) : null; }
        catch { return null; }
    };
    const moveTo = (target, animate = false) => {
        const smooth = animate && !matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (typeof target === 'number') {
            if (smoother) smoother.scrollTo(target, smooth);
            else window.scrollTo({ top: target, behavior: smooth ? 'smooth' : 'instant' });
        } else {
            const offset = (document.getElementById('navbar')?.getBoundingClientRect().height || 80) + 16;
            if (smoother) smoother.scrollTo(target, smooth, `top ${offset}px`);
            else window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - offset, behavior: smooth ? 'smooth' : 'instant' });
        }
    };
    const initialTarget = () => targetForHash(location.hash) ||
        (new URLSearchParams(location.search).get('preview') === 'services' ? document.querySelector('.service-explorer') : null);
    const applyInitialPosition = (correctLayout = false) => {
        if (interacted) return;
        if (initialApplied && !correctLayout) return;
        const target = initialTarget();
        // Back/forward restores the position saved for that history entry.
        if (navigationType === 'back_forward' && Number.isFinite(initialSavedY)) moveTo(initialSavedY);
        else if (restartAtHero) moveTo(0);
        else if (target) moveTo(target);
        else if (!initialApplied) moveTo(0);
        initialApplied = true;
        savePosition();
    };

    ['wheel', 'touchstart', 'pointerdown', 'keydown'].forEach(type => {
        window.addEventListener(type, event => {
            if (event.isTrusted) interacted = true;
        }, { passive: true });
    });
    const initialize = () => requestAnimationFrame(() => applyInitialPosition());
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize, { once: true });
    else initialize();

    const loaded = document.readyState === 'complete' ? Promise.resolve() :
        new Promise(resolve => window.addEventListener('load', resolve, { once: true }));
    Promise.all([loaded, document.fonts?.ready]).then(() => {
        requestAnimationFrame(() => {
            // Refresh geometry once assets settle; never rewind an engaged visitor.
            ScrollTrigger.refresh(interacted);
            applyInitialPosition(true);
        });
    });

    window.addEventListener('scroll', () => {
        if (!initialApplied) return;
        clearTimeout(saveTimer);
        saveTimer = setTimeout(savePosition, 100);
    }, { passive: true });
    window.addEventListener('pagehide', savePosition);
    window.addEventListener('pageshow', event => {
        if (event.persisted && Number.isFinite(history.state?.[stateKey])) moveTo(history.state[stateKey]);
    });
    window.addEventListener('popstate', () => {
        interacted = true;
        handledUrl = location.href;
        moveTo(Number.isFinite(history.state?.[stateKey]) ? history.state[stateKey] : targetForHash(location.hash) || 0);
    });
    window.addEventListener('hashchange', () => {
        if (handledUrl === location.href) return;
        interacted = true;
        handledUrl = location.href;
        moveTo(targetForHash(location.hash) || 0);
    });
    document.addEventListener('click', event => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        const link = event.target.closest('a[href]');
        if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) return;
        const url = new URL(link.href, location.href);
        if (url.origin !== location.origin || url.pathname !== location.pathname || url.search !== location.search) return;
        const target = targetForHash(url.hash);
        if (!target) return;
        event.preventDefault();
        interacted = true;
        savePosition();
        if (url.hash !== location.hash) history.pushState(null, '', url.href);
        handledUrl = location.href;
        moveTo(target, true);
    });
    return {
        goToTop() {
            interacted = true;
            savePosition();
            if (location.hash) history.pushState(null, '', location.pathname + location.search);
            handledUrl = location.href;
            moveTo(0, true);
        },
    };
}

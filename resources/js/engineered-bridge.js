// Every animated wrapper contains the unchanged vector paths from Group 3125.
import { animateStatementEffects, resetStatementEffects } from './engineered-bridge-effects';
export function resetEngineeredBridge(gsap) {
    const statement = document.getElementById('bridge-statement');
    if (!statement) return;
    gsap.set(statement.querySelectorAll('[data-bridge-part]'), { clearProps: 'all' });
    gsap.set(statement.querySelector('#bridge-we-craft-original'), { clearProps: 'all' });
    resetStatementEffects(gsap, statement);
}

export function animateEngineeredBridge({ gsap, timeline, horizontalDistance, reducedMotion }) {
    const statement = document.getElementById('bridge-statement');
    const bridge = document.getElementById('engineered-bridge');
    if (!statement || !bridge || reducedMotion) return;

    const viewBox = statement.viewBox.baseVal;
    const scale = statement.clientWidth / viewBox.width;
    const parts = Array.from(statement.querySelectorAll('[data-bridge-part]'));
    const compoundText = statement.querySelector('#bridge-we-craft-original');
    let compoundTextEnd = 0;
    const timings = new Map();
    gsap.set(compoundText, { opacity: 0 });
    const rotations = {
        'prototype-label': 5,
        'production-label': -5,
        'without-text': -5,
    };

    // Each part settles as it enters the viewport, rather than animating while offscreen.
    for (const part of parts) {
        const bounds = part.getBBox();
        // We and craft share an original compound path, clipped without changing its rendering.
        if (part.dataset.bridgeBoundsX) {
            bounds.x = Number(part.dataset.bridgeBoundsX);
            bounds.width = Number(part.dataset.bridgeBoundsWidth);
        }
        const kind = part.dataset.bridgeKind;
        const entryDistance = bridge.offsetLeft + (bounds.x - viewBox.x) * scale - window.innerWidth * 0.96;
        const entryTime = 0.4 + Math.max(0, entryDistance / horizontalDistance()) * 2;
        const name = part.dataset.bridgePart;
        const staticEntrance = ['flower-icon', 'fluid-label', 'systems-label', 'fluid-systems-connector'].includes(name);
        const duration = staticEntrance ? 0.08 : name === 'production-label' ? 0.15 : name === 'effortlessly-text' ? 0.3 : kind === 'text' ? 0.16 : 0.22;
        // Finish every entrance within the horizontal movement, even for the final words.
        const startTime = Math.min(2.4 - duration, entryTime);
        timings.set(name, startTime);
        if (name === 'scale-label') continue;
        if (part.dataset.bridgeBoundsX) compoundTextEnd = Math.max(compoundTextEnd, startTime + duration);
        gsap.set(part, {
            transformOrigin: '50% 50%',
            smoothOrigin: false,
        });
        timeline.fromTo(part, {
            opacity: 0,
            x: name === 'engineered-label' ? -12 : name === 'effortlessly-text' ? 20 : 0,
            y: staticEntrance || name === 'effortlessly-text' ? 0 : name === 'production-label' ? -12 : kind === 'text' ? 4 : 10,
            scale: staticEntrance || kind === 'text' ? 1 : name === 'production-label' ? 1.15 : 0.94,
            rotation: rotations[part.dataset.bridgePart] || 0,
        }, {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            rotation: 0,
            duration,
            ease: 'power2.out',
        }, startTime);
    }

    // Chrome rasterizes clipped text slightly differently. Restore the unchanged compound
    // path once both words settle, so the resting artwork matches the source pixel-for-pixel.
    timeline.set(compoundText, { opacity: 1 }, compoundTextEnd);
    timeline.set(parts.filter(part => part.dataset.bridgeBoundsX), { opacity: 0 }, compoundTextEnd);
    animateStatementEffects({ gsap, timeline, statement, timings });
}

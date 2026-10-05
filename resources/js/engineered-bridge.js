// Every animated wrapper contains the unchanged vector paths from Group 3125.
import { animateStatementEffects, resetStatementEffects } from './engineered-bridge-effects';
const entranceTimelines = [];
// In-memory state lasts until reload, including responsive timeline rebuilds.
const playedParts = new Set();
export function resetEngineeredBridge(gsap) {
    for (const timeline of entranceTimelines) {
        timeline.scrollTrigger?.kill();
        timeline.kill();
    }
    entranceTimelines.length = 0;
    const statement = document.getElementById('bridge-statement');
    if (!statement) return;
    gsap.set(statement.querySelectorAll('[data-bridge-part]'), { clearProps: 'all' });
    gsap.set(statement.querySelector('#bridge-we-craft-original'), { clearProps: 'all' });
    resetStatementEffects(gsap, statement);
}

export function animateEngineeredBridge({ gsap, scrollTween, reducedMotion }) {
    const statement = document.getElementById('bridge-statement');
    const bridge = document.getElementById('engineered-bridge');
    if (!statement || !bridge || reducedMotion) return;

    const viewBox = statement.viewBox.baseVal;
    const parts = Array.from(statement.querySelectorAll('[data-bridge-part]'));
    const compoundText = statement.querySelector('#bridge-we-craft-original');
    const timings = new Map();
    const timelines = new Map();
    const settledTimelines = [];
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
        const name = part.dataset.bridgePart;
        const isPourPart = ['fluid-label', 'systems-label', 'fluid-systems-connector'].includes(name);
        const entryX = isPourPart ? statement.querySelector('#bridge-fluid-label').getBBox().x : bounds.x;
        // The track scrubs; individual entrances play in seconds once they are in view.
        const alreadyPlayed = playedParts.has(name);
        const timeline = gsap.timeline(alreadyPlayed ? { paused: true } : {
            scrollTrigger: {
                trigger: bridge,
                containerAnimation: scrollTween,
                horizontal: true,
                start: () => `left+=${(entryX - viewBox.x) * statement.clientWidth / viewBox.width} 70%`,
                toggleActions: 'play none none none',
                once: true,
                onEnter: () => playedParts.add(name),
                invalidateOnRefresh: true,
            },
        });
        entranceTimelines.push(timeline);
        if (alreadyPlayed) settledTimelines.push(timeline);
        timelines.set(name, timeline);
        const staticEntrance = ['flower-icon', 'fluid-label', 'systems-label', 'fluid-systems-connector'].includes(name);
        const duration = staticEntrance ? 0.15 : name === 'production-label' ? 0.8 : name === 'effortlessly-text' ? 0.9 : kind === 'text' ? 0.6 : 0.8;
        const startTime = 0;
        timings.set(name, 0);
        if (name === 'scale-label') continue;
        gsap.set(part, {
            transformOrigin: '50% 50%',
            smoothOrigin: false,
        });
        timeline.fromTo(part, {
            opacity: 0,
            x: name === 'engineered-label' ? -12 : name === 'effortlessly-text' ? 20 : 0,
            y: staticEntrance || name === 'effortlessly-text' ? 0 : name === 'production-label' ? -20 : kind === 'text' ? 18 : 16,
            scale: staticEntrance || kind === 'text' ? 1 : name === 'production-label' ? 1.15 : 0.94,
            rotation: rotations[part.dataset.bridgePart] || 0,
        }, {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            rotation: 0,
            duration,
            ease: staticEntrance ? 'power2.out' : kind === 'text' ? 'back.out(1.08)' : 'back.out(1.15)',
        }, startTime);
    }

    animateStatementEffects({ gsap, timelines, statement, timings });
    // Restore completed effects only after their entire sequence has been assembled.
    for (const timeline of settledTimelines) timeline.progress(1).pause();
}

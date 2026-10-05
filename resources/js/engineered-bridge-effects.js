const originalDetailTransforms = new WeakMap();

export function animateFluidTexture(gsap, reducedMotion) {
    const texture = document.getElementById('bridge-fluid-texture-motion');
    if (!texture || reducedMotion) return;

    // Use wall-clock time so the stream keeps flowing when scrolling stops.
    gsap.fromTo(texture, { attr: { dx: -2, dy: -4 } }, {
        attr: { dx: 2, dy: 6 },
        duration: 1.8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
    });
}

export function resetStatementEffects(gsap, statement) {
    for (const detail of statement.querySelectorAll('[data-bridge-detail]')) {
        if (!originalDetailTransforms.has(detail)) originalDetailTransforms.set(detail, detail.getAttribute('transform'));
        gsap.set(detail, { clearProps: 'all' });
        const originalTransform = originalDetailTransforms.get(detail);
        if (originalTransform) detail.setAttribute('transform', originalTransform);
    }
    gsap.set(statement.querySelectorAll('[data-bridge-effect]'), { clearProps: 'all' });
    statement.querySelector('#bridge-flower-center').setAttribute('r', '6.08184');
    // Reduced motion keeps a complete, filled illustration without playing the pour.
    gsap.set(statement.querySelector('#bridge-pour-reveal'), { attr: { height: 80 } });
    gsap.set(statement.querySelector('#bridge-water-level'), { attr: { y: 155, height: 95 } });
}

export function animateStatementEffects({ gsap, timelines, statement, timings }) {
    let timeline;
    const element = name => statement.querySelector(`#bridge-${name}`);
    const time = name => timings.get(name);
    const origin = (target, x, y) => {
        const bounds = target.getBBox();
        gsap.set(target, {
            transformOrigin: `${(x - bounds.x) / bounds.width * 100}% ${(y - bounds.y) / bounds.height * 100}%`,
            smoothOrigin: false,
        });
    };
    const show = (target, start, duration = 0.08) => timeline.fromTo(target, { opacity: 0 }, { opacity: 1, duration, ease: 'none' }, start);
    const hide = (target, start, duration = 0.08) => timeline.to(target, { opacity: 0, duration, ease: 'none' }, start);

    // A circle first; the unchanged petals unfold and rotate with scroll.
    const flowerTime = time('flower-icon');
    timeline = timelines.get('flower-icon');
    const petals = element('flower-petals');
    origin(petals, 688.59, 180.711);
    timeline.fromTo(petals, { x: 0, y: 0, scale: 0, rotation: -150 }, {
        x: 0, y: 0, scale: 1, rotation: 0, duration: 0.8, ease: 'back.out(1.15)',
    }, flowerTime + 0.02);
    timeline.fromTo(element('flower-center'), { attr: { r: 10 } }, {
        attr: { r: 6.08184 }, duration: 0.8, ease: 'power2.out',
    }, flowerTime + 0.02);

    // The upper vessel tips, the blue stream pours down, and the receiver responds.
    const fluidTime = time('fluid-label');
    timeline = timelines.get('fluid-label');
    const fluid = element('fluid-label');
    const systems = element('systems-label');
    origin(fluid, 1586.5, 160.5);
    origin(systems, 1644, 201);
    timeline.to(fluid, { x: 0, y: 0, rotation: 18, duration: 0.3, ease: 'power3.inOut' }, fluidTime + 0.08);
    timeline.fromTo(element('pour-reveal'), { attr: { height: 0 } }, {
        attr: { height: 80 }, duration: 0.45, ease: 'power2.in',
    }, fluidTime + 0.2);
    // Both overlays share a level: blue rises through the bowl and the vector lettering.
    timeline.fromTo(element('water-level'), { attr: { y: 250, height: 0 } }, {
        attr: { y: 155, height: 95 }, duration: 1.4, ease: 'power1.inOut',
    }, fluidTime + 0.6);
    timeline.to(fluid, { x: 0, y: 0, rotation: 0, duration: 0.4, ease: 'power3.out' }, fluidTime + 1.6);
    timeline.to(systems, { x: 0, y: 3, rotation: -3, duration: 0.2, ease: 'power2.out' }, fluidTime + 0.35);
    timeline.to(systems, { x: 0, y: 0, rotation: 0, duration: 0.3, ease: 'power2.out' }, fluidTime + 0.6);

    // A small editable label grows as a cursor drags its lower-right resize handle.
    const scaleTime = time('scale-label');
    timeline = timelines.get('scale-label');
    const scale = element('scale-label');
    const selection = element('scale-selection');
    const cursor = element('scale-cursor');
    const click = element('scale-click');
    const smallScale = 0.58;
    const cornerX = 1878.5 + (2101 - 1878.5) * smallScale;
    const cornerY = 143.5 + (225 - 143.5) * smallScale;
    origin(scale, 1878.5, 143.5);
    origin(selection, 1878.5, 143.5);
    origin(cursor, 0, 0);
    origin(click, 0, 0);
    timeline.fromTo(scale, { opacity: 0, x: 0, y: 0, scale: smallScale, rotation: 0 }, {
        opacity: 1, duration: 0.06, ease: 'none',
    }, scaleTime);
    timeline.fromTo(selection, { opacity: 0, x: 0, y: 0, scale: smallScale }, {
        opacity: 1, duration: 0.04, ease: 'none',
    }, scaleTime + 0.04);
    timeline.fromTo(cursor, { opacity: 0, x: cornerX + 28, y: cornerY - 24 }, {
        opacity: 1, x: cornerX, y: cornerY, duration: 0.08, ease: 'power2.out',
    }, scaleTime + 0.02);
    timeline.fromTo(click, { opacity: 0.8, x: cornerX, y: cornerY, scale: 0.3 }, {
        opacity: 0, scale: 1.2, duration: 0.06, ease: 'power2.out', immediateRender: false,
    }, scaleTime + 0.1);
    timeline.to([scale, selection], { x: 0, y: 0, scale: 1, duration: 0.6, ease: 'back.out(1.12)' }, scaleTime + 0.14);
    timeline.to(cursor, { x: 2101, y: 225, duration: 0.6, ease: 'back.out(1.12)' }, scaleTime + 0.14);
    hide([selection, cursor], scaleTime + 0.84, 0.15);

    // Short supporting gestures keep the two main demonstrations readable.
    const guides = element('engineered-guides');
    timeline = timelines.get('engineered-label');
    show(guides, time('engineered-label'));
    hide(guides, time('engineered-label') + 0.65, 0.15);

    const prototypeTime = time('prototype-label');
    timeline = timelines.get('prototype-label');
    const prototypeOutline = element('prototype-outline');
    const prototypeLength = prototypeOutline.getTotalLength();
    timeline.fromTo(element('prototype-background'), { opacity: 0 }, { opacity: 1, duration: 0.16, ease: 'none' }, prototypeTime + 0.1);
    timeline.fromTo(prototypeOutline, { strokeDasharray: prototypeLength, strokeDashoffset: prototypeLength }, {
        strokeDashoffset: 0, duration: 0.6, ease: 'power3.inOut',
    }, prototypeTime);
    timeline.set(prototypeOutline, { clearProps: 'strokeDasharray,strokeDashoffset' }, prototypeTime + 0.6);

    const production = element('production-label');
    timeline = timelines.get('production-label');
    timeline.to(production, { x: 0, y: 1, scaleY: 0.97, duration: 0.08, ease: 'none' }, time('production-label') + 0.8);
    timeline.to(production, { x: 0, y: 0, scaleY: 1, duration: 0.15, ease: 'power2.out' }, time('production-label') + 0.88);

    const shieldTime = time('shield-icon');
    timeline = timelines.get('shield-icon');
    const shieldOutline = element('shield-outline');
    const shieldLength = shieldOutline.getTotalLength();
    timeline.fromTo(shieldOutline, { strokeDasharray: shieldLength, strokeDashoffset: shieldLength }, {
        strokeDashoffset: 0, duration: 0.6, ease: 'power3.inOut',
    }, shieldTime);
    timeline.set(shieldOutline, { clearProps: 'strokeDasharray,strokeDashoffset' }, shieldTime + 0.6);
    const glint = element('shield-glint');
    show(glint, shieldTime + 0.6, 0.08);
    hide(glint, shieldTime + 0.76, 0.15);

    const caret = element('craft-caret');
    timeline = timelines.get('craft-text');
    timeline.fromTo(caret, { opacity: 0, x: 1323, y: 0 }, {
        opacity: 1, x: 1474, y: 0, duration: 0.6, ease: 'power2.inOut',
    }, time('we-text'));
    hide(caret, time('craft-text') + 0.7, 0.15);
}

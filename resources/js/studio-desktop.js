const desktop = document.getElementById('studio-desktop');
if (desktop) {
    const services = JSON.parse(document.getElementById('odds-services-data').textContent);
    const workspace = document.getElementById('studio-workspace');
    const layer = document.getElementById('studio-window-layer');
    const launcher = document.getElementById('studio-launcher');
    const launcherButton = document.getElementById('studio-launcher-button');
    const windows = new Map();
    const mobile = window.matchMedia('(max-width: 700px)');
    let level = 10;
    let mobileState = null;
    const escape = value => String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));
    const clock = desktop.querySelector('.studio-clock');
    const updateClock = () => { clock.textContent = new Intl.DateTimeFormat('en', { timeZone: 'Asia/Manila', hour: 'numeric', minute: '2-digit' }).format(new Date()); };
    updateClock();
    setInterval(updateClock, 60000);

    function updateDock() {
        desktop.querySelectorAll('.studio-dock-app').forEach(button => {
            const state = windows.get(Number(button.dataset.studioOpen));
            button.classList.toggle('is-running', !!state);
            button.classList.toggle('is-front', !!state && !state.el.hidden && Number(state.el.style.zIndex) === level);
        });
    }
    function front(state) {
        state.el.hidden = false;
        state.el.style.zIndex = ++level;
        updateDock();
    }
    function leaveMobile(state) {
        if (mobileState?.state !== state) return;
        mobileState.background.forEach(([el, inert]) => { el.inert = inert; });
        document.body.style.overflow = mobileState.overflow;
        if (mobileState.paused !== undefined) window.smoother?.paused(mobileState.paused);
        layer.appendChild(state.el);
        state.el.classList.remove('is-mobile');
        state.el.removeAttribute('aria-modal');
        state.el.setAttribute('role', 'region');
        mobileState = null;
    }
    function minimize(state) {
        leaveMobile(state);
        state.el.hidden = true;
        updateDock();
        state.opener?.focus({ preventScroll: true });
    }
    function close(state) {
        leaveMobile(state);
        state.el.remove();
        windows.delete(state.index);
        updateDock();
        state.opener?.focus({ preventScroll: true });
    }
    function maximize(state) {
        state.el.classList.toggle('is-maximized');
        const expanded = state.el.classList.contains('is-maximized');
        state.el.querySelector('[data-window-maximize]').setAttribute('aria-label', expanded ? 'Restore window size' : 'Maximize window');
        state.el.querySelector('[data-window-maximize]').setAttribute('aria-pressed', String(expanded));
    }
    function clampPosition(state) {
        state.el.style.left = `${Math.max(0, Math.min(parseFloat(state.el.style.left) || 0, workspace.clientWidth - state.el.offsetWidth))}px`;
        state.el.style.top = `${Math.max(0, Math.min(parseFloat(state.el.style.top) || 0, workspace.clientHeight - state.el.offsetHeight))}px`;
    }
    function open(index, opener) {
        launcher.hidden = true;
        launcherButton.setAttribute('aria-expanded', 'false');
        if (mobileState) minimize(mobileState.state);
        let state = windows.get(index);
        if (!state) {
            const service = services[index];
            const el = document.createElement('section');
            el.className = 'studio-window';
            el.id = `studio-window-${index}`;
            el.setAttribute('role', 'region');
            el.setAttribute('aria-labelledby', `studio-title-${index}`);
            el.innerHTML = `
                <div class="studio-window-titlebar">
                    <span class="studio-window-app"><i class="fa-solid ${escape(service.icon)}" aria-hidden="true"></i><span>${escape(service.name)}</span></span>
                    <div class="studio-window-controls">
                        <button type="button" data-window-minimize aria-label="Minimize window">−</button>
                        <button type="button" data-window-maximize aria-label="Maximize window" aria-pressed="false">□</button>
                        <button type="button" data-window-close aria-label="Close ${escape(service.name)}">×</button>
                    </div>
                </div>
                <div class="studio-window-address"><span aria-hidden="true">↳</span> studio / services / ${escape(service.slug || 'custom')}</div>
                <div class="studio-window-content">
                    <span class="studio-window-eyebrow">Designed with care. Built to work.</span>
                    <h3 id="studio-title-${index}">${escape(service.name)}</h3>
                    <p class="studio-window-description">${escape(service.description)}</p>
                    <h4>Is this for you?</h4><p>${escape(service.fit || service.description)}</p>
                    <h4>What we can build</h4>
                    <ul>${(service.examples || service.features || []).map(example => `<li>${escape(example)}</li>`).join('')}</ul>
                    ${service.project ? `<a class="studio-project-proof" href="/our-work"><small>From our workbench</small><strong>${escape(service.project)} <span>↗</span></strong><p>${escape(service.proof)}</p></a>` : ''}
                    <div class="studio-window-next"><h4>Let's start with a conversation.</h4><p>We'll work out scope, budget, and timing together.</p>
                    <a href="#contact" class="js-open-contact-modal studio-project-cta" data-service-needed="${escape(service.contact || service.name)}">Discuss your project <span aria-hidden="true">↗</span></a></div>
                </div>`;
            layer.appendChild(el);
            state = { el, index, opener };
            windows.set(index, state);
            el.style.left = `${Math.min(workspace.clientWidth * .31 + (index % 3) * 24, workspace.clientWidth - el.offsetWidth - 18)}px`;
            el.style.top = `${28 + (index % 3) * 24}px`;
            el.addEventListener('pointerdown', () => front(state));
            el.addEventListener('focusin', () => { if (Number(el.style.zIndex) !== level) front(state); });
            el.querySelector('[data-window-close]').addEventListener('click', () => close(state));
            el.querySelector('[data-window-minimize]').addEventListener('click', () => minimize(state));
            el.querySelector('[data-window-maximize]').addEventListener('click', () => maximize(state));
            el.querySelector('.studio-project-cta').addEventListener('click', () => minimize(state));
            const titlebar = el.querySelector('.studio-window-titlebar');
            titlebar.addEventListener('dblclick', event => { if (!event.target.closest('button') && !mobile.matches) maximize(state); });
            titlebar.addEventListener('pointerdown', event => {
                if (event.button !== 0 || mobile.matches || el.classList.contains('is-maximized') || event.target.closest('button')) return;
                event.preventDefault();
                front(state);
                titlebar.setPointerCapture(event.pointerId);
                el.classList.add('is-dragging');
                const start = { x: event.clientX, y: event.clientY, left: parseFloat(el.style.left), top: parseFloat(el.style.top), paused: window.smoother?.paused() };
                window.smoother?.paused(true);
                const move = pointer => {
                    el.style.left = `${start.left + pointer.clientX - start.x}px`;
                    el.style.top = `${start.top + pointer.clientY - start.y}px`;
                    clampPosition(state);
                };
                const end = () => {
                    titlebar.removeEventListener('pointermove', move);
                    titlebar.removeEventListener('pointerup', end);
                    titlebar.removeEventListener('pointercancel', end);
                    el.classList.remove('is-dragging');
                    if (start.paused !== undefined) window.smoother?.paused(start.paused);
                };
                titlebar.addEventListener('pointermove', move);
                titlebar.addEventListener('pointerup', end);
                titlebar.addEventListener('pointercancel', end);
            });
        }
        state.opener = opener;
        front(state);
        if (mobile.matches) {
            document.body.appendChild(state.el);
            state.el.classList.add('is-mobile');
            state.el.setAttribute('role', 'dialog');
            state.el.setAttribute('aria-modal', 'true');
            mobileState = { state, overflow: document.body.style.overflow, paused: window.smoother?.paused(),
                background: [...document.body.children].filter(el => el !== state.el && !['SCRIPT', 'STYLE', 'LINK'].includes(el.tagName)).map(el => [el, el.inert]) };
            mobileState.background.forEach(([el]) => { el.inert = true; });
            document.body.style.overflow = 'hidden';
            window.smoother?.paused(true);
        } else clampPosition(state);
        state.el.querySelector('[data-window-close]').focus({ preventScroll: true });
    }
    desktop.querySelectorAll('[data-studio-open]').forEach(button => {
        button.addEventListener('click', () => open(Number(button.dataset.studioOpen), button));
    });
    launcherButton.addEventListener('click', () => {
        launcher.hidden = !launcher.hidden;
        launcherButton.setAttribute('aria-expanded', String(!launcher.hidden));
        if (!launcher.hidden) launcher.querySelector('button')?.focus({ preventScroll: true });
    });
    document.getElementById('studio-show-desktop').addEventListener('click', () => [...windows.values()].forEach(minimize));
    desktop.querySelector('[data-studio-chat]').addEventListener('click', () => {
        const chatWindow = document.getElementById('chat-window');
        if (chatWindow?.classList.contains('hidden')) document.getElementById('chat-toggle-btn')?.click();
        document.getElementById('chat-input')?.focus({ preventScroll: true });
    });
    const listToggle = document.getElementById('studio-list-toggle');
    const list = document.getElementById('studio-service-list');
    listToggle.addEventListener('click', () => {
        list.hidden = !list.hidden;
        listToggle.setAttribute('aria-expanded', String(!list.hidden));
        window.ScrollTrigger?.refresh();
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !document.querySelector('#odds-contact-modal.is-active')) {
            const state = [...windows.values()].filter(state => !state.el.hidden).sort((a, b) => Number(b.el.style.zIndex) - Number(a.el.style.zIndex))[0];
            if (state && (state.el.contains(document.activeElement) || mobileState)) { event.preventDefault(); close(state); }
            if (!launcher.hidden) { launcher.hidden = true; launcherButton.setAttribute('aria-expanded', 'false'); launcherButton.focus(); }
        }
        if (event.key === 'Tab' && mobileState) {
            const targets = [...mobileState.state.el.querySelectorAll('a[href], button')].filter(el => el.getClientRects().length);
            const first = targets[0], last = targets.at(-1);
            if ((event.shiftKey && document.activeElement === first) || (!event.shiftKey && document.activeElement === last)) {
                event.preventDefault(); (event.shiftKey ? last : first).focus();
            }
        }
    });
    mobile.addEventListener('change', () => [...windows.values()].forEach(minimize));
    new ResizeObserver(() => { if (!mobile.matches) [...windows.values()].filter(state => !state.el.hidden).forEach(clampPosition); }).observe(workspace);
}

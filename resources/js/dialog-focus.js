const openDialogs = [];
const focusableSelector = 'a[href], button, input, select, textarea, [tabindex]';

// Shared by project, service, and contact dialogs, including nested dialogs.
export function createDialogFocus(dialog, initialFocus) {
    dialog.inert = true;
    let opener;
    let previousOverflow;
    let previousPaused;
    let background = [];

    const focusable = () => Array.from(dialog.querySelectorAll(focusableSelector))
        .filter(el => !el.disabled && el.tabIndex >= 0 && !el.closest('[inert]') && el.getClientRects().length);
    const isTop = () => openDialogs.at(-1) === dialog;
    const focusFirst = () => {
        const target = initialFocus?.();
        (target?.getClientRects().length ? target : focusable()[0] || dialog).focus({ preventScroll: true });
    };
    const onKeydown = event => {
        if (!isTop() || event.key !== 'Tab') return;
        const targets = focusable();
        const first = targets[0] || dialog;
        const last = targets.at(-1) || dialog;
        if (!dialog.contains(document.activeElement) || !targets.length ||
            (event.shiftKey && document.activeElement === first) ||
            (!event.shiftKey && document.activeElement === last)) {
            event.preventDefault();
            (event.shiftKey ? last : first).focus({ preventScroll: true });
        }
    };
    const onFocusin = event => {
        if (isTop() && !dialog.contains(event.target)) focusFirst();
    };

    return {
        isTop,
        open(trigger) {
            if (openDialogs.includes(dialog)) return;
            opener = trigger?.getClientRects().length ? trigger : document.activeElement;
            previousOverflow = document.body.style.overflow;
            previousPaused = window.smoother?.paused();
            // Body-level placement avoids transformed scrolling ancestors.
            document.body.appendChild(dialog);
            dialog.inert = false;
            dialog.tabIndex = -1;
            background = Array.from(document.body.children)
                .filter(el => el !== dialog && !['SCRIPT', 'STYLE', 'LINK'].includes(el.tagName))
                .map(el => [el, el.inert]);
            background.forEach(([el]) => { el.inert = true; });
            openDialogs.push(dialog);
            document.body.classList.add('modal-open');
            document.body.style.overflow = 'hidden';
            window.smoother?.paused(true);
            document.addEventListener('keydown', onKeydown);
            document.addEventListener('focusin', onFocusin);
            focusFirst();
        },
        close() {
            if (!isTop()) return;
            const index = openDialogs.indexOf(dialog);
            if (index === -1) return;
            openDialogs.splice(index, 1);
            document.body.classList.toggle('modal-open', openDialogs.length > 0);
            document.removeEventListener('keydown', onKeydown);
            document.removeEventListener('focusin', onFocusin);
            background.forEach(([el, inert]) => { el.inert = inert; });
            background = [];
            document.body.style.overflow = previousOverflow;
            if (previousPaused !== undefined) window.smoother?.paused(previousPaused);
            if (opener?.isConnected && !opener.closest('[inert]')) opener.focus({ preventScroll: true });
            dialog.inert = true;
        }
    };
}

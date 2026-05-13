const ICONS = {
    success: '<i class="ti ti-check"></i>',
    error: '<i class="ti ti-alert-circle"></i>',
    warning: '<i class="ti ti-alert-triangle"></i>',
    info: '<i class="ti ti-info-circle"></i>',
    loading: '<span class="toast-spin"><i class="ti ti-loader-2"></i></span>',
};

let _id = 0;

export function toast(type, title, msg, duration = 4500, action = null) {
    let vp = document.getElementById("toast-viewport");
    if (!vp) {
        vp = document.createElement("div");
        vp.id = "toast-viewport";
        document.body.appendChild(vp);
    }

    const id = ++_id;
    const el = document.createElement("div");
    el.className = `toast t-${type}`;
    el.id = `toast-${id}`;
    el.setAttribute("role", "alert");

    const actionHtml = action
        ? `<div><button class="toast-action" data-action="${id}">${action.label}</button></div>`
        : "";

    el.innerHTML = `
        <div class="toast-icon">${ICONS[type]}</div>
        <div class="toast-body">
            <p class="toast-title">${title}</p>
            <p class="toast-msg">${msg}</p>
            ${actionHtml}
        </div>
        <button class="toast-close" data-dismiss="${id}" aria-label="Dismiss">
            <i class="ti ti-x"></i>
        </button>
        ${duration > 0 ? `<div class="toast-progress" style="animation-duration:${duration}ms"></div>` : ""}
    `;

    if (action) {
        el.querySelector(`[data-action="${id}"]`).addEventListener(
            "click",
            () => {
                action.fn();
                removeToast(id);
            },
        );
    }
    el.querySelector(`[data-dismiss="${id}"]`).addEventListener("click", () =>
        removeToast(id),
    );

    vp.appendChild(el);
    if (duration > 0) setTimeout(() => removeToast(id), duration);
    return id;
}

export function removeToast(id) {
    const el = document.getElementById(`toast-${id}`);
    if (!el || el.classList.contains("removing")) return;
    el.classList.add("removing");
    setTimeout(() => el.remove(), 240);
}

// Convenience aliases
export const toastSuccess = (t, m, opts) => toast("success", t, m, 4500, opts);
export const toastError = (t, m, opts) => toast("error", t, m, 6000, opts);
export const toastWarning = (t, m, opts) => toast("warning", t, m, 5000, opts);
export const toastInfo = (t, m, opts) => toast("info", t, m, 4500, opts);
export const toastLoading = (t, m) => toast("loading", t, m, 0);

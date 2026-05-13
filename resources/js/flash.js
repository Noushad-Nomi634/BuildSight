import { toast, removeToast } from "./toast.js";

const TYPE_MAP = {
    success: "success",
    error: "error",
    danger: "error",
    warning: "warning",
    info: "info",
};

const TITLES = {
    success: "Success",
    error: "Error",
    danger: "Error",
    warning: "Warning",
    info: "Information",
};

function detectAndFire() {
    // ── 1. DOM meta tags  (injected by Blade) ──────────────────────────────
    document.querySelectorAll('meta[name^="flash-"]').forEach((meta) => {
        const type = meta.getAttribute("name").replace("flash-", "");
        const message = meta.getAttribute("content");
        if (message && TYPE_MAP[type]) {
            toast(TYPE_MAP[type], TITLES[type], message);
        }
    });

    // ── 2. data-flash attribute on <body> ──────────────────────────────────
    const body = document.body;
    if (body.dataset.flash) {
        try {
            const flashes = JSON.parse(body.dataset.flash); // [{type, message}]
            flashes.forEach(({ type, message, title }) => {
                if (TYPE_MAP[type]) {
                    toast(TYPE_MAP[type], title ?? TITLES[type], message);
                }
            });
        } catch {}
    }

    // ── 3. Livewire flash events ───────────────────────────────────────────
    if (window.Livewire) {
        window.Livewire.on("flash", ({ type, message, title }) => {
            toast(
                TYPE_MAP[type] ?? "info",
                title ?? TITLES[type] ?? "Notice",
                message,
            );
        });
    }

    // ── 4. Custom window events (dispatch from anywhere) ──────────────────
    window.addEventListener("flash", (e) => {
        const {
            type = "info",
            title,
            message,
            duration,
            action,
        } = e.detail ?? {};
        toast(
            TYPE_MAP[type] ?? type,
            title ?? TITLES[type] ?? "Notice",
            message,
            duration,
            action,
        );
    });

    // ── 5. Axios / Fetch response interceptors ─────────────────────────────
    if (window.axios) {
        window.axios.interceptors.response.use(
            (response) => {
                const f = response.data?.flash;
                if (f)
                    toast(
                        TYPE_MAP[f.type] ?? "info",
                        f.title ?? TITLES[f.type] ?? "Notice",
                        f.message,
                    );
                return response;
            },
            (error) => {
                const f = error.response?.data?.flash;
                if (f) {
                    toast("error", f.title ?? "Error", f.message);
                } else if (error.response?.status >= 500) {
                    toast(
                        "error",
                        "Server error",
                        "Something went wrong. Please try again.",
                    );
                } else if (error.response?.status === 422) {
                    const errors = error.response.data?.errors;
                    if (errors) {
                        const first = Object.values(errors)[0];
                        toast(
                            "error",
                            "Validation error",
                            Array.isArray(first) ? first[0] : first,
                        );
                    }
                } else if (error.response?.status === 403) {
                    toast(
                        "warning",
                        "Access denied",
                        "You don't have permission to do that.",
                    );
                } else if (error.response?.status === 401) {
                    toast("error", "Session expired", "Please log in again.");
                }
                return Promise.reject(error);
            },
        );
    }

    // ── 6. Fetch API wrapper (optional global override) ────────────────────
    const _fetch = window.fetch;
    window.fetch = async (...args) => {
        const res = await _fetch(...args);
        const clone = res.clone();
        try {
            const ct = res.headers.get("content-type") ?? "";
            if (ct.includes("application/json")) {
                const data = await clone.json();
                if (data?.flash) {
                    const f = data.flash;
                    toast(
                        TYPE_MAP[f.type] ?? "info",
                        f.title ?? TITLES[f.type] ?? "Notice",
                        f.message,
                    );
                }
            }
        } catch {}
        return res;
    };
}

document.addEventListener("DOMContentLoaded", detectAndFire);

<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
        }

        body {
            font-family: 'Manrope', sans-serif;
        }

        /* ── Sidebar transitions ── */
        #sidebar {
            transition: transform 0.3s cubic-bezier(.4, 0, .2, 1), width 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        #sidebar-overlay {
            transition: opacity 0.3s;
        }

        /* ── Submenu ── */
        .submenu {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s cubic-bezier(.4, 0, .2, 1), opacity 0.2s;
        }

        .submenu.open {
            max-height: 300px;
            opacity: 1;
        }

        /* ── Chevron ── */
        .chevron {
            transition: transform 0.25s cubic-bezier(.4, 0, .2, 1);
        }

        .chevron.open {
            transform: rotate(180deg);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d0d8db;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #536c77;
        }

        /* ── Active nav item ── */
        .nav-active {
            background: #536c7712;
            border-right: 3px solid #536c77;
            color: #536c77 !important;
        }

        .nav-active .material-symbols-outlined {
            color: #536c77;
        }

        /* ── Desktop collapse ── */
        @media (min-width: 1024px) {
            body.sidebar-collapsed #sidebar {
                width: 68px;
            }

            body.sidebar-collapsed #sidebar .nav-label,
            body.sidebar-collapsed #sidebar .sidebar-logo-text,
            body.sidebar-collapsed #sidebar .sidebar-new-btn-text,
            body.sidebar-collapsed #sidebar .chevron,
            body.sidebar-collapsed #sidebar .submenu {
                display: none !important;
            }

            body.sidebar-collapsed #sidebar .nav-item {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            body.sidebar-collapsed #sidebar .nav-item .material-symbols-outlined {
                margin: 0 auto;
            }

            body.sidebar-collapsed main {
                margin-left: 68px;
            }

            body.sidebar-collapsed #top-header {
                width: calc(100% - 68px);
            }
        }

        /* ── Smooth layout transitions ── */
        main,
        #top-header {
            transition: margin-left 0.3s cubic-bezier(.4, 0, .2, 1), width 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        /* ── Bar chart ── */
        .bar-col {
            transition: background-color 0.15s;
        }

        #toast-viewport {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 9999;
            width: 320px;
            pointer-events: none;
        }

        .toast {
            pointer-events: all;
            background: #fff;
            border: 0.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            animation: toastIn 0.28s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            position: relative;
            overflow: hidden;
        }

        .toast.removing {
            animation: toastOut 0.22s ease-in forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(24px) scale(.97);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                max-height: 80px;
            }

            to {
                opacity: 0;
                transform: translateX(24px) scale(.96);
                max-height: 0;
                padding: 0;
            }
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            border-radius: 0;
            animation: toastProgress linear forwards;
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .toast-body {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-size: 13px;
            font-weight: 600;
            color: #1e2a2e;
            margin: 0 0 2px;
        }

        .toast-msg {
            font-size: 12px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        .toast-close {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #94a3b8;
            font-size: 15px;
            flex-shrink: 0;
            opacity: .6;
            transition: opacity .15s;
        }

        .toast-close:hover {
            opacity: 1;
        }

        .toast-action {
            background: none;
            border: 0.5px solid #e2e8f0;
            border-radius: 6px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background .15s;
            color: #1e2a2e;
        }

        .toast-action:hover {
            background: #f8fafc;
        }

        .toast-spin {
            display: inline-block;
            animation: spin .9s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .t-success .toast-icon {
            background: #EAF3DE;
            color: #3B6D11;
        }

        .t-success .toast-progress {
            background: #639922;
        }

        .t-error .toast-icon {
            background: #FCEBEB;
            color: #A32D2D;
        }

        .t-error .toast-progress {
            background: #E24B4A;
        }

        .t-warning .toast-icon {
            background: #FAEEDA;
            color: #854F0B;
        }

        .t-warning .toast-progress {
            background: #BA7517;
        }

        .t-info .toast-icon {
            background: #E6F1FB;
            color: #185FA5;
        }

        .t-info .toast-progress {
            background: #378ADD;
        }

        .t-loading .toast-icon {
            background: #f1f5f9;
            color: #64748b;
        }

        .t-loading .toast-progress {
            background: #7F77DD;
        }
    </style>

    @foreach (['success', 'error', 'warning', 'info', 'danger'] as $type)
        @if (session($type))
            <meta name="flash-{{ $type }}" content="{{ session($type) }}">
        @endif
    @endforeach
</head>

<body class="bg-[#f4f6f7] text-[#1e2a2e]">

    <!-- Mobile overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 lg:hidden"
        onclick="closeSidebar()"></div>

    {{-- ═══════════════════════════════════════
         SIDEBAR  (white, bordered)
    ═══════════════════════════════════════ --}}
    <aside id="sidebar"
        class="fixed left-0 top-0 h-screen w-[260px] bg-white border-r border-slate-200 flex flex-col z-50 -translate-x-full lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-slate-100 shrink-0">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Aura Clinic" class="h-8 w-auto">
            {{-- fallback text logo if image missing --}}
            {{-- <span class="sidebar-logo-text font-bold text-[17px] text-[#536c77]">Aura Clinic</span> --}}

            {{-- Close (mobile) --}}
            <button onclick="closeSidebar()"
                class="ml-auto text-slate-400 hover:text-[#536c77] lg:hidden transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-3 px-2.5 space-y-0.5">

            {{-- Dashboard (active) --}}
            <a href="#"
                class="nav-item nav-active flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-[13.5px]">
                <span class="material-symbols-outlined shrink-0" style="color:#536c77">dashboard</span>
                <span class="nav-label">Dashboard</span>
            </a>

            {{-- company --}}
            @superAdmin
                {{-- @dd(auth()->user()->super_admin) --}}
                <div>
                    <button onclick="toggleSubmenu('submenu-appointments', this)"
                        class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                        <span class="material-symbols-outlined shrink-0">calendar_month</span>
                        <span class="nav-label flex-1 text-left">Company</span>
                        <span class="material-symbols-outlined chevron nav-label" style="font-size:16px">expand_more</span>
                    </button>
                    <div id="submenu-appointments" class="submenu ml-3 mt-0.5 pl-5 border-l-2 border-slate-100 space-y-0.5">
                        <a href="{{ route('admin.company.create') }}"
                            class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Create
                        </a>
                        <a href="#"
                            class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Calendar View
                        </a>
                        <a href="#"
                            class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Waitlist
                        </a>
                        <a href="#"
                            class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Recurring Bookings
                        </a>
                    </div>
                </div>
            @endsuperAdmin

            {{-- Patients --}}
            <div>
                <button onclick="toggleSubmenu('submenu-patients', this)"
                    class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                    <span class="material-symbols-outlined shrink-0">group</span>
                    <span class="nav-label flex-1 text-left">Projects</span>
                    <span class="material-symbols-outlined chevron nav-label" style="font-size:16px">expand_more</span>
                </button>
                <div id="submenu-patients" class="submenu ml-3 mt-0.5 pl-5 border-l-2 border-slate-100 space-y-0.5">
                    <a href="{{ route('company.projects.index') }}"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>create
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>New Patient
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Medical Records
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Consent Forms
                    </a>
                </div>
            </div>

            {{-- Treatments --}}
            <div>
                <button onclick="toggleSubmenu('submenu-treatments', this)"
                    class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                    <span class="material-symbols-outlined shrink-0">medical_services</span>
                    <span class="nav-label flex-1 text-left">Treatments</span>
                    <span class="material-symbols-outlined chevron nav-label" style="font-size:16px">expand_more</span>
                </button>
                <div id="submenu-treatments" class="submenu ml-3 mt-0.5 pl-5 border-l-2 border-slate-100 space-y-0.5">
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Service Catalog
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Treatment Plans
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Before & After
                    </a>
                </div>
            </div>

            {{-- Payments --}}
            <div>
                <button onclick="toggleSubmenu('submenu-payments', this)"
                    class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                    <span class="material-symbols-outlined shrink-0">payments</span>
                    <span class="nav-label flex-1 text-left">Payments</span>
                    <span class="material-symbols-outlined chevron nav-label" style="font-size:16px">expand_more</span>
                </button>
                <div id="submenu-payments" class="submenu ml-3 mt-0.5 pl-5 border-l-2 border-slate-100 space-y-0.5">
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Invoices
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                        Pending
                        <span
                            class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">3</span>
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Refunds
                    </a>
                </div>
            </div>

            {{-- Staff --}}
            <div>
                <button onclick="toggleSubmenu('submenu-staff', this)"
                    class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                    <span class="material-symbols-outlined shrink-0">badge</span>
                    <span class="nav-label flex-1 text-left">Staff</span>
                    <span class="material-symbols-outlined chevron nav-label"
                        style="font-size:16px">expand_more</span>
                </button>
                <div id="submenu-staff" class="submenu ml-3 mt-0.5 pl-5 border-l-2 border-slate-100 space-y-0.5">
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Team Members
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Schedules
                    </a>
                    <a href="#"
                        class="submenu-link flex items-center gap-2 px-3 py-2 rounded-lg text-slate-500 hover:text-[#536c77] hover:bg-slate-50 text-[12.5px] transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>Roles & Permissions
                    </a>
                </div>
            </div>

            {{-- Divider --}}
            <div class="my-2 border-t border-slate-100"></div>

            {{-- Reports --}}
            <a href="{{ route('admin.roles.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                <span class="material-symbols-outlined shrink-0">assessment</span>
                <span class="nav-label">Roles & Permissions</span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('admin.permissions.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                <span class="material-symbols-outlined shrink-0">settings</span>
                <span class="nav-label">Permissions</span>
            </a>
            <a href="#"
                class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-[#536c77] transition-all duration-150 text-[13.5px]">
                <span class="material-symbols-outlined shrink-0">settings</span>
                <span class="nav-label">Settings</span>
            </a>

        </nav>

        {{-- New Appointment CTA --}}
        <div class="px-3 py-4 border-t border-slate-100 shrink-0">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl
                   font-semibold text-[13px] text-red-700
                   bg-red-50 hover:bg-red-100
                   active:scale-95 transition-all duration-200">
                    <span class="material-symbols-outlined shrink-0">
                        logout
                    </span>

                    <span>
                        Logout
                    </span>
                </button>
            </form>
        </div>

    </aside>

    {{-- ═══════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════ --}}
    <main id="main-content" class="lg:ml-[260px] min-h-screen flex flex-col">

        {{-- TOP HEADER --}}
        <header id="top-header"
            class="sticky top-0 w-full bg-white border-b border-slate-200 flex items-center gap-4 px-4 lg:px-6 h-16 z-30 shrink-0">

            {{-- Hamburger (mobile) --}}
            <button onclick="openSidebar()"
                class="lg:hidden text-slate-500 hover:text-[#536c77] transition-colors p-1">
                <span class="material-symbols-outlined">menu</span>
            </button>

            {{-- Collapse toggle (desktop) --}}
            <button onclick="toggleCollapse()"
                class="hidden lg:flex text-slate-500 hover:text-[#536c77] transition-colors p-1"
                title="Toggle sidebar">
                <span class="material-symbols-outlined">menu</span>
            </button>

            {{-- Search --}}
            <div
                class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-2 flex-1 max-w-xs lg:max-w-md">
                <span class="material-symbols-outlined text-slate-400 shrink-0" style="font-size:18px">search</span>
                <input
                    class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 outline-none"
                    placeholder="Search patients, treatments..." type="text" />
            </div>

            <div class="ml-auto flex items-center gap-2 lg:gap-3">

                {{-- Notification --}}
                <button
                    class="relative p-2 text-slate-500 hover:text-[#536c77] hover:bg-slate-50 rounded-xl transition-all">
                    <span class="material-symbols-outlined">notifications</span>
                    <span
                        class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                {{-- Divider --}}
                <div class="hidden sm:block h-7 w-px bg-slate-200"></div>

                {{-- Profile --}}
                <div class="flex items-center gap-2 cursor-pointer group">
                    <img alt="Receptionist Profile"
                        class="w-9 h-9 rounded-full object-cover border-2 border-white ring-2 ring-slate-200 group-hover:ring-[#536c77]/40 transition-all"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuADatYABYjqnChzgYlg2TE9WBeylrs8QriGgvvnWYipknAzhVxC1Um--O7k61VN5YTpuOVHIYWmi1BLNBxnkBiqh17ydH1qpwU31mjXjLp0HRwmY8B-ORvDtGWR8vYwAhKiQzFfaHE_ZOwZH6-FUXK6AGbjrU35oiHqlXwzZ1zot_ruB9itxZK2VaaWsVxgDLU88AfJS9Za13nc8-2F9pEYboEcOhr4SsaoIEE7j9WJPfjj8L4q9wrF4tqtDANqRF9rWxoNAaWPB7WJ" />
                    <div class="hidden md:block">
                        <p class="text-sm font-bold leading-tight text-slate-700">Sarah Jenkins</p>
                        <p class="text-[11px] text-slate-400">Reception</p>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 hidden md:block"
                        style="font-size:16px">expand_more</span>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="flex-1 px-4 lg:px-8 py-6 space-y-6">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer
            class="border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-2 px-6 py-4 text-[11px] text-slate-400">
            <p>© 2024 Aura Aesthetics Clinic. Professional Edition.</p>
            <div class="flex gap-4">
                <a class="hover:text-[#536c77] underline transition-all" href="#">Support</a>
                <a class="hover:text-[#536c77] underline transition-all" href="#">Privacy Policy</a>
                <a class="hover:text-[#536c77] underline transition-all" href="#">User Guide</a>
            </div>
        </footer>

    </main>

    <script>
        // ── Date display ──
        const dateEl = document.getElementById('current-date');
        if (dateEl) {
            dateEl.textContent = new Date().toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        }

        // ── Mobile sidebar ──
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden', 'opacity-0');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => {
                overlay.classList.add('hidden', 'opacity-0');
            }, 300);
            document.body.style.overflow = '';
        }

        // ── Desktop collapse ──
        function toggleCollapse() {
            document.body.classList.toggle('sidebar-collapsed');
            if (document.body.classList.contains('sidebar-collapsed')) {
                document.querySelectorAll('.submenu.open').forEach(el => {
                    el.classList.remove('open');
                    el.previousElementSibling?.querySelector('.chevron')?.classList.remove('open');
                });
            }
        }

        // ── Submenu toggle ──
        function toggleSubmenu(id, btn) {
            const submenu = document.getElementById(id);
            const chevron = btn.querySelector('.chevron');
            const isOpen = submenu.classList.contains('open');

            document.querySelectorAll('.submenu').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('.chevron').forEach(el => el.classList.remove('open'));

            if (!isOpen) {
                submenu.classList.add('open');
                chevron?.classList.add('open');
            }
        }

        // ── Close overlay on resize to desktop ──
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                overlay.classList.add('hidden', 'opacity-0');
                overlay.classList.remove('opacity-100');
                document.body.style.overflow = '';
            }
        });
    </script>

</body>

</html>

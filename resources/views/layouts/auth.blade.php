<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
        }

        /* ── Decorative panel pattern ── */
        .auth-panel {
            background-color: #536c77;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ── Input focus ── */
        .auth-input {
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .auth-input:focus {
            border-color: #536c77;
            box-shadow: 0 0 0 3px rgba(83, 108, 119, 0.12);
            outline: none;
        }

        /* ── Page fade in ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.4s cubic-bezier(.4, 0, .2, 1) both;
        }

        .fade-up-delay {
            animation: fadeUp 0.4s 0.08s cubic-bezier(.4, 0, .2, 1) both;
        }

        /* ── Password toggle ── */
        .pw-toggle {
            cursor: pointer;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d0d8db;
            border-radius: 9999px;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f6f7] flex">

    {{-- ── Left decorative panel (hidden on mobile) ── --}}
    <div
        class="auth-panel hidden lg:flex lg:w-[420px] xl:w-[480px] shrink-0 flex-col justify-between p-10 relative overflow-hidden">

        {{-- Logo --}}
        <div class="relative z-10">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Aura Clinic" class="h-9 w-auto brightness-0 invert" />
        </div>

        {{-- Centre illustration / quote --}}
        <div class="relative z-10 text-white">
            {{-- Abstract orb decoration --}}
            <div class="absolute -top-32 -left-16 w-64 h-64 rounded-full opacity-10"
                style="background: radial-gradient(circle, #fff 0%, transparent 70%)"></div>

            <p class="text-[13px] font-medium uppercase tracking-[0.15em] text-white/50 mb-4">Aura Aesthetics Clinic</p>
            <h2 class="text-3xl font-bold leading-snug mb-4">
                Streamline your<br>clinic, elevate<br>every experience.
            </h2>
            <p class="text-white/60 text-[14px] leading-relaxed max-w-xs">
                One platform for appointments, patients, treatments, and payments — built for modern aesthetics
                practices.
            </p>

            {{-- Stats row --}}
            <div class="flex gap-8 mt-10 pt-8 border-t border-white/10">
                <div>
                    <p class="text-2xl font-bold">1,240+</p>
                    <p class="text-white/50 text-[12px] mt-0.5">Active Patients</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">98%</p>
                    <p class="text-white/50 text-[12px] mt-0.5">Satisfaction Rate</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">24/7</p>
                    <p class="text-white/50 text-[12px] mt-0.5">Support Access</p>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <p class="relative z-10 text-white/30 text-[11px]">© {{ date('Y') }} Aura Aesthetics Clinic</p>
    </div>

    {{-- ── Right content area ── --}}
    <div class="flex-1 flex flex-col min-h-screen">

        {{-- Mobile logo bar --}}
        <div class="lg:hidden flex items-center px-6 py-5 border-b border-slate-200 bg-white">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Aura Clinic" class="h-7 w-auto" />
        </div>

        {{-- Centred form area --}}
        <div class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-md fade-up">
                @yield('auth-content')
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-2 border-t border-slate-200 bg-white">
            <p class="text-[11px] text-slate-400">© {{ date('Y') }} Aura Aesthetics Clinic. Professional Edition.
            </p>
            <div class="flex gap-4 text-[11px]">
                <a href="#" class="text-slate-400 hover:text-[#536c77] underline transition-colors">Support</a>
                <a href="#" class="text-slate-400 hover:text-[#536c77] underline transition-colors">Privacy
                    Policy</a>
            </div>
        </div>

    </div>

</body>

</html>

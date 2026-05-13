@extends('layouts.auth')

@section('title', 'Reset Password')

@section('auth-content')

    {{-- Icon --}}
    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6" style="background:rgba(83,108,119,0.10)">
        <span class="material-symbols-outlined" style="font-size:24px;color:#536c77">key</span>
    </div>

    {{-- Heading --}}
    <div class="mb-8">
        <p class="text-[12px] font-semibold uppercase tracking-widest text-[#536c77] mb-2">Set new password</p>
        <h1 class="text-2xl font-bold text-slate-800">Reset your password</h1>
        <p class="text-slate-500 text-sm mt-1.5">
            Choose a strong password for your Aura Clinic account.
        </p>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-5 flex items-start gap-2 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <span class="material-symbols-outlined text-red-500 shrink-0 mt-0.5" style="font-size:18px">error</span>
            <ul class="space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        {{-- Hidden token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}" />

        {{-- Email (pre-filled, readonly) --}}
        <div>
            <label for="email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                Email address
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autocomplete="username" readonly
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed @error('email') border-red-400 @enderror" />
            </div>
            @error('email')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- New password --}}
        <div>
            <label for="password" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                New password
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">lock</span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Min. 8 characters"
                    class="auth-input w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400 @error('password') border-red-400 @enderror" />
                <button type="button" onclick="togglePassword('password', this)"
                    class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#536c77] transition-colors">
                    <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                </button>
            </div>
            {{-- Strength bars --}}
            <div class="mt-2 flex gap-1">
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb1"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb2"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb3"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb4"></div>
            </div>
            @error('password')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm new password --}}
        <div>
            <label for="password_confirmation" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                Confirm new password
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">lock_reset</span>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Re-enter new password"
                    class="auth-input w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400" />
                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#536c77] transition-colors">
                    <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                </button>
            </div>
        </div>

        {{-- Password rules hint --}}
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
            <p class="text-[12px] font-semibold text-slate-600 mb-2">Password must include:</p>
            <div class="flex items-center gap-2 text-[12px] text-slate-500" id="rule-length">
                <span class="material-symbols-outlined" style="font-size:14px;color:#94a3b8">radio_button_unchecked</span>
                At least 8 characters
            </div>
            <div class="flex items-center gap-2 text-[12px] text-slate-500" id="rule-upper">
                <span class="material-symbols-outlined" style="font-size:14px;color:#94a3b8">radio_button_unchecked</span>
                One uppercase letter
            </div>
            <div class="flex items-center gap-2 text-[12px] text-slate-500" id="rule-number">
                <span class="material-symbols-outlined" style="font-size:14px;color:#94a3b8">radio_button_unchecked</span>
                One number
            </div>
            <div class="flex items-center gap-2 text-[12px] text-slate-500" id="rule-special">
                <span class="material-symbols-outlined" style="font-size:14px;color:#94a3b8">radio_button_unchecked</span>
                One special character
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-semibold text-[14px] transition-all active:scale-[0.98] flex items-center justify-center gap-2"
            style="background:#536c77">
            <span class="material-symbols-outlined" style="font-size:18px">check_circle</span>
            Reset password
        </button>

    </form>

    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('.material-symbols-outlined');
            field.type = field.type === 'password' ? 'text' : 'password';
            icon.textContent = field.type === 'password' ? 'visibility' : 'visibility_off';
        }

        // ── Strength + rules ──
        document.getElementById('password')?.addEventListener('input', function() {
            const val = this.value;
            const bars = [sb1, sb2, sb3, sb4];
            const cols = ['bg-red-400', 'bg-amber-400', 'bg-yellow-400', 'bg-green-500'];
            const checks = [{
                    id: 'rule-length',
                    ok: val.length >= 8
                },
                {
                    id: 'rule-upper',
                    ok: /[A-Z]/.test(val)
                },
                {
                    id: 'rule-number',
                    ok: /[0-9]/.test(val)
                },
                {
                    id: 'rule-special',
                    ok: /[^A-Za-z0-9]/.test(val)
                },
            ];

            const score = checks.filter(c => c.ok).length;

            bars.forEach((b, i) => {
                b.className = 'h-1 flex-1 rounded-full ' + (i < score ? cols[score - 1] : 'bg-slate-200');
            });

            checks.forEach(({
                id,
                ok
            }) => {
                const row = document.getElementById(id);
                const icon = row.querySelector('.material-symbols-outlined');
                icon.textContent = ok ? 'check_circle' : 'radio_button_unchecked';
                icon.style.color = ok ? '#536c77' : '#94a3b8';
                row.style.color = ok ? '#536c77' : '';
            });
        });
    </script>

@endsection

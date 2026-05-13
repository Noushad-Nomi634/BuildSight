@extends('layouts.auth')

@section('title', 'Create Account')

@section('auth-content')

    {{-- Heading --}}
    <div class="mb-8">
        <p class="text-[12px] font-semibold uppercase tracking-widest text-[#536c77] mb-2">Get started</p>
        <h1 class="text-2xl font-bold text-slate-800">Create your account</h1>
        <p class="text-slate-500 text-sm mt-1.5">Set up your reception team access in under a minute.</p>
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
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Full name --}}
        <div>
            <label for="name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Full name</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">person</span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Sarah Jenkins"
                    class="auth-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400 @error('name') border-red-400 @enderror" />
            </div>
            @error('name')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username" placeholder="you@auraclinic.com"
                    class="auth-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400 @error('email') border-red-400 @enderror" />
            </div>
            @error('email')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role / Position (optional UX field, not stored by default — remove if not needed) --}}
        <div>
            <label for="role" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                Role
                <span class="text-slate-400 font-normal ml-1">(optional)</span>
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">badge</span>
                <select id="role" name="role"
                    class="auth-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 appearance-none cursor-pointer">
                    <option value="">Select your role…</option>
                    <option value="receptionist" {{ old('role') === 'receptionist' ? 'selected' : '' }}>Receptionist
                    </option>
                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Clinic Manager</option>
                    <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor / Practitioner
                    </option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <span
                    class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"
                    style="font-size:16px">expand_more</span>
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Password</label>
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
            {{-- Strength indicator --}}
            <div class="mt-2 flex gap-1" id="strength-bars">
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb1"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb2"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb3"></div>
                <div class="h-1 flex-1 rounded-full bg-slate-200" id="sb4"></div>
            </div>
            @error('password')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="password_confirmation" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                Confirm password
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">lock_reset</span>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Re-enter password"
                    class="auth-input w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400" />
                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#536c77] transition-colors">
                    <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                </button>
            </div>
        </div>

        {{-- Terms --}}
        <div class="flex items-start gap-2.5 pt-1">
            <input id="terms" type="checkbox" name="terms" required
                class="w-4 h-4 mt-0.5 rounded border-slate-300 text-[#536c77] focus:ring-[#536c77]/30 cursor-pointer shrink-0" />
            <label for="terms" class="text-[13px] text-slate-500 leading-relaxed cursor-pointer">
                I agree to the
                <a href="#" class="text-[#536c77] hover:underline font-medium">Terms of Service</a>
                and
                <a href="#" class="text-[#536c77] hover:underline font-medium">Privacy Policy</a>
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-semibold text-[14px] transition-all active:scale-[0.98] flex items-center justify-center gap-2 mt-2"
            style="background:#536c77">
            <span class="material-symbols-outlined" style="font-size:18px">person_add</span>
            Create account
        </button>

    </form>

    {{-- Login link --}}
    <p class="mt-6 text-center text-[13px] text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-[#536c77] font-semibold hover:underline transition-colors ml-1">
            Sign in
        </a>
    </p>

    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('.material-symbols-outlined');
            field.type = field.type === 'password' ? 'text' : 'password';
            icon.textContent = field.type === 'password' ? 'visibility' : 'visibility_off';
        }

        // ── Password strength ──
        document.getElementById('password')?.addEventListener('input', function() {
            const val = this.value;
            const bars = [sb1, sb2, sb3, sb4];
            const colors = ['bg-red-400', 'bg-amber-400', 'bg-yellow-400', 'bg-green-500'];
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            bars.forEach((b, i) => {
                b.className = 'h-1 flex-1 rounded-full ' +
                    (i < score ? colors[score - 1] : 'bg-slate-200');
            });
        });
    </script>

@endsection

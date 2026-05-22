@extends('layouts.auth')

@section('title', 'Sign In')

@section('auth-content')

    {{-- Heading --}}
    <div class="mb-8">
        <p class="text-[12px] font-semibold uppercase tracking-widest text-[#536c77] mb-2">Welcome back</p>
        <h1 class="text-2xl font-bold text-slate-800">Sign in to your account</h1>
        <p class="text-slate-500 text-sm mt-1.5">Enter your credentials to access the reception dashboard.</p>
    </div>

    {{-- Session status (e.g. after logout) --}}
    @if (session('status'))
        <div
            class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            <span class="material-symbols-outlined text-green-500" style="font-size:18px">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

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
    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                Email address
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="you@auraclinic.com"
                    class="auth-input w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400 @error('email') border-red-400 @enderror" />
            </div>
            @error('email')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-[13px] font-semibold text-slate-700">Password</label>
                <a href="{{ route('password.request') }}"
                    class="text-[12px] text-[#536c77] hover:underline font-medium transition-colors">
                    Forgot password?
                </a>
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    style="font-size:18px">lock</span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="auth-input w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder:text-slate-400 @error('password') border-red-400 @enderror" />
                <button type="button" onclick="togglePassword('password', this)"
                    class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#536c77] transition-colors">
                    <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-slate-300 text-[#536c77] focus:ring-[#536c77]/30 cursor-pointer" />
            <label for="remember_me" class="text-[13px] text-slate-600 cursor-pointer select-none">
                Keep me signed in
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-semibold text-[14px] transition-all active:scale-[0.98] flex items-center justify-center gap-2"
            style="background:#536c77">
            <span class="material-symbols-outlined" style="font-size:18px">login</span>
            Sign in
        </button>

    </form>

    {{-- Register link --}}
   {{-- <p class="mt-6 text-center text-[13px] text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-[#536c77] font-semibold hover:underline transition-colors ml-1">
            Create one
        </a>
    </p>--}}

    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('.material-symbols-outlined');
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                field.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>

@endsection

@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('auth-content')

    {{-- Back link --}}
    <a href="{{ route('login') }}"
        class="inline-flex items-center gap-1.5 text-[13px] text-slate-500 hover:text-[#536c77] transition-colors mb-8 group">
        <span class="material-symbols-outlined group-hover:-translate-x-0.5 transition-transform"
            style="font-size:18px">arrow_back</span>
        Back to sign in
    </a>

    {{-- Icon --}}
    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6" style="background:rgba(83,108,119,0.10)">
        <span class="material-symbols-outlined" style="font-size:24px;color:#536c77">lock_reset</span>
    </div>

    {{-- Heading --}}
    <div class="mb-8">
        <p class="text-[12px] font-semibold uppercase tracking-widest text-[#536c77] mb-2">Account recovery</p>
        <h1 class="text-2xl font-bold text-slate-800">Forgot your password?</h1>
        <p class="text-slate-500 text-sm mt-1.5 leading-relaxed">
            No worries. Enter the email address linked to your account and we'll send you a secure reset link.
        </p>
    </div>

    {{-- Success message --}}
    @if (session('status'))
        <div class="mb-6 flex items-start gap-3 px-4 py-4 rounded-xl bg-green-50 border border-green-200">
            <span class="material-symbols-outlined text-green-500 shrink-0 mt-0.5"
                style="font-size:20px">mark_email_read</span>
            <div>
                <p class="text-[13px] font-semibold text-green-800 mb-0.5">Email sent!</p>
                <p class="text-[12px] text-green-700">{{ session('status') }}</p>
            </div>
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
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-semibold text-[14px] transition-all active:scale-[0.98] flex items-center justify-center gap-2"
            style="background:#536c77">
            <span class="material-symbols-outlined" style="font-size:18px">send</span>
            Send reset link
        </button>

    </form>

    {{-- Help note --}}
    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
        <p class="text-[12px] text-slate-500 leading-relaxed">
            <span class="font-semibold text-slate-600">Didn't receive the email?</span>
            Check your spam folder or
            <a href="{{ route('password.email') }}" class="text-[#536c77] hover:underline font-medium">try again</a>
            with a different address.
        </p>
    </div>

@endsection

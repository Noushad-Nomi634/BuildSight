@extends('layouts.app')

@section('title', 'Add Storage')

@section('content')

<div class="max-w-xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-5">

        <div>
            <h2 class="text-xl font-bold text-on-surface">Add Storage</h2>
            <p class="text-sm text-text-muted">Create new storage record</p>
        </div>

        <a href="/admin/storage"
           class="text-sm text-primary hover:underline">
            ← Back
        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm p-6">

        <form action="/admin/storage/store"
              method="POST"
              class="space-y-5">

            @csrf

            {{-- IP --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">IP Address</label>
                <input type="text"
                       name="ip"
                       value="{{ old('ip') }}"
                       required
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- SERVER --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Server</label>
                <input type="text"
                       name="server"
                       value="{{ old('server') }}"
                       required
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- USERNAME --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Username</label>
                <input type="text"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Password</label>
                <input type="text"
                       name="password"
                       value="{{ old('password') }}"
                       required
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- PATH --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Path</label>
                <input type="text"
                       name="path"
                       value="{{ old('path') }}"
                       required
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- BUTTON (CENTER) --}}
            <div class="pt-2 flex justify-center">
                <button type="submit"
                        class="flex items-center gap-2 py-2.5 px-6 rounded-xl
                               bg-primary text-white font-bold
                               hover:bg-primary/90 transition">

                    <span class="material-symbols-outlined text-[18px]">
                        save
                    </span>

                    Save Storage

                </button>
            </div>

        </form>

    </div>

</div>

@endsection
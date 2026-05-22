@extends('layouts.app')

@section('title', 'Edit Storage')

@section('content')

<div class="max-w-xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-5">

        <div>
            <h2 class="text-xl font-bold text-on-surface">Edit Storage</h2>
            <p class="text-sm text-text-muted">Update storage server details</p>
        </div>

        <a href="{{ route('admin.storage.index') }}"
           class="text-sm text-primary hover:underline">
            ← Back
        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm p-6">

        <form method="POST"
              action="{{ route('admin.storage.update', $data->id) }}"
              class="space-y-5">

            @csrf
            @method('PUT') {{-- ✅ REQUIRED FOR UPDATE ROUTE --}}

            {{-- IP --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    IP Address
                </label>

                <input type="text"
                       name="ip"
                       value="{{ $data->ip }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- SERVER --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Server
                </label>

                <input type="text"
                       name="server"
                       value="{{ $data->server }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- USERNAME --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Username
                </label>

                <input type="text"
                       name="username"
                       value="{{ $data->username }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Password
                </label>

                <input type="password"
                       name="password"
                       value="{{ $data->password }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- PATH --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Path
                </label>

                <input type="text"
                       name="path"
                       value="{{ $data->path }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-secondary-container/60
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary
                              text-on-surface">
            </div>

            {{-- BUTTON --}}
           <div class="flex justify-center">
    <button type="submit"
            class="bg-primary text-white py-2.5 px-6 rounded-xl font-bold
                   hover:bg-primary/90 transition">

        Update Storage

    </button>
</div>

        </form>

    </div>
</div>

@endsection
@extends('layouts.app')

@section('title', $camera->name)

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">
            {{ $camera->name }}
        </h2>

        <div class="flex items-center gap-2 mt-1 text-sm text-text-muted">
            <span class="material-symbols-outlined" style="font-size:14px">work</span>
            <span>Project: {{ $camera->project_name ?? '—' }}</span>
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="flex items-center gap-2 flex-wrap">

        <a href="{{ route('company.cameras.edit', $camera->id) }}"
           class="flex items-center gap-2 bg-primary text-white text-[13px] font-bold px-4 py-2.5
                  rounded-xl hover:bg-primary/90 transition-all shadow-sm active:scale-[0.98]">

            <span class="material-symbols-outlined" style="font-size:17px">edit</span>
            Edit
        </a>

        <form action="{{ route('company.cameras.destroy', $camera->id) }}"
              method="POST"
              onsubmit="return confirm('Delete this camera?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                class="flex items-center gap-2 bg-surface-white hover:bg-status-cancelled/10 border
                       border-secondary-container hover:border-status-cancelled/30 text-status-cancelled
                       text-[13px] font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm
                       active:scale-[0.98]">

                <span class="material-symbols-outlined" style="font-size:17px">delete</span>
                Delete
            </button>
        </form>

    </div>
</div>

{{-- STATUS BADGE --}}
@php
    $statusBadge = $camera->is_active
        ? 'bg-status-completed/10 text-status-completed'
        : 'bg-status-cancelled/10 text-status-cancelled';

    $statusDot = $camera->is_active
        ? 'bg-status-completed'
        : 'bg-status-cancelled';
@endphp

<div class="flex flex-wrap items-center gap-2 mb-4">

    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px]
                 font-bold uppercase tracking-wide {{ $statusBadge }}">

        <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
        {{ $camera->is_active ? 'Active' : 'Inactive' }}
    </span>

</div>

{{-- CARD --}}
<div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

    <div class="p-5 space-y-5">

        {{-- IP + PORT --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    IP Address
                </label>
                <p class="mt-1 text-[13px] font-semibold text-on-surface">
                    {{ $camera->ip_address ?? '—' }}
                </p>
            </div>

            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Port
                </label>
                <p class="mt-1 text-[13px] font-semibold text-on-surface">
                    {{ $camera->port ?? '—' }}
                </p>
            </div>

        </div>

        {{-- CREDENTIALS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Username
                </label>
                <p class="mt-1 text-[13px] font-semibold text-on-surface">
                    {{ $camera->username ?? '—' }}
                </p>
            </div>

            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Password
                </label>
                <p class="mt-1 text-[13px] font-semibold text-on-surface">
                    {{ $camera->password ?? '—' }}
                </p>
            </div>

        </div>

        {{-- SNAPSHOT --}}
        <div>
            <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                Snapshot URL
            </label>

            @if($camera->snapshot_url)
                <a href="{{ $camera->snapshot_url }}" target="_blank"
                   class="mt-1 inline-flex items-center gap-1.5 text-[13px] font-bold text-primary hover:underline">

                    <span class="material-symbols-outlined" style="font-size:15px">open_in_new</span>
                    Open Snapshot
                </a>
            @else
                <p class="mt-1 text-[13px] text-text-muted">—</p>
            @endif
        </div>

        {{-- UPLOAD METHOD --}}
        <div>
            <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                Upload Method
            </label>
            <p class="mt-1 text-[13px] font-semibold text-on-surface">
                {{ $camera->upload_method ?? '—' }}
            </p>
        </div>

        {{-- CREATED AT --}}
        <div>
            <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                Created At
            </label>
            <p class="mt-1 text-[13px] font-semibold text-on-surface">
                {{ optional($camera->created_at)->format('M d, Y') }}
            </p>
        </div>

    </div>
</div>

@endsection
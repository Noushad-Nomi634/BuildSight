@extends('layouts.app')

@section('title', 'Cameras')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">All Cameras</h2>
        <p class="text-sm text-text-muted mt-0.5">Manage all project cameras</p>
    </div>

    <a href="{{ route('company.cameras.create') }}"
       class="flex items-center gap-2 bg-primary text-white text-[13px] font-bold px-4 py-2.5
              rounded-xl hover:bg-primary/90 transition-all shadow-sm active:scale-[0.98] w-fit">

        <span class="material-symbols-outlined" style="font-size:17px">add_circle</span>
        Add Camera
    </a>

</div>

{{-- CARD --}}
<div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

    {{-- TABLE HEADER --}}
    <div class="grid grid-cols-6 bg-surface-container-low text-[11px] font-bold text-text-muted
                px-5 py-3 uppercase tracking-wide">

        <div>ID</div>
        <div>Name</div>
        <div>Project</div>
        <div>IP Address</div>
        <div>Status</div>
        <div class="text-right">Actions</div>

    </div>

    {{-- TABLE BODY --}}
    @forelse($cameras as $camera)

        @php
            $isActive = $camera->is_active;

            $badge = $isActive
                ? 'bg-status-completed/10 text-status-completed'
                : 'bg-status-cancelled/10 text-status-cancelled';

            $dot = $isActive ? 'bg-status-completed' : 'bg-status-cancelled';
        @endphp

        <div class="grid grid-cols-6 items-center px-5 py-3 border-t border-secondary-container/50
                    hover:bg-surface-container-low/60 transition">

            {{-- ID --}}
            <div class="text-[13px] text-text-muted font-medium">
                #{{ $camera->id }}
            </div>

            {{-- NAME --}}
            <div class="text-[13px] font-semibold text-on-surface">
                {{ $camera->name }}
            </div>

            {{-- PROJECT --}}
            <div class="text-[13px] text-text-muted">
                {{ $camera->project_name ?? '—' }}
            </div>

            {{-- IP --}}
            <div class="text-[13px] text-text-muted font-mono">
                {{ $camera->ip_address ?? '—' }}
            </div>

            {{-- STATUS --}}
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px]
                             font-bold uppercase tracking-wide {{ $badge }}">

                    <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                    {{ $isActive ? 'Active' : 'Inactive' }}
                </span>
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-1">

                {{-- VIEW --}}
                <a href="{{ route('company.cameras.show', $camera->id) }}"
                   class="p-1.5 rounded-lg hover:bg-primary/10 text-text-muted hover:text-primary transition"
                   title="View">

                    <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                </a>

                {{-- EDIT --}}
                <a href="{{ route('company.cameras.edit', $camera->id) }}"
                   class="p-1.5 rounded-lg hover:bg-status-upcoming/10 text-text-muted hover:text-status-upcoming transition"
                   title="Edit">

                    <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                </a>

                {{-- DELETE --}}
                <form action="{{ route('company.cameras.destroy', $camera->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this camera?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="p-1.5 rounded-lg hover:bg-status-cancelled/10 text-text-muted hover:text-status-cancelled transition"
                        title="Delete">

                        <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                    </button>

                </form>

            </div>

        </div>

    @empty

        <div class="p-12 text-center">
            <div class="text-text-muted text-sm">No cameras found</div>
        </div>

    @endforelse

</div>

@endsection
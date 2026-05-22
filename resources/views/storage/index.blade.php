@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">Storage Records</h2>
        <p class="text-sm text-text-muted">Manage all storage servers</p>
    </div>

    <a href="{{ route('admin.storage.create') }}"
       class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary/90">

        <span class="material-symbols-outlined text-[18px]">add</span>
        Add New
    </a>

</div>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

{{-- TABLE CARD --}}
<div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm overflow-hidden">

    {{-- TOP BAR --}}
    <div class="px-5 py-4 border-b flex justify-between items-center">

        <h3 class="font-bold text-on-surface">Storage List</h3>

        <span class="text-sm text-text-muted">
            {{ count($data) }} total
        </span>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px] text-sm">

            <thead class="bg-surface-container-low text-[11px] uppercase text-text-muted">
                <tr>
                    <th class="px-5 py-3 text-left">ID</th>
                    <th class="px-5 py-3 text-left">IP</th>
                    <th class="px-5 py-3 text-left">Server</th>
                    <th class="px-5 py-3 text-left">Username</th>
                    <th class="px-5 py-3 text-left">Password</th>
                    <th class="px-5 py-3 text-left">Path</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-secondary-container/60">

                @forelse($data as $row)

                <tr class="hover:bg-surface-container-low/60 transition">

                    <td class="px-5 py-4 text-text-muted font-medium">
                        #{{ $row->id }}
                    </td>

                    <td class="px-5 py-4 text-on-surface font-mono">
                        {{ $row->ip }}
                    </td>

                    <td class="px-5 py-4 text-on-surface">
                        {{ $row->server }}
                    </td>

                    <td class="px-5 py-4 text-text-muted">
                        {{ $row->username }}
                    </td>

                    <td class="px-5 py-4 text-text-muted">
                        {{ $row->password }}
                    </td>

                    <td class="px-5 py-4 text-text-muted">
                        {{ $row->path }}
                    </td>

                    <td class="px-5 py-4">

                        <div class="flex justify-end items-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.storage.edit', $row->id) }}"
                               class="p-2 rounded-lg hover:bg-status-upcoming/10 text-text-muted hover:text-status-upcoming transition"
                               title="Edit">

                                <span class="material-symbols-outlined text-[18px]">edit_square</span>
                            </a>

                            {{-- DELETE --}}
                            <a href="{{ route('admin.storage.delete', $row->id) }}"
                               onclick="return confirm('Delete?')"
                               class="p-2 rounded-lg hover:bg-status-cancelled/10 text-text-muted hover:text-status-cancelled transition"
                               title="Delete">

                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="p-10 text-center text-text-muted">
                        No storage records found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
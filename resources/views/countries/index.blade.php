@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">Countries</h2>
        <p class="text-sm text-text-muted">Manage all countries</p>
    </div>

    <a href="{{ route('company.countries.create') }}"
       class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary/90">

        <span class="material-symbols-outlined text-[18px]">add</span>
        Add Country
    </a>

</div>

{{-- TABLE CARD --}}
<div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm overflow-hidden">

    {{-- TOP BAR --}}
    <div class="px-5 py-4 border-b flex justify-between items-center">

        <h3 class="font-bold text-on-surface">Country List</h3>

        <span class="text-sm text-text-muted">
            {{ count($countries) }} total
        </span>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[650px] text-sm">

            {{-- HEADER --}}
            <thead class="bg-surface-container-low text-[11px] uppercase text-text-muted">
                <tr>
                    <th class="px-5 py-3 text-left">ID</th>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Code</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-secondary-container/60">

                @forelse($countries as $c)

                <tr class="hover:bg-surface-container-low/60 transition">

                    {{-- ID --}}
                    <td class="px-5 py-4 text-text-muted font-medium">
                        #{{ $c->id }}
                    </td>

                    {{-- NAME --}}
                    <td class="px-5 py-4 font-semibold text-on-surface">
                        {{ $c->name }}
                    </td>

                    {{-- CODE --}}
                    <td class="px-5 py-4 text-text-muted font-mono">
                        {{ $c->code ?? '-' }}
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-5 py-4">

                        <div class="flex justify-end items-center gap-2">

                            {{-- VIEW --}}
                            <a href="{{ route('company.countries.show', $c->id) }}"
                               class="p-2 rounded-lg hover:bg-primary/10 text-text-muted hover:text-primary transition"
                               title="View">

                                <span class="material-symbols-outlined text-[18px]">visibility</span>

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('company.countries.edit', $c->id) }}"
                               class="p-2 rounded-lg hover:bg-status-upcoming/10 text-text-muted hover:text-status-upcoming transition"
                               title="Edit">

                                <span class="material-symbols-outlined text-[18px]">edit_square</span>

                            </a>

                            {{-- DELETE --}}
                            <form method="POST"
                                  action="{{ route('company.countries.destroy', $c->id) }}"
                                  onsubmit="return confirm('Delete this country?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="p-2 rounded-lg hover:bg-status-cancelled/10 text-text-muted hover:text-status-cancelled transition"
                                    title="Delete">

                                    <span class="material-symbols-outlined text-[18px]">delete</span>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="p-10 text-center text-text-muted">
                        No countries found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
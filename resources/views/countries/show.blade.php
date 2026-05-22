@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">Country Details</h2>
        <p class="text-sm text-text-muted">View full information of country</p>
    </div>

    <a href="{{ route('company.countries.index') }}"
       class="flex items-center gap-2 bg-gray-100 text-on-surface px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200">

        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back
    </a>

</div>

{{-- CARD --}}
<div class="max-w-2xl mx-auto bg-white border border-secondary-container/60 rounded-2xl shadow-sm overflow-hidden">

    <div class="px-5 py-4 border-b">
        <h3 class="font-bold text-on-surface">Country Info</h3>
    </div>

    <div class="p-6 space-y-5">

        {{-- ID --}}
        <div>
            <p class="text-sm text-text-muted">ID</p>
            <p class="font-semibold text-on-surface">#{{ $country->id }}</p>
        </div>

        {{-- NAME --}}
        <div>
            <p class="text-sm text-text-muted">Name</p>
            <p class="font-semibold text-on-surface">{{ $country->name }}</p>
        </div>

        {{-- CODE --}}
        <div>
            <p class="text-sm text-text-muted">Code</p>
            <p class="font-semibold text-on-surface">{{ $country->code ?? '-' }}</p>
        </div>

    </div>

    {{-- FOOTER ACTIONS --}}
    <div class="px-5 py-4 border-t flex justify-end gap-3">

        <a href="{{ route('company.countries.edit', $country->id) }}"
           class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">

            Edit

        </a>

    </div>

</div>

@endsection
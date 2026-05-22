@extends('layouts.app')

@section('title', 'City Details')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">City Details</h2>
        <p class="text-sm text-text-muted">View city information</p>
    </div>

    <a href="{{ route('company.cities.index') }}"
       class="flex items-center gap-2 bg-gray-100 text-on-surface px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200">

        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back
    </a>

</div>

{{-- CARD --}}
<div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm overflow-hidden max-w-2xl mx-auto">

    {{-- TOP BAR --}}
    <div class="px-5 py-4 border-b">
        <h3 class="font-bold text-on-surface">City Information</h3>
    </div>

    {{-- CONTENT --}}
    <div class="p-6 space-y-6">

        {{-- ID --}}
        <div>
            <p class="text-sm text-text-muted">City ID</p>
            <p class="font-semibold text-on-surface">#{{ $city->id }}</p>
        </div>

        {{-- CITY NAME --}}
        <div>
            <p class="text-sm text-text-muted">City Name</p>
            <p class="font-semibold text-on-surface">{{ $city->name }}</p>
        </div>

        {{-- COUNTRY --}}
        <div>
            <p class="text-sm text-text-muted">Country</p>
            <p class="font-semibold text-on-surface">{{ $city->country_name ?? '-' }}</p>
        </div>

    </div>

    {{-- FOOTER ACTION --}}
    <div class="px-5 py-4 border-t flex justify-end gap-3">

        <a href="{{ route('company.cities.edit', $city->id) }}"
           class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">

            Edit

        </a>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('title', 'Create City')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-on-surface">Create City</h2>

        <a href="{{ route('company.cities.index') }}" class="text-sm text-primary hover:underline">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form method="POST" action="{{ route('company.cities.store') }}" class="space-y-4">
            @csrf

            {{-- COUNTRY --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Country</label>

                <select name="country_id" class="w-full mt-1 px-3 py-2 border rounded-xl">
                    <option value="">Select Country</option>

                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- CITY NAME --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">City Name</label>
                <input type="text" name="name"
                       class="w-full mt-1 px-3 py-2 border rounded-xl"
                       placeholder="Karachi">
            </div>

            <button class="w-full bg-primary text-white py-2.5 rounded-xl font-bold">
                Save City
            </button>

        </form>

    </div>
</div>

@endsection
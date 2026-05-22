@extends('layouts.app')

@section('title', 'Edit City')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-on-surface">Edit City</h2>

        <a href="{{ route('company.cities.index') }}" class="text-sm text-primary hover:underline">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form method="POST" action="{{ route('company.cities.update', $city->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- COUNTRY --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">Country</label>

                <select name="country_id" class="w-full mt-1 px-3 py-2 border rounded-xl">

                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ $city->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- CITY NAME --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">City Name</label>

                <input type="text" name="name"
                       value="{{ $city->name }}"
                       class="w-full mt-1 px-3 py-2 border rounded-xl">
            </div>

            <button class="w-full bg-primary text-white py-2.5 rounded-xl font-bold">
                Update City
            </button>

        </form>

    </div>
</div>

@endsection
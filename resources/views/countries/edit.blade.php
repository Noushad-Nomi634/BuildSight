@extends('layouts.app')

@section('title', 'Edit Country')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-on-surface">Edit Country</h2>

        <a href="{{ route('company.countries.index') }}"
           class="text-sm text-primary hover:underline">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form method="POST"
              action="{{ route('company.countries.update', $country->id) }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            {{-- NAME --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Country Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ $country->name }}"
                       class="w-full mt-1 px-3 py-2 border rounded-xl"
                       required>
            </div>

            {{-- CODE --}}
            <div>
                <label class="text-xs font-bold text-text-muted uppercase">
                    Country Code
                </label>

                <input type="text"
                       name="code"
                       value="{{ $country->code }}"
                       class="w-full mt-1 px-3 py-2 border rounded-xl">
            </div>

            <button type="submit"
                    class="w-full bg-primary text-white py-2.5 rounded-xl font-bold">
                Update Country
            </button>

        </form>

    </div>
</div>

@endsection
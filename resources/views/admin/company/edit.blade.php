@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

    <div>
        <h2 class="text-xl font-bold text-on-surface">Edit Company</h2>
        <p class="text-sm text-text-muted">Update company details</p>
    </div>

    <!-- BACK BUTTON (FIXED) -->
    <a href="{{ route('admin.company.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded-xl bg-surface-container text-sm font-semibold hover:bg-surface-container-low transition">

        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Back
    </a>

</div>

{{-- FORM CARD --}}
<div class="bg-white border border-secondary-container/60 rounded-2xl shadow-sm p-6">

    <form action="{{ route('admin.company.update', $company->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- NAME --}}
        <div class="mb-4">
            <label class="text-sm font-semibold text-on-surface">Company Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $company->name) }}"
                   class="w-full mt-2 px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                   placeholder="Enter company name">
        </div>

        {{-- PHONE --}}
        <div class="mb-4">
            <label class="text-sm font-semibold text-on-surface">Phone</label>
            <input type="text"
                   name="phone"
                   value="{{ old('phone', $company->phone) }}"
                   class="w-full mt-2 px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                   placeholder="Enter phone number">
        </div>

        {{-- STATUS --}}
        <div class="mb-4">
            <label class="text-sm font-semibold text-on-surface">Status</label>
            <select name="status"
                    class="w-full mt-2 px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">

                <option value="active" {{ $company->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $company->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

            </select>
        </div>

        {{-- LOGO --}}
        <div class="mb-6">
            <label class="text-sm font-semibold text-on-surface">Logo</label>

            <input type="file"
                   name="logo"
                   class="w-full mt-2 px-4 py-2.5 border rounded-xl">

            @if($company->logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $company->logo) }}"
                         class="w-16 h-16 rounded-lg object-cover border">
                </div>
            @endif
        </div>

        {{-- BUTTONS --}}
        <div class="flex items-center gap-3">

            <!-- SUBMIT -->
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary/90 transition">

                Update Company
            </button>

            <!-- CANCEL (FIXED) -->
            <a href="{{ route('admin.company.index') }}"
               class="px-5 py-2.5 rounded-xl bg-surface-container text-text-muted font-semibold hover:bg-surface-container-low transition">

                Cancel
            </a>

        </div>

    </form>

</div>

@endsection
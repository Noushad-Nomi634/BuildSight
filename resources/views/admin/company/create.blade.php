@extends('layouts.app')
@section('title', 'Create Company')
@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-text-muted mb-1">
                <a href="#" class="hover:text-primary transition-colors">Companies</a>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <span class="text-on-surface font-medium">New Company</span>
            </div>
            <h2 class="text-xl font-bold text-on-surface">Create New Company</h2>
            <p class="text-sm text-text-muted mt-0.5">Fill in the details below to register a new company.</p>
        </div>
        <a href="#"
            class="flex items-center gap-2 text-sm text-slate-500 hover:text-[#536c77] bg-white border border-slate-200 px-4 py-2 rounded-xl transition-all hover:shadow-sm w-fit">
            <span class="material-symbols-outlined" style="font-size:16px">arrow_back</span>
            Back to Companies
        </a>
    </div>

    <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data" id="create-company-form">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            {{-- ── LEFT COLUMN (main fields) ── --}}
            <div class="xl:col-span-2 space-y-5">

                {{-- Basic Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-primary/10 rounded-xl">
                            <span class="material-symbols-outlined text-primary" style="font-size:18px">business</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[14px] text-on-surface">Basic Information</h3>
                            <p class="text-[11px] text-text-muted">Core company details</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">

                        {{-- Company Name --}}
                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                for="name">
                                Company Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Aura Aesthetics Ltd." required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                            @error('name')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                for="description">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3" placeholder="Brief description of the company..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email + Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="email">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        style="font-size:16px">mail</span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="company@example.com"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="phone">
                                    Phone
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        style="font-size:16px">call</span>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="923xxxxxxxxxxx"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Mobile + Website --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="mobile">
                                    Mobile
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        style="font-size:16px">smartphone</span>
                                    <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                        placeholder="+44xxxxxxxxxx"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                </div>
                                @error('mobile')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="website">
                                    Website
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        style="font-size:16px">language</span>
                                    <input type="url" id="website" name="website" value="{{ old('website') }}"
                                        placeholder="https://example.com"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                </div>
                                @error('website')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Address Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-xl">
                            <span class="material-symbols-outlined text-blue-500" style="font-size:18px">location_on</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[14px] text-on-surface">Address</h3>
                            <p class="text-[11px] text-text-muted">Physical location details</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                for="address_1">
                                Address Line 1
                            </label>
                            <input type="text" id="address_1" name="address_1" value="{{ old('address_1') }}"
                                placeholder="Street address, building number..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                            @error('address_1')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                for="address_2">
                                Address Line 2
                                <span class="normal-case font-normal text-slate-400 ml-1">(optional)</span>
                            </label>
                            <input type="text" id="address_2" name="address_2" value="{{ old('address_2') }}"
                                placeholder="Suite, floor, apartment..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="country">
                                    Country
                                </label>
                                <select id="country" name="country"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all appearance-none cursor-pointer">
                                    <option value="">Select country</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States
                                    </option>
                                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom
                                    </option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia
                                    </option>
                                    <option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>Pakistan
                                    </option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>UAE</option>
                                    <option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>India</option>
                                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                                    {{-- Add more countries as needed --}}
                                </select>
                                @error('country')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="state_province">
                                    State / Province
                                </label>
                                <input type="text" id="state_province" name="state_province"
                                    value="{{ old('state_province') }}" placeholder="e.g. California"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                @error('state_province')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5"
                                    for="postal_code">
                                    Postal Code
                                </label>
                                <input type="text" id="postal_code" name="postal_code"
                                    value="{{ old('postal_code') }}" placeholder="e.g. 90210"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] text-on-surface placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" />
                                @error('postal_code')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Team Assignment --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-purple-50 rounded-xl">
                            <span class="material-symbols-outlined text-purple-500"
                                style="font-size:18px">group_add</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[14px] text-on-surface">Team Assignment</h3>
                            <p class="text-[11px] text-text-muted">Assign users and managers to this company (optional)</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">

                        {{-- Users Multi-select --}}
                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">
                                Users
                                <span class="normal-case font-normal text-slate-400 ml-1">(optional)</span>
                            </label>
                            <p class="text-[11px] text-text-muted mb-2">Search and select users to assign to this company.
                            </p>
                            <div class="multiselect-wrapper" id="users-wrapper">
                                <div class="multiselect-input-box flex flex-wrap gap-1.5 min-h-[44px] px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 cursor-text focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary focus-within:bg-white transition-all"
                                    id="users-input-box" onclick="focusSearch('users')">
                                    <div id="users-tags" class="flex flex-wrap gap-1.5 items-center"></div>
                                    <input type="text" id="users-search" placeholder="Search users..."
                                        autocomplete="off"
                                        class="flex-1 min-w-[120px] bg-transparent border-none outline-none text-[13px] text-on-surface placeholder:text-slate-400 py-0.5"
                                        oninput="filterOptions('users')" onfocus="openDropdown('users')" />
                                </div>
                                <div id="users-dropdown"
                                    class="hidden absolute z-50 mt-1 w-full bg-white rounded-xl border border-slate-200 shadow-lg overflow-hidden">
                                    <div class="max-h-52 overflow-y-auto" id="users-options-list">
                                        {{-- Options rendered by JS --}}
                                    </div>
                                    <div id="users-empty"
                                        class="hidden px-4 py-3 text-[12px] text-text-muted text-center">No users found.
                                    </div>
                                </div>
                            </div>
                            {{-- Hidden inputs will be injected here --}}
                            <div id="users-hidden-inputs"></div>
                            @error('users')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Managers Multi-select --}}
                        <div>
                            <label class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">
                                Managers
                                <span class="normal-case font-normal text-slate-400 ml-1">(optional)</span>
                            </label>
                            <p class="text-[11px] text-text-muted mb-2">Assign managers with elevated access to this
                                company.</p>
                            <div class="multiselect-wrapper" id="managers-wrapper">
                                <div class="multiselect-input-box flex flex-wrap gap-1.5 min-h-[44px] px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 cursor-text focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary focus-within:bg-white transition-all"
                                    id="managers-input-box" onclick="focusSearch('managers')">
                                    <div id="managers-tags" class="flex flex-wrap gap-1.5 items-center"></div>
                                    <input type="text" id="managers-search" placeholder="Search managers..."
                                        autocomplete="off"
                                        class="flex-1 min-w-[120px] bg-transparent border-none outline-none text-[13px] text-on-surface placeholder:text-slate-400 py-0.5"
                                        oninput="filterOptions('managers')" onfocus="openDropdown('managers')" />
                                </div>
                                <div id="managers-dropdown"
                                    class="hidden absolute z-50 mt-1 w-full bg-white rounded-xl border border-slate-200 shadow-lg overflow-hidden">
                                    <div class="max-h-52 overflow-y-auto" id="managers-options-list">
                                        {{-- Options rendered by JS --}}
                                    </div>
                                    <div id="managers-empty"
                                        class="hidden px-4 py-3 text-[12px] text-text-muted text-center">No managers found.
                                    </div>
                                </div>
                            </div>
                            <div id="managers-hidden-inputs"></div>
                            @error('managers')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- ── RIGHT COLUMN (logo + status + actions) ── --}}
            <div class="space-y-5">

                {{-- Logo Upload --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-amber-50 rounded-xl">
                            <span class="material-symbols-outlined text-amber-500" style="font-size:18px">image</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[14px] text-on-surface">Company Logo</h3>
                            <p class="text-[11px] text-text-muted">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    <div class="p-6">

                        {{-- Preview --}}
                        <div class="flex justify-center mb-5">
                            <div class="relative w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden group cursor-pointer"
                                onclick="document.getElementById('logo').click()">
                                <img id="logo-preview" src="#" alt="Logo Preview"
                                    class="hidden w-full h-full object-contain rounded-2xl" />
                                <div id="logo-placeholder"
                                    class="flex flex-col items-center gap-1 text-slate-400 group-hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined"
                                        style="font-size:28px">add_photo_alternate</span>
                                    <span class="text-[10px] font-medium">Upload</span>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white"
                                        style="font-size:22px">upload</span>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="logo" name="logo" accept="image/*" class="hidden"
                            onchange="previewLogo(event)" />

                        <button type="button" onclick="document.getElementById('logo').click()"
                            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-slate-200 text-[12px] font-semibold text-slate-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">
                            <span class="material-symbols-outlined" style="font-size:15px">upload_file</span>
                            Choose File
                        </button>
                        <p id="logo-filename" class="text-[11px] text-text-muted text-center mt-2">No file selected</p>
                        @error('logo')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="p-2 bg-green-50 rounded-xl">
                            <span class="material-symbols-outlined text-green-500" style="font-size:18px">toggle_on</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[14px] text-on-surface">Status</h3>
                            <p class="text-[11px] text-text-muted">Company visibility</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-3">
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                        {{ old('status', 'active') == 'active' ? 'border-primary bg-primary/5' : 'border-slate-200 hover:border-slate-300' }}"
                            id="status-active-label">
                            <input type="radio" name="status" value="active"
                                {{ old('status', 'active') == 'active' ? 'checked' : '' }} class="accent-primary w-4 h-4"
                                onchange="updateStatusStyle()" />
                            <div>
                                <p class="text-[13px] font-semibold text-on-surface">Active</p>
                                <p class="text-[11px] text-text-muted">Company is operational</p>
                            </div>
                            <span class="ml-auto w-2.5 h-2.5 rounded-full bg-green-500 shrink-0"></span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                        {{ old('status') == 'inactive' ? 'border-slate-400 bg-slate-50' : 'border-slate-200 hover:border-slate-300' }}"
                            id="status-inactive-label">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status') == 'inactive' ? 'checked' : '' }} class="accent-slate-500 w-4 h-4"
                                onchange="updateStatusStyle()" />
                            <div>
                                <p class="text-[13px] font-semibold text-on-surface">Inactive</p>
                                <p class="text-[11px] text-text-muted">Temporarily disabled</p>
                            </div>
                            <span class="ml-auto w-2.5 h-2.5 rounded-full bg-slate-400 shrink-0"></span>
                        </label>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="bg-gradient-to-br from-[#536c77] to-[#3a4f58] rounded-2xl p-5 text-white shadow-md">
                    <h4 class="font-bold text-[13px] mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:16px">checklist</span>
                        Quick Checklist
                    </h4>
                    <ul class="space-y-2 text-[12px]">
                        <li class="flex items-center gap-2 opacity-80">
                            <span class="material-symbols-outlined text-green-300"
                                style="font-size:14px">check_circle</span>
                            Company name is required
                        </li>
                        <li class="flex items-center gap-2 opacity-80">
                            <span class="material-symbols-outlined text-white/50"
                                style="font-size:14px">radio_button_unchecked</span>
                            All other fields are optional
                        </li>
                        <li class="flex items-center gap-2 opacity-80">
                            <span class="material-symbols-outlined text-white/50"
                                style="font-size:14px">radio_button_unchecked</span>
                            Assign users & managers later
                        </li>
                    </ul>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-[#536c77] hover:bg-[#3a4f58] text-white font-bold text-[13.5px] transition-all duration-200 active:scale-[0.98] shadow-sm hover:shadow-md">
                        <span class="material-symbols-outlined" style="font-size:18px">business_center</span>
                        Create Company
                    </button>
                    <a href="#"
                        class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl border border-slate-200 text-slate-600 font-semibold text-[13px] hover:bg-slate-50 transition-all duration-200 active:scale-[0.98]">
                        <span class="material-symbols-outlined" style="font-size:16px">cancel</span>
                        Cancel
                    </a>
                </div>

            </div>

        </div>
    </form>

    {{-- ── STYLES ── --}}
    <style>
        .multiselect-wrapper {
            position: relative;
        }

        .ms-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #536c7718;
            color: #3a4f58;
            border: 1px solid #536c7730;
            border-radius: 8px;
            padding: 2px 8px 2px 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            animation: tagIn 0.15s ease;
        }

        @keyframes tagIn {
            from {
                opacity: 0;
                transform: scale(0.85);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .ms-tag button {
            background: none;
            border: none;
            cursor: pointer;
            color: #536c77;
            display: flex;
            align-items: center;
            padding: 0;
            margin-left: 2px;
            border-radius: 50%;
            transition: color 0.15s;
        }

        .ms-tag button:hover {
            color: #c0392b;
        }

        .ms-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.1s;
        }

        .ms-option:hover {
            background: #536c7710;
        }

        .ms-option.selected {
            background: #536c7708;
        }

        .ms-option .ms-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .ms-option .ms-initials {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #536c7720;
            color: #536c77;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ms-check {
            margin-left: auto;
            color: #536c77;
            opacity: 0;
            transition: opacity 0.15s;
            font-size: 16px !important;
        }

        .ms-option.selected .ms-check {
            opacity: 1;
        }
    </style>
    @php
        $usersJson = isset($users)
            ? $users
            : [
                ['id' => 1, 'name' => 'Alice Cooper', 'email' => 'alice@example.com', 'avatar' => null],
                ['id' => 2, 'name' => 'Robert Fox', 'email' => 'robert@example.com', 'avatar' => null],
                ['id' => 3, 'name' => 'Linda Gray', 'email' => 'linda@example.com', 'avatar' => null],
                ['id' => 4, 'name' => 'Mark Sloan', 'email' => 'mark@example.com', 'avatar' => null],
                ['id' => 5, 'name' => 'Emma Thompson', 'email' => 'emma@example.com', 'avatar' => null],
                ['id' => 6, 'name' => 'David Chen', 'email' => 'david@example.com', 'avatar' => null],
                ['id' => 7, 'name' => 'Sofia Rodriguez', 'email' => 'sofia@example.com', 'avatar' => null],
                ['id' => 8, 'name' => 'James Wilson', 'email' => 'james@example.com', 'avatar' => null],
            ];

        $managersJson = isset($managers)
            ? $managers
            : [
                ['id' => 1, 'name' => 'Alice Cooper', 'email' => 'alice@example.com', 'avatar' => null],
                ['id' => 3, 'name' => 'Linda Gray', 'email' => 'linda@example.com', 'avatar' => null],
                ['id' => 5, 'name' => 'Emma Thompson', 'email' => 'emma@example.com', 'avatar' => null],
                ['id' => 8, 'name' => 'James Wilson', 'email' => 'james@example.com', 'avatar' => null],
            ];
    @endphp
    {{-- ── SCRIPTS ── --}}
    <script>
        // ── Logo preview ──
        function previewLogo(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                const img = document.getElementById('logo-preview');
                img.src = ev.target.result;
                img.classList.remove('hidden');
                document.getElementById('logo-placeholder').classList.add('hidden');
                document.getElementById('logo-filename').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }

        // ── Status radio styling ──
        function updateStatusStyle() {
            const active = document.querySelector('input[name="status"][value="active"]').checked;
            const lActive = document.getElementById('status-active-label');
            const lInactive = document.getElementById('status-inactive-label');
            if (active) {
                lActive.classList.add('border-primary', 'bg-primary/5');
                lActive.classList.remove('border-slate-200');
                lInactive.classList.remove('border-slate-400', 'bg-slate-50');
                lInactive.classList.add('border-slate-200');
            } else {
                lInactive.classList.add('border-slate-400', 'bg-slate-50');
                lInactive.classList.remove('border-slate-200');
                lActive.classList.remove('border-primary', 'bg-primary/5');
                lActive.classList.add('border-slate-200');
            }
        }

        // ══════════════════════════════════════════
        //  MULTI-SELECT ENGINE
        // ══════════════════════════════════════════

        // ── Seed data — replace with server-rendered JSON ──


        const MULTISELECT_DATA = {
            users: @json($usersJson),
            managers: @json($managersJson),
        };
        const msState = {
            users: new Set(),
            managers: new Set()
        };

        function initials(name) {
            return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
        }

        function renderOptions(key, query = '') {
            const list = document.getElementById(`${key}-options-list`);
            const empty = document.getElementById(`${key}-empty`);
            const items = MULTISELECT_DATA[key].filter(u =>
                u.name.toLowerCase().includes(query.toLowerCase()) ||
                u.email.toLowerCase().includes(query.toLowerCase())
            );
            list.innerHTML = '';
            if (items.length === 0) {
                empty.classList.remove('hidden');
                return;
            }
            empty.classList.add('hidden');
            items.forEach(u => {
                const div = document.createElement('div');
                div.className = 'ms-option' + (msState[key].has(u.id) ? ' selected' : '');
                div.dataset.id = u.id;
                div.innerHTML = `
                ${u.avatar
                    ? `<img src="${u.avatar}" class="ms-avatar" alt="${u.name}" />`
                    : `<div class="ms-initials">${initials(u.name)}</div>`
                }
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-on-surface text-[12.5px] truncate">${u.name}</p>
                    <p class="text-[11px] text-text-muted truncate">${u.email}</p>
                </div>
                <span class="material-symbols-outlined ms-check">check</span>
            `;
                div.addEventListener('click', () => toggleOption(key, u));
                list.appendChild(div);
            });
        }

        function toggleOption(key, user) {
            if (msState[key].has(user.id)) {
                msState[key].delete(user.id);
            } else {
                msState[key].add(user.id);
            }
            renderTags(key);
            renderOptions(key, document.getElementById(`${key}-search`).value);
            renderHiddenInputs(key);
        }

        function renderTags(key) {
            const container = document.getElementById(`${key}-tags`);
            container.innerHTML = '';
            msState[key].forEach(id => {
                const user = MULTISELECT_DATA[key].find(u => u.id === id);
                if (!user) return;
                const tag = document.createElement('span');
                tag.className = 'ms-tag';
                tag.innerHTML = `
                ${initials(user.name)}
                <span class="ml-1">${user.name.split(' ')[0]}</span>
                <button type="button" onclick="removeTag('${key}', ${id})" title="Remove">
                    <span class="material-symbols-outlined" style="font-size:14px">close</span>
                </button>
            `;
                container.appendChild(tag);
            });
        }

        function removeTag(key, id) {
            msState[key].delete(id);
            renderTags(key);
            renderOptions(key, document.getElementById(`${key}-search`).value);
            renderHiddenInputs(key);
        }

        function renderHiddenInputs(key) {
            const container = document.getElementById(`${key}-hidden-inputs`);
            container.innerHTML = '';
            msState[key].forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `${key}[]`;
                input.value = id;
                container.appendChild(input);
            });
        }

        function openDropdown(key) {
            const dd = document.getElementById(`${key}-dropdown`);
            dd.classList.remove('hidden');
            renderOptions(key, document.getElementById(`${key}-search`).value);
        }

        function filterOptions(key) {
            const query = document.getElementById(`${key}-search`).value;
            renderOptions(key, query);
            openDropdown(key);
        }

        function focusSearch(key) {
            document.getElementById(`${key}-search`).focus();
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', e => {
            ['users', 'managers'].forEach(key => {
                const wrapper = document.getElementById(`${key}-wrapper`);
                const dd = document.getElementById(`${key}-dropdown`);
                if (!wrapper.contains(e.target)) {
                    dd.classList.add('hidden');
                    document.getElementById(`${key}-search`).value = '';
                }
            });
        });

        // Keyboard: Escape closes, Backspace removes last tag
        ['users', 'managers'].forEach(key => {
            document.getElementById(`${key}-search`).addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    document.getElementById(`${key}-dropdown`).classList.add('hidden');
                }
                if (e.key === 'Backspace' && e.target.value === '' && msState[key].size > 0) {
                    const lastId = [...msState[key]].pop();
                    removeTag(key, lastId);
                }
            });
        });

        // Init
        ['users', 'managers'].forEach(key => renderOptions(key));
    </script>

@endsection

@extends('layouts.app')
@section('title', 'Create Project')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <div class="flex items-center gap-2 text-sm text-text-muted mb-1">
            <a href="#" class="hover:text-primary transition-colors">Projects</a>

            <span class="material-symbols-outlined" style="font-size:14px">
                chevron_right
            </span>

            <span class="text-on-surface font-medium">
                New Project
            </span>
        </div>

        <h2 class="text-xl font-bold text-on-surface">
            Create New Project
        </h2>

        <p class="text-sm text-text-muted mt-0.5">
            Fill in the details below to create a new project.
        </p>
    </div>

    <a href="#"
        class="flex items-center gap-2 text-sm text-slate-500 hover:text-[#536c77] bg-white border border-slate-200 px-4 py-2 rounded-xl transition-all hover:shadow-sm w-fit">

        <span class="material-symbols-outlined" style="font-size:16px">
            arrow_back
        </span>

        Back to Projects
    </a>
</div>

<form action="{{ route('company.projects.store') }}"
      method="POST"
      id="create-project-form">
{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm shadow-sm">
        <span class="material-symbols-outlined text-green-500" style="font-size:18px">
            check_circle
        </span>
        {{ session('success') }}
    </div>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
    <div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm shadow-sm">
        <span class="material-symbols-outlined text-red-500" style="font-size:18px">
            error
        </span>
        {{ session('error') }}
    </div>
@endif

{{-- VALIDATION ERRORS --}}
@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm shadow-sm">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-red-500" style="font-size:18px">
                warning
            </span>
            <span class="font-semibold">Please fix the following errors:</span>
        </div>

        <ul class="list-disc ml-6 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @csrf

    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

    {{-- OPTIONAL --}}
    {{-- <input type="hidden" name="company_id" value="{{ $company->id }}"> --}}

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- LEFT COLUMN --}}
        <div class="xl:col-span-2 space-y-5">

            {{-- BASIC INFORMATION --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">

                    <div class="p-2 bg-primary/10 rounded-xl">
                        <span class="material-symbols-outlined text-primary" style="font-size:18px">
                            work
                        </span>
                    </div>

                    <div>
                        <h3 class="font-bold text-[14px] text-on-surface">
                            Basic Information
                        </h3>

                        <p class="text-[11px] text-text-muted">
                            Project core details
                        </p>
                    </div>
                </div>

                <div class="p-6 space-y-5">

                    {{-- PROJECT NAME --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                            Project Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Enter project name"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                        @error('name')
                            <p class="text-red-500 text-[11px] mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- PROJECT CODE --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                            Project Code
                        </label>

                        <input type="text"
                               name="project_code"
                               value="{{ old('project_code') }}"
                               placeholder="PRJ-001"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                        @error('project_code')
                            <p class="text-red-500 text-[11px] mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="3"
                            placeholder="Project description..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 resize-none">{{ old('description') }}</textarea>

                        @error('description')
                            <p class="text-red-500 text-[11px] mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- LOCATION --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">

                    <div class="p-2 bg-blue-50 rounded-xl">
                        <span class="material-symbols-outlined text-blue-500" style="font-size:18px">
                            location_on
                        </span>
                    </div>

                    <div>
                        <h3 class="font-bold text-[14px] text-on-surface">
                            Location Information
                        </h3>

                        <p class="text-[11px] text-text-muted">
                            Project location details
                        </p>
                    </div>
                </div>

                <div class="p-6 space-y-5">

                    {{-- LAT LNG --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                Latitude
                            </label>

                            <input type="number"
                                   name="lat"
                                   value="{{ old('lat') }}"
                                   placeholder="Latitude"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                Longitude
                            </label>

                            <input type="number"
                                   name="lng"
                                   value="{{ old('lng') }}"
                                   placeholder="Longitude"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                    </div>

                    {{-- ADDRESS 1 --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                            Address Line 1
                        </label>

                        <input type="text"
                               name="address_1"
                               value="{{ old('address_1') }}"
                               placeholder="Street address"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                    </div>

                    {{-- ADDRESS 2 --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                            Address Line 2
                        </label>

                        <input type="text"
                               name="address_2"
                               value="{{ old('address_2') }}"
                               placeholder="Apartment, suite, floor..."
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                    </div>

                    {{-- COUNTRY --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                Country
                            </label>

                            <select
                                name="country"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                                <option value="">Select Country</option>

                                <option value="PK">Pakistan</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="IN">India</option>

                            </select>
                        </div>

                        {{-- STATE --}}
                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                State / Province
                            </label>

                            <input type="text"
                                   name="state_province"
                                   value="{{ old('state_province') }}"
                                   placeholder="Punjab"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                        {{-- POSTAL --}}
                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                Postal Code
                            </label>

                            <input type="text"
                                   name="postal_code"
                                   value="{{ old('postal_code') }}"
                                   placeholder="46000"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                    </div>

                </div>
            </div>

            {{-- DATES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-[14px]">
                        Project Dates
                    </h3>
                </div>

                <div class="p-6">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                Start Date
                            </label>

                            <input type="date"
                                   name="start_date"
                                   value="{{ old('start_date') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                        <div>
                            <label
                                class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                                End Date
                            </label>

                            <input type="date"
                                   name="end_date"
                                   value="{{ old('end_date') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        </div>

                    </div>

                </div>
            </div>

            {{-- ALERT EMAIL --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="p-6">

                    <label
                        class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                        Alerts Email
                    </label>

                    <input type="email"
                           name="alerts_email"
                           value="{{ old('alerts_email') }}"
                           placeholder="alerts@example.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                </div>
            </div>

            {{-- FTP --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="p-6">

                    <label
                        class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                        FTP Folder
                    </label>

                    <input type="text"
                           name="ftp_folder"
                           value="{{ old('ftp_folder') }}"
                           placeholder="/project-folder/"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="space-y-5">

            {{-- PRIORITY --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                <div class="p-6">

                    <label
                        class="block text-[12px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">

                        Priority
                    </label>

                    <select
                        name="priority"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50">

                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>

                    </select>

                </div>
            </div>

            {{-- STATUS --}}
           {{-- STATUS --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-bold text-[14px]">
            Status
        </h3>
    </div>

    <div class="p-6 space-y-3">

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="active" checked>
            <span>Active</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="inactive">
            <span>Inactive</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="planning">
            <span>Planning</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="on_hold">
            <span>On Hold</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="completed">
            <span>Completed</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="radio" name="status" value="cancelled">
            <span>Cancelled</span>
        </label>

    </div>
</div>

            {{-- SUBMIT --}}
            <div class="space-y-3">

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-[#536c77] hover:bg-[#3a4f58] text-white font-bold text-[13.5px]">

                    <span class="material-symbols-outlined" style="font-size:18px">
                        add
                    </span>

                    Create Project
                </button>

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

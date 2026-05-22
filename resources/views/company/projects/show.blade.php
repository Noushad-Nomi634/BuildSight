@extends('layouts.app')
@section('title', $project->name)

@section('content')

    {{-- ── Breadcrumb + Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-sm text-text-muted mb-1 flex-wrap">
                <span>Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <a href="{{ route('company.projects.index') }}" class="hover:text-primary transition-colors">Projects</a>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <span class="text-on-surface font-medium truncate max-w-[200px]">{{ $project->name }}</span>
            </div>
            <h2 class="text-xl font-bold text-on-surface">{{ $project->name }}</h2>
            @if ($project->project_code)
                <span
                    class="text-[11px] font-mono font-bold text-text-muted bg-surface-container-low
                             border border-secondary-container px-2 py-1 rounded-lg mt-1 inline-block">
                    {{ $project->project_code }}
                </span>
            @endif
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('company.projects.edit', $project) }}"
                class="flex items-center gap-2 bg-surface-white hover:bg-surface-container-low border
                       border-secondary-container text-on-surface text-[13px] font-bold px-4 py-2.5
                       rounded-xl transition-all duration-200 active:scale-[0.98] shadow-sm w-fit">
                <span class="material-symbols-outlined" style="font-size:17px">edit_square</span>
                Edit
            </a>
            <form method="POST" action="{{ route('company.projects.destroy', $project) }}"
                onsubmit="return confirm('Delete {{ addslashes($project->name) }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 bg-surface-white hover:bg-status-cancelled/10 border
                           border-secondary-container hover:border-status-cancelled/30 text-on-surface
                           hover:text-status-cancelled text-[13px] font-bold px-4 py-2.5 rounded-xl
                           transition-all duration-200 active:scale-[0.98] shadow-sm w-fit">
                    <span class="material-symbols-outlined" style="font-size:17px">delete</span>
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- ── Status / Priority / Timeline chips ── --}}
    @php
        $statusMap = [
            'active' => ['bg-status-completed/10 text-status-completed', 'bg-status-completed'],
            'planning' => ['bg-status-upcoming/10 text-status-upcoming', 'bg-status-upcoming'],
            'on_hold' => ['bg-status-pending/10 text-status-pending', 'bg-status-pending'],
            'completed' => ['bg-primary/10 text-primary', 'bg-primary'],
            'cancelled' => ['bg-status-cancelled/10 text-status-cancelled', 'bg-status-cancelled'],
        ];
        $priorityMap = [
            'low' => ['bg-secondary/10 text-secondary', 'bg-secondary'],
            'medium' => ['bg-status-upcoming/10 text-status-upcoming', 'bg-status-upcoming'],
            'high' => ['bg-status-pending/10 text-status-pending', 'bg-status-pending'],
            'urgent' => ['bg-status-cancelled/10 text-status-cancelled', 'bg-status-cancelled'],
        ];
        [$statusBadge, $statusDot] = $statusMap[$project->status] ?? ['bg-secondary/10 text-secondary', 'bg-secondary'];
        [$prioBadge, $prioDot] = $priorityMap[$project->priority] ?? ['bg-secondary/10 text-secondary', 'bg-secondary'];
    @endphp

    <div class="flex flex-wrap items-center gap-2">
        {{-- Status --}}
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px]
                     font-bold uppercase tracking-wide {{ $statusBadge }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
            {{ str_replace('_', ' ', $project->status) }}
        </span>
        {{-- Priority --}}
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px]
                     font-bold uppercase tracking-wide {{ $prioBadge }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $prioDot }}"></span>
            {{ $project->priority }} priority
        </span>
        {{-- Timeline --}}
        @if ($project->start_date || $project->end_date)
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px]
                         font-bold bg-surface-container-low border border-secondary-container text-text-muted">
                <span class="material-symbols-outlined" style="font-size:13px">calendar_today</span>
                {{ $project->start_date?->format('M d, Y') ?? '—' }}
                &rarr;
                {{ $project->end_date?->format('M d, Y') ?? 'Ongoing' }}
            </span>
        @endif
        {{-- FTP folder --}}
        @if ($project->ftp_folder)
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px]
                         font-bold bg-surface-container-low border border-secondary-container text-text-muted font-mono">
                <span class="material-symbols-outlined" style="font-size:13px">folder</span>
                {{ $project->ftp_folder }}
            </span>
        @endif
    </div>

    {{-- ── Two-column detail layout ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- LEFT: Details card + Description + Location ── --}}
        <div class="lg:col-span-2 flex flex-col gap-4">

            {{-- Description --}}
            @if ($project->description)
                <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 p-5">
                    <h3 class="font-bold text-[14px] text-on-surface mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary" style="font-size:17px">description</span>
                        Description
                    </h3>
                    <p class="text-[13px] text-text-muted leading-relaxed whitespace-pre-line">{{ $project->description }}
                    </p>
                </div>
            @endif

            {{-- Project details --}}
            <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 p-5">
                <h3 class="font-bold text-[14px] text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary" style="font-size:17px">info</span>
                    Project Details
                </h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">

                    @php
                        $details = [
                            ['label' => 'Project Name', 'value' => $project->name, 'icon' => 'work'],
                            ['label' => 'Project Code', 'value' => $project->project_code, 'icon' => 'tag'],
                            ['label' => 'FTP Folder', 'value' => $project->ftp_folder, 'icon' => 'folder'],
                            ['label' => 'Alerts Email', 'value' => $project->alerts_email, 'icon' => 'mail'],
                            [
                                'label' => 'Start Date',
                                'value' => $project->start_date?->format('M d, Y'),
                                'icon' => 'event',
                            ],
                            [
                                'label' => 'End Date',
                                'value' => $project->end_date?->format('M d, Y') ?? 'Ongoing',
                                'icon' => 'event_available',
                            ],
                            [
                                'label' => 'Created',
                                'value' => $project->created_at->format('M d, Y'),
                                'icon' => 'schedule',
                            ],
                            [
                                'label' => 'Last Updated',
                                'value' => $project->updated_at->format('M d, Y'),
                                'icon' => 'update',
                            ],
                        ];
                    @endphp

                    @foreach ($details as $d)
                        <div class="flex items-start gap-3">
                            <div class="p-1.5 bg-primary/10 rounded-lg mt-0.5 shrink-0">
                                <span class="material-symbols-outlined text-primary"
                                    style="font-size:14px">{{ $d['icon'] }}</span>
                            </div>
                            <div>
                                <dt class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                                    {{ $d['label'] }}</dt>
                                <dd class="text-[13px] text-on-surface font-medium mt-0.5">
                                    {{ $d['value'] ?? '—' }}
                                </dd>
                            </div>
                        </div>
                    @endforeach

                </dl>
            </div>

            {{-- Location --}}
            @if ($project->address_1 || $project->lat)
                <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 p-5">
                    <h3 class="font-bold text-[14px] text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary" style="font-size:17px">location_on</span>
                        Location
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        @foreach ([['Address Line 1', $project->address_1], ['Address Line 2', $project->address_2], ['Country', $project->country], ['State / Province', $project->state_province], ['Postal Code', $project->postal_code], ['Latitude', $project->lat], ['Longitude', $project->lng]] as [$label, $value])
                            @if ($value)
                                <div>
                                    <dt class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                                        {{ $label }}</dt>
                                    <dd class="text-[13px] text-on-surface font-medium mt-0.5">{{ $value }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if ($project->lat && $project->lng)
                        <a href="https://maps.google.com/?q={{ $project->lat }},{{ $project->lng }}" target="_blank"
                            class="mt-4 inline-flex items-center gap-1.5 text-[12px] font-bold text-primary
                                   hover:underline transition-colors">
                            <span class="material-symbols-outlined" style="font-size:14px">open_in_new</span>
                            View on Google Maps
                        </a>
                    @endif
                </div>
            @endif

        </div>

        {{-- RIGHT: Cameras card + Members card ── --}}
        {{-- RIGHT COLUMN --}}
        <div class="flex flex-col gap-4">

            {{-- CAMERA CARD --}}
            {{-- <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

                <div class="px-5 py-4 border-b flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">videocam</span>
                        <h3 class="font-bold text-[14px]">Cameras</h3>
                    </div>

                    <span class="text-[11px] font-bold text-text-muted bg-surface-container-low px-2 py-0.5 rounded-full">
                        {{ $project->cameras->count() }}
                    </span>
                </div>

                @if ($project->cameras->isEmpty())
                    <div class="px-5 py-6 text-text-muted text-sm">
                        No cameras assigned yet.
                    </div>
                @else
                    <ul class="divide-y divide-secondary-container/70">
                        @foreach ($project->cameras as $camera)
                            <li class="px-5 py-3 flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">videocam</span>
                                <p class="text-[13px] font-semibold">{{ $camera->name }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div> --}}

            {{-- MEMBERS CARD --}}



            <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
                {{-- HEADER --}}
                <div class="px-5 py-4 border-b flex items-center justify-between">

                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">videocam</span>
                        <h3 class="font-bold text-[14px]">Cameras</h3>

                        {{-- ➕ ADD BUTTON --}}
                        <button type="button" onclick="openCameraModal({{ $project->id }})"
                            class="ml-2 p-1.5 rounded-lg hover:bg-blue-100 text-blue-600" title="Add Camera">

                            <span class="material-symbols-outlined" style="font-size:18px">
                                add_circle
                            </span>
                        </button>
                    </div>

                    <span class="text-[11px] font-bold text-text-muted bg-surface-container-low px-2 py-0.5 rounded-full">
                        {{ $project->cameras->count() }}
                    </span>

                </div>

                {{-- BODY --}}
                @if ($project->cameras->isEmpty())

                    <div class="px-5 py-6 text-text-muted text-sm">
                        No cameras assigned yet.
                    </div>
                @else
                    <ul class="divide-y divide-secondary-container/70">

                        @foreach ($project->cameras as $camera)
                            <li class="px-5 py-3 flex items-center justify-between">

                                {{-- LEFT --}}
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">videocam</span>
                                    <p class="text-[13px] font-semibold">{{ $camera->name }}</p>
                                </div>

                                {{-- RIGHT ACTIONS --}}
                                <div class="flex items-center gap-2">

                                    {{-- VIEW --}}
                                    <a href="{{ route('company.cameras.show', $camera->id) }}"
                                        class="p-1.5 rounded-lg hover:bg-green-100 text-green-600" title="View">
                                        <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('company.cameras.edit', $camera->id) }}"
                                        class="p-1.5 rounded-lg hover:bg-yellow-100 text-yellow-600" title="Edit">
                                        <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                                    </a>

                                    {{-- DELETE --}}
                                    <form method="POST" action="{{ route('company.cameras.destroy', $camera->id) }}"
                                        onsubmit="return confirm('Delete this camera?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="p-1.5 rounded-lg hover:bg-red-100 text-red-600"
                                            title="Delete">
                                            <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                                        </button>
                                    </form>

                                </div>

                            </li>
                        @endforeach

                    </ul>

                @endif

            </div>
            <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

                <div class="px-5 py-4 border-b flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">group</span>
                        <h3 class="font-bold text-[14px]">Members</h3>
                    </div>

                    <span class="text-[11px] font-bold text-text-muted bg-surface-container-low px-2 py-0.5 rounded-full">
                        {{ $project->members->count() }}
                    </span>
                </div>

                @if ($project->members->isEmpty())
                    <div class="px-5 py-6 text-text-muted text-sm">
                        No members assigned yet.
                    </div>
                @else
                    <ul class="divide-y divide-secondary-container/70">
                        @foreach ($project->members as $member)
                            <li class="px-5 py-3 flex items-center gap-3">

                                @php
                                    $initials = collect(explode(' ', $member->name))
                                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                                        ->take(2)
                                        ->join('');
                                @endphp

                                <div
                                    class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[11px] font-bold">
                                    {{ $initials }}
                                </div>

                                <div>
                                    <p class="text-[13px] font-semibold">{{ $member->name }}</p>
                                    <p class="text-[11px] text-text-muted">{{ $member->email }}</p>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
        {{-- CAMERA CARD --}}


        {{-- @if ($project->cameras->isEmpty())
            <div class="px-5 py-8 flex flex-col items-center gap-2 text-center">
                <div class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-text-muted" style="font-size:22px">videocam_off</span>
                </div>
                <p class="text-[12px] text-text-muted">No cameras assigned yet.</p>
            </div>
        @else
            <ul class="divide-y divide-secondary-container/70">
                @foreach ($project->cameras as $camera)
                    <li class="px-5 py-3 flex items-center gap-3 hover:bg-surface-container-low/60 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary" style="font-size:16px">videocam</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[13px] font-semibold text-on-surface truncate">{{ $camera->name }}</p>
                            @if (isset($camera->status))
                                <p class="text-[11px] text-text-muted">{{ $camera->status }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif --}}
    </div>

    {{-- Members --}}
    {{-- <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
        <div class="px-5 py-4 border-b border-secondary-container flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size:17px">group</span>
                <h3 class="font-bold text-[14px] text-on-surface">Members</h3>
            </div>
            <span
                class="text-[11px] font-bold text-text-muted bg-surface-container-low
                                 border border-secondary-container px-2 py-0.5 rounded-full">
                {{ $project->members->count() }}
            </span>
        </div>

        @if ($project->members->isEmpty())
            <div class="px-5 py-8 flex flex-col items-center gap-2 text-center">
                <div class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center">
                    <span class="material-symbols-outlined text-text-muted" style="font-size:22px">person_off</span>
                </div>
                <p class="text-[12px] text-text-muted">No members assigned yet.</p>
            </div>
        @else
            <ul class="divide-y divide-secondary-container/70">
                @foreach ($project->members as $member)
                    <li class="px-5 py-3 flex items-center gap-3 hover:bg-surface-container-low/60 transition-colors">
                        @php
                            $initials = collect(explode(' ', $member->name))
                                ->map(fn($w) => strtoupper($w[0] ?? ''))
                                ->take(2)
                                ->join('');
                        @endphp
                        <div
                            class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center
                                            text-primary text-[11px] font-bold shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] font-semibold text-on-surface truncate">{{ $member->name }}</p>
                            <p class="text-[11px] text-text-muted truncate">{{ $member->email }}</p>
                        </div>
                        @if ($member->pivot->role)
                            <span
                                class="text-[10px] font-bold uppercase tracking-wide text-text-muted
                                                 bg-surface-container-low border border-secondary-container
                                                 px-2 py-0.5 rounded-full shrink-0">
                                {{ $member->pivot->role }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div> --}}

    </div>
    </div>

    {{-- CAMERA MODAL --}}
    <div id="cameraModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">

        <div onclick="event.stopPropagation()" class="bg-white w-full max-w-lg rounded-2xl shadow-lg overflow-hidden">

            {{-- HEADER --}}
            <div class="px-5 py-3 border-b flex justify-between items-center">
                <h3 class="font-bold text-on-surface">Add Camera</h3>

                <button onclick="closeCameraModal()" class="text-text-muted hover:text-red-500 text-lg">
                    ✕
                </button>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('company.cameras.store') }}" class="p-6 space-y-4">
                @csrf

                <input type="hidden" name="project_id" id="camera_project_id">

                {{-- Title --}}
                <div class="text-center mb-2">
                    <h2 class="text-lg font-bold text-on-surface">Add Camera</h2>
                    <p class="text-xs text-text-muted">Project me new camera assign karein</p>
                </div>

                {{-- Camera Name --}}
                <div>
                    <label class="text-xs font-semibold text-text-muted">Camera Name</label>
                    <input type="text" name="name" placeholder="e.g. Front Gate Camera"
                        class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                   focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm"
                        required>
                </div>

                {{-- IP + Port --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-text-muted">IP Address</label>
                        <input type="text" name="ip_address" placeholder="192.168.1.1"
                            class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                       focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-text-muted">Port</label>
                        <input type="number" name="port" placeholder="8080"
                            class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                       focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                    </div>
                </div>

                {{-- Username --}}
                <div>
                    <label class="text-xs font-semibold text-text-muted">Username</label>
                    <input type="text" name="username" placeholder="admin"
                        class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                   focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-xs font-semibold text-text-muted">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                   focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                </div>

                {{-- Snapshot URL --}}
                <div>
                    <label class="text-xs font-semibold text-text-muted">Snapshot URL</label>
                    <input type="text" name="snapshot_url" placeholder="http://..."
                        class="w-full mt-1 px-3 py-2 border border-secondary-container rounded-xl
                   focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                </div>

                {{-- Upload Method --}}
                <div>
                    <label class="text-xs font-semibold text-text-muted">Upload Method</label>
                    <select name="upload_method" class="w-full border rounded-lg p-2">
                        <option value="ftp">FTP</option>
                        <option value="http">HTTP</option>
                        <option value="onvif">ONVIF</option>
                    </select>
                </div>

                {{-- Active Checkbox --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1"
                        class="w-4 h-4 text-primary border-secondary-container rounded">
                    <label class="text-sm text-text-muted">Active Camera</label>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="closeCameraModal()"
                        class="w-1/2 py-2 rounded-xl border border-secondary-container text-text-muted hover:bg-surface-container-low transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="w-1/2 py-2 rounded-xl bg-primary text-white font-semibold hover:bg-primary/90 transition">
                        Save Camera
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function openCameraModal(projectId) {
            document.getElementById('camera_project_id').value = projectId;

            const modal = document.getElementById('cameraModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCameraModal() {
            const modal = document.getElementById('cameraModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ✅ better outside click handling
        document.getElementById('cameraModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCameraModal();
            }
        });

        // ✅ ESC key close (professional UX)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCameraModal();
            }
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')

    {{--
    View expects: $project (Project model, eager-loaded with company, cameras, members)
    All relations are nullable-safe — sections only render when data exists.
--}}

    <div class="space-y-6">

        {{-- ══════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-[12px] text-slate-400 mb-1">
                <a href="{{ route('company.projects.index') }}" class="hover:text-[#536c77] transition-colors">Projects</a>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <span class="text-slate-600 font-medium truncate max-w-[200px]">{{ $project->name }}</span>
            </nav>

            {{-- Action buttons --}}
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('company.projects.edit', $project) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:text-[#536c77] hover:border-[#536c77]/40 text-[13px] font-semibold transition-all">
                    <span class="material-symbols-outlined" style="font-size:16px">edit</span>
                    Edit
                </a>
                <form method="POST" action="{{ route('company.projects.destroy', $project) }}"
                    onsubmit="return confirm('Delete this project? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-red-200 bg-white text-red-500 hover:bg-red-50 text-[13px] font-semibold transition-all">
                        <span class="material-symbols-outlined" style="font-size:16px">delete</span>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
         HERO CARD — identity + status
    ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

            {{-- Coloured top bar keyed to status --}}
            @php
                $statusMeta = [
                    'active' => [
                        'bg' => 'bg-green-500',
                        'text' => 'Active',
                        'icon' => 'play_circle',
                        'pill' => 'bg-green-50 text-green-700 border-green-200',
                    ],
                    'planning' => [
                        'bg' => 'bg-blue-500',
                        'text' => 'Planning',
                        'icon' => 'pending',
                        'pill' => 'bg-blue-50 text-blue-700 border-blue-200',
                    ],
                    'on_hold' => [
                        'bg' => 'bg-amber-500',
                        'text' => 'On Hold',
                        'icon' => 'pause_circle',
                        'pill' => 'bg-amber-50 text-amber-700 border-amber-200',
                    ],
                    'completed' => [
                        'bg' => 'bg-slate-500',
                        'text' => 'Completed',
                        'icon' => 'check_circle',
                        'pill' => 'bg-slate-100 text-slate-600 border-slate-200',
                    ],
                    'cancelled' => [
                        'bg' => 'bg-red-400',
                        'text' => 'Cancelled',
                        'icon' => 'cancel',
                        'pill' => 'bg-red-50 text-red-600 border-red-200',
                    ],
                ];
                $priorityMeta = [
                    'low' => [
                        'pill' => 'bg-slate-100 text-slate-500 border-slate-200',
                        'icon' => 'arrow_downward',
                        'label' => 'Low',
                    ],
                    'medium' => [
                        'pill' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'icon' => 'drag_handle',
                        'label' => 'Medium',
                    ],
                    'high' => [
                        'pill' => 'bg-orange-50 text-orange-600 border-orange-200',
                        'icon' => 'arrow_upward',
                        'label' => 'High',
                    ],
                    'critical' => [
                        'pill' => 'bg-red-50 text-red-600 border-red-200',
                        'icon' => 'priority_high',
                        'label' => 'Critical',
                    ],
                ];

                $s = $statusMeta[$project->status] ?? [
                    'bg' => 'bg-slate-400',
                    'text' => ucfirst($project->status ?? 'Unknown'),
                    'icon' => 'info',
                    'pill' => 'bg-slate-100 text-slate-600 border-slate-200',
                ];
                $p = $priorityMeta[$project->priority] ?? [
                    'pill' => 'bg-slate-100 text-slate-500 border-slate-200',
                    'icon' => 'drag_handle',
                    'label' => ucfirst($project->priority ?? '—'),
                ];

                // Progress calculation
                $start = $project->start_date;
                $end = $project->end_date;
                $progress = 0;
                if ($start && $end) {
                    $total = $start->diffInDays($end);
                    $elapsed = $start->diffInDays(now()->min($end));
                    $progress = $total > 0 ? min(100, round(($elapsed / $total) * 100)) : 0;
                }
            @endphp

            <div class="h-1.5 w-full {{ $s['bg'] }}"></div>

            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-start gap-5">

                    {{-- Icon avatar --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                        style="background:rgba(83,108,119,0.10)">
                        <span class="material-symbols-outlined" style="font-size:28px;color:#536c77">apartment</span>
                    </div>

                    {{-- Title block --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h1 class="text-xl font-bold text-slate-800 leading-tight">{{ $project->name }}</h1>
                            @if ($project->project_code)
                                <span
                                    class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-slate-500 text-[11px] font-mono font-semibold">
                                    {{ $project->project_code }}
                                </span>
                            @endif
                        </div>

                        {{-- Badges row --}}
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            {{-- Status --}}
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border text-[11px] font-bold {{ $s['pill'] }}">
                                <span class="material-symbols-outlined" style="font-size:13px">{{ $s['icon'] }}</span>
                                {{ $s['text'] }}
                            </span>

                            {{-- Priority --}}
                            @if ($project->priority)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border text-[11px] font-bold {{ $p['pill'] }}">
                                    <span class="material-symbols-outlined"
                                        style="font-size:13px">{{ $p['icon'] }}</span>
                                    {{ $p['label'] }} Priority
                                </span>
                            @endif

                            {{-- Company --}}
                            @if ($project->company)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-600 text-[11px] font-semibold">
                                    <span class="material-symbols-outlined" style="font-size:13px">business</span>
                                    {{ $project->company->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if ($project->description)
                            <p class="mt-3 text-[13.5px] text-slate-500 leading-relaxed max-w-2xl">
                                {{ $project->description }}
                            </p>
                        @endif
                    </div>

                    {{-- Timeline + progress (right side) --}}
                    @if ($project->start_date || $project->end_date)
                        <div class="shrink-0 md:text-right min-w-[160px]">
                            @if ($project->start_date && $project->end_date)
                                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Timeline
                                </p>
                                <p class="text-[13px] font-semibold text-slate-700">
                                    {{ $project->start_date->format('M d, Y') }}
                                </p>
                                <p class="text-[12px] text-slate-400 flex md:justify-end items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined" style="font-size:13px">arrow_downward</span>
                                    {{ $project->end_date->format('M d, Y') }}
                                </p>
                                {{-- Progress bar --}}
                                <div class="mt-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[10px] text-slate-400 uppercase tracking-wider">Progress</span>
                                        <span class="text-[12px] font-bold text-[#536c77]">{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all"
                                            style="width:{{ $progress }}%; background:#536c77"></div>
                                    </div>
                                </div>
                            @elseif($project->start_date)
                                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Started
                                </p>
                                <p class="text-[13px] font-semibold text-slate-700">
                                    {{ $project->start_date->format('M d, Y') }}</p>
                            @elseif($project->end_date)
                                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold mb-1">Due</p>
                                <p class="text-[13px] font-semibold text-slate-700">
                                    {{ $project->end_date->format('M d, Y') }}</p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
         TWO-COLUMN BODY
    ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ── LEFT COLUMN (2/3) ── --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Location details --}}
                @php
                    $hasLocation = $project->address_1 || $project->city ?? null || $project->country || $project->lat;
                @endphp
                @if ($hasLocation)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#536c77]" style="font-size:18px">location_on</span>
                            <h2 class="font-bold text-[14px] text-slate-700">Location</h2>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if ($project->address_1)
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">
                                            Address</p>
                                        <p class="text-[13.5px] text-slate-700 leading-relaxed">
                                            {{ $project->address_1 }}<br>
                                            @if ($project->address_2)
                                                {{ $project->address_2 }}<br>
                                            @endif
                                            @if ($project->state_province)
                                                {{ $project->state_province }},
                                            @endif
                                            @if ($project->postal_code)
                                                {{ $project->postal_code }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                @if ($project->country)
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">
                                            Country</p>
                                        <p class="text-[13.5px] text-slate-700">{{ $project->country }}</p>
                                    </div>
                                @endif
                                @if ($project->lat && $project->lng)
                                    <div class="sm:col-span-2">
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-2">
                                            Coordinates</p>
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-[12px] font-mono text-slate-600">
                                                <span class="material-symbols-outlined text-slate-400"
                                                    style="font-size:14px">my_location</span>
                                                {{ $project->lat }}, {{ $project->lng }}
                                            </span>
                                            <a href="https://maps.google.com/?q={{ $project->lat }},{{ $project->lng }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1 text-[12px] text-[#536c77] hover:underline font-medium transition-colors">
                                                <span class="material-symbols-outlined"
                                                    style="font-size:14px">open_in_new</span>
                                                Open in Maps
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Cameras --}}
                @if ($project->cameras && $project->cameras->count() > 0)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#536c77]"
                                    style="font-size:18px">videocam</span>
                                <h2 class="font-bold text-[14px] text-slate-700">Cameras</h2>
                                <span
                                    class="ml-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[11px] font-bold">
                                    {{ $project->cameras->count() }}
                                </span>
                            </div>
                            <a href="#" class="text-[12px] text-[#536c77] hover:underline font-medium">Manage</a>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach ($project->cameras as $camera)
                                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                                        style="background:rgba(83,108,119,0.10)">
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;color:#536c77">camera_indoor</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold text-slate-700 truncate">
                                            {{ $camera->name ?? 'Camera ' . $loop->iteration }}
                                        </p>
                                        @if (isset($camera->serial_number) || isset($camera->location))
                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                {{ $camera->serial_number ?? '' }}
                                                @if (isset($camera->location))
                                                    · {{ $camera->location }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                    @if (isset($camera->status))
                                        @php
                                            $camStatus = match ($camera->status) {
                                                'online' => 'bg-green-50 text-green-600 border-green-200',
                                                'offline' => 'bg-red-50 text-red-500 border-red-200',
                                                default => 'bg-slate-100 text-slate-500 border-slate-200',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-0.5 rounded-full border text-[10px] font-bold uppercase {{ $camStatus }}">
                                            {{ $camera->status }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Team Members --}}
                @if ($project->members && $project->members->count() > 0)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#536c77]" style="font-size:18px">group</span>
                                <h2 class="font-bold text-[14px] text-slate-700">Team Members</h2>
                                <span
                                    class="ml-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[11px] font-bold">
                                    {{ $project->members->count() }}
                                </span>
                            </div>
                            <a href="#" class="text-[12px] text-[#536c77] hover:underline font-medium">Manage
                                team</a>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($project->members as $member)
                                    @php
                                        $roleMeta = [
                                            'owner' => 'bg-[#536c77]/10 text-[#536c77] border-[#536c77]/20',
                                            'admin' => 'bg-orange-50 text-orange-600 border-orange-200',
                                            'editor' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'viewer' => 'bg-slate-100 text-slate-500 border-slate-200',
                                        ];
                                        $roleClass =
                                            $roleMeta[$member->pivot->role ?? ''] ??
                                            'bg-slate-100 text-slate-500 border-slate-200';
                                        $initials = collect(explode(' ', $member->name))
                                            ->map(fn($w) => strtoupper($w[0] ?? ''))
                                            ->take(2)
                                            ->join('');
                                    @endphp
                                    <div
                                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50 hover:border-slate-200 transition-colors">
                                        {{-- Avatar --}}
                                        @if ($member->avatar ?? null)
                                            <img src="{{ $member->avatar }}" alt="{{ $member->name }}"
                                                class="w-9 h-9 rounded-full object-cover shrink-0 ring-2 ring-white" />
                                        @else
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 text-white text-[12px] font-bold"
                                                style="background:#536c77">{{ $initials }}</div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[13px] font-semibold text-slate-700 truncate">
                                                {{ $member->name }}</p>
                                            <p class="text-[11px] text-slate-400 truncate">{{ $member->email }}</p>
                                        </div>
                                        @if ($member->pivot->role)
                                            <span
                                                class="shrink-0 px-2 py-0.5 rounded-full border text-[10px] font-bold capitalize {{ $roleClass }}">
                                                {{ $member->pivot->role }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Empty state — shown only when no related data at all --}}
                @if (
                    (!$project->cameras || $project->cameras->count() === 0) &&
                        (!$project->members || $project->members->count() === 0) &&
                        !$hasLocation)
                    <div
                        class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 flex flex-col items-center justify-center text-center">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4"
                            style="background:rgba(83,108,119,0.08)">
                            <span class="material-symbols-outlined"
                                style="font-size:24px;color:#536c77">inventory_2</span>
                        </div>
                        <p class="font-semibold text-slate-600 text-[14px] mb-1">No related data yet</p>
                        <p class="text-[12.5px] text-slate-400 max-w-xs leading-relaxed">
                            Add cameras, team members, or location details to see them here.
                        </p>
                    </div>
                @endif

            </div>{{-- /left column --}}

            {{-- ── RIGHT COLUMN (1/3) — sidebar meta ── --}}
            <div class="space-y-4">

                {{-- Project details card --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h2 class="font-bold text-[14px] text-slate-700">Project Details</h2>
                    </div>
                    <div class="p-5 space-y-4">

                        {{-- Project Code --}}
                        @if ($project->project_code)
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Project
                                    Code</p>
                                <p class="text-[13px] font-mono font-semibold text-slate-700">{{ $project->project_code }}
                                </p>
                            </div>
                        @endif

                        {{-- Company --}}
                        {{-- @if ($project->company)
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Company
                                </p>
                                <a href="{{ route('companies.show', $project->company) }}"
                                    class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#536c77] hover:underline">
                                    <span class="material-symbols-outlined" style="font-size:15px">business</span>
                                    {{ $project->company->name }}
                                </a>
                            </div>
                        @endif --}}

                        {{-- Alerts email --}}
                        @if ($project->alerts_email)
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Alert
                                    Emails</p>
                                <div class="space-y-1">
                                    @foreach (explode(',', $project->alerts_email) as $email)
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-slate-400"
                                                style="font-size:14px">mail</span>
                                            <p class="text-[12.5px] text-slate-600 break-all">{{ trim($email) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Dates --}}
                        @if ($project->start_date || $project->end_date)
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-2">Timeline
                                </p>
                                <div class="space-y-2">
                                    @if ($project->start_date)
                                        <div class="flex items-center justify-between">
                                            <span class="text-[12px] text-slate-500 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-slate-400"
                                                    style="font-size:14px">play_arrow</span>
                                                Start
                                            </span>
                                            <span
                                                class="text-[12px] font-semibold text-slate-700">{{ $project->start_date->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                    @if ($project->end_date)
                                        <div class="flex items-center justify-between">
                                            <span class="text-[12px] text-slate-500 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-slate-400"
                                                    style="font-size:14px">flag</span>
                                                End
                                            </span>
                                            <span
                                                class="text-[12px] font-semibold text-slate-700">{{ $project->end_date->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                    @if ($project->start_date && $project->end_date)
                                        <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                                            <span class="text-[12px] text-slate-500 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-slate-400"
                                                    style="font-size:14px">timelapse</span>
                                                Duration
                                            </span>
                                            <span class="text-[12px] font-semibold text-slate-700">
                                                {{ $project->start_date->diffInDays($project->end_date) }} days
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Created by --}}
                        @if ($project->created_by)
                            <div class="pt-1 border-t border-slate-100">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Created
                                    by</p>
                                <p class="text-[12.5px] text-slate-600">
                                    User #{{ $project->created_by }}
                                </p>
                            </div>
                        @endif

                        {{-- Timestamps --}}
                        <div class="pt-1 border-t border-slate-100 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400">Created</span>
                                <span
                                    class="text-[11px] text-slate-500">{{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400">Updated</span>
                                <span
                                    class="text-[11px] text-slate-500">{{ $project->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Quick stats --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h2 class="font-bold text-[14px] text-slate-700">Quick Stats</h2>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                            <p class="text-xl font-bold text-[#536c77]">
                                {{ $project->cameras ? $project->cameras->count() : 0 }}
                            </p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Cameras</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                            <p class="text-xl font-bold text-[#536c77]">
                                {{ $project->members ? $project->members->count() : 0 }}
                            </p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Members</p>
                        </div>
                        @if ($project->start_date && $project->end_date)
                            <div class="col-span-2 p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                <p class="text-xl font-bold text-[#536c77]">{{ $progress }}%</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Timeline Progress</p>
                                <div class="mt-2 w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full"
                                        style="width:{{ $progress }}%; background:#536c77"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="bg-white rounded-2xl border border-red-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-red-100">
                        <h2 class="font-bold text-[14px] text-red-600">Danger Zone</h2>
                    </div>
                    <div class="p-5 space-y-3">
                        <p class="text-[12px] text-slate-500 leading-relaxed">
                            Deleting this project is permanent and cannot be undone. All related cameras and member
                            associations will be removed.
                        </p>
                        <form method="POST" action="{{ route('company.projects.destroy', $project) }}"
                            onsubmit="return confirm('Are you sure? This will permanently delete the project and all related data.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-[13px] font-semibold hover:bg-red-100 transition-all">
                                <span class="material-symbols-outlined" style="font-size:16px">delete_forever</span>
                                Delete Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

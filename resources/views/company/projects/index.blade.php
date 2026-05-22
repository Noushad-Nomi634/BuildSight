@extends('layouts.app')
@section('title', 'Projects')

@section('content')

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-sm text-text-muted mb-1">
                <span>Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <span class="text-on-surface font-medium">Projects</span>
            </div>
            <h2 class="text-xl font-bold text-on-surface">Projects</h2>
            <p class="text-sm text-text-muted mt-0.5">Manage and track all company projects.</p>
        </div>
        <a href="{{ route('company.projects.create') }}"
            class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-[13px] font-bold
                   px-5 py-2.5 rounded-xl transition-all duration-200 active:scale-[0.98] shadow-sm
                   hover:shadow-md w-fit">
            <span class="material-symbols-outlined" style="font-size:17px">add</span>
            New Project
        </a>
    </div>

    {{-- ── Stat Cards ── --}}
    <section class="grid grid-cols-2 sm:grid-cols-4 gap-3">

        @php
            $statuses = ['active', 'planning', 'on_hold', 'completed'];
            $statColors = [
                'active' => 'bg-status-completed/10 text-status-completed',
                'planning' => 'bg-status-upcoming/10 text-status-upcoming',
                'on_hold' => 'bg-status-pending/10 text-status-pending',
                'completed' => 'bg-primary/10 text-primary',
            ];
            $statIcons = [
                'active' => 'play_circle',
                'planning' => 'pending_actions',
                'on_hold' => 'pause_circle',
                'completed' => 'check_circle',
            ];
            $statLabels = [
                'active' => 'Active',
                'planning' => 'Planning',
                'on_hold' => 'On Hold',
                'completed' => 'Completed',
            ];
        @endphp

        @foreach ($statuses as $s)
            <div
                class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60
                        flex flex-col gap-3 hover:shadow-md transition-shadow">
                <div class="p-2 {{ $statColors[$s] }} rounded-xl w-fit">
                    <span class="material-symbols-outlined" style="font-size:18px">{{ $statIcons[$s] }}</span>
                </div>
                <div>
                    <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">{{ $statLabels[$s] }}</p>
                    <h4 class="text-3xl font-bold text-on-surface mt-0.5">
                        {{ $projects->where('status', $s)->count() }}
                    </h4>
                </div>
            </div>
        @endforeach

    </section>

    {{-- ── Table Card ── --}}
    <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

        {{-- toolbar --}}
        <div
            class="px-5 py-4 border-b border-secondary-container flex flex-col sm:flex-row sm:items-center
                    justify-between gap-3">
            <div>
                <h3 class="font-bold text-[15px] text-on-surface">All Projects</h3>
                <p class="text-[11px] text-text-muted mt-0.5">{{ $projects->total() }} total projects</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Search --}}
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-text-muted"
                        style="font-size:15px">search</span>
                    <input type="text" placeholder="Search projects..."
                        class="pl-8 pr-3 py-2 text-[12px] bg-surface-container-low border border-secondary-container
                               rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary
                               w-52 transition-all" />
                </div>
                {{-- Status filter --}}
                <select
                    class="px-3 py-2 text-[12px] bg-surface-container-low border border-secondary-container
                               rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary
                               text-on-surface transition-all appearance-none cursor-pointer pr-8">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="planning">Planning</option>
                    <option value="on_hold">On Hold</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        {{-- table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[720px]">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Project</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Code</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Priority</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Ftp Folder</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">Timeline</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-container/70">

                    @forelse ($projects as $project)
                        @php
                            $statusMap = [
                                'active' => 'bg-status-completed/10 text-status-completed',
                                'planning' => 'bg-status-upcoming/10 text-status-upcoming',
                                'on_hold' => 'bg-status-pending/10 text-status-pending',
                                'completed' => 'bg-primary/10 text-primary',
                                'cancelled' => 'bg-status-cancelled/10 text-status-cancelled',
                            ];
                            $priorityMap = [
                                'low' => 'bg-secondary/10 text-secondary',
                                'medium' => 'bg-status-upcoming/10 text-status-upcoming',
                                'high' => 'bg-status-pending/10 text-status-pending',
                                'urgent' => 'bg-status-cancelled/10 text-status-cancelled',
                            ];
                            $priorityDot = [
                                'low' => 'bg-secondary',
                                'medium' => 'bg-status-upcoming',
                                'high' => 'bg-status-pending',
                                'urgent' => 'bg-status-cancelled',
                            ];
                        @endphp
                        <tr class="hover:bg-surface-container-low/60 transition-colors" >

                            {{-- Project name + address --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary"
                                            style="font-size:18px">work</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[13px] text-on-surface">{{ $project->name }}</p>
                                        @if ($project->address_1)
                                            <p class="text-[11px] text-text-muted truncate max-w-[200px]">
                                                {{ $project->address_1 }}{{ $project->country ? ', ' . $project->country : '' }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Code --}}
                            <td class="px-5 py-4">
                                @if ($project->project_code)
                                    <span
                                        class="text-[11px] font-mono font-bold text-text-muted bg-surface-container-low
                                                 border border-secondary-container px-2 py-1 rounded-lg">
                                        {{ $project->project_code }}
                                    </span>
                                @else
                                    <span class="text-text-muted text-[12px]">—</span>
                                @endif
                            </td>

                            {{-- Priority --}}
                            <td class="px-5 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px]
                                             font-bold uppercase tracking-wide {{ $priorityMap[$project->priority] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $priorityDot[$project->priority] }}"></span>
                                    {{ $project->priority }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px]
                                             font-bold uppercase tracking-wide ">
                                    {{ $project->ftp_folder }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px]
                                             font-bold uppercase tracking-wide {{ $statusMap[$project->status] }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full
                                        {{ str_replace(['text-', 'bg-'], ['bg-', ''], explode(' ', $statusMap[$project->status])[1] ?? '') }}
                                        {{ match ($project->status) {
                                            'active' => 'bg-status-completed',
                                            'planning' => 'bg-status-upcoming',
                                            'on_hold' => 'bg-status-pending',
                                            'completed' => 'bg-primary',
                                            'cancelled' => 'bg-status-cancelled',
                                        } }}"></span>
                                    {{ str_replace('_', ' ', $project->status) }}
                                </span>
                            </td>

                            {{-- Timeline --}}
                            <td class="px-5 py-4">
                                @if ($project->start_date || $project->end_date)
                                    <p class="text-[12px] text-on-surface">
                                        {{ $project->start_date?->format('M d, Y') ?? '—' }}
                                    </p>
                                    <p class="text-[11px] text-text-muted mt-0.5">
                                        to {{ $project->end_date?->format('M d, Y') ?? 'Ongoing' }}
                                    </p>
                                @else
                                    <span class="text-text-muted text-[12px]">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                           <td class="px-5 py-4">
    <div class="flex items-center justify-end gap-1">

        {{-- VIEW --}}
        <a href="{{ route('company.projects.show', $project) }}"
            class="p-1.5 rounded-lg hover:bg-primary/10 text-text-muted hover:text-primary transition-colors"
            title="View">
            <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
        </a>

        {{-- EDIT --}}
        <a href="{{ route('company.projects.edit', $project) }}"
            class="p-1.5 rounded-lg hover:bg-primary/10 text-text-muted hover:text-primary transition-colors"
            title="Edit">
            <span class="material-symbols-outlined" style="font-size:18px">edit_square</span>
        </a>

      

        {{-- DELETE --}}
        <form method="POST" action="{{ route('company.projects.destroy', $project) }}"
            onsubmit="return confirm('Delete {{ addslashes($project->name) }}?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="p-1.5 rounded-lg hover:bg-status-cancelled/10 text-text-muted hover:text-status-cancelled transition-colors"
                title="Delete">
                <span class="material-symbols-outlined" style="font-size:18px">delete</span>
            </button>
        </form>

    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-surface-container-low flex items-center justify-center">
                                        <span class="material-symbols-outlined text-text-muted"
                                            style="font-size:28px">work_off</span>
                                    </div>
                                    <p class="text-[13px] font-semibold text-on-surface">No projects yet</p>
                                    <p class="text-[12px] text-text-muted">Get started by creating your first project.</p>
                                    <a href="{{ route('company.projects.create') }}"
                                        class="mt-1 flex items-center gap-1.5 text-[12px] font-bold text-white bg-primary
                                               hover:bg-primary/90 px-4 py-2 rounded-xl transition-all">
                                        <span class="material-symbols-outlined" style="font-size:15px">add</span>
                                        New Project
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($projects->hasPages())
            <div class="px-5 py-4 border-t border-secondary-container flex items-center justify-between">
                <p class="text-[12px] text-text-muted">
                    Showing {{ $projects->firstItem() }}–{{ $projects->lastItem() }} of {{ $projects->total() }}
                </p>
                {{ $projects->links() }}
            </div>
        @endif

    </div>

@endsection

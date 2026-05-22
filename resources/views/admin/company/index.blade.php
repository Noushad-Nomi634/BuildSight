@extends('layouts.app')
@section('content')
    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-on-surface">Good morning, {{ auth()->user()->name }} 👋</h2>
            <p class="text-sm text-text-muted mt-0.5">Here's what's happening at {{ config('app.name') }} today.</p>
        </div>
        <div
            class="flex items-center gap-2 text-sm text-text-muted bg-surface-white border border-secondary-container rounded-xl px-4 py-2 w-fit">
            <span class="material-symbols-outlined text-primary" style="font-size:16px">calendar_today</span>
            <span id="current-date" class="font-medium text-on-surface"></span>
        </div>
    </div>

     <!-- ── METRIC CARDS ── -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-3 lg:gap-4">

        <!-- Card 1 -->
        <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-primary/10 rounded-xl text-primary">
                    <span class="material-symbols-outlined" style="font-size:18px">event_available</span>
                </div>
                <span class="text-status-completed text-[11px] font-bold flex items-center gap-0.5">
                    <span class="material-symbols-outlined" style="font-size:14px">trending_up</span> 5%
                </span>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">
                    Total Companies
                </p>

                <h4 class="text-3xl font-bold text-on-surface mt-0.5">
                    {{ $totalCompanies }}
                </h4>
            </div>
        </div>

        <!-- Card 2 -->
        {{--   <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-accent-lavender/50 rounded-xl text-tertiary">
                    <span class="material-symbols-outlined" style="font-size:18px">group</span>
                </div>
                <span class="text-status-completed text-[11px] font-bold flex items-center gap-0.5">
                    <span class="material-symbols-outlined" style="font-size:14px">trending_up</span> 2%
                </span>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">Total Patients</p>
                <h4 class="text-3xl font-bold text-on-surface mt-0.5">1,240</h4>
            </div>
        </div> --}}

        <!-- Card 3 -->
        {{--  <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-status-completed/10 rounded-xl text-status-completed">
                    <span class="material-symbols-outlined" style="font-size:18px">payments</span>
                </div>
                <span class="text-status-completed text-[11px] font-bold flex items-center gap-0.5">
                    <span class="material-symbols-outlined" style="font-size:14px">trending_up</span> 8%
                </span>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">Revenue Today</p>
                <h4 class="text-3xl font-bold text-on-surface mt-0.5">$4,250</h4>
            </div>
        </div> --}}

        <!-- Card 4 -->
        <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-status-upcoming/10 rounded-xl text-status-upcoming">
                    <span class="material-symbols-outlined" style="font-size:18px">schedule</span>
                </div>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">
                    Total Projects
                </p>

                <h4 class="text-3xl font-bold text-on-surface mt-0.5">
                    {{ $totalProjects }}
                </h4>
            </div>
        </div>

        <!-- Card 5 -->
        <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-primary/10 rounded-xl text-primary">
                    <span class="material-symbols-outlined" style="font-size:18px">done_all</span>
                </div>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">
                    Total Cameras
                </p>

                <h4 class="text-3xl font-bold text-on-surface mt-0.5">
                    {{ $totalCameras }}
                </h4>
            </div>
        </div>

        <!-- Card 6 -->
        {{--  <div
            class="bg-surface-white p-4 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-status-pending/10 rounded-xl text-status-pending">
                    <span class="material-symbols-outlined" style="font-size:18px">hourglass_empty</span>
                </div>
            </div>
            <div>
                <p class="text-text-muted text-[11px] font-medium uppercase tracking-wide">Pending Pay.</p>
                <h4 class="text-3xl font-bold text-on-surface mt-0.5">3</h4>
            </div>
        </div> --}}

    </section>


    <!-- ── CHARTS ROW ── -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Weekly Bar Chart -->
        {{-- <div class="bg-surface-white p-5 rounded-2xl shadow-sm border border-secondary-container/60 lg:col-span-2">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="font-bold text-[15px] text-on-surface">Weekly Appointment Trend</h3>
                    <p class="text-[11px] text-text-muted mt-0.5">Last 7 days overview</p>
                </div>
                <span class="text-[11px] font-medium text-text-muted bg-surface-container px-3 py-1 rounded-full">This
                    Week</span>
            </div>

            <div class="flex items-end gap-2 h-[200px] pb-0">
                <!-- Bars: Mon–Sun with actual counts -->
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">16</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:40%"></div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">22</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:62%"></div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">28</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:80%"></div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">19</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:55%"></div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">32</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:92%"></div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] font-bold text-primary">24</span>
                    <div class="bar-col w-full bg-primary rounded-t-lg shadow-md shadow-primary/20" style="height:70%">
                    </div>
                </div>
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-[10px] text-text-muted font-medium">9</span>
                    <div class="bar-col w-full bg-primary/10 hover:bg-primary/25 rounded-t-lg" style="height:28%"></div>
                </div>
            </div>
            <div class="flex justify-between pt-3 border-t border-secondary-container mt-2">
                <span class="text-[11px] text-text-muted">Mon</span>
                <span class="text-[11px] text-text-muted">Tue</span>
                <span class="text-[11px] text-text-muted">Wed</span>
                <span class="text-[11px] text-text-muted">Thu</span>
                <span class="text-[11px] text-text-muted">Fri</span>
                <span class="text-[11px] font-bold text-primary">Sat</span>
                <span class="text-[11px] text-text-muted">Sun</span>
            </div>
        </div> --}}

        <!-- Donut / Treatment Breakdown -->
        {{-- <div class="bg-surface-white p-5 rounded-2xl shadow-sm border border-secondary-container/60 flex flex-col">
            <div>
                <h3 class="font-bold text-[15px] text-on-surface">Treatment Mix</h3>
                <p class="text-[11px] text-text-muted mt-0.5">Today's breakdown</p>
            </div>

            <div class="relative w-40 h-40 mx-auto my-4">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" fill="none" r="15.5" stroke="#eceeee"
                        stroke-width="3.5" />
                    <circle cx="18" cy="18" fill="none" r="15.5" stroke="#006162"
                        stroke-dasharray="40 100" stroke-width="3.5" />
                    <circle cx="18" cy="18" fill="none" r="15.5" stroke="#3182CE"
                        stroke-dasharray="30 100" stroke-dashoffset="-40" stroke-width="3.5" />
                    <circle cx="18" cy="18" fill="none" r="15.5" stroke="#E9D8FD"
                        stroke-dasharray="20 100" stroke-dashoffset="-70" stroke-width="3.5" />
                    <circle cx="18" cy="18" fill="none" r="15.5" stroke="#595f63"
                        stroke-dasharray="10 100" stroke-dashoffset="-90" stroke-width="3.5" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-lg font-bold text-on-surface">24</span>
                    <span class="text-[9px] text-text-muted uppercase tracking-wider">Total</span>
                </div>
            </div>

            <div class="space-y-2.5 mt-auto">
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-[12px] text-on-surface"><span
                            class="w-2.5 h-2.5 rounded-full bg-primary inline-block"></span>Botox</span>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-secondary-container rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width:40%"></div>
                        </div>
                        <span class="text-[12px] font-bold text-on-surface w-7 text-right">40%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-[12px] text-on-surface"><span
                            class="w-2.5 h-2.5 rounded-full bg-status-upcoming inline-block"></span>Laser</span>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-secondary-container rounded-full overflow-hidden">
                            <div class="h-full bg-status-upcoming rounded-full" style="width:30%"></div>
                        </div>
                        <span class="text-[12px] font-bold text-on-surface w-7 text-right">30%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-[12px] text-on-surface"><span
                            class="w-2.5 h-2.5 rounded-full bg-accent-lavender inline-block border border-slate-200"></span>Facials</span>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-secondary-container rounded-full overflow-hidden">
                            <div class="h-full bg-accent-lavender rounded-full" style="width:20%"></div>
                        </div>
                        <span class="text-[12px] font-bold text-on-surface w-7 text-right">20%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-[12px] text-text-muted"><span
                            class="w-2.5 h-2.5 rounded-full bg-secondary inline-block"></span>Others</span>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-secondary-container rounded-full overflow-hidden">
                            <div class="h-full bg-secondary rounded-full" style="width:10%"></div>
                        </div>
                        <span class="text-[12px] font-bold text-text-muted w-7 text-right">10%</span>
                    </div>
                </div>
            </div>
        </div> --}}

    </section>

    <!-- ── TABLES ROW ── -->
    <section class="grid grid-cols-1  gap-4">

        <!-- Today's Appointments Table -->
       <div
            class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 xl:col-span-3 overflow-hidden">
            <div class="px-5 py-4 border-b border-secondary-container flex justify-between items-center">
                {{--<div>
                    <h3 class="font-bold text-[15px] text-on-surface">Today's Appointments</h3>
                    <p class="text-[11px] text-text-muted mt-0.5">4 scheduled · 1 cancelled</p>
                </div>--}}
                <button
                    class="text-primary text-[12px] font-semibold hover:underline transition-all flex items-center gap-1">
                   {{--View All <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span>--}}
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[520px]">
                    <thead>
                        <tr class="bg-surface-container-low">
                            <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">
                                profile</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">
                                Name</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">
                                Phone</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">
                                Status</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-text-muted uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-container/70">
                        <!-- Row 1 -->
                        {{-- @dd($companies) --}}
                        @foreach ($companies as $company)
                            <tr class="hover:bg-surface-container-low/60 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <img alt="Emma Thompson"
                                            class="w-8 h-8 rounded-full object-cover shrink-0 ring-1 ring-secondary-container"
                                            src="{{ asset('storage/' . $company->logo) }}">
                                        <span class="font-semibold text-[13px] text-on-surface">{{ $company->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-[13px] text-on-surface-variant">{{ $company->name }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-on-surface-variant">{{ $company->phone }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-on-surface-variant">{{ $company->status }}</td>

                                <td class="px-5 py-3.5">
    <div class="flex items-center gap-2">

        <!-- VIEW -->
        <a href="{{ route('admin.company.show', $company->id) }}"
           class="p-2 rounded-lg hover:bg-primary/10 text-text-muted hover:text-primary transition">

            <span class="material-symbols-outlined text-[18px]">visibility</span>
        </a>

        <!-- EDIT -->
        <a href="{{ route('admin.company.edit', $company->id) }}"
           class="p-2 rounded-lg hover:bg-status-upcoming/10 text-text-muted hover:text-status-upcoming transition">

            <span class="material-symbols-outlined text-[18px]">edit</span>
        </a>

        <!-- DELETE -->
        <form action="{{ route('admin.company.destroy', $company->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                class="p-2 rounded-lg hover:bg-red-100 text-text-muted hover:text-red-600 transition">

                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>

        </form>

    </div>
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Patients -->
        {{-- <div
            class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 xl:col-span-2 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-secondary-container flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-bold text-[15px] text-on-surface">Recent Patients</h3>
                    <p class="text-[11px] text-text-muted mt-0.5">Latest registrations</p>
                </div>
                <button
                    class="text-primary text-[12px] font-semibold hover:underline transition-all flex items-center gap-1">
                    All <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span>
                </button>
            </div>
            <div class="flex-1 divide-y divide-secondary-container/70">

                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-surface-container-low/60 transition-colors">
                    <div
                        class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">
                        AC</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-[13px] text-on-surface truncate">Alice Cooper</p>
                        <p class="text-[11px] text-text-muted">(555) 012-3456</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[11px] text-text-muted">Oct 24, 2023</p>
                        <p class="text-[12px] font-bold text-primary mt-0.5">12 visits</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-surface-container-low/60 transition-colors">
                    <div
                        class="w-9 h-9 rounded-full bg-status-upcoming/10 text-status-upcoming flex items-center justify-center font-bold text-sm shrink-0">
                        RF</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-[13px] text-on-surface truncate">Robert Fox</p>
                        <p class="text-[11px] text-text-muted">(555) 987-6543</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[11px] text-text-muted">Oct 22, 2023</p>
                        <p class="text-[12px] font-bold text-primary mt-0.5">4 visits</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-surface-container-low/60 transition-colors">
                    <div
                        class="w-9 h-9 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center font-bold text-sm shrink-0">
                        LG</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-[13px] text-on-surface truncate">Linda Gray</p>
                        <p class="text-[11px] text-text-muted">(555) 456-7890</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[11px] text-text-muted">Oct 21, 2023</p>
                        <p class="text-[12px] font-bold text-primary mt-0.5">8 visits</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-surface-container-low/60 transition-colors">
                    <div
                        class="w-9 h-9 rounded-full bg-status-pending/10 text-status-pending flex items-center justify-center font-bold text-sm shrink-0">
                        MS</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-[13px] text-on-surface truncate">Mark Sloan</p>
                        <p class="text-[11px] text-text-muted">(555) 222-3333</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[11px] text-text-muted">Oct 20, 2023</p>
                        <p class="text-[12px] font-bold text-primary mt-0.5">2 visits</p>
                    </div>
                </div>

            </div>
            <!-- Quick add patient -->
            <div class="px-5 py-3 border-t border-secondary-container shrink-0">
                <button
                    class="w-full flex items-center justify-center gap-2 text-primary text-[12px] font-semibold py-2 rounded-xl border border-primary/30 hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined" style="font-size:15px">person_add</span> Add New
                    Patient
                </button>
            </div>
        </div> --}}

    </section>
@endsection

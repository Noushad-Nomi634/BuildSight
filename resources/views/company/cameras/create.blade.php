@extends('layouts.app')

@section('title', 'Create Camera')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

        <div>
            <h2 class="text-xl font-bold text-on-surface">
                Create Camera
            </h2>

            <p class="text-sm text-text-muted mt-0.5">
                Add a new camera to your system
            </p>
        </div>

        <a href="{{ route('company.cameras.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  bg-surface-white border border-secondary-container
                  text-text-muted hover:text-primary hover:border-primary
                  transition w-fit">

            <span class="material-symbols-outlined" style="font-size:16px">
                arrow_back
            </span>

            Back
        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

        <form method="POST" action="{{ route('company.cameras.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- PROJECT --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Project
                </label>

                <select name="project_id"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                               bg-surface-container-low text-on-surface text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">

                    <option value="">Select Project</option>

                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- CAMERA NAME --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Camera Name
                </label>

                <input type="text"
                       name="name"
                       placeholder="e.g. Front Gate Camera"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>

            {{-- IP + PORT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                        IP Address
                    </label>

                    <input type="text"
                           name="ip_address"
                           placeholder="192.168.1.1"
                           class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                                  bg-surface-container-low text-on-surface text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>

                <div>
                    <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                        Port
                    </label>

                    <input type="number"
                           name="port"
                           placeholder="8080"
                           class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                                  bg-surface-container-low text-on-surface text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>

            </div>

            {{-- USERNAME --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Username
                </label>

                <input type="text"
                       name="username"
                       placeholder="admin"
                       class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Password
                </label>

                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>

            {{-- SNAPSHOT URL --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Snapshot URL
                </label>

                <input type="text"
                       name="snapshot_url"
                       placeholder="http://..."
                       class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>

            {{-- UPLOAD METHOD --}}
            <div>
                <label class="block text-[12px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                    Upload Method
                </label>

                <select name="upload_method"
                        class="w-full px-4 py-2.5 rounded-xl border border-secondary-container/60
                               bg-surface-container-low text-on-surface text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">

                    <option value="ftp">FTP</option>
                    <option value="http">HTTP</option>
                    <option value="onvif">ONVIF</option>

                </select>
            </div>

            {{-- ACTIVE --}}
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="w-4 h-4 text-primary border-secondary-container rounded">

                <label class="text-sm text-text-muted">
                    Active Camera
                </label>
            </div>

            {{-- BUTTON --}}
            <div class="pt-2 flex justify-center">
    <button type="submit"
            class="flex items-center gap-2 py-2.5 px-6 rounded-xl
                   bg-primary text-white font-bold text-[13.5px]
                   hover:bg-primary/90 transition active:scale-[0.98]">

        <span class="material-symbols-outlined" style="font-size:18px">
            save
        </span>

        Save Camera

    </button>
</div>

        </form>

    </div>

</div>

@endsection
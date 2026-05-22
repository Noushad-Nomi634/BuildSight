@extends('layouts.app')

@section('title', 'Edit Camera')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-on-surface">
            Edit Camera
        </h2>

        <p class="text-sm text-text-muted">
            Update camera configuration and settings
        </p>
    </div>

    <a href="{{ route('company.cameras.show', $camera->id) }}"
       class="flex items-center gap-2 bg-surface-white hover:bg-surface-container-low border
              border-secondary-container text-on-surface text-[13px] font-bold px-4 py-2.5
              rounded-xl transition-all shadow-sm active:scale-[0.98] w-fit">

        <span class="material-symbols-outlined" style="font-size:17px">arrow_back</span>
        Back
    </a>

</div>

{{-- CARD --}}
<div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">

    <form method="POST" action="{{ route('company.cameras.update', $camera->id) }}"
          class="p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- GRID INPUTS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Camera Name --}}
            <div class="sm:col-span-2">
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Camera Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $camera->name) }}"
                       class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            {{-- IP Address --}}
            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    IP Address
                </label>

                <input type="text"
                       name="ip_address"
                       value="{{ old('ip_address', $camera->ip_address) }}"
                       class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            {{-- Port --}}
            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Port
                </label>

                <input type="number"
                       name="port"
                       value="{{ old('port', $camera->port) }}"
                       class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            {{-- Username --}}
            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Username
                </label>

                <input type="text"
                       name="username"
                       value="{{ old('username', $camera->username) }}"
                       class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            {{-- Password --}}
            <div>
                <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                    Password
                </label>

                <input type="text"
                       name="password"
                       value="{{ old('password', $camera->password) }}"
                       class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                              bg-surface-container-low text-on-surface text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

        </div>

        {{-- SNAPSHOT URL --}}
        <div>
            <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                Snapshot URL
            </label>

            <input type="text"
                   name="snapshot_url"
                   value="{{ old('snapshot_url', $camera->snapshot_url) }}"
                   class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                          bg-surface-container-low text-on-surface text-sm
                          focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>

        {{-- UPLOAD METHOD --}}
        <div>
            <label class="text-[10px] font-bold text-text-muted uppercase tracking-wide">
                Upload Method
            </label>

            <select name="upload_method"
                    class="w-full mt-1 px-3 py-2 rounded-xl border border-secondary-container/60
                           bg-surface-container-low text-on-surface text-sm
                           focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">

                <option value="ftp" {{ old('upload_method', $camera->upload_method) == 'ftp' ? 'selected' : '' }}>FTP</option>
                <option value="http" {{ old('upload_method', $camera->upload_method) == 'http' ? 'selected' : '' }}>HTTP</option>
                <option value="onvif" {{ old('upload_method', $camera->upload_method) == 'onvif' ? 'selected' : '' }}>ONVIF</option>

            </select>
        </div>

        {{-- ACTIVE --}}
        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   class="w-4 h-4 text-primary border-secondary-container rounded"
                   {{ old('is_active', $camera->is_active) ? 'checked' : '' }}>

            <label class="text-sm text-text-muted">
                Active Camera
            </label>
        </div>

        {{-- BUTTON --}}
        <div class="pt-2">
            <button type="submit"
                    class="flex items-center justify-center gap-2 w-full bg-primary text-white font-bold
                           text-[13px] py-2.5 rounded-xl hover:bg-primary/90 transition-all shadow-sm
                           active:scale-[0.98]">

                <span class="material-symbols-outlined" style="font-size:17px">save</span>
                Update Camera
            </button>
        </div>

    </form>

</div>

@endsection
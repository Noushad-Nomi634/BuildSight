 @php
     $isEdit = $isEdit ?? false;
     $project = $project ?? null;
 @endphp

 <form method="POST" action="{{ $route }}">
     @csrf
     @if ($method !== 'POST')
         @method($method)
     @endif
     @if ($errors->any())
         <div class="bg-status-cancelled/10 border border-status-cancelled text-status-cancelled p-4 rounded-xl mb-5">
             <p class="font-bold text-sm mb-2">Please fix the following errors:</p>
             <ul class="list-disc pl-5 text-[12px] space-y-1">
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
     @endif
     <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

         {{-- ── LEFT: Main fields ── --}}
         <div class="xl:col-span-2 space-y-5">

             {{-- Basic Info --}}
             <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
                 <div class="px-5 py-4 border-b border-secondary-container flex items-center gap-2">
                     <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                     <h3 class="font-bold text-[14px] text-on-surface">Basic Information</h3>
                 </div>
                 <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                     {{-- Name --}}
                     <div class="sm:col-span-2">
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Project Name <span class="text-status-cancelled">*</span>
                         </label>
                         <input type="text" name="name" value="{{ old('name', $project?->name ?? '') }}"
                             placeholder="e.g. Downtown Office Renovation"
                             class="w-full px-4 py-2.5 rounded-xl border @error('name') border-status-cancelled @else border-secondary-container @enderror
                                       bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none
                                       focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white
                                       transition-all placeholder:text-text-muted" />
                         @error('name')
                             <p class="mt-1 text-[11px] text-status-cancelled">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- Project Code --}}
                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Project Code
                         </label>
                         <input type="text" name="project_code"
                             value="{{ old('project_code', $project?->project_code ?? '') }}" placeholder="e.g. PRJ-001"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low
                                       text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25
                                       focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     {{-- Alerts Email --}}
                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Alerts Email
                         </label>
                         <input type="email" name="alerts_email"
                             value="{{ old('alerts_email', $project?->alerts_email ?? '') }}"
                             placeholder="alerts@example.com"
                             class="w-full px-4 py-2.5 rounded-xl border @error('alerts_email') border-status-cancelled @else border-secondary-container @enderror
                                       bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none
                                       focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white
                                       transition-all placeholder:text-text-muted" />
                         @error('alerts_email')
                             <p class="mt-1 text-[11px] text-status-cancelled">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- Description --}}
                     <div class="sm:col-span-2">
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Description
                         </label>
                         <textarea name="description" rows="3" placeholder="Describe the project scope, goals, or notes..."
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low
                                       text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25
                                       focus:border-primary focus:bg-surface-white transition-all resize-none
                                       placeholder:text-text-muted">{{ old('description', $project?->description ?? '') }}</textarea>
                     </div>

                 </div>
             </div>

             {{-- Location --}}
             <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
                 <div class="px-5 py-4 border-b border-secondary-container flex items-center gap-2">
                     <span class="material-symbols-outlined text-primary" style="font-size:18px">location_on</span>
                     <h3 class="font-bold text-[14px] text-on-surface">Location</h3>
                 </div>
                 <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                     <div class="sm:col-span-2">
                         <label
                             class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Address
                             Line 1</label>
                         <input type="text" name="address_1"
                             value="{{ old('address_1', $project?->address_1 ?? '') }}" placeholder="Street address"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     <div class="sm:col-span-2">
                         <label
                             class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Address
                             Line 2</label>
                         <input type="text" name="address_2"
                             value="{{ old('address_2', $project?->address_2 ?? '') }}" placeholder="Suite, floor, etc."
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     <div>
                         <label
                             class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Country</label>
                         <input type="text" name="country" value="{{ old('country', $project?->country ?? '') }}"
                             placeholder="e.g. United States"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">State
                             / Province</label>
                         <input type="text" name="state_province"
                             value="{{ old('state_province', $project?->state_province ?? '') }}"
                             placeholder="e.g. California"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     <div>
                         <label
                             class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Postal
                             Code</label>
                         <input type="text" name="postal_code"
                             value="{{ old('postal_code', $project?->postal_code ?? '') }}" placeholder="e.g. 90210"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                     {{-- Coordinates --}}
                     <div class="sm:col-span-2 grid grid-cols-2 gap-4">
                         <div>
                             <label
                                 class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Latitude</label>
                             <input type="text" name="lat" value="{{ old('lat', $project?->lat ?? '') }}"
                                 placeholder="e.g. 34.0522"
                                 class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                         </div>
                         <div>
                             <label
                                 class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Longitude</label>
                             <input type="text" name="lng" value="{{ old('lng', $project?->lng ?? '') }}"
                                 placeholder="e.g. -118.2437"
                                 class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                         </div>
                     </div>

                 </div>
             </div>

         </div>

         {{-- ── RIGHT: Settings sidebar ── --}}
         <div class="space-y-5">

             {{-- Status & Priority --}}
             <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
                 <div class="px-5 py-4 border-b border-secondary-container flex items-center gap-2">
                     <span class="material-symbols-outlined text-primary" style="font-size:18px">tune</span>
                     <h3 class="font-bold text-[14px] text-on-surface">Settings</h3>
                 </div>
                 <div class="p-5 space-y-4">

                     {{-- Status --}}
                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Status <span class="text-status-cancelled">*</span>
                         </label>
                         <select name="status"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low
                                       text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25
                                       focus:border-primary focus:bg-surface-white transition-all appearance-none cursor-pointer">
                             @foreach (['active', 'planning', 'on_hold', 'completed', 'cancelled'] as $s)
                                 <option value="{{ $s }}" @selected(old('status', $project?->status ?? 'active') === $s)>
                                     {{ ucwords(str_replace('_', ' ', $s)) }}
                                 </option>
                             @endforeach
                         </select>
                     </div>



                     {{-- Priority --}}
                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             Priority <span class="text-status-cancelled">*</span>
                         </label>
                         <select name="priority"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low
                                       text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25
                                       focus:border-primary focus:bg-surface-white transition-all appearance-none cursor-pointer">
                             @foreach (['low', 'medium', 'high', 'urgent'] as $p)
                                 <option value="{{ $p }}" @selected(old('priority', $project?->priority ?? 'low') === $p)>
                                     {{ ucfirst($p) }}
                                 </option>
                             @endforeach
                         </select>
                     </div>

                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">
                             FTP Folder<span class="text-status-cancelled">*</span>
                         </label>
                         <input type="text" name="ftp_folder"
                             value="{{ old('ftp_folder', $project?->ftp_folder ?? '') }}"
                             placeholder="e.g. folder name"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all placeholder:text-text-muted" />
                     </div>

                 </div>
             </div>

             {{-- Timeline --}}
             <div class="bg-surface-white rounded-2xl shadow-sm border border-secondary-container/60 overflow-hidden">
                 <div class="px-5 py-4 border-b border-secondary-container flex items-center gap-2">
                     <span class="material-symbols-outlined text-primary" style="font-size:18px">calendar_month</span>
                     <h3 class="font-bold text-[14px] text-on-surface">Timeline</h3>
                 </div>
                 <div class="p-5 space-y-4">

                     <div>
                         <label
                             class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">Start
                             Date</label>
                         <input type="date" name="start_date"
                             value="{{ old('start_date', $project?->start_date?->format('Y-m-d') ?? '') }}"
                             class="w-full px-4 py-2.5 rounded-xl border border-secondary-container bg-surface-container-low
                                       text-[13.5px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/25
                                       focus:border-primary focus:bg-surface-white transition-all" />
                     </div>

                     <div>
                         <label class="block text-[11px] font-bold text-text-muted uppercase tracking-wide mb-1.5">End
                             Date</label>
                         <input type="date" name="end_date"
                             value="{{ old('end_date', $project?->end_date?->format('Y-m-d') ?? '') }}"
                             class="w-full px-4 py-2.5 rounded-xl border @error('end_date') border-status-cancelled @else border-secondary-container @enderror
                                       bg-surface-container-low text-[13.5px] text-on-surface focus:outline-none
                                       focus:ring-2 focus:ring-primary/25 focus:border-primary focus:bg-surface-white transition-all" />
                         @error('end_date')
                             <p class="mt-1 text-[11px] text-status-cancelled">{{ $message }}</p>
                         @enderror
                     </div>

                 </div>
             </div>

             {{-- Submit --}}
             <button type="submit"
                 class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white
                           font-bold text-[13px] px-5 py-3 rounded-xl transition-all active:scale-[0.98] shadow-sm
                           hover:shadow-md">
                 <span class="material-symbols-outlined" style="font-size:17px">{{ $isEdit ? 'save' : 'add' }}</span>
                 {{ $isEdit ? 'Save Changes' : 'Create Project' }}
             </button>

         </div>

     </div>

 </form>

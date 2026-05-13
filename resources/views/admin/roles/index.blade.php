@extends('layouts.app')
@section('title', 'Roles & Permissions')

@section('content')

    <style>
        .role-row.active {
            background: #536c7710;
            border-right: 3px solid #536c77;
        }

        .role-row.active .material-symbols-outlined.text-slate-300 {
            color: #536c77 !important;
        }

        .perm-item:has(.perm-checkbox:checked) {
            background: #536c7708;
            border-color: #536c7740;
        }

        .perm-item:has(.perm-checkbox:checked) p {
            color: #536c77;
        }

        #roles-list {
            max-height: 500px;
        }

        #matrix-content {
            max-height: 500px;
        }

        .modal-enter {
            animation: modalIn 0.2s ease forwards;
        }

        @keyframes modalIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    {{-- ── Page Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-400 mb-1">
                <span>Settings</span>
                <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                <span class="text-slate-600 font-medium">Roles & Permissions</span>
            </div>
            <h2 class="text-xl font-bold text-[#1e2a2e]">Roles & Permissions</h2>
            <p class="text-sm text-slate-400 mt-0.5">Manage what each role can access across the system.</p>
        </div>
        <button onclick="openCreateModal()"
            class="flex items-center gap-2 bg-[#536c77] hover:bg-[#3a4f58] text-white text-[13px] font-bold px-5 py-2.5 rounded-xl transition-all duration-200 active:scale-[0.98] shadow-sm hover:shadow-md w-fit">
            <span class="material-symbols-outlined" style="font-size:17px">add</span>
            New Role
        </button>
    </div>

    {{-- ── Stats Row ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex items-center gap-3">
            <div class="p-2.5 bg-[#536c77]/10 rounded-xl shrink-0">
                <span class="material-symbols-outlined text-[#536c77]" style="font-size:20px">shield_person</span>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wide">Total Roles</p>
                <p class="text-2xl font-bold text-[#1e2a2e]">{{ $roles->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex items-center gap-3">
            <div class="p-2.5 bg-blue-50 rounded-xl shrink-0">
                <span class="material-symbols-outlined text-blue-500" style="font-size:20px">lock_open</span>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wide">Permissions</p>
                <p class="text-2xl font-bold text-[#1e2a2e]">{{ $permissions->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex items-center gap-3">
            <div class="p-2.5 bg-green-50 rounded-xl shrink-0">
                <span class="material-symbols-outlined text-green-600" style="font-size:20px">group</span>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wide">Users Assigned</p>
                <p class="text-2xl font-bold text-[#1e2a2e]">{{ $roles->sum(fn($r) => $r->users->count()) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex items-center gap-3">
            <div class="p-2.5 bg-purple-50 rounded-xl shrink-0">
                <span class="material-symbols-outlined text-purple-500" style="font-size:20px">category</span>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wide">Groups</p>
                <p class="text-2xl font-bold text-[#1e2a2e]">{{ $permissionGroups->count() }}</p>
            </div>
        </div>
    </div>

    {{-- ── Main Grid: Roles list + Permission Matrix ── --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-5">

        {{-- ── ROLES LIST (left) ── --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">

            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="font-bold text-[14px] text-[#1e2a2e]">Roles</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Click a role to edit permissions</p>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                        style="font-size:15px">search</span>
                    <input type="text" id="role-search" placeholder="Search roles..." oninput="filterRoles(this.value)"
                        class="pl-8 pr-3 py-2 text-[12px] bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#536c77]/20 focus:border-[#536c77] w-36 transition-all" />
                </div>
            </div>

            <div class="flex-1 divide-y divide-slate-100 overflow-y-auto" id="roles-list">
                @foreach ($roles as $role)
                    @php
                        $isSystem = in_array($role->name, ['super-admin', 'admin']);
                        $colorMap = [
                            'super-admin' => 'bg-red-50 text-red-700 border-red-200',
                            'admin' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'manager' => 'bg-blue-50 text-blue-700 border-blue-200',
                        ];
                        $badgeClass = $colorMap[$role->name] ?? 'bg-[#536c77]/10 text-[#536c77] border-[#536c77]/20';
                    @endphp
                    <div class="role-row flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 cursor-pointer transition-colors group"
                        data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}"
                        onclick="selectRole({{ $role->id }}, '{{ $role->name }}')">

                        <div
                            class="w-9 h-9 rounded-xl bg-[#536c77]/10 flex items-center justify-center shrink-0 group-hover:bg-[#536c77]/20 transition-colors">
                            <span class="material-symbols-outlined text-[#536c77]" style="font-size:18px">
                                {{ $role->name === 'super-admin' ? 'shield' : ($role->name === 'admin' ? 'admin_panel_settings' : 'manage_accounts') }}
                            </span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-[13px] text-[#1e2a2e] capitalize truncate">
                                    {{ str_replace('-', ' ', $role->name) }}</p>
                                @if ($isSystem)
                                    <span
                                        class="text-[9px] font-bold uppercase tracking-wide px-1.5 py-0.5 rounded-md border {{ $badgeClass }} shrink-0">System</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                {{ $role->permissions->count() }} permissions · {{ $role->users->count() }} users
                            </p>
                        </div>

                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if (!$isSystem)
                                <button
                                    onclick="event.stopPropagation(); openEditModal({{ $role->id }}, '{{ $role->name }}')"
                                    class="p-1.5 rounded-lg hover:bg-[#536c77]/10 text-slate-400 hover:text-[#536c77] transition-colors"
                                    title="Edit role name">
                                    <span class="material-symbols-outlined" style="font-size:15px">edit</span>
                                </button>
                                <button
                                    onclick="event.stopPropagation(); confirmDelete({{ $role->id }}, '{{ $role->name }}')"
                                    class="p-1.5 rounded-lg hover:bg-red-50 text-slate-400 hover:text-red-500 transition-colors"
                                    title="Delete role">
                                    <span class="material-symbols-outlined" style="font-size:15px">delete</span>
                                </button>
                            @else
                                <span class="material-symbols-outlined text-slate-300" style="font-size:15px">lock</span>
                            @endif
                            <span class="material-symbols-outlined text-slate-300 ml-1"
                                style="font-size:16px">chevron_right</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- ── PERMISSION MATRIX (right) ── --}}
        <div class="xl:col-span-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="font-bold text-[14px] text-[#1e2a2e]" id="matrix-title">Select a role</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5" id="matrix-subtitle">Click any role on the left to manage
                        its permissions</p>
                </div>
                <div id="matrix-actions" class="hidden flex items-center gap-2">
                    <button onclick="checkAll()"
                        class="text-[11px] font-semibold text-[#536c77] border border-[#536c77]/30 hover:bg-[#536c77]/5 px-3 py-1.5 rounded-lg transition-all">
                        Check All
                    </button>
                    <button onclick="uncheckAll()"
                        class="text-[11px] font-semibold text-slate-500 border border-slate-200 hover:bg-slate-50 px-3 py-1.5 rounded-lg transition-all">
                        Uncheck All
                    </button>
                    <button onclick="savePermissions()" id="save-btn"
                        class="flex items-center gap-1.5 text-[12px] font-bold bg-[#536c77] hover:bg-[#3a4f58] text-white px-4 py-1.5 rounded-xl transition-all active:scale-[0.97]">
                        <span class="material-symbols-outlined" style="font-size:15px">save</span>
                        Save
                    </button>
                </div>
            </div>

            {{-- Empty state --}}
            <div id="matrix-empty" class="flex-1 flex flex-col items-center justify-center gap-3 py-16 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400" style="font-size:28px">security</span>
                </div>
                <p class="text-[13px] font-semibold text-slate-500">No role selected</p>
                <p class="text-[12px] text-slate-400 max-w-[220px]">Select a role from the left panel to view and edit its
                    permissions.</p>
            </div>

            {{-- Permission groups --}}
            <div id="matrix-content" class="hidden flex-1 overflow-y-auto divide-y divide-slate-100">
                @foreach ($permissionGroups as $group => $perms)
                    <div class="px-5 py-4">

                        {{-- Group header --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#536c77]" style="font-size:16px">
                                    {{ match (true) {
                                        str_contains($group, 'company') => 'business',
                                        str_contains($group, 'user') => 'group',
                                        str_contains($group, 'camera') => 'videocam',
                                        str_contains($group, 'report') => 'assessment',
                                        str_contains($group, 'role') => 'shield_person',
                                        str_contains($group, 'setting') => 'settings',
                                        default => 'category',
                                    } }}
                                </span>
                                <span
                                    class="text-[12px] font-bold text-[#1e2a2e] capitalize">{{ str_replace('-', ' ', $group) }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $perms->count() }}
                                    permissions</span>
                            </div>
                            {{-- Group toggle --}}
                            <button onclick="toggleGroup('{{ $group }}')"
                                class="text-[10px] font-semibold text-[#536c77] hover:underline transition-all"
                                data-group-toggle="{{ $group }}">
                                Select all
                            </button>
                        </div>

                        {{-- Permission pills --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach ($perms as $permission)
                                <label
                                    class="perm-item flex items-center gap-2.5 p-2.5 rounded-xl border border-slate-100 hover:border-[#536c77]/30 hover:bg-[#536c77]/5 cursor-pointer transition-all group/perm"
                                    data-group="{{ $group }}">
                                    <input type="checkbox"
                                        class="perm-checkbox w-4 h-4 rounded accent-[#536c77] cursor-pointer shrink-0"
                                        data-permission-id="{{ $permission->id }}"
                                        data-permission-name="{{ $permission->name }}" onchange="markDirty()" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[12px] font-semibold text-[#1e2a2e] truncate">
                                            {{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-mono truncate">{{ $permission->name }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Unsaved changes bar --}}
            <div id="dirty-bar"
                class="hidden border-t border-amber-200 bg-amber-50 px-5 py-3 flex items-center gap-3 shrink-0">
                <span class="material-symbols-outlined text-amber-500" style="font-size:16px">warning</span>
                <p class="text-[12px] text-amber-700 font-medium flex-1">You have unsaved changes.</p>
                <button onclick="savePermissions()" class="text-[12px] font-bold text-amber-700 underline">Save
                    now</button>
            </div>

        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════
     MODALS
══════════════════════════════════════════════════════════ --}}

    {{-- Backdrop --}}
    <div id="modal-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-200"
        onclick="closeAllModals()"></div>

    {{-- ── Create Role Modal ── --}}
    <div id="modal-create" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md transform transition-all duration-200 scale-95 opacity-0"
            id="modal-create-inner">

            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-[#536c77]/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[#536c77]" style="font-size:20px">shield_person</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-[15px] text-[#1e2a2e]">Create New Role</h4>
                    <p class="text-[11px] text-slate-400">Add a new role to the system</p>
                </div>
                <button onclick="closeAllModals()" class="text-slate-400 hover:text-slate-600 transition-colors p-1">
                    <span class="material-symbols-outlined" style="font-size:20px">close</span>
                </button>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Role Name
                        <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="create-role-name" required
                        placeholder="e.g. camera-operator"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] focus:outline-none focus:ring-2 focus:ring-[#536c77]/25 focus:border-[#536c77] focus:bg-white transition-all" />
                    <p class="text-[11px] text-slate-400 mt-1">Use lowercase with hyphens. e.g. <code
                            class="bg-slate-100 px-1 rounded">camera-operator</code></p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Guard</label>
                    <select name="guard_name"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] focus:outline-none focus:ring-2 focus:ring-[#536c77]/25 focus:border-[#536c77] focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="web">web</option>
                        <option value="api">api</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAllModals()"
                        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-[#536c77] hover:bg-[#3a4f58] text-white text-[13px] font-bold transition-all active:scale-[0.98]">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Edit Role Modal ── --}}
    <div id="modal-edit" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md transform transition-all duration-200 scale-95 opacity-0"
            id="modal-edit-inner">

            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-blue-500" style="font-size:20px">edit</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-[15px] text-[#1e2a2e]">Edit Role</h4>
                    <p class="text-[11px] text-slate-400">Rename this role</p>
                </div>
                <button onclick="closeAllModals()" class="text-slate-400 hover:text-slate-600 transition-colors p-1">
                    <span class="material-symbols-outlined" style="font-size:20px">close</span>
                </button>
            </div>

            <form id="edit-role-form" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wide mb-1.5">Role Name
                        <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="edit-role-name" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13.5px] focus:outline-none focus:ring-2 focus:ring-[#536c77]/25 focus:border-[#536c77] focus:bg-white transition-all" />
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAllModals()"
                        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-[13px] font-bold transition-all active:scale-[0.98]">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Delete Confirm Modal ── --}}
    <div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-sm transform transition-all duration-200 scale-95 opacity-0"
            id="modal-delete-inner">

            <div class="px-6 pt-6 pb-5 text-center">
                <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-500" style="font-size:28px">delete_forever</span>
                </div>
                <h4 class="font-bold text-[15px] text-[#1e2a2e] mb-1">Delete Role?</h4>
                <p class="text-[12px] text-slate-500">
                    You're about to delete <strong id="delete-role-label" class="text-[#1e2a2e]"></strong>.
                    This will revoke this role from all assigned users and cannot be undone.
                </p>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <form id="delete-role-form" method="POST" class="flex gap-3 w-full">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeAllModals()"
                        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-[13px] font-bold transition-all active:scale-[0.98]">
                        Delete Role
                    </button>
                </form>
            </div>
        </div>
    </div>
    @php
        $allUsers = $users->map(function ($u) {
            $parts = explode(' ', trim($u->name));

            $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1));

            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'company' => $u->company_name ?? null,
                'roles' => $u->roles->pluck('name')->values(),
                'initials' => $initials,
            ];
        });
    @endphp
    <script>
        // ── Data from server ────────────────────────────────────────────────────────
        let allRolePerms = @json($rolePermissions ?? []);
        const allUsers = @json($allUsers);

        // ── State ───────────────────────────────────────────────────────────────────
        let activeRoleId = null;
        let activeRoleName = null;
        let isDirty = false;
        let isUsersDirty = false;
        let pendingUserIds = new Set(); // user ids currently toggled ON for this role

        // ── Drawer open / close ─────────────────────────────────────────────────────
        function openDrawer(roleId, roleName) {
            activeRoleId = roleId;
            activeRoleName = roleName;
            isDirty = false;
            isUsersDirty = false;

            const label = roleName.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            document.getElementById('drawer-title').textContent = label;
            document.getElementById('drawer-subtitle').textContent = 'Manage permissions and assigned users';

            // Load permissions tab
            const rolePerms = allRolePerms[roleId] ?? [];
            document.querySelectorAll('.perm-checkbox').forEach(cb => {
                cb.checked = rolePerms.includes(parseInt(cb.dataset.permissionId));
            });
            updateGroupToggles();
            document.getElementById('dirty-bar').classList.add('hidden');

            // Load users tab
            const assignedIds = allUsers
                .filter(u => u.roles.includes(roleName))
                .map(u => u.id);
            pendingUserIds = new Set(assignedIds);
            renderUsers('');
            document.getElementById('users-dirty-bar').classList.add('hidden');

            // Update user count badge
            document.getElementById('drawer-user-count').textContent = assignedIds.length;

            // Switch to permissions tab by default
            switchDrawerTab('permissions');

            // Animate in
            document.getElementById('drawer-backdrop').classList.remove('hidden');
            requestAnimationFrame(() => {
                document.getElementById('drawer-backdrop').classList.add('opacity-100');
                document.getElementById('role-drawer').classList.remove('translate-x-full');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            if ((isDirty || isUsersDirty) && !confirm('You have unsaved changes. Discard them?')) return;

            document.getElementById('role-drawer').classList.add('translate-x-full');
            document.getElementById('drawer-backdrop').classList.remove('opacity-100');
            setTimeout(() => {
                document.getElementById('drawer-backdrop').classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
            activeRoleId = null;
        }

        // Keep existing role-row click handler pointing to openDrawer
        function selectRole(roleId, roleName) {
            // Highlight sidebar
            document.querySelectorAll('.role-row').forEach(r => r.classList.remove('active'));
            document.querySelector(`[data-role-id="${roleId}"]`)?.classList.add('active');
            openDrawer(roleId, roleName);
        }

        // ── Tab switching ────────────────────────────────────────────────────────────
        function switchDrawerTab(tab) {
            const isPerms = tab === 'permissions';

            document.getElementById('drawer-tab-permissions').classList.toggle('hidden', !isPerms);
            document.getElementById('drawer-tab-users').classList.toggle('hidden', isPerms);

            document.getElementById('tab-permissions').className = `drawer-tab px-4 py-3 text-[13px] font-semibold
        border-b-2 transition-colors -mb-px ${isPerms
            ? 'border-[#536c77] text-[#536c77]'
            : 'border-transparent text-slate-400 hover:text-slate-600'}`;
            document.getElementById('tab-users').className = `drawer-tab px-4 py-3 text-[13px] font-semibold
        border-b-2 transition-colors -mb-px ${!isPerms
            ? 'border-[#536c77] text-[#536c77]'
            : 'border-transparent text-slate-400 hover:text-slate-600'}`;
        }

        // ── User rendering ───────────────────────────────────────────────────────────
        function renderUsers(query) {
            const q = query.toLowerCase();
            const filtered = allUsers.filter(u =>
                u.name.toLowerCase().includes(q) ||
                u.email.toLowerCase().includes(q) ||
                (u.company ?? '').toLowerCase().includes(q)
            );

            const assigned = filtered.filter(u => pendingUserIds.has(u.id));
            const unassigned = filtered.filter(u => !pendingUserIds.has(u.id));

            document.getElementById('assigned-count').textContent = pendingUserIds.size;
            document.getElementById('drawer-user-count').textContent = pendingUserIds.size;

            document.getElementById('assigned-users-list').innerHTML =
                assigned.length ? assigned.map(userRow).join('') : emptyUsersMsg('No users assigned to this role yet.');

            document.getElementById('all-users-list').innerHTML =
                unassigned.length ? unassigned.map(userRow).join('') : emptyUsersMsg('All users are already assigned.');
        }

        function userRow(u) {
            const checked = pendingUserIds.has(u.id);
            const rolesBadges = u.roles.length ?
                u.roles.map(r =>
                    `<span class="bg-slate-100 text-slate-500 text-[9px] font-bold px-1.5 py-0.5 rounded-md uppercase tracking-wide">${r.replace(/-/g,' ')}</span>`
                ).join(' ') :
                '';

            const avatarColors = ['bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600',
                'bg-green-100 text-green-600', 'bg-amber-100 text-amber-600', 'bg-rose-100 text-rose-600'
            ];
            const color = avatarColors[u.id % avatarColors.length];

            return `
    <div class="user-row flex items-center gap-3 py-3 cursor-pointer hover:bg-slate-50 rounded-xl px-2 -mx-2 transition-colors"
         data-user-id="${u.id}"
         data-name="${u.name.toLowerCase()}"
         data-email="${u.email.toLowerCase()}"
         data-company="${(u.company ?? '').toLowerCase()}"
         onclick="toggleUser(${u.id})">

        {{-- Avatar --}}
        <div class="w-9 h-9 rounded-xl ${color} flex items-center justify-center shrink-0 font-bold text-[13px]">
            ${u.initials}
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
                <p class="text-[13px] font-semibold text-[#1e2a2e] truncate">${u.name}</p>
                ${rolesBadges}
            </div>
            <p class="text-[11px] text-slate-400 truncate">${u.email}${u.company ? ' · ' + u.company : ''}</p>
        </div>

        {{-- Toggle --}}
        <div class="shrink-0">
            <div class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all
                        ${checked ? 'bg-[#536c77] border-[#536c77]' : 'border-slate-300'}">
                ${checked ? '<span class="material-symbols-outlined text-white" style="font-size:13px">check</span>' : ''}
            </div>
        </div>
    </div>`;
        }

        function emptyUsersMsg(msg) {
            return `<p class="text-[12px] text-slate-400 py-4 text-center">${msg}</p>`;
        }

        function toggleUser(userId) {
            if (pendingUserIds.has(userId)) {
                pendingUserIds.delete(userId);
            } else {
                pendingUserIds.add(userId);
            }
            isUsersDirty = true;
            document.getElementById('users-dirty-bar').classList.remove('hidden');
            renderUsers(document.getElementById('user-search').value);
        }

        function filterUsers(q) {
            renderUsers(q);
        }

        // ── Save users ───────────────────────────────────────────────────────────────
        async function saveUsers() {
            if (!activeRoleId) return;

            const btn = document.getElementById('save-users-btn');
            btn.disabled = true;
            btn.innerHTML =
                '<span class="material-symbols-outlined animate-spin" style="font-size:15px">refresh</span> Saving...';

            try {
                const res = await fetch(`/admin/roles/${activeRoleId}/users`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        users: [...pendingUserIds]
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    isUsersDirty = false;
                    document.getElementById('users-dirty-bar').classList.add('hidden');

                    // Update the in-memory user roles so re-opening is accurate
                    allUsers.forEach(u => {
                        if (pendingUserIds.has(u.id)) {
                            if (!u.roles.includes(activeRoleName)) u.roles.push(activeRoleName);
                        } else {
                            u.roles = u.roles.filter(r => r !== activeRoleName);
                        }
                    });

                    // Update sidebar count
                    const row = document.querySelector(`[data-role-id="${activeRoleId}"]`);
                    if (row) {
                        const meta = row.querySelector('p.text-\\[11px\\]');
                        if (meta) {
                            const permCount = meta.textContent.match(/(\d+) permissions/)?.[1] ?? 0;
                            meta.textContent = `${permCount} permissions · ${pendingUserIds.size} users`;
                        }
                    }

                    window.dispatchEvent(new CustomEvent('flash', {
                        detail: {
                            type: 'success',
                            title: 'Users updated',
                            message: data.message ?? 'Role users saved.'
                        }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('flash', {
                        detail: {
                            type: 'error',
                            title: `Save failed (${res.status})`,
                            message: data.message ?? 'Could not update users.'
                        }
                    }));
                }
            } catch (err) {
                console.error('saveUsers error:', err);
                window.dispatchEvent(new CustomEvent('flash', {
                    detail: {
                        type: 'error',
                        title: 'Network error',
                        message: 'Could not reach the server.'
                    }
                }));
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:15px">save</span> Save';
            }
        }

        // ── Save permissions ─────────────────────────────────────────────────────────
        async function savePermissions() {
            if (!activeRoleId) return;

            const btn = document.getElementById('save-btn');
            const permIds = [...document.querySelectorAll('.perm-checkbox:checked')]
                .map(b => parseInt(b.dataset.permissionId));

            btn.disabled = true;
            btn.innerHTML =
                '<span class="material-symbols-outlined animate-spin" style="font-size:15px">refresh</span> Saving...';

            try {
                const res = await fetch(`/admin/roles/${activeRoleId}/permissions`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        permissions: permIds
                    }),
                });

                const raw = await res.text();
                let data = {};
                try {
                    data = JSON.parse(raw);
                } catch {
                    console.error('Non-JSON response:', raw);
                }

                if (res.ok) {
                    allRolePerms[activeRoleId] = permIds;
                    isDirty = false;
                    document.getElementById('dirty-bar').classList.add('hidden');

                    const row = document.querySelector(`[data-role-id="${activeRoleId}"]`);
                    if (row) {
                        const meta = row.querySelector('p.text-\\[11px\\]');
                        if (meta) {
                            const userCount = meta.textContent.match(/(\d+) users/)?.[1] ?? 0;
                            meta.textContent = `${permIds.length} permissions · ${userCount} users`;
                        }
                    }
                    window.dispatchEvent(new CustomEvent('flash', {
                        detail: {
                            type: 'success',
                            title: 'Permissions saved',
                            message: data.message ?? 'Role permissions updated.'
                        }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('flash', {
                        detail: {
                            type: 'error',
                            title: `Save failed (${res.status})`,
                            message: data.message ?? 'Could not update permissions.'
                        }
                    }));
                }
            } catch (err) {
                console.error('savePermissions error:', err);
                window.dispatchEvent(new CustomEvent('flash', {
                    detail: {
                        type: 'error',
                        title: 'Network error',
                        message: 'Could not reach the server.'
                    }
                }));
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:15px">save</span> Save';
            }
        }

        // ── Permissions helpers ──────────────────────────────────────────────────────
        function markDirty() {
            if (!isDirty) {
                isDirty = true;
                document.getElementById('dirty-bar').classList.remove('hidden');
            }
            updateGroupToggles();
        }

        function toggleGroup(group) {
            const boxes = document.querySelectorAll(`[data-group="${group}"] .perm-checkbox`);
            const allChecked = [...boxes].every(b => b.checked);
            boxes.forEach(b => b.checked = !allChecked);
            document.querySelector(`[data-group-toggle="${group}"]`).textContent =
                allChecked ? 'Select all' : 'Deselect all';
            markDirty();
        }

        function updateGroupToggles() {
            document.querySelectorAll('[data-group-toggle]').forEach(btn => {
                const group = btn.dataset.groupToggle;
                const boxes = [...document.querySelectorAll(`[data-group="${group}"] .perm-checkbox`)];
                btn.textContent = boxes.every(b => b.checked) ? 'Deselect all' : 'Select all';
            });
        }

        function checkAll() {
            document.querySelectorAll('.perm-checkbox').forEach(b => b.checked = true);
            markDirty();
        }

        function uncheckAll() {
            document.querySelectorAll('.perm-checkbox').forEach(b => b.checked = false);
            markDirty();
        }

        // ── Role search ──────────────────────────────────────────────────────────────
        function filterRoles(query) {
            const q = query.toLowerCase();
            document.querySelectorAll('.role-row').forEach(row => {
                row.style.display = row.dataset.roleName.includes(q) ? '' : 'none';
            });
        }

        // ── Role CRUD modals ─────────────────────────────────────────────────────────
        function openModal(id) {
            const backdrop = document.getElementById('modal-backdrop');
            const modal = document.getElementById(id);
            const inner = document.getElementById(id + '-inner');
            backdrop.classList.remove('hidden');
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.add('opacity-100');
                inner.classList.remove('scale-95', 'opacity-0');
                inner.classList.add('scale-100', 'opacity-100', 'modal-enter');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeAllModals() {
            ['modal-create', 'modal-edit', 'modal-delete'].forEach(id => {
                const modal = document.getElementById(id);
                const inner = document.getElementById(id + '-inner');
                if (!modal) return;
                inner?.classList.add('scale-95', 'opacity-0');
                inner?.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            });
            const backdrop = document.getElementById('modal-backdrop');
            backdrop.classList.remove('opacity-100');
            setTimeout(() => backdrop.classList.add('hidden'), 200);
            document.body.style.overflow = '';
        }

        function openCreateModal() {
            document.getElementById('create-role-name').value = '';
            openModal('modal-create');
            setTimeout(() => document.getElementById('create-role-name').focus(), 150);
        }

        function openEditModal(roleId, roleName) {
            document.getElementById('edit-role-form').action = `/admin/roles/${roleId}`;
            document.getElementById('edit-role-name').value = roleName;
            openModal('modal-edit');
            setTimeout(() => document.getElementById('edit-role-name').focus(), 150);
        }

        function confirmDelete(roleId, roleName) {
            document.getElementById('delete-role-form').action = `/admin/roles/${roleId}`;
            document.getElementById('delete-role-label').textContent = roleName.replace(/-/g, ' ');
            openModal('modal-delete');
        }

        // Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeDrawer();
                closeAllModals();
            }
        });

        // Auto-select first role
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.role-row')?.click();
        });
    </script>


    {{-- Drawer backdrop --}}
    <div id="drawer-backdrop" class="fixed inset-0 bg-black/40 z-50 hidden opacity-0 transition-opacity duration-300"
        onclick="closeDrawer()"></div>

    {{-- Drawer panel --}}
    <div id="role-drawer"
        class="fixed top-0 right-0 h-full w-full max-w-2xl bg-white z-50 shadow-2xl
           translate-x-full transition-transform duration-300 ease-out
           flex flex-col overflow-hidden">

        {{-- Drawer header --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 shrink-0">
            <div id="drawer-icon" class="w-10 h-10 rounded-xl bg-[#536c77]/10 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#536c77]" style="font-size:20px">manage_accounts</span>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="font-bold text-[15px] text-[#1e2a2e]" id="drawer-title">Role</h4>
                <p class="text-[11px] text-slate-400" id="drawer-subtitle">Manage permissions and users</p>
            </div>
            <button onclick="closeDrawer()"
                class="p-2 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined" style="font-size:20px">close</span>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="flex border-b border-slate-100 shrink-0 px-6">
            <button id="tab-permissions" onclick="switchDrawerTab('permissions')"
                class="drawer-tab px-4 py-3 text-[13px] font-semibold border-b-2 transition-colors -mb-px
                   border-[#536c77] text-[#536c77]">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined" style="font-size:15px">lock_open</span>
                    Permissions
                </span>
            </button>
            <button id="tab-users" onclick="switchDrawerTab('users')"
                class="drawer-tab px-4 py-3 text-[13px] font-semibold border-b-2 transition-colors -mb-px
                   border-transparent text-slate-400 hover:text-slate-600">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined" style="font-size:15px">group</span>
                    Users
                    <span id="drawer-user-count"
                        class="bg-slate-100 text-slate-500 text-[10px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                </span>
            </button>
        </div>

        {{-- ── TAB: Permissions ── --}}
        <div id="drawer-tab-permissions" class="flex-1 flex flex-col overflow-hidden">

            {{-- Permissions toolbar --}}
            <div class="flex items-center gap-2 px-6 py-3 border-b border-slate-100 shrink-0">
                <button onclick="checkAll()"
                    class="text-[11px] font-semibold text-[#536c77] border border-[#536c77]/30
                       hover:bg-[#536c77]/5 px-3 py-1.5 rounded-lg transition-all">
                    Check All
                </button>
                <button onclick="uncheckAll()"
                    class="text-[11px] font-semibold text-slate-500 border border-slate-200
                       hover:bg-slate-50 px-3 py-1.5 rounded-lg transition-all">
                    Uncheck All
                </button>
                <div class="flex-1"></div>
                <button onclick="savePermissions()" id="save-btn"
                    class="flex items-center gap-1.5 text-[12px] font-bold bg-[#536c77]
                       hover:bg-[#3a4f58] text-white px-4 py-1.5 rounded-xl transition-all
                       active:scale-[0.97]">
                    <span class="material-symbols-outlined" style="font-size:15px">save</span>
                    Save
                </button>
            </div>

            {{-- Permission groups (scrollable) --}}
            <div id="drawer-permissions-body" class="flex-1 overflow-y-auto divide-y divide-slate-100">
                @foreach ($permissionGroups as $group => $perms)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#536c77]" style="font-size:15px">
                                    {{ match (true) {
                                        str_contains($group, 'company') => 'business',
                                        str_contains($group, 'user') => 'group',
                                        str_contains($group, 'camera') => 'videocam',
                                        str_contains($group, 'report') => 'assessment',
                                        str_contains($group, 'role') => 'shield_person',
                                        str_contains($group, 'setting') => 'settings',
                                        default => 'category',
                                    } }}
                                </span>
                                <span class="text-[12px] font-bold text-[#1e2a2e] capitalize">
                                    {{ str_replace('-', ' ', $group) }}
                                </span>
                                <span class="text-[10px] text-slate-400">{{ $perms->count() }} permissions</span>
                            </div>
                            <button onclick="toggleGroup('{{ $group }}')"
                                class="text-[10px] font-semibold text-[#536c77] hover:underline"
                                data-group-toggle="{{ $group }}">Select all</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach ($perms as $perm)
                                <label
                                    class="perm-item flex items-center gap-2.5 p-2.5 rounded-xl border
                                          border-slate-100 hover:border-[#536c77]/30 hover:bg-[#536c77]/5
                                          cursor-pointer transition-all"
                                    data-group="{{ $group }}">
                                    <input type="checkbox"
                                        class="perm-checkbox w-4 h-4 rounded accent-[#536c77] cursor-pointer shrink-0"
                                        data-permission-id="{{ $perm->id }}"
                                        data-permission-name="{{ $perm->name }}" onchange="markDirty()" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[12px] font-semibold text-[#1e2a2e] truncate">
                                            {{ ucwords(str_replace(['-', '_'], ' ', $perm->name)) }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-mono truncate">{{ $perm->name }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Unsaved bar --}}
            <div id="dirty-bar"
                class="hidden border-t border-amber-200 bg-amber-50 px-6 py-3 flex items-center gap-3 shrink-0">
                <span class="material-symbols-outlined text-amber-500" style="font-size:16px">warning</span>
                <p class="text-[12px] text-amber-700 font-medium flex-1">You have unsaved changes.</p>
                <button onclick="savePermissions()" class="text-[12px] font-bold text-amber-700 underline">Save
                    now</button>
            </div>
        </div>

        {{-- ── TAB: Users ── --}}
        <div id="drawer-tab-users" class="hidden flex-1 flex flex-col overflow-hidden">

            {{-- Search --}}
            <div class="px-6 py-3 border-b border-slate-100 shrink-0 flex items-center gap-3">
                <div class="relative flex-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                        style="font-size:15px">search</span>
                    <input type="text" id="user-search" placeholder="Search users..."
                        oninput="filterUsers(this.value)"
                        class="w-full pl-8 pr-3 py-2 text-[12px] bg-slate-50 border border-slate-200
                           rounded-xl focus:outline-none focus:ring-2 focus:ring-[#536c77]/20
                           focus:border-[#536c77] transition-all" />
                </div>
                <button onclick="saveUsers()" id="save-users-btn"
                    class="flex items-center gap-1.5 text-[12px] font-bold bg-[#536c77]
                       hover:bg-[#3a4f58] text-white px-4 py-2 rounded-xl transition-all
                       active:scale-[0.97] shrink-0">
                    <span class="material-symbols-outlined" style="font-size:15px">save</span>
                    Save
                </button>
            </div>

            {{-- Assigned / All sections --}}
            <div class="flex-1 overflow-y-auto" id="users-body">

                {{-- Assigned users group --}}
                <div class="px-6 pt-4 pb-2 sticky top-0 bg-white z-10 border-b border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">
                        Assigned to this role
                        <span id="assigned-count"
                            class="ml-1 bg-[#536c77]/10 text-[#536c77] px-1.5 py-0.5 rounded-full">0</span>
                    </p>
                </div>
                <div id="assigned-users-list" class="divide-y divide-slate-50 px-6"></div>

                {{-- All users group --}}
                <div class="px-6 pt-4 pb-2 sticky top-0 bg-white z-10 border-b border-slate-100 mt-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">All users</p>
                </div>
                <div id="all-users-list" class="divide-y divide-slate-50 px-6 pb-6"></div>
            </div>

            {{-- Users dirty bar --}}
            <div id="users-dirty-bar"
                class="hidden border-t border-amber-200 bg-amber-50 px-6 py-3 flex items-center gap-3 shrink-0">
                <span class="material-symbols-outlined text-amber-500" style="font-size:16px">warning</span>
                <p class="text-[12px] text-amber-700 font-medium flex-1">You have unsaved user changes.</p>
                <button onclick="saveUsers()" class="text-[12px] font-bold text-amber-700 underline">Save now</button>
            </div>
        </div>

    </div>
@endsection

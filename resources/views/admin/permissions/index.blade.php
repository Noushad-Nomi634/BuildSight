@extends('layouts.app')

@section('title', 'Permissions')

@section('content')

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-[#1e2a2e]">Permissions</h2>
            <p class="text-sm text-slate-400 mt-0.5">
                Manage system permissions and access rules.
            </p>
        </div>

        <button onclick="openCreateModal()"
            class="flex items-center gap-2 bg-[#536c77] hover:bg-[#3a4f58] text-white text-[13px] font-bold px-5 py-2.5 rounded-xl">
            <span class="material-symbols-outlined" style="font-size:17px">add</span>
            New Permission
        </button>
    </div>

    {{-- TABLE --}}
    <div class="bg-white mt-5 rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-4 border-b flex justify-between items-center">
            <input type="text" id="search" oninput="filterPermissions(this.value)" placeholder="Search permissions..."
                class="px-3 py-2 text-sm border rounded-xl w-64 bg-slate-50 focus:ring-2 focus:ring-[#536c77]/20" />
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left p-3">Name</th>
                    <th class="text-left p-3">Group</th>
                    <th class="text-left p-3">Guard</th>
                    <th class="text-right p-3">Actions</th>
                </tr>
            </thead>

            <tbody id="perm-table">
                @foreach ($permissions as $perm)
                    <tr class="border-t hover:bg-slate-50" data-name="{{ strtolower($perm->name) }}">

                        <td class="p-3 font-medium text-[#1e2a2e]">
                            {{ $perm->name }}
                        </td>

                        <td class="p-3 text-slate-500">
                            {{ $perm->group ?? 'general' }}
                        </td>

                        <td class="p-3 text-slate-500">
                            {{ $perm->guard_name }}
                        </td>

                        <td class="p-3 text-right space-x-2">
                            <button onclick="editPermission({{ $perm->id }}, '{{ $perm->name }}')"
                                class="text-blue-500 hover:underline text-sm">
                                Edit
                            </button>

                            <button onclick="deletePermission({{ $perm->id }}, '{{ $perm->name }}')"
                                class="text-red-500 hover:underline text-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- CREATE / EDIT MODAL --}}
    <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/40 p-4">
        <div class="bg-white w-full max-w-md rounded-2xl p-5">

            <h3 class="text-lg font-bold text-[#1e2a2e]" id="modal-title">Create Permission</h3>

            <form id="perm-form" method="POST" class="mt-4 space-y-3">
                @csrf

                <input type="text" name="name" id="perm-name" placeholder="permission name"
                    class="w-full border rounded-xl px-3 py-2" />

                <input type="text" name="group" id="perm-group" placeholder="group (e.g. user, project)"
                    class="w-full border rounded-xl px-3 py-2" />

                <select name="guard_name" id="perm-guard" class="w-full border rounded-xl px-3 py-2">
                    <option value="web">web</option>
                    <option value="api">api</option>
                </select>

                <div class="flex justify-end gap-2 pt-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm border rounded-xl">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 text-sm bg-[#536c77] text-white rounded-xl">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        let editMode = false;
        let editId = null;

        function openCreateModal() {
            editMode = false;
            document.getElementById('modal-title').innerText = "Create Permission";
            document.getElementById('perm-form').action = "{{ route('admin.permissions.store') }}";
            document.getElementById('perm-form').method = "POST";
            removeSpoofField(); // ← clear any leftover _method
            document.getElementById('perm-name').value = '';
            document.getElementById('perm-group').value = '';
            openModal();
        }

        function editPermission(id, name) {
            editMode = true;
            editId = id;

            document.getElementById('modal-title').innerText = "Edit Permission";
            document.getElementById('perm-form').action = `/admin/permissions/${id}`;
            setSpoofField('PUT'); // ← inject _method=PUT
            document.getElementById('perm-name').value = name;
            openModal();
        }

        function setSpoofField(method) {
            removeSpoofField();
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_method';
            input.id = 'spoof-method';
            input.value = method;
            document.getElementById('perm-form').appendChild(input);
        }

        function removeSpoofField() {
            document.getElementById('spoof-method')?.remove();
        }

        function deletePermission(id, name) {
            if (!confirm(`Delete permission "${name}"?`)) return;

            fetch(`admin/permissions/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => location.reload());
        }

        function filterPermissions(q) {
            q = q.toLowerCase();
            document.querySelectorAll('#perm-table tr').forEach(row => {
                row.style.display = row.dataset.name.includes(q) ? '' : 'none';
            });
        }

        /* modal helpers */
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }
    </script>

@endsection

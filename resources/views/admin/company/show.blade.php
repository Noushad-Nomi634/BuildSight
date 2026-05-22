@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-6 px-4">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-1">Record</p>
                <h2 class="text-xl font-medium text-gray-900">Company details</h2>
            </div>
            @if ($company->status == 'active')
                <span class="text-xs font-medium px-3 py-1 rounded-md bg-green-100 text-green-700">Active</span>
            @else
                <span class="text-xs font-medium px-3 py-1 rounded-md bg-red-100 text-red-700">Inactive</span>
            @endif
        </div>

        {{-- CARD --}}
        <div class="bg-white border border-gray-200/70 rounded-xl overflow-hidden">

            {{-- AVATAR + NAME --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                <div
                    class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-medium text-sm flex-shrink-0">
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}"
                        class="w-full h-full object-cover rounded-full">
                </div>
                <div>
                    <p class="text-base font-medium text-gray-900">{{ $company->name }}</p>
                    <p class="text-sm text-gray-400 mt-0.5">ID #{{ $company->id }}</p>
                </div>
            </div>

            {{-- FIELDS GRID --}}
            <div class="px-6 grid grid-cols-1 sm:grid-cols-2">

                @php
                    $fields = [
                        ['icon' => 'ti-id', 'label' => 'ID', 'value' => $company->id],
                        ['icon' => 'ti-building', 'label' => 'Name', 'value' => $company->name],
                        ['icon' => 'ti-file-text', 'label' => 'Description', 'value' => $company->description],
                        ['icon' => 'ti-mail', 'label' => 'Email', 'value' => $company->email],
                        ['icon' => 'ti-phone', 'label' => 'Phone', 'value' => $company->phone],
                        ['icon' => 'ti-device-mobile', 'label' => 'Mobile', 'value' => $company->mobile],
                        ['icon' => 'ti-world', 'label' => 'Website', 'value' => $company->website],
                        ['icon' => 'ti-map-pin', 'label' => 'Address 1', 'value' => $company->address_1],
                        ['icon' => 'ti-map-pin-2', 'label' => 'Address 2', 'value' => $company->address_2],
                        ['icon' => 'ti-flag', 'label' => 'Country ID', 'value' => $company->country_id],
                        ['icon' => 'ti-map', 'label' => 'State/Province', 'value' => $company->state_province],
                        ['icon' => 'ti-mailbox', 'label' => 'Postal Code', 'value' => $company->postal_code],
                        ['icon' => 'ti-toggle-left', 'label' => 'Status', 'value' => $company->status],
                        ['icon' => 'ti-user', 'label' => 'Created By', 'value' => $company->created_by],
                        [
                            'icon' => 'ti-calendar-plus',
                            'label' => 'Created at',
                            'value' => $company->created_at?->format('d M Y, H:i'),
                        ],
                        [
                            'icon' => 'ti-calendar-event',
                            'label' => 'Updated at',
                            'value' => $company->updated_at?->format('d M Y, H:i'),
                        ],
                    ];
                @endphp

                @foreach ($fields as $field)
                    <div class="flex items-center gap-3 py-3 border-b border-gray-100">
                        <i class="ti {{ $field['icon'] }} text-gray-400 text-base w-5 flex-shrink-0"></i>
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-gray-400">{{ $field['label'] }}</p>
                            <p class="text-[13px] font-medium text-gray-800 mt-0.5">{{ $field['value'] ?? '—' }}</p>
                        </div>
                    </div>
                @endforeach

                {{-- WEBSITE (special — link) --}}
                <div class="flex items-center gap-3 py-3 border-b border-gray-100">
                    <i class="ti ti-world text-gray-400 text-base w-5 flex-shrink-0"></i>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-gray-400">Website</p>
                        @if ($company->website)
                            <a href="{{ $company->website }}" target="_blank"
                                class="text-[13px] font-medium text-blue-600 hover:underline mt-0.5 inline-flex items-center gap-1">
                                {{ $company->website }}
                                <i class="ti ti-external-link text-xs"></i>
                            </a>
                        @else
                            <p class="text-[13px] font-medium text-gray-800 mt-0.5">—</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex gap-2 mt-5">
            <a href="{{ route('admin.company.index') }}"
                class="inline-flex items-center gap-1.5 text-[13px] px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all active:scale-[0.98]">
                <i class="ti ti-arrow-left text-sm"></i> Back to list
            </a>
            {{-- <a href="{{ route('admin.company.edit', $company->id) }}"
           class="inline-flex items-center gap-1.5 text-[13px] px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all active:scale-[0.98]">
            <i class="ti ti-edit text-sm"></i> Edit
        </a> --}}
        </div>

    </div>
@endsection

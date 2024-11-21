<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Rents') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('My Rents') }}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <h1 class="mb-0">{{ __('Units Rented List') }}</h1>
                    </div>

                    <div class="d-flex flex-wrap justify-content-center">
                        @php
                        $hasUnits = false;
                        @endphp

                        @foreach ($tenants as $tenant)
                        @php
                        $units = $tenant->units;
                        @endphp

                        @if (!$units->isEmpty())
                        @php $hasUnits = true; @endphp
                        @foreach ($units as $unit)
                        <div class="card m-3" style="width: 300px;">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    {{ $unit->unit_number }} - {{ $unit->block->block }} - {{ $unit->block->condominium->name }}
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ __('Start Date') }}: {{ $unit->tenant->lease_start_date }}
                                </h6>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ __('End Date') }}: {{ $unit->tenant->lease_end_date ?? __('Not Defined') }}
                                </h6>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ __('Base Rent') }}: {{ $unit->base_rent }}€
                                </h6>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <a href="{{ route('rents.show', $unit->tenant_id) }}" class="btn btn-primary w-100">
                                    {{ __('View Rent') }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @endforeach

                        @if (!$hasUnits)
                        <h4 class="text-center text-muted w-100">{{ __('No units rented') }}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .card-footer a {
        text-align: center;
        padding: 10px 0;
    }
</style>
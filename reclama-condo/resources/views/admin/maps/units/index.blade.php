@extends('layouts.admin')

@section('title', __('Unit Map'))

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Unit Map') }}</h1>
                    <hr class="mb-4" />

                    <!-- Formulário de Filtros -->
                    <form id="filter-form" action="#" method="GET">
                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>{{ __('Occupied') }}</option>
                                    <option value="vacant" {{ request('status') == 'vacant' ? 'selected' : '' }}>{{ __('Vacant') }}</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                                    <option value="in repair" {{ request('status') == 'in repair' ? 'selected' : '' }}>{{ __('In Repair') }}</option>
                                </select>
                            </div>

                            <!-- Base Rent Range -->
                            <div class="col-md-3 mb-3">
                                <label for="rent_range" class="form-label">{{ __('Base Rent Range') }}</label>
                                <div class="d-flex">
                                    <input type="number" name="rent_min" class="form-control me-2" placeholder="Min (€)" 
                                           value="{{ request('rent_min') }}" step="0.01">
                                    <input type="number" name="rent_max" class="form-control" placeholder="Max (€)" 
                                           value="{{ request('rent_max') }}" step="0.01">
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- Botões de Exportação -->
                    <div class="text-end">
                        <button id="export-pdf" class="btn btn-danger me-2"><i class="mr-2 fa-regular fa-file-pdf"></i>{{ __('Export to PDF') }}</button>
                        <button id="export-excel" class="btn btn-success"><i class="mr-2 fa-regular fa-file-excel"></i>{{ __('Export to Excel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JavaScript -->
<script>
    // Configura o botão para exportar PDF
    document.getElementById('export-pdf').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.action = "{{ route('admin.maps.units.export.pdf') }}";
        form.submit();
    });

    // Configura o botão para exportar Excel
    document.getElementById('export-excel').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.action = "{{ route('admin.maps.units.export.excel') }}";
        form.submit();
    });
</script>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@endsection

@extends('layouts.admin')

@section('title', __('Condominium Map'))

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Condominium Map') }}</h1>
                    <hr class="mb-4" />

                    <!-- Formulário de Filtros -->
                    <form id="filter-form" action="#" method="GET">
                        <div class="row">

                            <!-- City -->
                            <div class="col-md-3 mb-3">
                                <label for="city" class="form-label">{{ __('City') }}</label>
                                <select name="city" id="city" class="form-select">
                                    <option value="">{{ __('All Cities') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State -->
                            <div class="col-md-3 mb-3">
                                <label for="state" class="form-label">{{ __('State') }}</label>
                                <select name="state" id="state" class="form-select">
                                    <option value="">{{ __('All States') }}</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Postal Code -->
                            <div class="col-md-3 mb-3">
                                <label for="postal_code" class="form-label">{{ __('Postal Code') }}</label>
                                <select name="postal_code" id="postal_code" class="form-select">
                                    <option value="">{{ __('All Postal Codes') }}</option>
                                    @foreach($postal_codes as $postal_code)
                                        <option value="{{ $postal_code }}" {{ request('postal_code') == $postal_code ? 'selected' : '' }}>{{ $postal_code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Number of Blocks -->
                            <div class="col-md-3 mb-3">
                                <label for="number_of_blocks" class="form-label">{{ __('Number of Blocks') }}</label>
                                <select name="number_of_blocks" id="number_of_blocks" class="form-select">
                                    <option value="">{{ __('All Block Counts') }}</option>
                                    @foreach($blocks as $block_count)
                                        <option value="{{ $block_count }}" {{ request('number_of_blocks') == $block_count ? 'selected' : '' }}>{{ $block_count }}</option>
                                    @endforeach
                                </select>
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
        form.action = "{{ route('admin.maps.condominiums.export.pdf') }}";
        form.target = "_blank";
        form.submit();
    });

    // Configura o botão para exportar Excel
    document.getElementById('export-excel').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.action = "{{ route('admin.maps.condominiums.export.excel') }}";
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

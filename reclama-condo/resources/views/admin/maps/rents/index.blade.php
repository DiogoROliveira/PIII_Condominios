@extends('layouts.admin')

@section('title', __('Rents Map'))

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Rents Map') }}</h1>
                    <hr class="mb-4" />

                    <!-- Formulário de Filtros -->
                    <form id="filter-form" action="#" method="GET">
                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>{{ __('Overdue') }}</option>
                                </select>
                            </div>                            

                            <!-- Rent Range -->
                            <div class="col-md-3 mb-3">
                                <label for="rent_range" class="form-label">{{ __('Rent Range') }}</label>
                                <div class="d-flex">
                                    <input type="number" name="amount_min" class="form-control me-2" placeholder="Min (€)" 
                                           value="{{ request('amount_min') }}" step="0.01">
                                    <input type="number" name="amount_max" class="form-control" placeholder="Max (€)" 
                                           value="{{ request('amount_max') }}" step="0.01">
                                </div>
                            </div>

                            <!-- Date Range -->
                            <div class="col-md-3 mb-3">
                                <label for="date_range" class="form-label">{{ __('Date Range') }}</label>
                                <div class="d-flex">
                                    <input type="date" name="due_date_from" class="form-control me-2" 
                                           value="{{ request('due_date_from') }}">
                                    <input type="date" name="due_date_to" class="form-control" 
                                           value="{{ request('due_date_to') }}">
                                </div>
                            </div>

                        <div class="row">
                            <!-- Paid At -->
                            <div class="col-md-3 mb-3">
                                <label for="paid_at" class="form-label">{{ __('Paid At') }}</label>
                                <input type="date" name="paid_at" id="paid_at" class="form-control" value="{{ request('paid_at') }}">
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
        form.action = "{{ route('admin.maps.rents.export.pdf') }}";
        form.target = "_blank"; 
        form.submit();
    });

    // Configura o botão para exportar Excel
    document.getElementById('export-excel').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.action = "{{ route('admin.maps.rents.export.excel') }}";
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

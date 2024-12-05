@extends('layouts.admin')

@section('title', __('Complaint Map'))

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Complaint Map') }}</h1>
                    <hr class="mb-4" />

                    <!-- Formulário de Filtros -->
                    <form id="filter-form" action="#" method="GET" class="mb-4">
                        <div class="row">
                            <!-- Complaint Type -->
                            <div class="col-md-3 mb-3">
                                <label for="complaint_type" class="form-label">{{ __('Complaint Type') }}</label>
                                <select name="complaint_type" id="complaint_type" class="form-select">
                                    <option value="">{{ __('All Types') }}</option>
                                    @foreach($complaintTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('complaint_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                    <option value="Solved" {{ request('status') == 'Solved' ? 'selected' : '' }}>{{ __('Solved') }}</option>
                                </select>
                            </div>

                            <!-- Has Attachment -->
                            <div class="col-md-3 mb-3">
                                <label for="attachment" class="form-label">{{ __('Has Attachment') }}</label>
                                <select name="attachment" id="attachment" class="form-select">
                                    <option value="">{{ __('Both') }}</option>
                                    <option value="1" {{ request('attachment') == '1' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                    <option value="0" {{ request('attachment') == '0' ? 'selected' : '' }}>{{ __('No') }}</option>
                                </select>
                            </div>

                            <!-- User -->
                            <div class="col-md-3 mb-3">
                                <label for="user" class="form-label">{{ __('User') }}</label>
                                <select name="user" id="user" class="form-select">
                                    <option value="">{{ __('All Users') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
    document.getElementById('export-pdf').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.action = "{{ route('admin.maps.complaints.export.pdf') }}";
        form.target = "_blank"; 
        form.submit();
    });

    document.getElementById('export-excel').addEventListener('click', function() {
        document.getElementById('filter-form').action = "{{ route('admin.maps.complaints.export.excel') }}";
        document.getElementById('filter-form').method = 'GET'; 
        document.getElementById('filter-form').submit();
    });
</script>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@endsection

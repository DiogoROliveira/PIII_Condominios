@extends('layouts.admin')

@section('title')
{{ __('Edit Tenant') }}
@endsection

@section('content')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Tenant')}}</h1>
                    <hr class="mb-4" />
                    <x-alert-messages />

                    <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- User Selection -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">{{__('Tenant')}}</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="" disabled>{{__('Select a Tenant')}}</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $tenant->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Unit Selection -->
                            <div class="col-md-6">
                                <label for="unit_id" class="form-label">{{__('Unit')}}</label>
                                <select name="unit_id" id="unit_id" class="form-select">
                                    <option value="" disabled>{{__('Select a Unit')}}</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $tenant->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->unit_number }} - Block {{ $unit->block->block ?? '' }} ({{ $unit->block->condominium->name ?? '' }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Lease Start Date -->
                            <div class="col-md-6">
                                <label for="lease_start_date" class="form-label">{{__('Lease Start Date')}}</label>
                                <input type="date" name="lease_start_date" id="lease_start_date" class="form-control"
                                    value="{{ old('lease_start_date', $tenant->lease_start_date ? $tenant->lease_start_date : '') }}">
                            </div>

                            <!-- Lease End Date -->
                            <div class="col-md-6">
                                <label for="lease_end_date" class="form-label">{{__('Lease End Date')}}</label>
                                <input type="date" name="lease_end_date" id="lease_end_date" class="form-control"
                                    value="{{ old('lease_end_date', $tenant->lease_end_date ? $tenant->lease_end_date : '') }}">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active" {{ $tenant->status == 'active' ? 'selected' : '' }}>{{__('Active')}}</option>
                                    <option value="inactive" {{ $tenant->status == 'inactive' ? 'selected' : '' }}>{{__('Inactive')}}</option>
                                    <option value="pending" {{ $tenant->status == 'pending' ? 'selected' : '' }}>{{__('Pending')}}</option>
                                    <option value="terminated" {{ $tenant->status == 'terminated' ? 'selected' : '' }}>{{__('Terminated')}}</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="col-md-6">
                                <label for="notes" class="form-label">{{__('Notes')}}</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $tenant->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                            <a href="{{ route('admin.tenants') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@endsection
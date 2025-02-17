@extends('layouts.admin')

@section('title')
{{ __('Create Tenant') }}
@endsection

@section('content')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Create New Tenant') }}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.tenants.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <!-- User -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">{{ __('Tenant Name') }}</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="" disabled selected>{{ __('Select Tenant') }}</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        @php
                                        $decryptedEmail = Crypt::decrypt($user->email);
                                        @endphp
                                        {{ $user->name }} ({{ $decryptedEmail }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Unit -->
                            <div class="col-md-6">
                                <label for="unit_id" class="form-label">{{ __('Unit') }}</label>
                                <select name="unit_id" id="unit_id" class="form-select">
                                    <option value="" disabled selected>{{ __('Select Unit') }}</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->unit_number }} - Block {{ $unit->block->block ?? __('N/A') }} ({{ $unit->block->condominium->name ?? __('N/A') }}) - {{ $unit->status }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Lease Start Date -->
                            <div class="col-md-6">
                                <label for="lease_start_date" class="form-label">{{ __('Lease Start Date') }}</label>
                                <input type="date" name="lease_start_date" id="lease_start_date" class="form-control"
                                    value="{{ old('lease_start_date') }}">
                            </div>

                            <!-- Lease End Date -->
                            <div class="col-md-6">
                                <label for="lease_end_date" class="form-label">{{ __('Lease End Date') }}</label>
                                <input type="date" name="lease_end_date" id="lease_end_date" class="form-control"
                                    value="{{ old('lease_end_date') }}">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>{{ __('Terminated') }}</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="col-md-6">
                                <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3"
                                    placeholder="{{ __('Additional notes (optional)') }}">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Create Tenant') }}</button>
                            <a href="{{ route('admin.tenants') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
@extends('layouts.admin')

@section('title')
{{ __('Create Monthly Payment') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Create Monthly Payment') }}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.monthly-payments.store') }}" method="POST">
                        @csrf
                        <!-- Unit Selection -->
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">{{ __('Select Unit') }}</label>
                            <select name="unit_id" id="unit_id" class="form-select" required>
                                <option value="">{{ __('Select a unit') }}</option>
                                @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ __('Unit:') }} {{ $unit->unit_number }} - {{ $unit->block->block }} - {{ $unit->block->condominium->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tenant Info -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('Tenant of Selected Unit') }}</label>
                            <ul id="tenant_info" class="list-group">
                                <li class="list-group-item text-muted">{{ __('Select a unit to view its tenant') }}</li>
                            </ul>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>

                        <!-- Payment Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Payment Amount') }}</label>
                            <input type="number" name="amount" id="amount" class="form-control" required min="0" step="0.01" placeholder="0.00">
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Payment Status') }}</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="paid">{{ __('Paid') }}</option>
                                <option value="overdue">{{ __('Overdue') }}</option>
                            </select>
                        </div>

                        <!-- Paid At -->
                        <div class="mb-3">
                            <label for="paid_at" class="form-label">{{ __('Paid At (Optional)') }}</label>
                            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Create Monthly Payment') }}</button>
                        <a href="{{ route('admin.monthly-payments') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const units = @json($units);
            const tenants = @json($tenants);
            const users = @json($users); // Usando os e-mails já desencriptados

            const unitSelect = document.getElementById('unit_id');
            const tenantInfo = document.getElementById('tenant_info');

            unitSelect.addEventListener('change', function() {
                const unitId = this.value;
                tenantInfo.innerHTML = '';

                const unit = units.find(u => u.id == unitId);

                if (unit && unit.tenant_id) {
                    const tenant = tenants.find(t => t.id == unit.tenant_id);
                    const user = users.find(u => u.id == tenant.user_id);

                    if (user) {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item';
                        listItem.textContent = `${user.name} - ${user.decrypted_email}`; // Usando o e-mail desencriptado
                        tenantInfo.appendChild(listItem);
                        return;
                    }
                }

                const emptyMessage = document.createElement('li');
                emptyMessage.className = 'list-group-item text-muted';
                emptyMessage.textContent = '{{ __("No tenant found for this unit") }}';
                tenantInfo.appendChild(emptyMessage);
            });
        });
    </script>
</x-app-layout>
@endsection
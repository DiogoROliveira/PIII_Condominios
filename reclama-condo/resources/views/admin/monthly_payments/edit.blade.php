@extends('layouts.admin')

@section('title')
{{ __('Edit Monthly Payment') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Edit Monthly Payment') }}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.monthly-payments.update', $monthlyPayment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Payment Status') }}</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" {{ $monthlyPayment->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="paid" {{ $monthlyPayment->status == 'paid' ? 'selected' : '' }}>
                                    {{ __('Paid') }}
                                </option>
                                <option value="overdue" {{ $monthlyPayment->status == 'overdue' ? 'selected' : '' }}>
                                    {{ __('Overdue') }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Payment Amount') }}</label>
                            <input type="number" name="amount" id="amount" class="form-control"
                                value="{{ old('amount', $monthlyPayment->amount) }}" required min="0" step="0.01" placeholder="0.00">
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" id="due_date" class="form-control"
                                value="{{ old('due_date', $monthlyPayment->due_date) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="paid_at" class="form-label">{{ __('Paid At (Optional)') }}</label>
                            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control"
                                value="{{ old('paid_at', $monthlyPayment->paid_at ? $monthlyPayment->paid_at : '') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Monthly Payment') }}</button>
                        <a href="{{ route('admin.monthly-payments') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
</x-app-layout>
@endsection
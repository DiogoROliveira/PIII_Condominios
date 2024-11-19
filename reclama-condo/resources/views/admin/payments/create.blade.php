@extends('layouts.admin')

@section('title')
{{ __('Create Payment') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{ __('Create Payment') }}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.payments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="monthly_payment_id" class="form-label">{{ __('Select Monthly Payment') }}</label>
                            <select name="monthly_payment_id" id="monthly_payment_id" class="form-select">
                                <option value="">{{ __('Select a monthly payment') }}</option>
                                @foreach ($monthlyPayments as $monthlyPayment)
                                <option value="{{ $monthlyPayment->id }}">
                                    {{__('Unit:')}} {{ $monthlyPayment->unit->unit_number }} | {{ __('Due Date:') }} {{ $monthlyPayment->due_date }} | {{ __('Payment Amount:') }} {{ $monthlyPayment->amount }}€
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Payment Amount') }}</label>
                            <input type="number" name="amount" id="amount" class="form-control" min="0" step="0.01" placeholder="0.00">
                        </div>

                        <div class="mb-3">
                            <label for="method" class="form-label">{{ __('Payment Method') }}</label>
                            <select name="method" id="method" class="form-select">
                                <option value="">{{ __('Select a payment method') }}</option>
                                @foreach ($paymentMethodsJson as $method)
                                <option value="{{ $method['id'] }}">{{ $method['code'] }} - {{ __($method['name']) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="paid_at" class="form-label">{{ __('Paid At (Leave blank for current date)') }}</label>
                            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Create Payment') }}</button>
                        <a href="{{ route('admin.payments') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
</x-app-layout>
@endsection
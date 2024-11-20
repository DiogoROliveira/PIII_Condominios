<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rent Details') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rents.index') }}">{{ __('My Rents') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Details') }}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>{{ __('Tenant') }}: {{ $tenant->user->name }}</h3>
                    <h4>{{ __('Unit') }}: {{ $unit->unit_number }}</h4>

                    <hr class="mb-4">

                    <x-alert-messages />

                    <h5>{{ __('Payment History') }}</h5>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>{{ __('Date Paid') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Method') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paymentHistory as $payment)
                            <tr>
                                <td>{{ $payment->paid_at }}</td>
                                <td>{{ $payment->amount }}€</td>
                                <td>{{ $payment->method }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('No payment history available.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <hr class="mt-5 mb-4">

                    <h5>{{ __('Pending Monthly Payments') }}</h5>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingMonthlyPayments as $payment)
                            <tr>
                                <td>{{ $payment->due_date }}</td>
                                <td>{{ $payment->amount }}€</td>
                                <td class="text-center">
                                    <button
                                        class="btn btn-primary pay-now-btn"
                                        data-monthly-payment-id="{{ $payment->id }}">
                                        {{ __('Pay Now') }}
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('No pending payments.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('rents.pay') }}" method="POST" id="payment-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">{{ __('Pay Now') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="monthly_payment_id" id="monthly-payment-id">

                        <!-- Mostrar checkbox se houver método de pagamento guardado -->
                        @if (isset($savedPaymentDetails))
                        @foreach ($savedPaymentDetails as $detail)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="use_saved_payment" id="use-saved-payment" checked>
                            <label class="form-check-label p-3 rounded border" for="use-saved-payment" style="display: block; border-color: #ddd; background-color: #f9f9f9;">
                                <strong>{{ __('Use saved payment method: ') . $detail->method }}</strong>
                                <br>
                                @php
                                $cardNumber = $detail->card_number;
                                $maskedCardNumber = str_repeat('*', min(strlen($cardNumber) - 4, 5)) . substr($cardNumber, -4);
                                @endphp
                                <span>{{ __('Card Number: ') . $maskedCardNumber }}</span>
                                <span>{{ __('Expiration: ') . $detail->card_expiration }}</span>
                            </label>
                        </div>
                        @endforeach
                        @else
                        <div class=" form-check">
                            <input class="form-check-input" type="checkbox" name="use_saved_payment" id="use-saved-payment">
                            <label class="form-check-label" for="use-saved-payment">
                                {{ __('Use saved payment method (if available)') }}
                            </label>
                        </div>
                        @endif

                        <hr class="my-4">

                        <div class="mb-3">
                            <label for="payment-method" class="form-label">{{ __('Payment Method') }}</label>
                            <select name="payment_method" id="payment-method" class="form-select">
                                <option value="">{{ __('Select a payment method') }}</option>
                                @foreach ($paymentMethodsJson as $method)
                                <option
                                    value="{{ $method['code'] }}"
                                    data-needs-bank="{{ $method['needsBank'] }}">
                                    {{ $method['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="bank-details" class="d-none">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Account Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="card_number" class="form-label">{{ __('Card Number') }}</label>
                                <input type="text" name="card_number" id="card_number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="card_expiration" class="form-label">{{ __('Card Expiration Date') }}</label>
                                <input type="text" name="card_expiration" id="card_expiration" class="form-control" placeholder="MM/YY">
                            </div>
                            <div class="mb-3">
                                <label for="card_cvv" class="form-label">{{ __('CVV') }}</label>
                                <input type="text" name="card_cvv" id="card_cvv" class="form-control">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="save_payment_details" id="save-payment-details">
                                <label class="form-check-label" for="save-payment-details">
                                    {{ __('Save payment details for future use') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Confirm Payment') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-check-label {
            display: block;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            text-align: left;
        }

        .form-check-label strong {
            font-weight: bold;
        }

        .form-check-label span {
            display: block;
            margin-top: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const payNowButtons = document.querySelectorAll('.pay-now-btn');
            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            const paymentMethodSelect = document.getElementById('payment-method');
            const bankDetails = document.getElementById('bank-details');
            const monthlyPaymentIdInput = document.getElementById('monthly-payment-id');

            // Show modal with payment details
            payNowButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const monthlyPaymentId = button.getAttribute('data-monthly-payment-id');
                    monthlyPaymentIdInput.value = monthlyPaymentId;
                    paymentModal.show();
                });
            });

            // Show or hide bank details based on payment method
            paymentMethodSelect.addEventListener('change', () => {
                const selectedOption = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
                const needsBank = selectedOption.getAttribute('data-needs-bank') === '1';

                if (needsBank) {
                    bankDetails.classList.remove('d-none');
                } else {
                    bankDetails.classList.add('d-none');
                }
            });
        });
    </script>
</x-app-layout>
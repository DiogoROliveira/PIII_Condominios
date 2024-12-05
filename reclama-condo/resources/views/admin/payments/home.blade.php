@extends('layouts.admin')

@section('title')
{{ __('Payments DataTable') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header position-relative">
                        <h1 class="card-title" style="font-size: 2rem">{{__('Payments DataTable')}}</h1>
                        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%);">{{__('Add Payment')}}</a>
                    </div>

                    <div class="card-body">
                        <table id="paymentsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('Monthly Payment')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Paid At')}}</th>
                                    <th>{{__('Method')}}</th>
                                    <th class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->monthly_payment_id }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->paid_at }}</td>
                                    <td>
                                        @php
                                        $method = $paymentMethodsJson[$payment->method] ?? null;
                                        @endphp
                                        @if ($method)
                                        {{ __($method['description']) }}
                                        @else
                                        {{ __('Unknown Method') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!--
                                        <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-payment-id="{{ $payment->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">{{__('Confirm Delete')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{__('Are you sure you want to delete this payment?')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var locale = "{{ app()->getLocale() }}";
        var translations = {
            en: '//cdn.datatables.net/plug-ins/2.1.8/i18n/en-GB.json',
            pt: '//cdn.datatables.net/plug-ins/2.1.8/i18n/pt-PT.json',
        };

        $('#paymentsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "url": translations[locale] || translations['en']
            },
            "buttons": ["excel", "pdf"],
            "dom": "<'row'<'col-md-6'Bl><'col-md-6'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-6'i><'col-md-6'p>>",
        }).buttons().container().appendTo('#paymentsTable_wrapper .col-md-6:eq(0)');

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const paymentId = button.data('payment-id');
            $('#deleteForm').attr('action', `/admin/dashboard/payments/${paymentId}`);
        });
    });
</script>

@endsection
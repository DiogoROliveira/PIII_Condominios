@extends ('layouts.admin')

@section('title')
{{ __('Email Invoices') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="font-size: 2rem">{{ __('Invoices DataTable') }}</h1>
                    </div>
                    <div class="card-body">
                        <table id="invoicesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('Invoice Number') }}</th>
                                    <th>{{ __('Reference') }}</th>
                                    <th>{{ __('Paid Amount') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Tenant') }}</th>
                                    <th>{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $index => $invoice)
                                <tr>
                                    @php
                                    $decryptedEmail = Crypt::decrypt($invoice->tenant->user->email);
                                    @endphp
                                    <td>
                                        <input type="checkbox" name="invoices[]" value="{{ json_encode($invoice) }}" class="invoice-checkbox">
                                    </td>
                                    <td>{{ $invoice->invoice }}</td>
                                    <td>{{ $invoice->reference }}</td>
                                    <td>{{ $invoice->payment->amount ?? __('N/A') }}</td>
                                    <td>{{ $invoice->payment->paid_at ?? __('N/A') }}</td>
                                    <td>{{ $invoice->tenant->user->name ?? __('N/A') }}</td>
                                    <td>{{ $decryptedEmail }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary mb-4 mt-2" id="open-modal">{{__('Send Invoices')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="email-form" action="{{ route('admin.email-invoices.send') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">{{ __('Send Invoices') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>{{ __('Selected Invoices') }}:</h6>
                        <ul id="selected-invoices-list" class="list-group mb-3"></ul>

                        <div class="form-group">
                            <label for="email">{{ __('Recipient Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="{{ __('Enter recipient email') }}">
                        </div>
                        <input type="hidden" name="selected_invoices" id="selected-invoices-input">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Send Email') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DataTables and JavaScript -->
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
        var translations = {
            en: '//cdn.datatables.net/plug-ins/2.1.8/i18n/en-GB.json',
            pt: '//cdn.datatables.net/plug-ins/2.1.8/i18n/pt-PT.json',
        };

        var locale = "{{ app()->getLocale() }}";

        $('#invoicesTable').DataTable({
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
        }).buttons().container().appendTo('#invoicesTable_wrapper .col-md-6:eq(0)');

        $('#open-modal').on('click', function() {
            const selectedInvoices = [];
            const invoiceList = $('#selected-invoices-list');
            const selectedInvoicesInput = $('#selected-invoices-input');

            invoiceList.empty(); // Limpa a lista anterior

            $('.invoice-checkbox:checked').each(function() {
                const invoiceRow = $(this).closest('tr');
                const invoiceNumber = invoiceRow.find('td:nth-child(2)').text();
                const invoiceData = $(this).val();

                selectedInvoices.push(invoiceData);
                invoiceList.append(`<li class="list-group-item">${invoiceNumber}</li>`);
            });

            if (selectedInvoices.length === 0) {
                alert('{{ __("No invoices selected.") }}');
                return;
            }

            selectedInvoicesInput.val(JSON.stringify(selectedInvoices));
            $('#emailModal').modal('show');
        });
    });
</script>
@endsection
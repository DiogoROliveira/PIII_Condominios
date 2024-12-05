@extends ('layouts.admin')

@section('title')
{{ __('Invoices') }}
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
                                    <th>#</th>
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
                                    <td>{{ $index + 1 }}</td>
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
                    </div>
                </div>
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
    });
</script>



@endsection
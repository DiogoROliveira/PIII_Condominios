@extends('layouts.admin')

@section('title')
{{__('Mail Account') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="font-size: 2rem">{{ __('Tenants DataTable') }}</h1>
                    </div>
                    <div class="card-body">
                        <table id="invoicesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Units') }}</th>
                                    <th>{{ __('Block') }}</th>
                                    <th>{{ __('Condominium') }}</th>
                                    <th>{{ __('Total Payments') }}</th>
                                    <th>{{__('Overdue/Pending Payments')}}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                <tr>
                                    @php
                                    $decryptedEmail = Crypt::decrypt($user->email);

                                    // Coletar todas as unidades de todos os tenants do user
                                    $units = collect();
                                    $totalPayments = 0;
                                    $overduePayments = 0;

                                    foreach ($user->tenants as $tenant) {
                                    $units = $units->concat($tenant->units);
                                    $totalPayments += $tenant->monthly_payments->sum('amount');
                                    $overduePayments += $tenant->monthly_payments->where('status', 'overdue')->sum('amount');
                                    $overduePayments += $tenant->monthly_payments->where('status', 'pending')->sum('amount');
                                    }

                                    // Agora podemos pegar todas as informações únicas
                                    $unitNumbers = $units->pluck('unit_number')->unique()->implode('; ');
                                    $blocks = $units->pluck('block.block')->unique()->implode('; ');
                                    $condominiums = $units->pluck('block.condominium.name')->unique()->implode('; ');
                                    @endphp

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $decryptedEmail }}</td>
                                    <td>{{ $unitNumbers ?: __('N/A') }}</td>
                                    <td>{{ $blocks ?: __('N/A') }}</td>
                                    <td>{{ $condominiums ?: __('N/A') }}</td>
                                    <td>{{ $totalPayments ?: 0 }}</td>
                                    <td>{{ $overduePayments ?: 0 }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="sendEmail('{{ $decryptedEmail }}', '{{ $user->id }}')">
                                            {{ __('Send Email') }}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for sending email -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="email-form" action="{{ route('admin.email-accounts.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tenant_id" id="selected-tenant-id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">{{ __('Recipient Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="{{ __('Enter recipient email') }}">
                        </div>
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
    function sendEmail(decriptedEmail, userId) {
        $('#email').val(decriptedEmail);
        $('#selected-tenant-id').attr('name', 'user_id').val(userId);
        $('#emailModal').modal('show');
    }

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
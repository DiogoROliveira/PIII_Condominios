@extends('layouts.admin')

@section('title')
{{ __('Condominiums') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header position-relative">
                        <h1 class="card-title" style="font-size: 2rem">{{ __('Condominiums DataTable') }}</h1>
                        <a href="{{ route('admin.condominiums.create') }}" class="btn btn-primary position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%);">{{ __('Add Condominium') }}</a>
                    </div>
                    <div class="card-body">
                        <table id="condominiumsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('City') }}</th>
                                    <th>{{ __('State') }}</th>
                                    <th>{{ __('Postal Code') }}</th>
                                    <th>{{ __('Admin') }}</th>
                                    <th>{{ __('Blocks') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($condominiums as $index => $condominium)
                                <tr>
                                    @php
                                    $decryptedEmail = Crypt::decrypt($condominium->admin->email);
                                    @endphp
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $condominium->name }}</td>
                                    <td>{{ $condominium->address }}</td>
                                    <td>{{ $condominium->city ?? __('N/A') }}</td>
                                    <td>{{ $condominium->state ?? __('N/A') }}</td>
                                    <td>{{ $condominium->postal_code ?? __('N/A') }}</td>
                                    <td>{{ $condominium->admin->name }} ({{ $decryptedEmail }})</td>
                                    <td>{{ $condominium->number_of_blocks }}</td>
                                    <td>{{ $condominium->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.condominiums.edit', $condominium->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-condominium-id="{{ $condominium->id }}">
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
                                <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Delete') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure you want to delete this condominium?') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
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

        $('#condominiumsTable').DataTable({
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
        }).buttons().container().appendTo('#condominiumsTable_wrapper .col-md-6:eq(0)');

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const condominiumId = button.data('condominium-id');
            $('#deleteForm').attr('action', `/admin/dashboard/condominiums/${condominiumId}`);
        });
    });
</script>

@endsection
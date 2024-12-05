@extends('layouts.admin')

@section('title')
{{ __('Complaints') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="font-size: 2rem">{{__('Complaints DataTable')}}</h1>
                        <a href="{{ route('admin.complaints.create') }}" class="btn btn-primary" style="transform: translate(575px, 4px)">{{__('Add Complaint')}}</a>
                    </div>
                    <div class="card-body">
                        <table id="complaintsTable" class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Condominium') }}</th>
                                    <th>{{ __('Block') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Complaint Type') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Attachments') }}</th>
                                    <th>{{ __('Response') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select id="filter-condominium" class="form-control">
                                            <option value="">{{ __('All Condominiums') }}</option>
                                            @foreach($condominiums as $condominium)
                                            <option value="{{ $condominium->name }}">{{ $condominium->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select id="filter-type" class="form-control">
                                            <option value="">{{ __('All Types') }}</option>
                                            @foreach($complaintTypes as $type)
                                            <option value="{{ $type->name }}">{{ __($type->name) }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select id="filter-status" class="form-control">
                                            <option value="">{{ __('All Statuses') }}</option>
                                            <option value="Pending">{{ __('Pending') }}</option>
                                            <option value="Resolved">{{ __('In Progress') }}</option>
                                            <option value="Closed">{{ __('Solved') }}</option>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ $complaint->user->name ?? __('N/A') }}</td>
                                    <td>{{ $complaint->unit->block->condominium->name ?? '' }}</td>
                                    <td>{{ $complaint->unit->block->block ?? '' }}</td>
                                    <td>{{ $complaint->unit->unit_number ?? '' }}</td>
                                    <td>{{ $complaint->complaintType->name }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{{ $complaint->description }}</td>
                                    <td>{{ $complaint->status }}</td>
                                    <td class="text-center">
                                        @if ($complaint->attachments->isNotEmpty())
                                        {{ $complaint->attachments->count() }}
                                        <a href="{{ route('admin.complaints.download', $complaint->id) }}">
                                            <i class="fa-solid fa-download ms-1" style="color: #414243"></i>
                                        </a>
                                        @else
                                        {{ __('N/A') }}
                                        @endif
                                    </td>
                                    <td>{{ $complaint->response ?? __('N/A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.complaints.edit', $complaint->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-complaint-id="{{ $complaint->id }}">
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
                                {{__('Are you sure you want to delete this complaint?')}}'
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

        const table = $('#complaintsTable').DataTable({
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
        });

        $('#filter-condominium').on('change', function() {
            const value = $(this).val();
            table.column(2).search(value).draw();
        });

        $('#filter-type').on('change', function() {
            const value = $(this).val();
            table.column(5).search(value).draw();
        });

        $('#filter-status').on('change', function() {
            const value = $(this).val();
            table.column(8).search(value).draw();
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const complaintId = button.data('complaint-id');
            $('#deleteForm').attr('action', `/admin/dashboard/complaints/${complaintId}`);
        });

        table.buttons().container().appendTo('#complaintsTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
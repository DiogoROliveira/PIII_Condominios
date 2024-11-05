@extends('layouts.admin')

@section('title', 'Tenants')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="font-size: 2rem">Tenants DataTable</h1>
                    </div>
                    <div class="card-body">
                        <table id="tenantsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Unit Number</th>
                                    <th>Block</th>
                                    <th>Condominium</th>
                                    <th>Status</th>
                                    <th>Lease Start</th>
                                    <th>Lease End</th>
                                    <th>Created At</th>
                                    <th>Notes</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tenants as $index => $tenant)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tenant->user->name }}</td>
                                    <td>{{ $tenant->user->email }}</td>
                                    <td>{{ $tenant->unit->unit_number ?? 'N/A' }}</td>
                                    <td>{{ $tenant->unit->block->block ?? 'N/A' }}</td>
                                    <td>{{ $tenant->unit->block->condominium->name ?? 'N/A' }}</td>
                                    <td>{{ strtoupper($tenant->status) }}</td>
                                    <td>{{ $tenant->lease_start_date ?? 'N/A' }}</td>
                                    <td>{{ $tenant->lease_end_date ?? 'N/A' }}</td>
                                    <td>{{ $tenant->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $tenant->notes ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-tenant-id="{{ $tenant->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary">Add Tenant</a>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this tenant?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
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
        $('#tenantsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tenantsTable_wrapper .col-md-6:eq(0)');

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const tenantId = button.data('tenant-id');
            $('#deleteForm').attr('action', `/admin/dashboard/tenants/${tenantId}`);
        });
    });
</script>

@endsection
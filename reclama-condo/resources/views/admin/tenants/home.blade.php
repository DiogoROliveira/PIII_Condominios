<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tenants</li>
            </ol>
        </nav>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Tenants List</h1>
                        <a href="{{route('admin.tenants.create')}}" class="btn btn-primary">Add Tenant</a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Unit Number</th>
                                    <th scope="col">Block</th>
                                    <th scope="col">Condominium</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Lease Start</th>
                                    <th scope="col">Lease End</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $tenant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tenant->user->name }}</td>
                                    <td>{{ $tenant->user->email }}</td>
                                    <td>{{ $tenant->unit->unit_number ?? 'N/A' }}</td>
                                    <td>{{ $tenant->unit->block->block ?? 'N/A' }}</td>
                                    <td>{{ $tenant->unit->block->condominium->name ?? 'N/A' }}</td>
                                    <td>{{ strtoupper($tenant->status) }} </td>
                                    <td>{{ $tenant->lease_start_date ?? 'N/A' }}</td>
                                    <td>{{ $tenant->lease_end_date ?? 'N/A' }}</td>
                                    <td>{{ $tenant->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $tenant->notes ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-tenant-id="{{ $tenant->id }}">
                                                Delete
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">No tenants available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h4 class="mt-4">Total tenants: {{ $tenants->count() }}</h4>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this tenant?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-fill" data-bs-dismiss="modal">Cancel</button>
                                        <!-- Delete Form -->
                                        <form id="deleteForm" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-fill">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for handling delete button click -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const tenantId = button.getAttribute('data-tenant-id');
                const action = `/admin/dashboard/tenants/${tenantId}`;
                deleteForm.setAttribute('action', action);
            });
        });
    </script>

</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Condominiums') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Condominiums</li>
            </ol>
        </nav>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Condominiums List</h1>
                        <a href="{{route('admin.condominiums.create')}}" class="btn btn-primary">Add Condominium</a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">City</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Zip Code</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Blocks</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($condominiums as $condominium)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $condominium->name }}</td>
                                    <td>{{ $condominium->address }}</td>
                                    <td>{{ $condominium->city ?? 'N/A' }}</td>
                                    <td>{{ $condominium->state ?? 'N/A' }}</td>
                                    <td>{{ $condominium->zip_code ?? 'N/A' }}</td>
                                    <td>{{ $condominium->admin->name }} ({{ $condominium->admin->email }})</td>
                                    <td>{{ $condominium->number_of_blocks }}</td>
                                    <td>{{ $condominium->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.condominiums.edit', $condominium->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <form action="{{ route('admin.condominiums.destroy', $condominium->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-condominium-id="{{ $condominium->id }}">
                                                Delete
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No condominiums available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h4 class="mt-4">Total Condominiums: {{ $condominiums->count() }}</h4>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this condominium?
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
                const condominiumId = button.getAttribute('data-condominium-id');
                const action = `/admin/dashboard/condominiums/${condominiumId}`;
                deleteForm.setAttribute('action', action);
            });
        });
    </script>

</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complaint Types') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Complaint Types</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Complaint Types List</h1>
                        <a href="{{ route('admin.complaint-types.create') }}" class="btn btn-primary">Add Complaint Type</a>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center w-25">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaint_types as $complaintType)
                                <tr>
                                    <td>{{ $complaintType->id }}</td>
                                    <td>{{ $complaintType->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.complaint-types.edit', $complaintType->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <form action="{{ route('admin.complaint-types.destroy', $complaintType->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-complaint-type-id="{{ $complaintType->id }}">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No complaint types available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this complaint type?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <!-- Delete Form -->
                                        <form id="deleteForm" method="POST" style="display: inline;">
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
    </div>

    <!-- JavaScript for handling delete button click -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const complaintTypeId = button.getAttribute('data-complaint-type-id');
                const action = `/admin/dashboard/complaint-types/${complaintTypeId}`;
                deleteForm.setAttribute('action', action);
            });
        });
    </script>

</x-app-layout>
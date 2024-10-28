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

                    <div class="mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>

                        @if ($errors->any())
                        <div class="col-12">
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi me-2" width="16" height="16" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>
                                    {{ $error }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if (session()->has('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi me-2" width="16" height="16" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>
                                {{ session('error') }}
                            </div>
                        </div>
                        @endif

                        @if (session()->has('success'))
                        <div class="alert alert-success d-flex align-items-center p-3" role="alert">
                            <svg class="bi me-2" width="16" height="16" role="img" aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        @endif
                    </div>

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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blocks') }}
        </h2>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blocks</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Blocks List</h1>
                        <a href="{{ route('admin.blocks.create') }}" class="btn btn-primary">Add Block</a>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Condominium</th>
                                    <th scope="col">Block</th>
                                    <th scope="col">Nº of Units</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blocks as $block)
                                <tr>
                                    <td>{{ $block->id }}</td>
                                    <td>{{ $block->condominium->name }}</td>
                                    <td>{{ $block->block }}</td>
                                    <td>{{ $block->number_of_units }}</td>
                                    <td>{{ $block->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.blocks.edit', $block->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-block-id="{{ $block->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No blocks available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h4 class="mt-4">Total Blocks: {{ $blocks->count() }}</h4>

                        <!-- delete modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this block?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form id="deleteForm" method="POST" action="">
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
                const blockId = button.getAttribute('data-block-id');
                deleteForm.setAttribute('action', `/admin/dashboard/blocks/${blockId}`);
            });
        });
    </script>
</x-app-layout>
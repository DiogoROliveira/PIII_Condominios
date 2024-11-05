<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Complaint') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route($breadcrumbRoute) }}">Complaints</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Create Complaint</h1>
                    <hr class="mb-4" />
                    <x-alert-messages />
                </div>
                <div class="me-4 ms-4 mb-4">
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="complaint_type_id" class="form-label">Complaint Type</label>
                            <select name="complaint_type_id" id="complaint_type_id" class="form-select" required>
                                <option value="">Select a complaint type</option>
                                @foreach ($complaintTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('complaint_type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="attachments" class="form-label">Attachments</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple onchange="handleFileSelect(event)">
                            @error('attachments')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Preview area for selected files -->
                            <ul id="file-list" class="mt-3 list-unstyled">
                                <!-- JavaScript will populate this area -->
                            </ul>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit Complaint</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle file selection and removal -->
    <script>
        const fileList = document.getElementById('file-list');
        const fileInput = document.getElementById('attachments');

        function handleFileSelect(event) {
            fileList.innerHTML = ''; // Clear previous file list
            const files = Array.from(event.target.files); // Convert FileList to array for easier manipulation

            files.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('d-flex', 'align-items-center', 'mb-2', 'justify-content-between');

                // Display the file name with dotted line separator
                const fileName = document.createElement('span');
                fileName.innerText = file.name;
                fileName.classList.add('file-name');

                // Create "X" button to remove the file
                const removeButton = document.createElement('button');
                removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'remove-button');
                removeButton.innerText = 'X';
                removeButton.onclick = function() {
                    files.splice(index, 1); // Remove the file from the array
                    fileInput.files = createFileList(files); // Update the input files
                    handleFileSelect({
                        target: {
                            files: fileInput.files
                        }
                    }); // Refresh the file list display
                };

                listItem.appendChild(fileName);
                listItem.appendChild(removeButton);
                fileList.appendChild(listItem);
            });
        }

        // Helper function to create a new FileList
        function createFileList(files) {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            return dataTransfer.files;
        }
    </script>

    <style>
        #file-list .file-name {
            flex-grow: 1;
            border-bottom: 1px dotted #ccc;
            padding-right: 10px;
            margin-right: 10px;
            display: inline-block;
        }

        #file-list .remove-button {
            white-space: nowrap;
        }
    </style>
</x-app-layout>
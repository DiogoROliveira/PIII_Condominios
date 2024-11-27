@extends('layouts.admin')

@section('title')
{{ __('Create Complaint') }}
@endsection

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Create Complaint')}}</h1>
                    <hr class="mb-4" />
                    <x-alert-messages />
                </div>
                <div class="me-4 ms-4 mb-4">
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="unit_id" class="form-label">{{__('Unit')}}</label>
                            <select name="unit_id" id="unit_id" class="form-select" required>
                                <option value="">{{__('Select a unit')}}</option>
                                @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->unit_number }} - {{ $unit->block->block ?? '' }} - {{ $unit->block->condominium->name ?? '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="complaint_type_id" class="form-label">{{__('Complaint Type')}}</label>
                            <select name="complaint_type_id" id="complaint_type_id" class="form-select" required>
                                <option value="">{{__('Select a complaint type')}}</option>
                                @foreach ($complaintTypes as $type)
                                <option value="{{ $type->id }}">{{ __($type->name) }}</option>
                                @endforeach
                            </select>
                            @error('complaint_type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label">{{__('Title')}}</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">{{__('Description')}}</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="attachments" class="form-label">{{__('Attachments')}}</label>
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
                            <button type="submit" class="btn btn-primary">{{__('Submit Complaint')}}</button>
                            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
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
            fileList.innerHTML = '';
            const files = Array.from(event.target.files);

            files.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('d-flex', 'align-items-center', 'mb-2', 'justify-content-between');

                const fileName = document.createElement('span');
                fileName.innerText = file.name;
                fileName.classList.add('file-name');

                const removeButton = document.createElement('button');
                removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'remove-button');
                removeButton.innerText = 'X';
                removeButton.onclick = function() {
                    files.splice(index, 1);
                    fileInput.files = createFileList(files);
                    handleFileSelect({
                        target: {
                            files: fileInput.files
                        }
                    });
                };

                listItem.appendChild(fileName);
                listItem.appendChild(removeButton);
                fileList.appendChild(listItem);
            });
        }

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

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
</x-app-layout>

@endsection
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Complaint Type') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.complaint-types') }}">Complaint Types</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Edit Complaint Type</h1>
                    <hr class="mb-4" />

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi me-2" width="16" height="16" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            {{ $errors->first() }}
                        </div>
                    </div>
                    @endif

                    <!-- Success Message -->
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

                    <form action="{{ route('admin.complaint-types.update', $complaintType->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $complaintType->name) }}" placeholder="Complaint Type Name" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.complaint-types') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Complaint Type') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.complaint-types') }}">Complaint Types</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Create Complaint Type</h1>
                    <hr class="mb-4" />
                    
                    <div class="mt-5">
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
                </div>

                <div class="me-4 ms-4 mb-4">
                    <form action="{{ route('admin.complaint-types.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <!-- Name -->
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Complaint Type Name" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Create Complaint Type</button>
                            <a href="{{ route('admin.complaint-types') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

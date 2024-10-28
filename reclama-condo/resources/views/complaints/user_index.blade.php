<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Complaints') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Complaints</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

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

                    @if ($complaints->isEmpty())
                        <p class="text-gray-500">You have not submitted any complaints yet.</p>
                    @else

                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="text-lg font-medium mb-4">Your Complaints</h3>
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">Create Complaint</a>
                    </div>
                        <div class="table-responsive mt-6">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Complaint Type</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $complaint->id }}</td>
                                            <td>{{ $complaint->complaintType->name }}</td>
                                            <td>{{ $complaint->title }}</td>
                                            <td>{{ $complaint->description }}</td>
                                            <td>{{ $complaint->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

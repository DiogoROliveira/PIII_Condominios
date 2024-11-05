@extends('layouts.admin')

@section('title', 'Create Complaint Type')

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Create Complaint Type</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

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

@endsection
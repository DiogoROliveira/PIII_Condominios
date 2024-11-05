@extends('layouts.admin')

@section('title', 'Edit Complaint Type')

@section('content')
<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Edit Complaint Type</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

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
@endsection
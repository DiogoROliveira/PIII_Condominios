@extends('layouts.admin')

@section('title', 'Edit Complaint')

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Edit Complaint</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Solved" {{ $complaint->status == 'Solved' ? 'selected' : '' }}>Solved</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- User -->
                            <div class="col-md-6">
                                <label for="user" class="form-label">User</label>
                                <input type="text" id="user" class="form-control" value="{{ $complaint->user->name ?? 'N/A' }}" readonly>
                            </div>

                            <!-- Complaint Type -->
                            <div class="col-md-6">
                                <label for="complaint_type" class="form-label">Complaint Type</label>
                                <input type="text" id="complaint_type" class="form-control" value="{{ $complaint->complaintType->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" class="form-control" value="{{ $complaint->title }}" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control" rows="4" readonly>{{ $complaint->description }}</textarea>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Response -->
                            <div class="col-md-12">
                                <label for="response" class="form-label">Response</label>
                                <textarea id="response" class="form-control" rows="4" name="response">{{ $complaint->response ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@endsection
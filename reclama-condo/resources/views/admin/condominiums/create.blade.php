@extends('layouts.admin')

@section('title', 'Create Condominium')

@section('content')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Create Condominium</h1>
                    <hr class="mb-4" />
                    <x-alert-messages />
                </div>
                <div class="me-4 ms-4 mb-4">
                    <form action="{{ route('admin.condominiums.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 mb-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Condominium Name">
                            </div>
                            <!-- Address -->
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="123 Main St">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- City -->
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City (optional)">
                            </div>
                            <!-- State -->
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State (optional)">
                            </div>
                            <!-- Postal Code -->
                            <div class="col-md-4">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code (optional)">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone (optional)">
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email (optional)">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Admin ID -->
                            <div class="col-md-6">
                                <label for="admin_id" class="form-label">Admin</label>
                                <select name="admin_id" id="admin_id" class="form-select">
                                    <option value="" disabled selected>Select an Admin</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Number of Blocks -->
                            <div class="col-md-6">
                                <label for="number_of_blocks" class="form-label">Number of Blocks</label>
                                <input type="number" name="number_of_blocks" id="number_of_blocks" class="form-control" placeholder="Number of Blocks" min="1">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Create Condominium</button>
                            <a href="{{ route('admin.condominiums') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

@endsection
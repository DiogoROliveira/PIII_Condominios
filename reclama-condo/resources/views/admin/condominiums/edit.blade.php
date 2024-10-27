<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Condominium') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.condominiums') }}">Condominiums</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Edit Condominium</h1>
                    <hr class="mb-4" />

                    <div class="mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>
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
                    </div>

                    <form action="{{ route('admin.condominiums.update', $condominium->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $condominium->name) }}" placeholder="Condominium Name">
                            </div>
                            <!-- Address -->
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ old('address', $condominium->address) }}" placeholder="123 Main St">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- City -->
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                    value="{{ old('city', $condominium->city) }}" placeholder="City (optional)">
                            </div>
                            <!-- State -->
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state" class="form-control"
                                    value="{{ old('state', $condominium->state) }}" placeholder="State (optional)">
                            </div>
                            <!-- Zip Code -->
                            <div class="col-md-4">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                    value="{{ old('zip_code', $condominium->zip_code) }}" placeholder="Zip Code (optional)">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $condominium->phone) }}" placeholder="Phone (optional)">
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $condominium->email) }}" placeholder="Email (optional)">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Admin ID -->
                            <div class="col-md-6">
                                <label for="admin_id" class="form-label">Admin</label>
                                <select name="admin_id" id="admin_id" class="form-select">
                                    <option value="" disabled>Select an Admin</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('admin_id', $condominium->admin_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Number of Blocks -->
                            <div class="col-md-6">
                                <label for="number_of_blocks" class="form-label">Number of Blocks</label>
                                <input type="number" name="number_of_blocks" id="number_of_blocks" class="form-control"
                                    value="{{ old('number_of_blocks', $condominium->number_of_blocks) }}" min="1">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
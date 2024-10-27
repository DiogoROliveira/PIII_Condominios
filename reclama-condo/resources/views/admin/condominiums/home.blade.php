<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Condominiums') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Condominiums</li>
            </ol>
        </nav>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

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

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Condominiums List</h1>
                        <a href="{{route('admin.condominiums.create')}}" class="btn btn-primary">Add Condominium</a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">City</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Zip Code</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Blocks</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($condominiums as $condominium)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $condominium->name }}</td>
                                    <td>{{ $condominium->address }}</td>
                                    <td>{{ $condominium->city ?? 'N/A' }}</td>
                                    <td>{{ $condominium->state ?? 'N/A' }}</td>
                                    <td>{{ $condominium->zip_code ?? 'N/A' }}</td>
                                    <td>{{ $condominium->admin->name }} ({{ $condominium->admin->email }})</td>
                                    <td>{{ $condominium->number_of_blocks }}</td>
                                    <td>{{ $condominium->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.condominiums.edit', $condominium->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <form action="{{ route('admin.condominiums.destroy', $condominium->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No condominiums available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
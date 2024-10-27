<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Block') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.blocks') }}">Blocks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Edit Block</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Block Name -->
                            <div class="col-md-6">
                                <label for="block" class="form-label">Block Name</label>
                                <input type="text" name="block" id="block" class="form-control"
                                    value="{{ old('block', $block->block) }}" placeholder="Block Name">
                            </div>

                            <!-- Number of Units -->
                            <div class="col-md-6">
                                <label for="number_of_units" class="form-label">Number of Units</label>
                                <input type="number" name="number_of_units" id="number_of_units" class="form-control"
                                    value="{{ old('number_of_units', $block->number_of_units) }}" min="1">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Condominium Selection -->
                            <div class="col-md-6">
                                <label for="condominium_id" class="form-label">Condominium</label>
                                <select name="condominium_id" id="condominium_id" class="form-select">
                                    <option value="" disabled>Select a Condominium</option>
                                    @foreach ($condominiums as $condominium)
                                    <option value="{{ $condominium->id }}"
                                        {{ old('condominium_id', $block->condominium_id) == $condominium->id ? 'selected' : '' }}>
                                        {{ $condominium->name }}
                                    </option>
                                    @endforeach
                                </select>
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
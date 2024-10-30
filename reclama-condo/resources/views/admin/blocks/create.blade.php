<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Block') }}
        </h2>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.blocks') }}">Blocks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Block</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert-messages />

                    <form action="{{ route('admin.blocks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="condominium_id" class="form-label">Select Condominium</label>
                            <select name="condominium_id" id="condominium_id" class="form-select" required>
                                <option value="">Select a condominium</option>
                                @foreach ($condominiums as $condominium)
                                <option value="{{ $condominium->id }}">{{ $condominium->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="block" class="form-label">Block Name</label>
                            <input type="text" name="block" id="block" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="number_of_units" class="form-label">Number of Units</label>
                            <input type="number" name="number_of_units" id="number_of_units" class="form-control" required min="1">
                        </div>

                        <button type="submit" class="btn btn-primary">Create Block</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const condominiumSelect = document.getElementById('condominium_id');
            const blockSelect = document.getElementById('block');

            // Ativar ou desativar o campo de bloco
            condominiumSelect.addEventListener('change', function() {
                if (this.value) {
                    blockSelect.removeAttribute('disabled');
                } else {
                    blockSelect.setAttribute('disabled', 'disabled');
                }
            });

            // Adicione mais lógica aqui se necessário para carregar blocos baseados no condomínio selecionado
        });
    </script>

</x-app-layout>
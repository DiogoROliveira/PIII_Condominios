@extends('layouts.admin')

@section('title')
{{ __('Create Unit') }}
@endsection

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Create Unit')}}</h1>
                    <hr class="mb-4" />
                    <x-alert-messages />
                </div>
                <div class="me-4 ms-4 mb-4">
                    <form action="{{ route('admin.units.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <!-- Condominium -->
                            <div class="col-md-6">
                                <label for="condominium_id" class="form-label">{{__('Condominium')}}</label>
                                <select name="condominium_id" id="condominium_id" class="form-select">
                                    <option value="" disabled selected>{{__('Select a Condominium')}}</option>
                                    @foreach ($condominiums as $condominium)
                                    <option value="{{ $condominium->id }}">{{ $condominium->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Block -->
                            <div class="col-md-6">
                                <label for="block_id" class="form-label">{{__('Block')}}</label>
                                <select name="block_id" id="block_id" class="form-select" disabled>
                                    <option value="" disabled selected>{{ __('Select a Block') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Unit Number -->
                            <div class="col-md-6">
                                <label for="unit_number" class="form-label">{{__('Unit Number')}}</label>
                                <input type="number" name="unit_number" id="unit_number" class="form-control" placeholder="{{__('Unit Number')}}" min="1">
                            </div>
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="occupied">{{__('Occupied')}}</option>
                                    <option value="vacant">{{__('Vacant')}}</option>
                                    <option value="reserved">{{__('Reserved')}}</option>
                                    <option value="in repair">{{__('In Repair')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('Create Unit')}}</button>
                            <a href="{{ route('admin.units') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <script>
        document.getElementById('condominium_id').addEventListener('change', function() {
            const condominiumId = this.value;
            const blockSelect = document.getElementById('block_id');
            blockSelect.innerHTML = '<option value="" disabled selected>{{ __("Select a Block") }}</option>';

            if (condominiumId) {
                // if a condominium is selected, enable the block select
                blockSelect.disabled = false;

                // fetch blocks based on the selected condominium
                fetch(`/admin/dashboard/blocks/${condominiumId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(block => {
                            const option = document.createElement('option');
                            option.value = block.id;
                            option.textContent = block.block;
                            blockSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching blocks:', error));
            } else {
                // if the condominium is not selected, disable the block select
                blockSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>

@endsection
@extends('layouts.admin')

@section('title')
{{ __('Create Block') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Create Block')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.blocks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="condominium_id" class="form-label">{{__('Select Condominium')}}</label>
                            <select name="condominium_id" id="condominium_id" class="form-select" required>
                                <option value="">{{__('Select a condominium')}}</option>
                                @foreach ($condominiums as $condominium)
                                <option value="{{ $condominium->id }}">{{ $condominium->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="block" class="form-label">{{__('Block Name')}}</label>
                            <input type="text" name="block" id="block" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="number_of_units" class="form-label">{{__('Number of Units')}}</label>
                            <input type="number" name="number_of_units" id="number_of_units" class="form-control" required min="1">
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('Create Block')}}</button>
                        <a href="{{ route('admin.blocks') }}" class="btn btn-secondary">Cancel</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const condominiumSelect = document.getElementById('condominium_id');
            const blockSelect = document.getElementById('block');

            // enable block select if a condominium is selected
            condominiumSelect.addEventListener('change', function() {
                if (this.value) {
                    blockSelect.removeAttribute('disabled');
                } else {
                    blockSelect.setAttribute('disabled', 'disabled');
                }
            });

        });
    </script>

</x-app-layout>
@endsection
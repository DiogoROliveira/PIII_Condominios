@extends('layouts.admin')

@section('title')
{{ __('Edit Unit') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Unit')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Condominium -->
                            <div class="col-md-6">
                                <label for="condominium_id" class="form-label">{{__('Condominium')}}</label>
                                <select name="condominium_id" id="condominium_id" class="form-select" disabled>
                                    <option value="{{ $unit->block->condominium->id }}" selected>{{ $unit->block->condominium->name }}</option>

                                </select>
                            </div>

                            <!-- Block -->
                            <div class="col-md-6">
                                <label for="block_id" class="form-label">{{__('Block')}}</label>
                                <select name="block_id" id="block_id" class="form-select">
                                    <option value="" disabled>{{__('Select a Block')}}</option>
                                    @foreach ($blocks as $block)
                                    <option value="{{ $block->id }}" {{ old('block_id', $unit->block_id) == $block->id ? 'selected' : '' }}>
                                        {{ $block->block }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Unit Number -->
                            <div class="col-md-6">
                                <label for="unit_number" class="form-label">{{__('Unit Number')}}</label>
                                <input type="number" name="unit_number" id="unit_number" class="form-control"
                                    value="{{ old('unit_number', $unit->unit_number) }}" min="1">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="occupied" {{ old('status', $unit->status) == 'occupied' ? 'selected' : '' }}>{{__('Occupied')}}</option>
                                    <option value="vacant" {{ old('status', $unit->status) == 'vacant' ? 'selected' : '' }}>{{__('Vacant')}}</option>
                                    <option value="reserved" {{ old('status', $unit->status) == 'reserved' ? 'selected' : '' }}>{{__('Reserved')}}</option>
                                    <option value="in repair" {{ old('status', $unit->status) == 'in repair' ? 'selected' : '' }}>{{__('In Repair')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
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
</x-app-layout>
@endsection
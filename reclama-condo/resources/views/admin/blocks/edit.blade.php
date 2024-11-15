@extends('layouts.admin')

@section('title')
{{ __('Edit Block') }}
@endsection

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Block')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Block Name -->
                            <div class="col-md-6">
                                <label for="block" class="form-label">{{__('Block Name')}}</label>
                                <input type="text" name="block" id="block" class="form-control"
                                    value="{{ old('block', $block->block) }}" placeholder="{{__('Block Name')}}">
                            </div>

                            <!-- Number of Units -->
                            <div class="col-md-6">
                                <label for="number_of_units" class="form-label">{{__('Number of Units')}}</label>
                                <input type="number" name="number_of_units" id="number_of_units" class="form-control"
                                    value="{{ old('number_of_units', $block->number_of_units) }}" min="1">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Condominium Selection -->
                            <div class="col-md-6">
                                <label for="condominium_id" class="form-label">{{__('Condominium')}}</label>
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
                            <a href="{{ route('admin.blocks') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

@endsection
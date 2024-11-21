@extends('layouts.admin')

@section('title')
{{ __('Edit Condominium') }}
@endsection

@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Condominium')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.condominiums.update', $condominium->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{__('Name')}}</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $condominium->name) }}" placeholder="{{__('Condominium Name')}}">
                            </div>
                            <!-- Address -->
                            <div class="col-md-6">
                                <label for="address" class="form-label">{{__('Address')}}</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ old('address', $condominium->address) }}" placeholder="{{__('123 Main St')}}">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- City -->
                            <div class="col-md-4">
                                <label for="city" class="form-label">{{__('City')}}</label>
                                <input type="text" name="city" id="city" class="form-control"
                                    value="{{ old('city', $condominium->city) }}" placeholder="{{__('City (optional)')}}">
                            </div>
                            <!-- State -->
                            <div class="col-md-4">
                                <label for="state" class="form-label">{{__('State')}}</label>
                                <input type="text" name="state" id="state" class="form-control"
                                    value="{{ old('state', $condominium->state) }}" placeholder="{{__('State (optional)')}}">
                            </div>
                            <!-- Postal Code -->
                            <div class="col-md-4">
                                <label for="postal_code" class="form-label">{{__('Postal Code')}}</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control"
                                    value="{{ old('postal_code', $condominium->postal_code) }}" placeholder="{{__('Postal Code (optional)')}}">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">{{__('Phone')}}</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $condominium->phone) }}" placeholder="{{__('Phone (optional)')}}">
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">{{__('Email')}}</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $condominium->email) }}" placeholder="{{__('Email (optional)')}}">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Admin ID -->
                            <div class="col-md-6">
                                <label for="admin_id" class="form-label">{{__('Admin')}}</label>
                                <select name="admin_id" id="admin_id" class="form-select">
                                    <option value="" disabled>{{__('Select an Admin')}}</option>
                                    @foreach ($users as $user)
                                    @php
                                    $decryptedEmail = Crypt::decrypt($user->email);
                                    @endphp
                                    <option value="{{ $user->id }}"
                                        {{ old('admin_id', $condominium->admin_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $decryptedEmail }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Number of Blocks -->
                            <div class="col-md-6">
                                <label for="number_of_blocks" class="form-label">{{__('Number of Blocks')}}</label>
                                <input type="number" name="number_of_blocks" id="number_of_blocks" class="form-control"
                                    value="{{ old('number_of_blocks', $condominium->number_of_blocks) }}" min="1">
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.condominiums') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
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
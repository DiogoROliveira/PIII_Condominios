@extends('layouts.admin')

@section('title')
{{ __('Edit Complaint Type') }}
@endsection

@section('content')
<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Complaint Type')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.complaint-types.update', $complaintType->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">{{__('Name')}}</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $complaintType->name) }}" placeholder="{{__('Complaint Type Name')}}" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                            <a href="{{ route('admin.complaint-types') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
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
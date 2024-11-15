@extends('layouts.admin')

@section('title')
{{ __('Edit Complaint') }}
@endsection

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Edit Complaint')}}</h1>
                    <hr class="mb-4" />

                    <x-alert-messages />

                    <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>{{__('Pending')}}</option>
                                    <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>{{__('In Progress')}}</option>
                                    <option value="Solved" {{ $complaint->status == 'Solved' ? 'selected' : '' }}>{{__('Solved')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- User -->
                            <div class="col-md-6">
                                <label for="user" class="form-label">{{__('User')}}</label>
                                <input type="text" id="user" class="form-control" value="{{ $complaint->user->name ?? 'N/A' }}" readonly>
                            </div>

                            <!-- Complaint Type -->
                            <div class="col-md-6">
                                <label for="complaint_type" class="form-label">{{__('Complaint Type')}}</label>
                                <input type="text" id="complaint_type" class="form-control" value="{{ $complaint->complaintType->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label">{{__('Title')}}</label>
                                <input type="text" id="title" class="form-control" value="{{ $complaint->title }}" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="description" class="form-label">{{__('Description')}}</label>
                                <textarea id="description" class="form-control" rows="4" readonly>{{ $complaint->description }}</textarea>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Response -->
                            <div class="col-md-12">
                                <label for="response" class="form-label">{{__('Response')}}</label>
                                <textarea id="response" class="form-control" rows="4" name="response">{{ $complaint->response ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">{{__('Attachments')}}</label>
                            @if ($complaint->attachments->isNotEmpty())
                            <ul class="list-unstyled mt-3">
                                @foreach ($complaint->attachments as $attachment)
                                <li class="d-flex align-items-center mb-2 justify-content-between">
                                    <!-- Exibe o nome do arquivo -->
                                    <span class="file-name" style="flex-grow: 1; border-bottom: 1px dotted #ccc; padding-right: 10px;">
                                        {{ $attachment->name ?? __('Unnamed Attachment') }}
                                    </span>

                                    <!-- Botão de download -->
                                    <a href="{{ route('complaints.download', ['id' => $complaint->id, 'attachment' => $attachment->id]) }}" <i class="fa-solid fa-download ms-1" style="color: #414243"></i></a>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>{{__('No attachments available')}}</p>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
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
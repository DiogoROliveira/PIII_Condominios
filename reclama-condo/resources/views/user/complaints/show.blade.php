<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Complaints') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('complaints.index') }}">{{__('My Complaints')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{__('Complaint Details')}}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">{{__('Complaint Details')}}</h1>
                    <hr class="mb-4" />

                    <!-- Alerta de mensagens (se necessário) -->
                    <x-alert-messages />

                    <div class="row g-3 mb-4">
                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">{{__('Status')}}</label>
                            <input type="text" id="status" class="form-control" value="{{ $complaint->status }}" readonly>
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
                            <textarea id="response" class="form-control" rows="4" readonly>{{ $complaint->response ?? 'No response yet' }}</textarea>
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
                        <a href="{{ route('complaints.index') }}" class="btn btn-secondary">{{__('Back to Complaints')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as admin!") }}
                    <hr>
                    <p><a href="{{ route('admin.condominiums') }}" class="btn btn-primary">Condominiumns</a></p>
                    <p><a href="{{ route('admin.blocks') }}" class="btn btn-primary">Blocks</a></p>
                    <p><a href="{{ route('admin.units') }}" class="btn btn-primary">Units</a></p>
                    <p><a href="{{ route('admin.tenants') }}" class="btn btn-primary">Tenants</a></p>
                    <p><a href="{{ route('admin.complaint-types') }}" class="btn btn-primary">Complaint Types</a></p>
                    <p><a href="{{ route('admin.complaints') }}" class="btn btn-primary">Complaints</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
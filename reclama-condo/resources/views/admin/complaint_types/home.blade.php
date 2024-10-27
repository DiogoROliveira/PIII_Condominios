<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complaint Types') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="mb-4 text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <h3 class="text-lg font-medium mb-4">Total: {{ $total }}</h3>
                    <a href="{{ route('admin.complaint-types.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Complaint Type</a>

                    <table class="min-w-full mt-6">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaint_types as $complaintType)
                                <tr>
                                    <td class="border px-4 py-2">{{ $complaintType->id }}</td>
                                    <td class="border px-4 py-2">{{ $complaintType->name }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.complaint-types.edit', $complaintType->id) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('admin.complaint-types.destroy', $complaintType->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

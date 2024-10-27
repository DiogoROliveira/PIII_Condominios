<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Complaints') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Your Complaints</h3>

                    @if ($complaints->isEmpty())
                        <p class="text-gray-500">You have not submitted any complaints yet.</p>
                    @else
                        <table class="min-w-full mt-6">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Complaint Type</th>
                                    <th class="px-4 py-2">Title</th>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $complaint->id }}</td>
                                        <td class="border px-4 py-2">{{ $complaint->complaintType->name }}</td>
                                        <td class="border px-4 py-2">{{ $complaint->title }}</td>
                                        <td class="border px-4 py-2">{{ $complaint->description }}</td>
                                        <td class="border px-4 py-2">{{ $complaint->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

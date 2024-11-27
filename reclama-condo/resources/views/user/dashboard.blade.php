<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500">{{ __("Welcome back!") }}</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">
                        {{ __("You're logged in!") }}
                    </h3>
                    <hr class="mb-6">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Complaints Section -->
                        <div class="border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-300">
                            <div class="p-4 flex flex-col items-center text-center">
                                <div class="bg-blue-100 p-3 rounded-full text-blue-600 mb-3">
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">{{ __('Complaints') }}</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ __('View and manage your complaints.') }}
                                </p>
                                <a href="{{ route('complaints.index') }}" class="btn btn-primary w-full">
                                    {{ __('Go to Complaints') }}
                                </a>
                            </div>
                        </div>

                        <!-- My Rents Section -->
                        <div class="border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-300">
                            <div class="p-4 flex flex-col items-center text-center">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 mb-3">
                                    <i class="fas fa-home fa-2x"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">{{ __('My Rents') }}</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ __('Manage your rented properties and payments.') }}
                                </p>
                                <a href="{{ route('rents.index') }}" class="btn btn-primary w-full">
                                    {{ __('Go to My Rents') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <div class="text-center text-sm text-gray-500">
                        {{ __('Need help? Contact support at ') }}
                        <a href="mailto:support@example.com" class="text-blue-500 hover:underline">
                            support@example.com
                        </a>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-primary {
            background-color: #2563eb;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }
    </style>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-app-layout>
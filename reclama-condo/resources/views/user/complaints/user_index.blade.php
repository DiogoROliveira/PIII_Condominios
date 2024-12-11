<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Complaints') }}
        </h2>

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{__('My Complaints')}}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-alert-messages />

                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">{{__('Complaints List')}}</h1>
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">{{__('Add Complaint')}}</a>
                    </div>
                    <div class="table-responsive mt-6">
                        <table id="complaintsTable" class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">{{__('ID')}}</th>
                                    <th scope="col">{{__('Complaint Type')}}</th>
                                    <th scope="col">{{__('Title')}}</th>
                                    <th scope="col">{{__('Description')}}</th>
                                    <th scope="col">{{__('Status')}}</th>
                                    <th scope="col">{{__('Attachments')}}</th>
                                    <th scope="col">{{__('Response')}}</th>
                                    <th scope="col" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ __($complaint->complaintType->name) }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{{ $complaint->description }}</td>
                                    <td>{{ __($complaint->status) }}</td>
                                    <td class="text-center">
                                        @if ($complaint->attachments->isNotEmpty())
                                        {{ $complaint->attachments->count() }}
                                        <a href="{{ route('complaints.download', $complaint->id) }}">
                                            <i class="fa-solid fa-download ms-1" style="color: #414243"></i>
                                        </a>
                                        @else
                                        {{ __('N/A') }}
                                        @endif
                                    </td>
                                    <td>{{ $complaint->response ?? __('N/A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-file-lines"></i></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{__('No complaints available.')}}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DataTables and JavaScript -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var translations = {
                en: '//cdn.datatables.net/plug-ins/2.1.8/i18n/en-GB.json',
                pt: '//cdn.datatables.net/plug-ins/2.1.8/i18n/pt-PT.json',
            };

            var locale = "{{ app()->getLocale() }}";

            const table = $('#complaintsTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "url": translations[locale] || translations['en']
                },
                "buttons": ["excel", "pdf"],
                "dom": "<'row'<'col-md-6'Bl><'col-md-12'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-6'i><'col-md-12'p>>",
            });
        });
    </script>
</x-app-layout>
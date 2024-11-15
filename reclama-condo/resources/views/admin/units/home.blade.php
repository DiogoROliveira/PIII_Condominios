@extends('layouts.admin')

@section('title')
{{ __('Units') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <x-alert-messages />

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="card-title" style="font-size: 2rem">{{__('Units DataTable')}}</h1>

                    </div>
                    <div class="card-body">
                        <table id="unitsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('Condominium')}}</th>
                                    <th>{{__('Block')}}</th>
                                    <th>{{__('Unit Number')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created At')}}</th>
                                    <th class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $index => $unit)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $unit->block->condominium->name }}</td>
                                    <td>{{ $unit->block->block }}</td>
                                    <td>{{ $unit->unit_number }}</td>
                                    <td>{{ strtoupper($unit->status) }}</td>
                                    <td>{{ $unit->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-unit-id="{{ $unit->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('admin.units.create') }}" class="btn btn-primary ms-auto">{{__('Add Unit')}}</a>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">{{__('Confirm Delete')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{__('Are you sure you want to delete this unit?')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
        $('#unitsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#unitsTable_wrapper .col-md-6:eq(0)');

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const unitId = button.data('unit-id');
            $('#deleteForm').attr('action', `/admin/dashboard/units/${unitId}`);
        });
    });
</script>

@endsection
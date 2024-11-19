@extends('layouts.admin')

@section('title')
{{ __('Blocks & Units') }}
@endsection

@section('content')
<div class="container">

    <x-alert-messages />

    <h1>{{ $condominium->name }} - {{__('Blocks & Units')}}</h1>

    @foreach($condominium->blocks as $block)
    <h3>{{__('Block')}} {{ $block->block }}</h3>
    <table class="table table-striped mb-2">
        <thead>
            <tr>
                <th></th>
                <th>{{__('Unit')}}</th>
                <th>{{__('Tenant')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Base Rent')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($block->units as $unit)
            <tr>
                <td>
                    <input type="checkbox" name="units[]" value="{{ $unit->id }}" class="unit-checkbox">
                </td>
                <td>{{ $unit->unit_number }}</td>
                <td>{{ $unit->tenant->user->name ?? __('N/A') }}</td>
                <td>{{ strtoupper($unit->status) }}</td>
                <td>{{ $unit->base_rent ?? __('N/A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="button" class="btn btn-primary mb-4" id="open-modal">{{__('Post Rents')}}</button>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="rentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.manage-rents.payments') }}" method="POST" id="rent-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rentModalLabel">{{__('Rent Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="rent-details"></div>
                    <div>
                        <label for="due-date">{{__('Due Date')}}</label>
                        <input type="date" id="due-date" name="due_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-success">{{__('Confirm Launch')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<script>
    document.getElementById('open-modal').addEventListener('click', function() {
        const selectedUnits = document.querySelectorAll('.unit-checkbox:checked');
        if (selectedUnits.length === 0) {
            alert("{{ __('Select at least one unit.') }}");
            return;
        }

        let rentDetailsHtml = '';
        selectedUnits.forEach(unit => {
            const unitId = unit.value;
            const row = unit.closest('tr');
            const unitName = row.querySelector('td:nth-child(2)').innerText;
            const baseRent = row.querySelector('td:nth-child(5)').innerText;

            rentDetailsHtml += `
                <div class="form-group">
                    <label>{{__('Unit')}}: ${unitName}</label>
                    <input type="hidden" name="units[]" value="${unitId}">
                    <br>
                    <label for="base_rent_${unitId}">{{__('Rent Amount')}}</label>
                    <input type="number" step="0.01" id="base_rent_${unitId}" name="rents[${unitId}]" value="${baseRent !== '{{ __("N/A") }}' ? baseRent : ''}" class="form-control" required min="0">
                    <hr>
                </div>
            `;
        });

        document.getElementById('rent-details').innerHTML = rentDetailsHtml;
        $('#rentModal').modal('show');
    });
</script>
@endsection
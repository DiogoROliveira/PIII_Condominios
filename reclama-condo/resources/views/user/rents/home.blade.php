<x-app-layout>
    @foreach($units as $unit)

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$unit->unit_number}} - {{ $unit->block->block }} - {{ $unit->block->condominium->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Start Date: {{ $unit->tenant->lease_start_date }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">End Date: {{ $unit->tenant->lease_end_date }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">Base Rent: {{ $unit->base_rent }}</h6>
            </div>
        </div>
    </div>


    @endforeach

</x-app-layout>
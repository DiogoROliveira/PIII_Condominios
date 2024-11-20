@extends('layouts.admin')

@section('title')
{{ __('Rent Management') }}
@endsection

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">{{__('Condominiums')}}</h1>
    <div class="row">
        @foreach($condominiums as $condominium)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <!-- Small box -->
            <div class="small-box bg-info d-flex flex-column h-100">
                <div class="inner flex-grow-1">
                    <h4>{{ $condominium->name }}</h4>
                    <p>{{__('Blocks')}}: {{ $condominium->blocks->count() ?? 0 }}</p>
                    <p>{{__('Units')}}: {{ $condominium->units->count() ?? 0 }}</p>
                </div>
                <div class="icon mt-auto">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.manage-rents.blocks', $condominium->id) }}" class="small-box-footer">
                    {{ __('View More') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@endsection
@extends('layouts.admin')

@section('title')
{{ __('Dashboard') }}
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Dashboard')}}</h3>
                    </div>
                    <div class="card-body">
                        {{__('Welcome to the admin dashboard')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@endsection
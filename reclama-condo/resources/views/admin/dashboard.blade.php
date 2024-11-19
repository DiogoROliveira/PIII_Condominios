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

        <h1 class="mt-4 mb-4 ml-2">{{ __('Statistics') }}</h1>

        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>

                    <p>{{ __('User Registrations') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.users') }}" class="small-box-footer">
                    {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <hr class="my-4">

        <h1 class="mt-4">{{ __('Graphs') }}</h1>

        <!-- Google Charts -->


    </div>
</section>


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
@endsection
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header')
    @yield('styles')
    <title>{{ env('APP_NAME') }} </title>
</head>
<body class="@if(\App\Models\Setting::all()->first()['sidebar'] == 'dark')sidebar-dark @endif">
<div class="main-wrapper">

    @include('partials.admin.sidebar')

    <div class="page-wrapper">

        @include('partials.admin.topbar')

        <div class="page-content">
            @yield('breadcrumbs')

            @if (session('error'))
                <div class="alert alert-fill-danger" role="alert">
                    <i data-feather="alert-circle" class="mr-2"></i>
                    <strong style="font-size: 13px" class="small">{{ session('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session('success'))
                <div class="alert alert-fill-success" role="alert">
                    <i data-feather="check-circle" class="mr-2"></i>
                    <strong style="font-size: 13px" class="small">{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session('info'))
                <div class="alert alert-fill-warning" role="alert">
                    <i data-feather="check-circle" class="mr-2"></i>
                    <strong style="font-size: 13px" class="small">{{ session('info') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @yield('content')

            @yield('modals')

        </div>

        @include('partials.footer')
    </div>
</div>
@include('partials.scripts')
@yield('scripts')
</body>
</html>

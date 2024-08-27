<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.header')
    <title>{{ env('APP_NAME') }}  @yield('title')</title>
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-left-wrapper">

                                </div>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('partials.scripts')
</body>
</html>

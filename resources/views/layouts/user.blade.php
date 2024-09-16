<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header')
    @yield('styles')
    <title>{{ env('APP_NAME') }}  @isset($title) | @endisset {{ $title ?? '' }} </title>
    
</head>
<body>
<div class="main-wrapper">

    @include('partials.user.sidebar')

    <div class="page-wrapper">

        @include('partials.user.topbar')

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

            @include('partials.user.modal.naira')

        </div>

        @include('partials.footer')
    </div>
</div>
    <script src="{{ asset('asset/js/toasts.js') }}"></script>
    @include('partials.scripts')
    @yield('scripts')
    {{-- <script src="https://desk.zoho.com/portal/api/feedbackwidget/691549000000186183?orgId=769978518&displayType=popout"></script> --}}
    <script>
        $(document).ready(function (){
            let payment = $('#paymentDeposit');
            let bankDetails = $('#bankDetailsForDepositForm');
            let securedLogo = $('#securedByPaystackLogo');
            payment.on('change', function (){
                if (payment.val() === 'deposit'){
                    bankDetails.show(500);
                    securedLogo.hide(500);
                }else {
                    bankDetails.hide(500);
                    securedLogo.show(500);
                }
            });
        });
    </script>
</body>
</html>

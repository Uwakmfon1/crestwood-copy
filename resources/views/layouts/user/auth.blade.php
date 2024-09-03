<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ env('APP_NAME') }}  @yield('title') </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
<meta name="keywords" content="dashboard template,dashboard html,bootstrap admin,dashboard admin,admin template,sales dashboard,crypto dashboard,projects dashboard,html template,html,html css,admin dashboard template,html css bootstrap,dashboard html css,pos system,bootstrap dashboard">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('asset/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('asset/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('asset/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{ asset('asset/css/styles.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('asset/css/icons.css') }}" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="{{ asset('asset/libs/node-waves/waves.min.css') }}" rel="stylesheet" > 

    <!-- Simplebar Css -->
    <link href="{{ asset('asset/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('asset/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('asset/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('asset/libs/flatpickr/flatpickr.min.css') }}">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="{{ asset('asset/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">


    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('asset/libs/flatpickr/flatpickr.min.css') }}">


</head>

<body class="authentication-background">


    @yield('content')
   
    <!-- Bootstrap JS -->
    <script src="{{ asset('asset/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('asset/js/show-password.js') }}"></script>

    <!-- Custom-Switcher JS -->
    <script src="{{ asset('asset/js/custom-switcher.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('asset/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Vanilla-Wizard JS -->
    <script src="{{ asset('asset/libs/vanilla-wizard/js/wizard.min.js') }}"></script>

    <!-- Internal Form Wizard JS -->
    <script src="{{ asset('asset/js/form-wizard.js') }}"></script>
    <script src="{{ asset('asset/js/form-wizard-init.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('asset/js/custom.js') }}"></script>

    @yield('scripts')

</body>

</html>
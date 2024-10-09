 <!-- Start::app-sidebar -->
 <aside class="app-sidebar sticky" id="sidebar">

<!-- Start::main-sidebar-header -->
<div class="main-sidebar-header">
    <a href="index.html" class="header-logo">
        <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
        <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
        <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
    </a>
</div>
<!-- End::main-sidebar-header -->

<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
        

        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Main</span></li>
            <!-- End::slide__category -->

            

            <li class="slide @if(request()->routeIs(['dashboard', 'dashboard.investment', 'dashboard.trading'])) active @endif">
                <a href="{{ route('dashboard') }}" class="side-menu__item">
                    <i class="fe fe-home mx-2"></i>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>

            <li class="slide @if(request()->routeIs(['investments'])) active @endif">
                <a href="{{ route('investments') }}" class="side-menu__item">
                    <i class="fe fe-inbox mx-2"></i>
                    <span class="side-menu__label">Investment</span>
                </a>
            </li>

             <!-- Start::slide -->
             <li class="slide has-sub @if(request()->routeIs(['savings', 'savings.create'])) active @endif">
                <a href="javascript:void(0);" class="side-menu__item">
                    <i class="fe fe-dollar-sign mx-2"></i>
                    <span class="side-menu__label">Savings <span class="mx-2 badge bg-info-transparent">Coming soon</span> </span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">
                    <!-- <li class="slide">
                        <a href="{{ route('savings') }}" class="side-menu__item @if(request()->routeIs(['savings'])) active @endif">My Savings</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('savings.create') }}" class="side-menu__item @if(request()->routeIs(['savings.create'])) active @endif">New Savings</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('savings.history') }}" class="side-menu__item @if(request()->routeIs(['savings.history'])) active @endif">History</a>
                    </li> -->
                </ul>
            </li>
            <!-- End::slide -->

            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Trade</span></li>
             <!-- End::slide__category -->

            <li class="slide has-sub @if(request()->routeIs(['tradings', 'assets'])) active @endif">
                <a href="javascript:void(0);" class="side-menu__item">
                <i class="fe fe-tag mx-2"></i>
                    <span class="side-menu__label">Stocks</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">
                    <li class="slide">
                        <a href="{{ route('tradings') }}" class="side-menu__item @if(request()->routeIs(['tradings'])) active @endif">Stocks</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('assets') }}" class="side-menu__item @if(request()->routeIs(['assets'])) active @endif">Holdings</a>
                    </li>
                </ul>
            </li>

            <li class="slide has-sub @if(request()->routeIs(['crypto', 'crypto.assets'])) active @endif">
                <a href="javascript:void(0);" class="side-menu__item">
                <i class="fe fe-dollar-sign mx-2"></i>
                    <span class="side-menu__label">Crypto</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">
                    <li class="slide">
                        <a href="{{ route('crypto') }}" class="side-menu__item @if(request()->routeIs(['crypto'])) active @endif">Crypto</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('crypto.assets') }}" class="side-menu__item @if(request()->routeIs(['crypto.assets'])) active @endif">Assets</a>
                    </li>
                </ul>
            </li>

            <!-- <li class="slide @if(request()->routeIs(['asset'])) active @endif">
                <a href="{{ route('assets') }}" class="side-menu__item">
                    <i class="fe fe-credit-card mx-2"></i>
                    <span class="side-menu__label">History</span>
                </a>
            </li> -->
          
            
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Finance</span></li>
            <!-- End::slide__category -->

            <li class="slide @if(request()->routeIs(['wallet'])) active @endif">
                <a href="{{ route('wallet') }}" class="side-menu__item">
                    <i class="fe fe-dollar-sign mx-2"></i>
                    <span class="side-menu__label">Cash</span>
                </a>
            </li>

            <li class="slide @if(request()->routeIs(['transactions.history'])) active @endif">
                <a href="{{ route('transactions.history') }}" class="side-menu__item">
                    <i class="fe fe-dollar-sign mx-2"></i>
                    <span class="side-menu__label">History</span>
                </a>
            </li>

            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Account</span></li>
            <!-- End::slide__category -->

            <!-- <li class="slide @if(request()->routeIs(['profile'])) active @endif">
                <a href="{{ route('profile') }}" class="side-menu__item">
                    <i class="fe fe-user mx-2"></i>
                    <span class="side-menu__label">Profile</span>
                </a>
            </li> -->

            <li class="slide @if(request()->routeIs(['profile'])) active @endif">
                <a href="{{ route('profile') }}" class="side-menu__item">
                    <i class="fe fe-settings mx-2"></i>
                    <span class="side-menu__label">Settings</span>
                </a>
            </li>

            <li class="slide">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <a href="#" class="side-menu__item" id="logout">
                        <i class="ti ti-logout mx-2"></i>
                        <span class="side-menu__label">Log out</span>
                    </a>
                </form>
            </li>


        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
    </nav>
    <!-- End::nav -->

</div>
<!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->

<style>
    form:hover .side-menu__item {
        background-color: transparent !important; /* Change this to your desired color */
    }
</style>

<script>
    $(document).ready(function() {
        $('#logout').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            $(this).closest('form').submit(); // Submit the form
        });
    });
</script>
 

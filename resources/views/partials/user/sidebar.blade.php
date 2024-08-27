<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand mx-auto">
           <img src="{{ asset('assets/images/logos/sandbox-dashboard-logo-large.png') }}" width="150px" class="img-fluid" alt="Logo">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item @if(request()->routeIs(['dashboard', 'dashboard.investment', 'dashboard.trading'])) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#dashboard" role="button" aria-expanded="false" aria-controls="investment">
                    <i class="link-icon" data-feather="grid"></i>
                    <span class="link-title">Dashboard</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="dashboard">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs(['dashboard'])) text-primary @endif">Quick Overview</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('dashboard.investment') }}" class="nav-link @if(request()->routeIs(['dashboard.investment'])) text-primary @endif">Investment</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.trading') }}" class="nav-link @if(request()->routeIs(['dashboard.trading'])) text-primary @endif">Savings</a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item @if(request()->is('transactions')) active @endif">
                <a href="{{ route('transactions') }}" class="nav-link">
                    <i class="link-icon" data-feather="command"></i>
                    <span class="link-title">Transactions</span>
                </a>
            </li>

            <li class="nav-item nav-category">Investment</li>

            <li class="nav-item @if(request()->is('packages')) active @endif">
                <a href="{{ route('packages') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Packages</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('invest')) active @endif">
                <a href="{{ route('invest') }}" class="nav-link">
                    <i class="link-icon" data-feather="tag"></i>
                    <span class="link-title">New Investment</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('investments') || request()->routeIs(['investments.show'])) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#investment" role="button" aria-expanded="false" aria-controls="investment">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">My Investments</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="investment">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('investments') }}" class="nav-link @if(request()->is('investments') && !request()->offsetExists('active') && !request()->offsetExists('cancelled') && !request()->offsetExists('pending') && !request()->offsetExists('settled')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investments', 'active') }}" class="nav-link @if(request()->offsetExists('active')) text-primary @endif">Active</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investments', 'pending') }}" class="nav-link @if(request()->offsetExists('pending')) text-primary @endif">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investments', 'cancelled') }}" class="nav-link @if(request()->offsetExists('cancelled')) text-primary @endif">Cancelled</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('investments', 'settled') }}" class="nav-link @if(request()->offsetExists('settled')) text-primary @endif">Settled</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Savings</li>

            <li class="nav-item @if(request()->is('savingsPackage')) active @endif">
                <a href="{{ route('savingsPackage') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Packages</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('savings.create')) active @endif">
                <a href="{{ route('savings.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="tag"></i>
                    <span class="link-title">New Savings</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('savings')) active @endif">
                <a href="{{ route('savings') }}" class="nav-link">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">My Savings</span>
                </a>
            </li>

            <li class="nav-item nav-category">Trading</li>

            <li class="nav-item @if(request()->is('savings.create')) active @endif">
                <a href="{{ route('savings.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="tag"></i>
                    <span class="link-title">New Trade</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('savings')) active @endif">
                <a href="{{ route('tradings') }}" class="nav-link">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">My Trades</span>
                </a>
            </li>
            {{-- <li class="nav-item @if(request()->is('transactions')) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#transaction" role="button" aria-expanded="false" aria-controls="transaction">
                    <i class="link-icon" data-feather="command"></i>
                    <span class="link-title">Transactions</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="transaction">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('transactions') }}" class="nav-link @if(request()->is('transactions') && !request()->offsetExists('withdrawal') && !request()->offsetExists('deposit') && !request()->offsetExists('others')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transactions', 'withdrawal') }}" class="nav-link @if(request()->offsetExists('withdrawal')) text-primary @endif">Withdrawals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transactions', 'deposit') }}" class="nav-link @if(request()->offsetExists('deposit')) text-primary @endif">Deposits</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transactions', 'others') }}" class="nav-link @if(request()->offsetExists('others')) text-primary @endif">Others</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
{{--            <li class="nav-item @if(request()->is('trades')) active @endif">--}}
{{--                <a class="nav-link" data-toggle="collapse" href="#trade" role="button" aria-expanded="false" aria-controls="trade">--}}
{{--                    <i class="link-icon" data-feather="trending-up"></i>--}}
{{--                    <span class="link-title">Trades</span>--}}
{{--                    <i class="link-arrow" data-feather="chevron-down"></i>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="trade">--}}
{{--                    <ul class="nav sub-menu">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('trades') }}" class="nav-link @if(request()->is('trades') && !request()->offsetExists('buy') && !request()->offsetExists('sell')) text-primary @endif">All</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('trades', 'buy') }}" class="nav-link @if(request()->offsetExists('buy')) text-primary @endif">Buy</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('trades', 'sell') }}" class="nav-link @if(request()->offsetExists('sell')) text-primary @endif">Sell</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <li class="nav-item nav-category">Trade</li>--}}
{{--            <li class="nav-item @if(request()->is('buy')) active @endif">--}}
{{--                <a href="{{ route('buy') }}" class="nav-link">--}}
{{--                    <i class="link-icon @if(request()->is('buy')) text-primary @else text-success @endif" data-feather="trending-up"></i>--}}
{{--                    <span class="link-title">Buy</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item @if(request()->is('sell')) active @endif">--}}
{{--                <a href="{{ route('sell') }}" class="nav-link">--}}
{{--                    <i class="link-icon @if(request()->is('sell')) text-primary @else text-danger @endif" data-feather="trending-down"></i>--}}
{{--                    <span class="link-title">Sell</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item @if(request()->is('market')) active @endif">--}}
{{--                <a href="{{ route('market') }}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="bar-chart-2"></i>--}}
{{--                    <span class="link-title">Statistics / Market</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li class="nav-item nav-category">Wallet</li>

            <li class="nav-item @if(request()->is('wallet')) active @endif">
                <a href="{{ route('wallet') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Wallets</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-toggle="modal" data-target="#nairaDepositModal" href="#" class="nav-link">
                    <i class="link-icon text-dark" data-feather="corner-up-right"></i>
                    <span class="link-title">Deposit</span>
                </a>
            </li>
            <li class="nav-item">
                @if(\App\Models\Setting::all()->first()['withdrawal'] == 1)
                <a data-toggle="modal" data-target="#nairaWithdrawalModal" href="#" class="nav-link">
                    <i class="link-icon" data-feather="corner-down-left"></i>
                    <span class="link-title">Withdrawal</span>
                </a>
                @else
                    <button class="nav-link btn p-0 text-secondary">
                        <i class="link-icon" data-feather="corner-down-left"></i>
                        <span class="link-title">Withdrawal</span>
                    </button>
                @endif
            </li>
            <li class="nav-item nav-category">Account</li>
            <li class="nav-item @if(request()->is('profile')) active @endif">
                <a href="{{ route('profile') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Profile</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('referrals')) active @endif">
                <a href="{{ route('referrals') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Referrals</span>
                </a>
            </li>
            <li class="nav-item @if(request()->is('notifications') || request()->routeIs(['notifications.show'])) active @endif">
                <a href="{{ route('notifications') }}" class="nav-link">
                    <i class="link-icon" data-feather="bell"></i>
                    <span class="link-title">Notifications
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="badge badge-pill ml-2 badge-primary">New</span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <button class="btn p-0 nav-link" onclick="confirmFormSubmit('logout-form')">
                    <i class="link-icon" data-feather="log-out"></i>
                    <span class="link-title">Logout</span>
                </button>
            </li>
        </ul>
    </div>
</nav>

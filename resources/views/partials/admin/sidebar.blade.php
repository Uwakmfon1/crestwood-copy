@php
    $trxs = \App\Models\Transaction::query()->where('status', 'pending')->count();
    $invs = \App\Models\Investment::query()->where('status', 'pending')->count();

    $trds = \App\Models\Trade::query()->where('type', 'pending')->count();
    
@endphp
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand mx-auto">
            {{-- <img src="{{ asset('assets/images/logos/sandbox-dashboard-logo-large.png') }}" width="150px" class="img-fluid" alt="Logo"> --}}
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
            @if(auth()->user()->can('View Quick Overview') || auth()->user()->can('View Investment Dashboard') || auth()->user()->can('View Trading Dashboard'))
{{--            <li class="nav-item @if(request()->routeIs(['admin.dashboard', 'admin.dashboard.investment', 'admin.dashboard.trading'])) active @endif">--}}
{{--                <a class="nav-link" data-toggle="collapse" href="#dashboard" role="button" aria-expanded="false" aria-controls="investment">--}}
{{--                    <i class="link-icon" data-feather="grid"></i>--}}
{{--                    <span class="link-title">Dashboard</span>--}}
{{--                    <i class="link-arrow" data-feather="chevron-down"></i>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="dashboard">--}}
{{--                    <ul class="nav sub-menu">--}}
{{--                        @can('View Quick Overview')--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs(['admin.dashboard'])) text-primary @endif">Quick Overview</a>--}}
{{--                        </li>--}}
{{--                        @endcan--}}
{{--                        @can('View Investment Dashboard')--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.dashboard.investment') }}" class="nav-link @if(request()->routeIs(['admin.dashboard.investment'])) text-primary @endif">Investment</a>--}}
{{--                        </li>--}}
{{--                        @endcan--}}
{{--                        @can('View Trading Dashboard')--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.dashboard.trading') }}" class="nav-link @if(request()->routeIs(['admin.dashboard.trading'])) text-primary @endif">Trading</a>--}}
{{--                        </li>--}}
{{--                        @endcan--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item @if(request()->is('admin.dashboard')) active @endif">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="grid"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            @endif
            @can('View Packages')
            <!-- <li class="nav-item @if(request()->routeIs(['admin.packages', 'admin.packages.create', 'admin.packages.edit'])) active @endif">
                <a href="{{ route('admin.packages') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Packages</span>
                </a>
            </li> -->
            <li class="nav-item @if(request()->is('admin.saving.package') || request()->routeIs(['admin.packages'])) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#savings" role="button" aria-expanded="false" aria-controls="savings">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Packages </span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="savings">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.packages') }}" class="nav-link @if(request()->is('admin/investments') && !request('type')) text-primary @endif">Investment</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.saving.package') }}" class="nav-link @if(request('type') == 'active') text-primary @endif">Savings</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('View Users')
            <li class="nav-item @if(request()->routeIs(['admin.users', 'admin.users.show', 'admin.users.trades.buy', 'admin.users.trades.sell', 'admin.users.invest', 'admin.users.investment.show'])) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="investment">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link @if(request()->is('admin/users') && !request()->offsetExists('verified') && !request()->offsetExists('unverified')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users', 'verified') }}" class="nav-link @if(request()->offsetExists('verified')) text-primary @endif">Verified</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users', 'unverified') }}" class="nav-link @if(request()->offsetExists('unverified')) text-primary @endif">Unverified</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('View Investments')
            <li class="nav-item @if(request()->is('admin/investments') || request()->routeIs(['admin.investments.show'])) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#investment" role="button" aria-expanded="false" aria-controls="investment">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Investments @if($invs > 0) <span class="badge badge-primary badge-pill px-2">{{ $invs }}</span> @endif</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="investment">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.investments') }}" class="nav-link @if(request()->is('admin/investments') && !request('type')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.investments', ['type' => 'active']) }}" class="nav-link @if(request('type') == 'active') text-primary @endif">Active</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.investments', ['type' => 'pending']) }}" class="nav-link @if(request('type') == 'pending') text-primary @endif">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.investments', ['type' => 'cancelled']) }}" class="nav-link @if(request('type') == 'cancelled') text-primary @endif">Cancelled</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.investments', ['type' => 'settled']) }}" class="nav-link @if(request('type') == 'settled') text-primary @endif">Settled</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('View Investments')
            <li class="nav-item @if(request()->is('admin/savings') || request()->routeIs(['admin.savings.show'])) active @endif">
                {{-- <a class="nav-link" data-toggle="collapse" href="#saving" role="button" aria-expanded="false" aria-controls="investment">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Savings @if($save > 0) <span class="badge badge-primary badge-pill px-2">{{ $save }}</span> @endif</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a> --}}
                <div class="collapse" id="saving">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.savings') }}" class="nav-link @if(request()->is('admin/savings') && !request('type')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.savings', ['type' => 'active']) }}" class="nav-link @if(request('type') == 'active') text-primary @endif">Active</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.savings', ['type' => 'pending']) }}" class="nav-link @if(request('type') == 'pending') text-primary @endif">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.savings', ['type' => 'cancelled']) }}" class="nav-link @if(request('type') == 'cancelled') text-primary @endif">Cancelled</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.savings', ['type' => 'settled']) }}" class="nav-link @if(request('type') == 'settled') text-primary @endif">Settled</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('View Investments Maturity')
            <li class="nav-item @if(request()->routeIs(['admin.investment.maturity'])) active @endif">
                <a href="{{ route('admin.investment.maturity') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Investments Maturity</span>
                </a>
            </li>
            @endcan
            @can('View Transactions')
            <li class="nav-item @if(request()->is('admin/transactions')) active @endif">
                <a class="nav-link" data-toggle="collapse" href="#transaction" role="button" aria-expanded="false" aria-controls="transaction">
                    <i class="link-icon" data-feather="command"></i>
                    <span class="link-title">Transactions @if($trxs > 0) <span class="badge badge-primary badge-pill px-2">{{ $trxs }}</span> @endif</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="transaction">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions') }}" class="nav-link @if(request()->is('admin/transactions') && !request()->offsetExists('pending') && !request()->offsetExists('withdrawal') && !request()->offsetExists('deposit') && !request()->offsetExists('others')) text-primary @endif">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions', 'pending') }}" class="nav-link @if(request()->offsetExists('pending')) text-primary @endif">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions', 'withdrawal') }}" class="nav-link @if(request()->offsetExists('withdrawal')) text-primary @endif">Withdrawals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions', 'deposit') }}" class="nav-link @if(request()->offsetExists('deposit')) text-primary @endif">Deposits</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions', 'others') }}" class="nav-link @if(request()->offsetExists('others')) text-primary @endif">Others</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
{{--            @can('View Trades')--}}
{{--            <li class="nav-item @if(request()->is('admin/trades')) active @endif">--}}
{{--                <a class="nav-link" data-toggle="collapse" href="#trade" role="button" aria-expanded="false" aria-controls="trade">--}}
{{--                    <i class="link-icon" data-feather="trending-up"></i>--}}
{{--                    <span class="link-title">Trades @if($trds > 0) <span class="badge badge-primary badge-pill px-2">{{ $trds }}</span> @endif</span>--}}
{{--                    <i class="link-arrow" data-feather="chevron-down"></i>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="trade">--}}
{{--                    <ul class="nav sub-menu">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.trades') }}" class="nav-link @if(request()->is('admin/trades') && !request()->offsetExists('buy') && !request()->offsetExists('sell')) text-primary @endif">All</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.trades', 'buy') }}" class="nav-link @if(request()->offsetExists('buy')) text-primary @endif">Buy</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="{{ route('admin.trades', 'sell') }}" class="nav-link @if(request()->offsetExists('sell')) text-primary @endif">Sell</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            @endcan--}}
            @can('View Payments')
                <li class="nav-item @if(request()->routeIs(['admin.payments.index'])) active @endif">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="credit-card"></i>
                        <span class="link-title">Online Payments @if($pyts > 0) <span class="badge badge-primary badge-pill px-2">{{ $pyts }}</span> @endif</span>
                    </a>
                </li>
            @endcan
{{--            @can('View Market / Statistics')--}}
{{--            <li class="nav-item @if(request()->routeIs(['admin.market'])) active @endif">--}}
{{--                <a href="{{ route('admin.market') }}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="bar-chart-2"></i>--}}
{{--                    <span class="link-title">Statistics / Market</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @endcan--}}
{{--            @can('View Market / Statistics')--}}
{{--            <li class="nav-item @if(request()->routeIs(['admin.referrals'])) active @endif">--}}
{{--                <a href="{{ route('admin.referrals') }}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="users"></i>--}}
{{--                    <span class="link-title">Referrals Leaderboard</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @endcan--}}
{{--            <li class="nav-item @if(request()->routeIs('admin.referrals')) active @endif">--}}
{{--                <a href="{{ route('admin.referrals') }}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="users"></i>--}}
{{--                    <span class="link-title">Referrals</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            @can('View Emails')
            <li class="nav-item @if(request()->routeIs(['admin.email', 'admin.email.show', 'admin.email.create'])) active @endif">
                <a href="{{ route('admin.email') }}" class="nav-link">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Notification Management</span>
                </a>
            </li>
            @endcan
            @if(auth()->user()->can('View Admins') || auth()->user()->can('View Roles'))
            <li class="nav-item nav-category">Admin Management</li>
            @endif
            @can('View Admins')
            <li class="nav-item @if(request()->routeIs(['admin.admins', 'admin.admins.create'])) active @endif">
                <a href="{{ route('admin.admins') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">All Admin</span>
                </a>
            </li>
            @endcan
            @can('View Roles')
            <li class="nav-item @if(request()->routeIs(['admin.roles', 'admin.roles.create', 'admin.roles.edit'])) active @endif">
                <a href="{{ route('admin.roles') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Roles / Permissions</span>
                </a>
            </li>
            @endcan
            <li class="nav-item nav-category">Personal</li>
            <li class="nav-item @if(request()->routeIs(['admin.profile'])) active @endif">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Profile</span>
                </a>
            </li>
            @can('View Settings')
            <li class="nav-item @if(request()->routeIs(['admin.settings'])) active @endif">
                <a href="{{ route('admin.settings') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <button class="btn p-0 nav-link" onclick="confirmFormSubmit('logout-form')">
                    <i class="link-icon" data-feather="log-out"></i>
                    <span class="link-title">Logout</span>
                </button>
            </li>
        </ul>
    </div>
</nav>

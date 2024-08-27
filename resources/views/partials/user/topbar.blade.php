<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            <li class="nav-item d-md-flex d-none dropdown nav-apps">
                <a href="{{ route('wallet') }}" class="mx-2">
                    <p style="font-size: 9px">Naira Balance</p>
                    <p>₦ {{ number_format(auth()->user()->walletBalance(), 2) }}</p>
                </a>
{{--                <a href="{{ route('wallet') }}" class="mx-3">--}}
{{--                    <p style="font-size: 9px">Gold Balance</p>--}}
{{--                    <p>{{ round(auth()->user()['goldWallet']['balance'], 6) }} grams</p>--}}
{{--                </a>--}}
{{--                <a href="{{ route('wallet') }}" class="mx-3">--}}
{{--                    <p style="font-size: 9px">Silver Balance</p>--}}
{{--                    <p>{{ round(auth()->user()['silverWallet']['balance'], 6) }} grams</p>--}}
{{--                </a>--}}
            </li>
            <li class="nav-item dropdown nav-apps">
                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="appsDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium">Quick Actions</p>
                    </div>
                    <div class="dropdown-body">
                        <div class="d-flex align-items-center apps">
                            <a  data-toggle="modal" data-target="#nairaDepositModal" href="#"><i data-feather="trending-up" class="text-success icon-lg"></i><p>Deposit</p></a>
                            <a data-toggle="modal" data-target="#nairaWithdrawalModal" href="#"><i data-feather="trending-down" class="icon-lg text-danger"></i><p>Withdraw</p></a>
                            <a href="{{ route('invest') }}"><i data-feather="tag" class="icon-lg"></i><p>Invest</p></a>
                            <a href="{{ route('market') }}"><i data-feather="dollar-sign" class="icon-lg"></i><p>Save</p></a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown nav-notifications">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                    <div class="indicator">
                        <div class="circle"></div>
                    </div>
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <p class="mb-0 font-weight-medium">{{ auth()->user()->unreadNotifications()->count() }} New Notifications</p>
                            <a href="{{ route('notifications.read') }}" class="text-muted">Mark all as read</a>
                        @endif
                    </div>
                    <div class="dropdown-body dropdown-body-notification">
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            @foreach (auth()->user()->unreadNotifications()->get() as $notification)
                                <a href="{{ route('notifications.show', $notification['id']) }}" class="dropdown-item notify-danger">
                                    {!! $notification['data']['icon'] !!}
                                    <div class="content">
                                        <p>{{ $notification['data']['title'] }}</p>
                                        <p class="sub-text text-muted">{{ $notification['created_at']->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <a href="javascript:;" class="dropdown-item disabled">
                                <p>No new notification(s)</p>
                            </a>
                        @endif
                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="{{ route('notifications') }}">View all</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="custom-name-avatar custom-name-avatar-sm">{{ auth()->user()->getNameAvatar() }}</div>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <div class="custom-name-avatar custom-name-avatar-lg">{{ auth()->user()->getNameAvatar() }}</div>
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ auth()->user()['name'] }}</p>
                            <p class="email text-muted mb-3">{{ auth()->user()['email'] }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="{{ route('profile') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <button class="btn p-0 nav-link" onclick="confirmFormSubmit('logout-form')">
                                    <i class="link-icon" data-feather="log-out"></i>
                                    <span class="link-title">Logout</span>
                                </button>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

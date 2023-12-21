<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
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
                                <a href="{{ route('admin.profile') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            @can('View Settings')
                            <li class="nav-item">
                                <a href="{{ route('admin.settings') }}" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <button class="btn p-0 nav-link" onclick="confirmFormSubmit('logout-form')">
                                    <i class="link-icon" data-feather="log-out"></i>
                                    <span class="link-title">Logout</span>
                                </button>
                            </li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

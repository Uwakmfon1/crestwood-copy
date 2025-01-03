@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <style>
        html{
            scroll-behavior: smooth;
        }
    </style>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row profile-body">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <a href="#userInfo" class="btn btn-sm btn-primary">Info</a>
                    <a href="#wallets" class="btn btn-sm btn-primary">Wallets</a>
{{--                    <a href="#trades" class="btn btn-sm btn-primary">Trades</a>--}}
                    <a href="#investments" class="btn btn-sm btn-primary">Investments</a>
                    <a href="#saving" class="btn btn-sm btn-primary">Savings</a>
                    <a href="#referrals" class="btn btn-sm btn-primary">Referrals</a>
                </div>
            </div>
        </div>
        <div id="userInfo" class="col-lg-3 col-md-4 left-wrapper">
            <div class="row flex-md-column flex-column-reverse">
                <div class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="d-flex mb-3 align-items-center">
                                @if($user->getAvatar())
                                    <img width="80px"  src="{{ $user->getAvatar() }}" style="border-radius: 5px" alt="{{ $user['name'] }}">
                                @else
                                    <div class="custom-name-avatar custom-name-avatar-lg" style="border-radius: 5px;">{{ $user->getNameAvatar() }}</div>
                                @endif
                                <div class="ml-2">
                                    <h6>{{ $user['name'] }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="card-title mb-0">Personal Information</h6>
                            </div>
                            <div class="mt-2">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                                <p class="text-muted">{{ $user['email'] }}</p>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Phone:</label>
                                        <p class="text-muted">{{ $user->getPhone() }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Country:</label>
                                        <p class="text-muted">{{ $user['country'] ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">State:</label>
                                        <p class="text-muted">{{ $user['state'] ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">City:</label>
                                        <p class="text-muted">{{ $user['city'] ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Address:</label>
                                        <p class="text-muted">{{ $user['address'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Joined:</label>
                                        <p class="text-muted">{{ $user['created_at']->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Bank Details</h6>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Bank Name:</label>
                                        <p class="text-muted">{{ $user['bank_name'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Account No:</label>
                                        <p class="text-muted">{{ $user['account_number'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Account Name:</label>
                                        <p class="text-muted">{{ $user['account_name'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Crypto Wallet</h6>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Cryptocurrency:</label>
                                        <div id="coin-select"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Network:</label>
                                        <div id="network-select"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Wallet Address:</label>
                                        <p class="fw-bold">{{ $user['wallet_address'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Next of Kin Details</h6>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Full Name:</label>
                                        <p class="text-muted">{{ $user['nk_name'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Phone:</label>
                                        <p class="text-muted">{{ $user['nk_phone'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Address:</label>
                                        <p class="text-muted">{{ $user['nk_address'] ?? 'Not set' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Identification</h6>
                            </div>
                            @if($user['identification'])
                                <div class="mt-2">
                                    <img class="img-fluid" style="border-radius: 5px" src="{{ asset($user['identification']) }}" alt="Identification">
                                </div>
                                <div class="mt-2 text-right">
                                    <button onclick="confirmFormSubmit('downloadFileForm')" class="btn btn-sm btn-primary"><i class="icon-sm" data-feather="download"></i></button>
                                    <form id="downloadFileForm" action="{{ route('admin.download') }}" method="POST">
                                        @csrf
                                        <label>
                                            <input type="hidden" name="path" value="{{ $user['identification'] }}">
                                        </label>
                                    </form>
                                </div>
                            @else
                                <div class="mt-2">
                                    <p class="text-muted">Not Set</p>
                                </div>
                            @endif
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Proof of Address</h6>
                                <span class="badge @if($user['is_approved'] == 'pending') bg-warning @elseif($user['is_approved'] == 'decline') bg-danger @else bg-success @endif text-light">
                                    @if($user['is_approved'] == 'pending') Pending @elseif($user['is_approved'] == 'decline') Declined @else Approved @endif
                                </span>
                            </div>
                            @if($user['proof'])
                                <div class="mt-2">
                                    <img class="img-fluid" style="border-radius: 5px" src="{{ asset($user['proof']) }}" alt="proof">
                                </div>
                                <div class="mt-2 text-right">
                                    <form id="actionForm" action="{{ route('admin.user.proof', $user['id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" id="actionField" value="">
                                        <button type="button" onclick="submitAction('approved')" class="btn btn-sm btn-success">Approve</button>
                                        <button type="button" onclick="submitAction('decline')" class="btn btn-sm btn-danger">Decline</button>
                                        <button onclick="confirmFormSubmit('downloadFileForm')" class="btn btn-sm btn-primary"><i class="icon-sm" data-feather="download"></i></button>
                                    </form>
                                    <form id="downloadFileForm" action="{{ route('admin.download') }}" method="POST">
                                        @csrf
                                        <label>
                                            <input type="hidden" name="path" value="{{ $user['proof'] }}">
                                        </label>
                                    </form>
                                </div>
                            @else
                                <div class="mt-2">
                                    <p class="text-muted">Not Set</p>
                                </div>
                            @endif
                            @can('Delete Users')
                                <div class="mt-4">
                                    <button data-toggle="modal" data-target="#deleteUserModal" class="btn my-2 mx-1 btn-danger">
                                        Delete User
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8 middle-wrapper">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-body">
                            <div id="wallets" class="row">
                                <div class="col-md-6 my-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-center">Wallet Account</h5>
                                            <div class="my-2">
                                                <p class="mt-3 small">Total Balance</p>
                                                <h3 class="font-weight-light">${{ number_format($user->wallet->balance, 2) }}</h3>
                                            </div>
                                            <div class="mt-3 bg-light py-3 mb-2 d-flex justify-content-around" style="border-radius: 5px">
                                                @can('Deposit For Users')
                                                <button data-toggle="modal" data-target="#nairaDepositModal" class="btn my-2 mx-1 btn-success">
                                                    <i class="fa fa-credit-card"></i>
                                                    <span class="mt-1 d-block small">Deposit</span>
                                                </button>
                                                @endcan
                                                @can('Withdraw For Users')
                                                <button data-toggle="modal" data-target="#nairaWithdrawalModal" class="btn my-2 mx-1 btn-danger">
                                                    <i class="fa fa-money-check"></i>
                                                    <span class="mt-1 d-block small">Withdraw</span>
                                                </button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="investments" class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="d-flex mb-3 align-items-center justify-content-between">
                                    <h6 class="card-title my-auto">Investments</h6>
                                    <div>
                                        {{--@can('Make Investment For Users')--}}
                                        {{-- <a href="{{ route('admin.users.invest', $user['id']) }}" class="btn btn-sm btn-primary">New Investment</a>--}}
                                        {{-- @endcan--}}
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table">
                                        <thead>
                                        <tr>
                                            <th><i class="fas fa-list-ul"></i></th>
                                            <th>Package</th>
                                            <th>Slots</th>
                                            <th>Total Invested</th>
                                            <th>Expected returns</th>
                                            <th>Days left</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user->investments()->latest()->get() as $key=>$investment)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $investment->package['name'] }}</td>
                                                <td>{{ $investment['slots'] }}</td>
                                                <td>₦ {{ number_format($investment['amount']) }}</td>
                                                <td>₦ {{ number_format($investment['total_return']) }}</td>
                                                <td>
                                                    @if($investment['status'] == 'active')
                                                        {{ $investment['return_date']->diffInDays($investment['investment_date']) }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($investment['status'] == 'active')
                                                        <span class="badge badge-pill badge-success">Active</span>
                                                    @elseif($investment['status'] == 'pending')
                                                        <span class="badge badge-pill badge-warning">Pending</span>
                                                    @elseif($investment['status'] == 'cancelled')
                                                        <span class="badge badge-pill badge-danger">Cancelled</span>
                                                    @elseif($investment['status'] == 'settled')
                                                        <span class="badge badge-pill badge-secondary">Settled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action <i class="icon-lg" data-feather="chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.users.investment.show', ['user' => $user['id'], 'investment' =>  $investment['id']]) }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                            @if($investment['transaction']['status'] == 'pending')
                                                                <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit('transactionApprove{{ $investment['id'] }}')" href="{{ route('admin.transactions.approve', $investment['transaction']['id']) }}"><i data-feather="check" class="icon-sm mr-2"></i> <span class="">Approve</span></a>
                                                                <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit('transactionDecline{{ $investment['id'] }}')" href="{{ route('admin.transactions.decline', $investment['transaction']['id']) }}"><i data-feather="x" class="icon-sm mr-2"></i> <span class="">Decline</span></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($investment['transaction']['status'] == 'pending')
                                                        <form id="transactionApprove{{ $investment['id'] }}" action="{{ route('admin.transactions.approve', $investment['transaction']['id']) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                        <form id="transactionDecline{{ $investment['id'] }}" action="{{ route('admin.transactions.decline', $investment['transaction']['id']) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="saving" class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="d-flex mb-3 align-items-center justify-content-between">
                                    <h6 class="card-title my-auto">Savings</h6>
                                    <div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Plan</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php 
                                            $save = $user->savings;
                                        @endphp
                                            
                                        @foreach($save as $key=>$saving)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $saving->plan->name }}</td>
                                                <td>{{ $saving['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                <td>
                                                    @if($saving['status'] == 'active')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Active</span>
                                                    @elseif($saving['status'] == 'pending')
                                                        <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                    @elseif($saving['status'] == 'cancelled')
                                                        <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Cancelled</span>
                                                    @elseif($saving['status'] == 'settled')
                                                        <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Settled</span>
                                                    @endif
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        {{-- @foreach($user->savings()->latest()->get() as $key=>$saving)
                                            @php 
                                                $paid = $saving->transaction()->where('status', 'approved')->count();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                            <td>{{ $saving->package['name'] }}</td>
                                            <td class="text-capitalize">{{ $saving->package['duration'] }}</td>
                                            <td>₦ {{ number_format($saving['amount'] * $paid) }}</td>
                                            <td>₦ {{ number_format(($saving['amount'] * $saving->package['milestone']) - ($saving['amount'] * $paid)) }}</td>
                                            <td>
                                                @if($saving['status'] == 'active')
                                                    {{ $saving['return_date']->diffInDays(now()) > 0 ? $saving['return_date']->diffInDays(now()) : '---' }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($saving['status'] == 'active')
                                                    <span class="badge badge-pill badge-success">Active</span>
                                                @elseif($saving['status'] == 'pending')
                                                    <span class="badge badge-pill badge-warning">Pending</span>
                                                @elseif($saving['status'] == 'cancelled')
                                                    <span class="badge badge-pill badge-danger">Cancelled</span>
                                                @elseif($saving['status'] == 'settled')
                                                    <span class="badge badge-pill badge-secondary">Settled</span>
                                                @endif
                                            </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action <i class="icon-lg" data-feather="chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.users.savings.show', ['user' => $user['id'], 'saving' =>  $saving['id']]) }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="referrals" class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="d-flex mb-3 align-items-center justify-content-between">
                                    <h6 class="card-title my-auto">Referrals</h6>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table">
                                        <thead>
                                        <tr>
                                            <th><i class="fas fa-list-ul"></i></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user->referrals as $key=>$referral)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $referral['referred']['name'] }}</td>
                                                <td>{{ $referral['referred']['email'] }}</td>
                                                <td>{{ $referral['created_at']->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('partials.admin.modal.naira')
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        document.getElementById('deleteInputVerify').addEventListener('input', (e) => {
            if (e.target.value.toLowerCase() === 'delete') {
                document.getElementById('deleteUserButton').disabled = false;
            } else {
                document.getElementById('deleteUserButton').disabled = true;
            }
        });


        function submitAction(action) {
            document.getElementById('actionField').value = action;
            document.getElementById('actionForm').submit();
        }
    </script>
    <script>
        $(document).ready(function () {
            // Fetch coins on page load
            fetchCoins();

            // Variables to hold selected coin rate and symbol
            let selectedCoinRate = 0;
            let selectedCoinSymbol = '';
            let coins = []; // Store coins data for reference

            // Default values from server-side data
            const defaultCoinId = "{{ $user['wallet_asset'] }}";
            const defaultNetworkId = "{{ $user['wallet_network'] }}";

            fetchNetworks(defaultCoinId)

            const coinImages = {
                ETH: 'https://cryptologos.cc/logos/ethereum-eth-logo.png',
                BTC: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
                TRX: 'https://cdn-icons-png.flaticon.com/512/12114/12114250.png',
                USDT: 'https://icons.iconarchive.com/icons/cjdowner/cryptocurrency-flat/512/Tether-USDT-icon.png'
            };

            // Function to fetch coins and set default selection
            function fetchCoins() {
                $.ajax({
                    url: '/api/deposit/coin',
                    type: 'GET',
                    success: function (response) {
                        coins = response.data;
                        let options = '<p value="fw-bold">Not set</p>';
                        response.data.forEach(function (coin) {
                            if(defaultCoinId == coin.id)
                                options = `<p class="fw-bold">${coin.name} (${coin.symbol})</p>`;
                        });
                        $('#coin-select').html(options);
                    }
                });
            }

            // Function to fetch networks and set default selection
            function fetchNetworks(coinId) {
                $.ajax({
                    url: `/api/deposit/networks/${coinId}`,
                    type: 'GET',
                    success: function (response) {
                        let options = '<option value="">Select Network</option>';
                        response.data.forEach(function (network) {
                            if(defaultNetworkId == network.id)
                                options = `<p class="fw-bold">${network.name}</p>`;
                        });
                        $('#network-select').html(options);
                    }
                });
            }

            // Function to fetch address
            function fetchAddress(networkId) {
                $.ajax({
                    url: `/api/deposit/address/${networkId}`,
                    type: 'GET',
                    success: function (response) {
                        if (response.data && response.data.address) {
                            $('#address-display').val(response.data.address).prop('disabled', true);
                        } else {
                            $('#address-display').val('Address not available').prop('disabled', true);
                        }
                    }
                });
            }
        });
    </script>
@endsection

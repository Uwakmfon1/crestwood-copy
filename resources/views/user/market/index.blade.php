@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Market</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row inbox-wrapper">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-12">
                            <div class="float-right">
                                <a href="{{ route('buy') }}" class="btn btn-success">Buy</a>
                                <a href="{{ route('sell') }}" class="btn btn-danger">Sell</a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div id="tradingview_207c6"></div>
                                <div class="tradingview-widget-copyright">
                                    <a href="https://www.tradingview.com/symbols/FOREXCOM-XAUUSD/" rel="noopener" target="_blank"><span class="blue-text">Product - USD Chart</span></a> by TradingView
                                </div>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget(
            {
                "width": "100%",
                "symbol": "TVC:GOLD*FX_IDC:USDNGN*{{ \App\Models\Setting::all()->first()['gram_to_ounce'] ?? '0.035274' }}",
                "timezone": "Africa/Lagos",
                "theme": "light",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "withdateranges": true,
                "range": "1D",
                "allow_symbol_change": true,
                "details": true,
                "hotlist": true,
                "calendar": true,
                "container_id": "tradingview_207c6"
            }
        );
    </script>
@endsection

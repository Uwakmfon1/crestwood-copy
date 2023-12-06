<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Market Data</title>
</head>
<style>
    body {
        width: 100%;
        height: 100vh;
        padding: 0;
        margin: 0;
    }
</style>
<body>
    <div class="tradingview-widget-container" style="height: 100vh">
        <div id="tradingview_b4097" style="height: 100vh"></div>
        {{-- <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span class="blue-text">AAPL Chart</span></a> by TradingView</div> --}}
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
        new TradingView.widget(
        {
            "autosize": true,
            "symbol": "TVC:{{ strtoupper($product) }}*FX_IDC:USDNGN*{{ \App\Models\Setting::all()->first()['gram_to_ounce'] ?? '0.035274' }}",
            "timezone": "Africa/Lagos",
            "theme": "light",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "withdateranges": true,
            "allow_symbol_change": false,
            "details": true,
            "hotlist": true,
            "calendar": true,
            "container_id": "tradingview_b4097"
        }
        );
        </script>
      </div>
</body>
</html>
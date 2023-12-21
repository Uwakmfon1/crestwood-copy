<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@500;700&display=swap" rel="stylesheet">
    <title>Investment Certificate</title>
    <style type="text/css" media="all">
        @page {
            margin: 0;
            padding: 0;
        }
        html{
            width: 100%;
            max-height: 100%;
            padding: 0 !important;
            margin: 0 !important;
        }
        body{
            padding: 0 !important;
            width: 100%;
            margin: 0 !important;
            height: 100%;
            font-family: 'Overpass', sans-serif;
        }
        .certificate{
            width: 100%;
            max-height: 100%;
            font-size: 50px;
            position: relative !important;
        }

        .certificate #bg img{
            position: absolute;
            max-width: 100%;
        }

        .certificate .item{
            font-family: 'Overpass', sans-serif;
            position: absolute !important;
            text-transform: capitalize;
            font-size: 17px;
            font-weight: 700;
            color: #000;
            text-align: center !important;
        }

        @media (max-width: 700px) {
            body{
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="certificate" style="position: relative">
    <div style="position: absolute" id="bg"><img src="https://app.raregems.ng/assets/images/certificate.png" alt="bg"></div>
    <div style="top: 410px; left: 36%;" class="item">
        {{ ucwords(strtolower($investment["user"]["name"])) }}
    </div>
    <div style="top: 442px; left: 39%;" class="item">
        {{ ucwords(strtolower($investment["package"]["name"])) }}
    </div>
    <div style="top: 477px; left: 30%;" class="item">
        {{ $investment["package"]["duration"] }} {{ $investment["package"]["duration"] > 1 ? 'Months' : 'Month' }}
    </div>
    <div style="top: 507px; left: 38%;" class="item">
        {{ $investment["investment_date"]->format("d F Y") }}
    </div>
    <div style="top: 540px; left: 34%;" class="item">
        {{ $investment["return_date"]->format("d F Y") }}
    </div>
    <div style="top: 572px; left: 37%;" class="item">
        NGN {{ number_format($investment["amount"]) }}
    </div>
    <div style="top: 605px; left: 38%;" class="item">
        NGN {{ number_format($investment["total_return"]) }}
    </div>
</div>
</body>
</html>

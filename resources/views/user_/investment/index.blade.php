@extends('layouts.user.index')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

    @include('partials.users.alert')

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Investment</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Investment
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('investments.history') }}" class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="fe fe-clock me-2"></i>History
                </a>
                <a href="{{ route('packages') }}" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="fe fe-plus me-2"></i>Start Investment
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-6">
                        <div class="card custom-card icon-overlay">
                            <span class="icon svg-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path><path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z"></path></svg>
                            </span>
                            <div class="card-body">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <line x1="96" y1="64" x2="160" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="128" x2="160" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="192" x2="160" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <rect x="40" y="48" width="176" height="160" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <!-- <h4 class="fw-semibold mb-1">&#36;{{ number_format(($total_amount + $balance) + ($total_invest - $total_amount), 2) }}</h4> -->
                                         <h4 class="fw-semibold mb-1">&#36;{{ number_format($balance, 2) }}</h4>
                                        <span class="text-muted fs-12">Portfolio Balance 
                                            <!-- <span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span> -->
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <a href="javascript:void(0);" class="py-2 fs-11 text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openInvestmentModal">Top Up Wallet<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-6">
                        <div class="card custom-card icon-overlay">
                            <span class="icon svg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,56V90.06h0a44,44,0,1,0-56,67.88h0V192H40a8,8,0,0,1-8-8V56a8,8,0,0,1,8-8H216A8,8,0,0,1,224,56Z" opacity="0.2"></path><path d="M128,136a8,8,0,0,1-8,8H72a8,8,0,0,1,0-16h48A8,8,0,0,1,128,136Zm-8-40H72a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Zm112,65.47V224A8,8,0,0,1,220,231l-24-13.74L172,231A8,8,0,0,1,160,224V200H40a16,16,0,0,1-16-16V56A16,16,0,0,1,40,40H216a16,16,0,0,1,16,16V86.53a51.88,51.88,0,0,1,0,74.94ZM160,184V161.47A52,52,0,0,1,216,76V56H40V184Zm56-12a51.88,51.88,0,0,1-40,0v38.22l16-9.16a8,8,0,0,1,7.94,0l16,9.16Zm16-48a36,36,0,1,0-36,36A36,36,0,0,0,232,124Z"></path></svg>
                            </span>
                            <div class="card-body">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <circle cx="128" cy="96" r="48" opacity="0.2" />
                                                    <circle cx="128" cy="96" r="80" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <circle cx="128" cy="96" r="48" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <polyline
                                                        points="176 160 176 240 127.99 216 80 240 80 160.01"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="fw-semibold mb-1">{{ number_format($asv) }}</h4>
                                        <span class="text-muted fs-12">Active Investment<span class="text-success ms-2 d-inline-block">+$20.80</span></span>
                                    </div>
                                    <div class="mt-1">
                                        <a href="javascript:void(0);" class="py-2 fs-11 text-white fw-semibold">.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-header d-flex">
                        <div class="card-title">Investment</div>
                        <div class="btn-group ms-auto">
                            <button class="btn btn-success btn-sm" id="one_month">1M</button>
                            <button class="btn btn-success btn-sm" id="six_months">6M</button>
                            <button class="btn btn-success btn-sm" id="one_year">1Y</button>
                            <button class="btn btn-success btn-sm" id="all">ALL</button>
                            <!-- <button class="btn btn-primary btn-sm" id="ytd">ALL</button> -->
                        </div>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body">
                            <div id="area-spline"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card card-bg-primary crypto-card">
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="avatar avatar-lg p-2 svg-white bg-white-transparent shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                    <path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path>
                                    <path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z">
                                    </path>
                                </svg> </span>
                            <div>
                                <span class="text-fixed-white op-8">Investment Overview</span>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="py-2 fs-16 text-fixed-white show" data-bs-toggle="dropdown" aria-expanded="true"> USD </a>
                                </div>
                            </div>
                        </div>
                        <hr class="text-fixed-white op-1">
                        <div>
                            <span class="text-fixed-white op-8">Available Balance</span>
                            <h4 class="fw-semibold d-block text-fixed-white mt-2">{{ number_format($balance, 2) }}<span class="fs-12 ms-1 op-8 d-inline-flex">USD</span></h4>
                            <span>Locked Funds: ${{ number_format($total_amount, 2) }}</span>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <span class="avatar avatar-sm bg-primary avatar-rounded me-2 svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                <path d="M192,168a40,40,0,0,1-40,40H128V128h24A40,40,0,0,1,192,168ZM112,48a40,40,0,0,0,0,80h16V48Z" opacity="0.2"></path>
                                                <path d="M152,120H136V56h8a32,32,0,0,1,32,32,8,8,0,0,0,16,0,48.05,48.05,0,0,0-48-48h-8V24a8,8,0,0,0-16,0V40h-8a48,48,0,0,0,0,96h8v64H104a32,32,0,0,1-32-32,8,8,0,0,0-16,0,48.05,48.05,0,0,0,48,48h16v16a8,8,0,0,0,16,0V216h16a48,48,0,0,0,0-96Zm-40,0a32,32,0,0,1,0-64h8v64Zm40,80H136V136h16a32,32,0,0,1,0,64Z">
                                                </path>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="fs-12 text-left" style="padding: 0px !important; margin: 0px !important;">Total Invested</p> 
                                            <span class="fs-16 fw-semibold text-left" style="padding-right: 40px;">{{ number_format($total_amount, 2) }} USD</span> 
                                        </div>
                                    </div>
                                    <div class="mt-1"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <span class="avatar avatar-sm bg-primary avatar-rounded me-2 svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                <path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path>
                                                <path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z">
                                                </path>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="fs-12 text-left" style="padding: 0px !important; margin: 0px !important;">Expected Returns</p>
                                            <span class="fs-16 fw-semibold text-left" style="padding-right: 40px;">{{ number_format($total_invest - $total_amount, 2) }} USD</span> 
                                        </div>
                                    </div>
                                    <div class="mt-1"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card bg-success">
                    <div class="card-body p-4">
                        <div class="">
                            <div class="text-fixed-white mb-2">Investment Profit<span class="ms-2 d-inline-block text-fixed-white op-5">
                            </div>
                            <h4 class="fw-semibold mb-0 text-fixed-white">{{ number_format($profit, 2) }}<span class="fs-12 ms-1 op-8 d-inline-flex">USD</span></h4>
                        </div>
                        <div id="engaged-users" class="mb-3" style="min-height: 40px;"><div id="apexchartsck4vlp4l" class="apexcharts-canvas apexchartsck4vlp4l apexcharts-theme-light" style="width: 280px; height: 40px;"><svg id="SvgjsSvg2201" width="280" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="280" height="40"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 20px;"></div></foreignObject><rect id="SvgjsRect2205" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG2246" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2203" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs2202"><clipPath id="gridRectMaskck4vlp4l"><rect id="SvgjsRect2207" width="286" height="42" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskck4vlp4l"></clipPath><clipPath id="nonForecastMaskck4vlp4l"></clipPath><clipPath id="gridRectMarkerMaskck4vlp4l"><rect id="SvgjsRect2208" width="284" height="44" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2213" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop2214" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="0"></stop><stop id="SvgjsStop2215" stop-opacity="1" stop-color="rgba(255,255,255)" offset="0.9"></stop><stop id="SvgjsStop2216" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="1"></stop></linearGradient><filter id="SvgjsFilter2218" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood2219" flood-color="rgba(255,255,255)" flood-opacity="0.3" result="SvgjsFeFlood2219Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite2220" in="SvgjsFeFlood2219Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2220Out"></feComposite><feOffset id="SvgjsFeOffset2221" dx="0" dy="3" result="SvgjsFeOffset2221Out" in="SvgjsFeComposite2220Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur2222" stdDeviation="3 " result="SvgjsFeGaussianBlur2222Out" in="SvgjsFeOffset2221Out"></feGaussianBlur><feMerge id="SvgjsFeMerge2223" result="SvgjsFeMerge2223Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode2224" in="SvgjsFeGaussianBlur2222Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode2225" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend2226" in="SourceGraphic" in2="SvgjsFeMerge2223Out" mode="normal" result="SvgjsFeBlend2226Out"></feBlend></filter></defs><line id="SvgjsLine2206" x1="0" y1="0" x2="0" y2="40" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="40" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG2227" class="apexcharts-grid"><g id="SvgjsG2228" class="apexcharts-gridlines-horizontal" style="display: none;"></g><g id="SvgjsG2229" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2232" x1="0" y1="40" x2="280" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2231" x1="0" y1="1" x2="0" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2230" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG2209" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG2210" class="apexcharts-series" seriesName="Value" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath2217" d="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient2213)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskck4vlp4l)" filter="url(#SvgjsFilter2218)" pathTo="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" pathFrom="M -1 56 L -1 56 L 35 56 L 70 56 L 105 56 L 140 56 L 175 56 L 210 56 L 245 56 L 280 56" fill-rule="evenodd"></path><g id="SvgjsG2211" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle2250" r="0" cx="0" cy="0" class="apexcharts-marker wgpj0tnic no-pointer-events" stroke="#ffffff" fill="rgba(255,255,255)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG2212" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2233" x1="0" y1="0" x2="280" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2234" x1="0" y1="0" x2="280" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2235" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2236" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2247" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2248" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2249" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 255, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                        <div>
                            <span class=" text-fixed-white op-7">Overall Investment Growth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start:: row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Latest Investment 
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>ROI</th>
                                        <th>Profit</th>
                                        <!-- <th>Expected returns</th> -->
                                        <th>Due Days</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($investments as $key=>$investment)
                                        @php
                                            $profit = $investment->investmentTransaction()->sum('amount');
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            @if($investment->package)
                                                <td>{{ $investment->package['name'] }}</td>
                                            @else
                                                <td>Deleted Package</td>
                                            @endif
                                            <td>${{ number_format($investment['amount']) }}</td>
                                            @if($investment->package)
                                                <td>{{ $investment->package['roi'] }}%</td>
                                            @else
                                                <td>Deleted Package</td>
                                            @endif
                                            <!-- <td>${{ number_format($investment['total_return']) }}</td> -->
                                            <td class="text-success">
                                                <strong>+${{ number_format(($profit - $investment['amount']), 2) }}</strong>
                                            </td>
                                            <td class="text-danger">
                                                @if($investment['status'] == 'active')
                                                    {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($investment['created_at'])->add($investment->package['milestone'], $investment->package['duration'])) }} days
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($investment['status'] == 'active')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Active</span>
                                                @elseif($investment['status'] == 'pending')
                                                    <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                @elseif($investment['status'] == 'cancelled')
                                                    <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Cancelled</span>
                                                @elseif($investment['status'] == 'settled')
                                                    <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Settled</span>
                                                @endif
                                            </td>
                                            <td>{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('investments.show', $investment['id']) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($investments->count() == 0)
                                <tr>
                                    <p class="py-4 text-center">
                                        No Investment
                                    </p>
                                </tr>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-2 -->

        @include('partials.users.modal.topup')
    </div>
</div>
<!-- End::app-content -->

<!-- End::app-content -->
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    var options = {
        series: [{
            name: 'Invested',
            data: @json($totals)  // Inject the total amounts here
        }],
        chart: {
            height: 320,
            type: 'area'
        },
        colors: ["#8274ff"],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        grid: {
            borderColor: '#f2f5f7',
        },
        xaxis: {
            type: 'datetime',
            categories: @json($dates),  // Inject the dates here
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-label',
                },
            }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-label',
                },
            }
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy'  // Format the date displayed in the tooltip
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#area-spline"), options);
    chart.render();
</script>

@endsection
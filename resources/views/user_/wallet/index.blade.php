@extends('layouts.user.index')

@section('content')
<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
</style>
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

    @include('partials.users.alert')

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Wallet</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Wallet
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#nairaDepositModal">
                    <i class="ri-filter-3-fill me-2"></i>Deposit
                </button>
                <button class="btn btn-primary btn-wave waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#nairaWithdrawalModal">
                    <i class="ri-upload-2-line me-2"></i> Withdraw
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-3">
                <div class="card custom-card card-bg-success crypto-card py-2">
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="avatar avatar-lg p-2 svg-white bg-white-transparent shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                    <path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path>
                                    <path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z">
                                    </path>
                                </svg> </span>
                            <div>
                                <span class="text-fixed-white op-8">Portfolio</span>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="py-2 fs-16 text-fixed-white show" data-bs-toggle="dropdown" aria-expanded="true"> USD</a>
                                </div>
                            </div>
                        </div>
                        <hr class="text-fixed-white op-1">
                        <div>
                            <span class="text-fixed-white op-8">My Portfolio</span>
                            <h4 class="fw-semibold d-block text-fixed-white mt-2">
                                {{ number_format($wallet, 2) }}
                                <span class="fs-12 ms-1 d-inline-flex" style="margin-top: -5px;">USD</span>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex">
                                        <span class="fs-10">Available Balance</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="fs-18 fw-semibold text-start">{{ number_format($cash, 2) }} USD</span>
                                    </div>
                                    <div class="mt-1">  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex">
                                        <!-- <span class="avatar avatar-sm bg-dark avatar-rounded me-2 svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                <path d="M192,168a40,40,0,0,1-40,40H128V128h24A40,40,0,0,1,192,168ZM112,48a40,40,0,0,0,0,80h16V48Z" opacity="0.2"></path>
                                                <path d="M152,120H136V56h8a32,32,0,0,1,32,32,8,8,0,0,0,16,0,48.05,48.05,0,0,0-48-48h-8V24a8,8,0,0,0-16,0V40h-8a48,48,0,0,0,0,96h8v64H104a32,32,0,0,1-32-32,8,8,0,0,0-16,0,48.05,48.05,0,0,0,48,48h16v16a8,8,0,0,0,16,0V216h16a48,48,0,0,0,0-96Zm-40,0a32,32,0,0,1,0-64h8v64Zm40,80H136V136h16a32,32,0,0,1,0,64Z">
                                                </path>
                                            </svg>
                                        </span> -->
                                        <span class="fs-10">Locked Cash</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="fs-18 fw-semibold text-start">{{ number_format($locked, 2) }} USD</span>
                                    </div>
                                    <div class="mt-1">  </div>
                                </div>
                            </div>
                        </div>
                        <div id="engaged-users" class="mb-3" style="min-height: 40px;"><div id="apexchartsck4vlp4l" class="apexcharts-canvas apexchartsck4vlp4l apexcharts-theme-light" style="width: 280px; height: 40px;"><svg id="SvgjsSvg2201" width="280" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="280" height="40"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 20px;"></div></foreignObject><rect id="SvgjsRect2205" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG2246" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2203" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs2202"><clipPath id="gridRectMaskck4vlp4l"><rect id="SvgjsRect2207" width="286" height="42" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskck4vlp4l"></clipPath><clipPath id="nonForecastMaskck4vlp4l"></clipPath><clipPath id="gridRectMarkerMaskck4vlp4l"><rect id="SvgjsRect2208" width="284" height="44" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2213" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop2214" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="0"></stop><stop id="SvgjsStop2215" stop-opacity="1" stop-color="rgba(255,255,255)" offset="0.9"></stop><stop id="SvgjsStop2216" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="1"></stop></linearGradient><filter id="SvgjsFilter2218" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood2219" flood-color="rgba(255,255,255)" flood-opacity="0.3" result="SvgjsFeFlood2219Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite2220" in="SvgjsFeFlood2219Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2220Out"></feComposite><feOffset id="SvgjsFeOffset2221" dx="0" dy="3" result="SvgjsFeOffset2221Out" in="SvgjsFeComposite2220Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur2222" stdDeviation="3 " result="SvgjsFeGaussianBlur2222Out" in="SvgjsFeOffset2221Out"></feGaussianBlur><feMerge id="SvgjsFeMerge2223" result="SvgjsFeMerge2223Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode2224" in="SvgjsFeGaussianBlur2222Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode2225" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend2226" in="SourceGraphic" in2="SvgjsFeMerge2223Out" mode="normal" result="SvgjsFeBlend2226Out"></feBlend></filter></defs><line id="SvgjsLine2206" x1="0" y1="0" x2="0" y2="40" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="40" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG2227" class="apexcharts-grid"><g id="SvgjsG2228" class="apexcharts-gridlines-horizontal" style="display: none;"></g><g id="SvgjsG2229" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2232" x1="0" y1="40" x2="280" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2231" x1="0" y1="1" x2="0" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2230" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG2209" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG2210" class="apexcharts-series" seriesName="Value" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath2217" d="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient2213)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskck4vlp4l)" filter="url(#SvgjsFilter2218)" pathTo="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" pathFrom="M -1 56 L -1 56 L 35 56 L 70 56 L 105 56 L 140 56 L 175 56 L 210 56 L 245 56 L 280 56" fill-rule="evenodd"></path><g id="SvgjsG2211" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle2250" r="0" cx="0" cy="0" class="apexcharts-marker wgpj0tnic no-pointer-events" stroke="#ffffff" fill="rgba(255,255,255)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG2212" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2233" x1="0" y1="0" x2="280" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2234" x1="0" y1="0" x2="280" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2235" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2236" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2247" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2248" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2249" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 255, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                    </div>
                </div>
                <div class="card custom-card bg-dark py-2">
                    <div class="card-body p-4">
                        <div class="">
                            <div class="text-fixed-white mb-2">Ledger Balance<span class="ms-2 d-inline-block text-fixed-white op-5"><i class="fe fe-arrow-up-right"></i>0.25%</span>
                            </div>
                            <h4 class="fw-semibold mb-0 text-fixed-white">0.00 <sub class="fs-12 op-8 d-inline-flex">USD</sub></h4>
                        </div>
                        <div id="engaged-users" class="mb-3" style="min-height: 40px;"><div id="apexchartsck4vlp4l" class="apexcharts-canvas apexchartsck4vlp4l apexcharts-theme-light" style="width: 280px; height: 40px;"><svg id="SvgjsSvg2201" width="280" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="280" height="40"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 20px;"></div></foreignObject><rect id="SvgjsRect2205" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG2246" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2203" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs2202"><clipPath id="gridRectMaskck4vlp4l"><rect id="SvgjsRect2207" width="286" height="42" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskck4vlp4l"></clipPath><clipPath id="nonForecastMaskck4vlp4l"></clipPath><clipPath id="gridRectMarkerMaskck4vlp4l"><rect id="SvgjsRect2208" width="284" height="44" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient2213" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop2214" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="0"></stop><stop id="SvgjsStop2215" stop-opacity="1" stop-color="rgba(255,255,255)" offset="0.9"></stop><stop id="SvgjsStop2216" stop-opacity="0.2" stop-color="rgba(255,255,255)" offset="1"></stop></linearGradient><filter id="SvgjsFilter2218" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood2219" flood-color="rgba(255,255,255)" flood-opacity="0.3" result="SvgjsFeFlood2219Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite2220" in="SvgjsFeFlood2219Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite2220Out"></feComposite><feOffset id="SvgjsFeOffset2221" dx="0" dy="3" result="SvgjsFeOffset2221Out" in="SvgjsFeComposite2220Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur2222" stdDeviation="3 " result="SvgjsFeGaussianBlur2222Out" in="SvgjsFeOffset2221Out"></feGaussianBlur><feMerge id="SvgjsFeMerge2223" result="SvgjsFeMerge2223Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode2224" in="SvgjsFeGaussianBlur2222Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode2225" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend2226" in="SourceGraphic" in2="SvgjsFeMerge2223Out" mode="normal" result="SvgjsFeBlend2226Out"></feBlend></filter></defs><line id="SvgjsLine2206" x1="0" y1="0" x2="0" y2="40" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="40" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG2227" class="apexcharts-grid"><g id="SvgjsG2228" class="apexcharts-gridlines-horizontal" style="display: none;"></g><g id="SvgjsG2229" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2232" x1="0" y1="40" x2="280" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2231" x1="0" y1="1" x2="0" y2="40" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2230" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG2209" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG2210" class="apexcharts-series" seriesName="Value" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath2217" d="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient2213)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskck4vlp4l)" filter="url(#SvgjsFilter2218)" pathTo="M 0 37.33333333333333C 12.25 37.33333333333333 22.75 29.333333333333332 35 29.333333333333332C 47.25 29.333333333333332 57.75 36 70 36C 82.25 36 92.75 22.666666666666664 105 22.666666666666664C 117.25 22.666666666666664 127.75 26.666666666666668 140 26.666666666666668C 152.25 26.666666666666668 162.75 9.333333333333336 175 9.333333333333336C 187.25 9.333333333333336 197.75 36 210 36C 222.25 36 232.75 16 245 16C 257.25 16 267.75 22.666666666666664 280 22.666666666666664" pathFrom="M -1 56 L -1 56 L 35 56 L 70 56 L 105 56 L 140 56 L 175 56 L 210 56 L 245 56 L 280 56" fill-rule="evenodd"></path><g id="SvgjsG2211" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle2250" r="0" cx="0" cy="0" class="apexcharts-marker wgpj0tnic no-pointer-events" stroke="#ffffff" fill="rgba(255,255,255)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG2212" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2233" x1="0" y1="0" x2="280" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2234" x1="0" y1="0" x2="280" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2235" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2236" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2247" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2248" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2249" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 255, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Savings Balance</div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($savings, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary svg-white"> 
                                        <i class="ti ti-user-circle fs-20"></i>
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div id="realtimeusers" style="min-height: 30px;"><div id="apexchartsfggvoc4u" class="apexcharts-canvas apexchartsfggvoc4u apexcharts-theme-light" style="width: 120px; height: 30px;"><svg id="SvgjsSvg3007" width="120" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="120" height="30"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 15px;"></div></foreignObject><g id="SvgjsG3066" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG3009" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs3008"><clipPath id="gridRectMaskfggvoc4u"><rect id="SvgjsRect3011" width="125.7" height="31.7" x="-2.85" y="-0.85" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskfggvoc4u"></clipPath><clipPath id="nonForecastMaskfggvoc4u"></clipPath><clipPath id="gridRectMarkerMaskfggvoc4u"><rect id="SvgjsRect3012" width="124" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient3017" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop3018" stop-opacity="0.5" stop-color="rgba(130,116,255,0.5)" offset="0"></stop><stop id="SvgjsStop3019" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="0.6"></stop><stop id="SvgjsStop3020" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="1"></stop></linearGradient><filter id="SvgjsFilter3022" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3023" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3023Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3024" in="SvgjsFeFlood3023Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3024Out"></feComposite><feOffset id="SvgjsFeOffset3025" dx="0" dy="6" result="SvgjsFeOffset3025Out" in="SvgjsFeComposite3024Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3026" stdDeviation="0 " result="SvgjsFeGaussianBlur3026Out" in="SvgjsFeOffset3025Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3027" result="SvgjsFeMerge3027Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3028" in="SvgjsFeGaussianBlur3026Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3029" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3030" in="SourceGraphic" in2="SvgjsFeMerge3027Out" mode="normal" result="SvgjsFeBlend3030Out"></feBlend></filter><filter id="SvgjsFilter3032" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3033" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3033Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3034" in="SvgjsFeFlood3033Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3034Out"></feComposite><feOffset id="SvgjsFeOffset3035" dx="0" dy="6" result="SvgjsFeOffset3035Out" in="SvgjsFeComposite3034Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3036" stdDeviation="0 " result="SvgjsFeGaussianBlur3036Out" in="SvgjsFeOffset3035Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3037" result="SvgjsFeMerge3037Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3038" in="SvgjsFeGaussianBlur3036Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3039" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3040" in="SourceGraphic" in2="SvgjsFeMerge3037Out" mode="normal" result="SvgjsFeBlend3040Out"></feBlend></filter></defs><g id="SvgjsG3041" class="apexcharts-grid"><g id="SvgjsG3042" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine3045" x1="0" y1="0" x2="120" y2="0" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3046" x1="0" y1="6" x2="120" y2="6" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3047" x1="0" y1="12" x2="120" y2="12" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3048" x1="0" y1="18" x2="120" y2="18" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3049" x1="0" y1="24" x2="120" y2="24" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3050" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG3043" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine3052" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine3051" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG3044" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG3013" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG3014" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath3021" d="M 0 30 L 0 12 L 15 21 L 30 12 L 45 9 L 60 28.5 L 75 24 L 90 13.5 L 105 27 L 120 4.5 L 120 30M 120 4.5z" fill="url(#SvgjsLinearGradient3017)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskfggvoc4u)" filter="url(#SvgjsFilter3022)" pathTo="M 0 30 L 0 12 L 15 21 L 30 12 L 45 9 L 60 28.5 L 75 24 L 90 13.5 L 105 27 L 120 4.5 L 120 30M 120 4.5z" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42"></path><path id="SvgjsPath3031" d="M 0 12 L 15 21 L 30 12 L 45 9 L 60 28.5 L 75 24 L 90 13.5 L 105 27 L 120 4.5" fill="none" fill-opacity="1" stroke="#8274ff" stroke-opacity="1" stroke-linecap="butt" stroke-width="1.7" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskfggvoc4u)" filter="url(#SvgjsFilter3032)" pathTo="M 0 12 L 15 21 L 30 12 L 45 9 L 60 28.5 L 75 24 L 90 13.5 L 105 27 L 120 4.5" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42" fill-rule="evenodd"></path><g id="SvgjsG3015" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle3070" r="0" cx="0" cy="0" class="apexcharts-marker ws7u0swy8 no-pointer-events" stroke="#ffffff" fill="#8274ff" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG3016" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine3053" x1="0" y1="0" x2="120" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine3054" x1="0" y1="0" x2="120" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG3055" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG3056" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG3067" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG3068" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG3069" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(130, 116, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-dark"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex">+23.76%</span>more</span>
                                        <p class="mb-0 text-muted">from last week</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Investment Balance</div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($investment, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary  svg-white">
                                        <i class="ti ti-percentage fs-20"></i>
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div id="bouncerate" style="min-height: 30px;"><div id="apexcharts19f0c54m" class="apexcharts-canvas apexcharts19f0c54m apexcharts-theme-light" style="width: 120px; height: 30px;"><svg id="SvgjsSvg3072" width="120" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="120" height="30"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 15px;"></div></foreignObject><g id="SvgjsG3131" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG3074" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs3073"><clipPath id="gridRectMask19f0c54m"><rect id="SvgjsRect3076" width="125.7" height="31.7" x="-2.85" y="-0.85" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask19f0c54m"></clipPath><clipPath id="nonForecastMask19f0c54m"></clipPath><clipPath id="gridRectMarkerMask19f0c54m"><rect id="SvgjsRect3077" width="124" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient3082" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop3083" stop-opacity="0.5" stop-color="rgba(130,116,255,0.5)" offset="0"></stop><stop id="SvgjsStop3084" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="0.6"></stop><stop id="SvgjsStop3085" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="1"></stop></linearGradient><filter id="SvgjsFilter3087" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3088" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3088Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3089" in="SvgjsFeFlood3088Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3089Out"></feComposite><feOffset id="SvgjsFeOffset3090" dx="0" dy="6" result="SvgjsFeOffset3090Out" in="SvgjsFeComposite3089Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3091" stdDeviation="0 " result="SvgjsFeGaussianBlur3091Out" in="SvgjsFeOffset3090Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3092" result="SvgjsFeMerge3092Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3093" in="SvgjsFeGaussianBlur3091Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3094" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3095" in="SourceGraphic" in2="SvgjsFeMerge3092Out" mode="normal" result="SvgjsFeBlend3095Out"></feBlend></filter><filter id="SvgjsFilter3097" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3098" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3098Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3099" in="SvgjsFeFlood3098Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3099Out"></feComposite><feOffset id="SvgjsFeOffset3100" dx="0" dy="6" result="SvgjsFeOffset3100Out" in="SvgjsFeComposite3099Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3101" stdDeviation="0 " result="SvgjsFeGaussianBlur3101Out" in="SvgjsFeOffset3100Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3102" result="SvgjsFeMerge3102Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3103" in="SvgjsFeGaussianBlur3101Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3104" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3105" in="SourceGraphic" in2="SvgjsFeMerge3102Out" mode="normal" result="SvgjsFeBlend3105Out"></feBlend></filter></defs><g id="SvgjsG3106" class="apexcharts-grid"><g id="SvgjsG3107" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine3110" x1="0" y1="0" x2="120" y2="0" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3111" x1="0" y1="6" x2="120" y2="6" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3112" x1="0" y1="12" x2="120" y2="12" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3113" x1="0" y1="18" x2="120" y2="18" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3114" x1="0" y1="24" x2="120" y2="24" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3115" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG3108" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine3117" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine3116" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG3109" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG3078" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG3079" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath3086" d="M 0 30 L 0 4.5 L 15 27 L 30 13.5 L 45 24 L 60 28.5 L 75 9 L 90 12 L 105 21 L 120 12 L 120 30M 120 12z" fill="url(#SvgjsLinearGradient3082)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask19f0c54m)" filter="url(#SvgjsFilter3087)" pathTo="M 0 30 L 0 4.5 L 15 27 L 30 13.5 L 45 24 L 60 28.5 L 75 9 L 90 12 L 105 21 L 120 12 L 120 30M 120 12z" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42"></path><path id="SvgjsPath3096" d="M 0 4.5 L 15 27 L 30 13.5 L 45 24 L 60 28.5 L 75 9 L 90 12 L 105 21 L 120 12" fill="none" fill-opacity="1" stroke="#8274ff" stroke-opacity="1" stroke-linecap="butt" stroke-width="1.7" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask19f0c54m)" filter="url(#SvgjsFilter3097)" pathTo="M 0 4.5 L 15 27 L 30 13.5 L 45 24 L 60 28.5 L 75 9 L 90 12 L 105 21 L 120 12" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42" fill-rule="evenodd"></path><g id="SvgjsG3080" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle3135" r="0" cx="0" cy="0" class="apexcharts-marker wpet2sdva no-pointer-events" stroke="#ffffff" fill="#8274ff" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG3081" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine3118" x1="0" y1="0" x2="120" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine3119" x1="0" y1="0" x2="120" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG3120" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG3121" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG3132" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG3133" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG3134" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(130, 116, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-dark"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                    <div>
                                        <span class=""><span class="text-success fw-medium me-1 d-inline-flex">+12.5%</span>more</span>
                                        <p class="mb-0 text-muted">from last week</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Trading balance</div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($trading, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary  svg-white">  <i class="ti ti-users fs-20"></i> </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap  justify-content-between mt-2">
                                    <div id="total-visitors" style="min-height: 30px;"><div id="apexchartszcovgw6m" class="apexcharts-canvas apexchartszcovgw6m apexcharts-theme-light" style="width: 120px; height: 30px;"><svg id="SvgjsSvg3137" width="120" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="120" height="30"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 15px;"></div></foreignObject><g id="SvgjsG3196" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG3139" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs3138"><clipPath id="gridRectMaskzcovgw6m"><rect id="SvgjsRect3141" width="125.7" height="31.7" x="-2.85" y="-0.85" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskzcovgw6m"></clipPath><clipPath id="nonForecastMaskzcovgw6m"></clipPath><clipPath id="gridRectMarkerMaskzcovgw6m"><rect id="SvgjsRect3142" width="124" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient3147" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop3148" stop-opacity="0.5" stop-color="rgba(130,116,255,0.5)" offset="0"></stop><stop id="SvgjsStop3149" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="0.6"></stop><stop id="SvgjsStop3150" stop-opacity="0.2" stop-color="rgba(193,186,255,0.2)" offset="1"></stop></linearGradient><filter id="SvgjsFilter3152" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3153" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3153Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3154" in="SvgjsFeFlood3153Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3154Out"></feComposite><feOffset id="SvgjsFeOffset3155" dx="0" dy="6" result="SvgjsFeOffset3155Out" in="SvgjsFeComposite3154Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3156" stdDeviation="0 " result="SvgjsFeGaussianBlur3156Out" in="SvgjsFeOffset3155Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3157" result="SvgjsFeMerge3157Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3158" in="SvgjsFeGaussianBlur3156Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3159" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3160" in="SourceGraphic" in2="SvgjsFeMerge3157Out" mode="normal" result="SvgjsFeBlend3160Out"></feBlend></filter><filter id="SvgjsFilter3162" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood3163" flood-color="var(--primary-color)" flood-opacity="0.05" result="SvgjsFeFlood3163Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite3164" in="SvgjsFeFlood3163Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite3164Out"></feComposite><feOffset id="SvgjsFeOffset3165" dx="0" dy="6" result="SvgjsFeOffset3165Out" in="SvgjsFeComposite3164Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur3166" stdDeviation="0 " result="SvgjsFeGaussianBlur3166Out" in="SvgjsFeOffset3165Out"></feGaussianBlur><feMerge id="SvgjsFeMerge3167" result="SvgjsFeMerge3167Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode3168" in="SvgjsFeGaussianBlur3166Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode3169" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend3170" in="SourceGraphic" in2="SvgjsFeMerge3167Out" mode="normal" result="SvgjsFeBlend3170Out"></feBlend></filter></defs><g id="SvgjsG3171" class="apexcharts-grid"><g id="SvgjsG3172" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine3175" x1="0" y1="0" x2="120" y2="0" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3176" x1="0" y1="6" x2="120" y2="6" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3177" x1="0" y1="12" x2="120" y2="12" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3178" x1="0" y1="18" x2="120" y2="18" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3179" x1="0" y1="24" x2="120" y2="24" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3180" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG3173" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine3182" x1="0" y1="30" x2="120" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine3181" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG3174" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG3143" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG3144" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath3151" d="M 0 30 L 0 24 L 15 12 L 30 27 L 45 4.5 L 60 13.5 L 75 9 L 90 12 L 105 7.5 L 120 28.5 L 120 30M 120 28.5z" fill="url(#SvgjsLinearGradient3147)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskzcovgw6m)" filter="url(#SvgjsFilter3152)" pathTo="M 0 30 L 0 24 L 15 12 L 30 27 L 45 4.5 L 60 13.5 L 75 9 L 90 12 L 105 7.5 L 120 28.5 L 120 30M 120 28.5z" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42"></path><path id="SvgjsPath3161" d="M 0 24 L 15 12 L 30 27 L 45 4.5 L 60 13.5 L 75 9 L 90 12 L 105 7.5 L 120 28.5" fill="none" fill-opacity="1" stroke="#8274ff" stroke-opacity="1" stroke-linecap="butt" stroke-width="1.7" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskzcovgw6m)" filter="url(#SvgjsFilter3162)" pathTo="M 0 24 L 15 12 L 30 27 L 45 4.5 L 60 13.5 L 75 9 L 90 12 L 105 7.5 L 120 28.5" pathFrom="M -1 42 L -1 42 L 15 42 L 30 42 L 45 42 L 60 42 L 75 42 L 90 42 L 105 42 L 120 42" fill-rule="evenodd"></path><g id="SvgjsG3145" class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle3200" r="0" cx="0" cy="0" class="apexcharts-marker wbis4dgev no-pointer-events" stroke="#ffffff" fill="#8274ff" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG3146" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine3183" x1="0" y1="0" x2="120" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine3184" x1="0" y1="0" x2="120" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG3185" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG3186" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG3197" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG3198" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG3199" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(130, 116, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-dark"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                    <div>
                                        <span class=""><span class="text-danger fw-medium me-1 d-inline-flex">-2.65%</span>less</span>
                                        <p class="mb-0 text-muted">from last week</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Wallet transaction</div>
                                    <!-- <div id="filter-buttons">
                                        <button onclick="updateChart('daily')">Daily</button>
                                        <button onclick="updateChart('weekly')">Weekly</button>
                                        <button onclick="updateChart('monthly')">Monthly</button>
                                    </div> -->
                            </div>
                            <div class="card-body">
                                <div id="area-spline"></div>
                            </div>
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
                                Latest Transactions 
                            </div>
                            <div class="d-flex flex-wrap gap-2"> 
                                <div class="dropdown"> 
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> 
                                    </a>  
                                </div> 
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Amount</th>
                                            <th>Account</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $key=>$transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>${{ number_format($transaction['amount'], 2) }}</td>
                                                <td>
                                                    @if($transaction['type'] == 'trade')
                                                        <span class="badge bg-pink-transparent">Trading</span>
                                                    @elseif($transaction['type'] == 'save')
                                                        <span class="badge bg-info-transparent">Savings</span>
                                                    @elseif($transaction['type'] == 'invest')
                                                        <span class="badge bg-primary-transparent">Investment</span>
                                                    @elseif($transaction['type'] == 'wallet')
                                                        <span class="badge bg-dark-transparent">Wallet</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction['description'] }}</td>
                                                <td>
                                                    @if($transaction['method'] == 'credit')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Credit</span>
                                                    @elseif($transaction['method'] == 'debit')
                                                        <span class="badge bg-danger-transparent"><i class="ri-info-fill align-middle me-1"></i>Debit</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction['status'] == 'approved')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Approved</span>
                                                    @elseif($transaction['status'] == 'pending')
                                                        <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                    @elseif($transaction['status'] == 'decline')
                                                        <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Decline</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                        @if($transactions->count() == 0)
                                            <tr>
                                                <p class="py-4 text-center">
                                                    No Transactions...
                                                </p>
                                            </tr>
                                        @endif

                                        <div class="card-footer border-top-0">
                                            <div class="d-flex align-items-center">
                                                <div> Showing {{ $transactions->count() }} of {{ $transactions->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                                <div class="ms-auto">
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-2 -->
    </div>
</div>
<!-- End::app-content -->

<div class="modal fade" id="nairaDepositModal" tabindex="-1" role="dialog" aria-labelledby="nairaDepositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <form method="POST" action="{{ route('deposit') }}" id="depositForm">
                @csrf
                <div class="my-4">
                    <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Make a Deposit</h5>
                </div>
                <div class="modal-body">
                    <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                        <div class="col-xl-6">
                            <label for="amountDeposit" class="form-label">Deposit Amount</label>
                            <div class="input-group"> 
                                <input type="number" value="{{ old('amount') }}" required style="font-size: 14px" step="any" class="form-control" name="amount" id="amountDeposit" placeholder="Amount">
                                <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                            </div>
                            @error('amount')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label" for="duration-type">Choose deposit method</label>
                            <div class="input-group"> 
                                <select name="roi_duration" id="duration-type" class="form-control py-2">
                                    <option value="">Select method</option>
                                    <option value="coin">Cryptocurrency</option>
                                    <option value="bank">Bank Account</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="my-4">
                        <h4 class="text-center fs-13">You are about to make a deposit of <strong class="fw-bold text-primary amount-val">100USD</strong></h4>
                        <p class="text-center text-muted fs-10">Exchange Rate: 1USD - 0.99928USDT</strong></p>
                    </div>
                    
                    <div id="crypto" class="d-none">
                        <div class="my-4">
                            <p class="text-center fs-12 fw-medium">Carefully follow the procedures below for successful investment.</p>
                            <div class="d-flex justify-content-center mx-auto my-2">
                                <img width="130" height="130" src="https://upload.wikimedia.org/wikipedia/commons/5/5e/QR_Code_example.png" alt="...">
                            </div>
                            <p class="text-center fs-12 fw-medium">Scan the QR code above or copy and pay to this <span class="text-primary fw-bold">CRESTWOOD</span> address below:</p>
                        </div>

                        <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                            <div class="col-xl-12">
                                <div class="input-group">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave"><i class="ri-link me-2"></i></button>
                                    <input type="text" name="roi_method" class="form-control text-center" placeholder="Enter Method..." aria-label="Stock Quantity" value="Wewrreik#$whhjzgehgnqkjskfpscnhsbfrghsxbdgnkdhjgh" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="account_type" value="wallet">

                        <div id="" class="alert mx-3 alert-primary mt-2">
                            <h4 class="text-danger fs-13">Please Note</h4>
                            <div class="">
                                    <p class="fs-12 text-muted"> <i class="fe fe-info text-primary fs-12 me-2"></i> Please ensure you deposit the exact amount of cryptocurrency before confirming your transaction</p>
                            </div>
                            <div class="">
                                    <p class="fs-12 text-muted"> <i class="fe fe-info text-primary fs-12 me-2"></i> Incase the current session closed after you made payment, you can always start a new transaction with the exact amount you deposited.</p>
                            </div>
                            <div class="">
                                    <p class="fs-12 text-muted"> <i class="fe fe-info text-primary fs-12 me-2"></i> Our customer care representatives are always available for support.</p>
                            </div>
                        </div>
                        <p class="text-dark fs-13 text-center fw-medium">Already made payment of <span class="fw-bold text-primary amount-val">100USD</span> to the wallet address above® <br> Click the button below to confirm transaction.</p>
                    </div>
                    <div id="bank" class="">
                        <div class="my-2">
                            <p class="text-center fs-12 fw-medium">You are making a deposit into the following account detail</p>
                        </div>
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12" style="max-width: 500px;">
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Name</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="Crestwood Capital LTD" disabled>
                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                </div>
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Number</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="0092431552" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                </div>
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Bank Name</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="Swiss Banks LTD" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                </div>
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">SWISS Code</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="3352241" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="card"  class="btn btn-primary-transparent" style="width: 100%;" >Confirm Deposit</button>
                    <button type="button" class="btn btn-secondary-transparent" style="width: 100%;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="nairaWithdrawalModal" tabindex="-1" role="dialog" aria-labelledby="nairaWithdrawalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <form method="POST" action="{{ route('withdraw') }}" id="withdrawalForm">
                @csrf
                <div class="my-4">
                    <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Withdrawal</h5>
                </div>
                <div class="modal-body">
                    <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                        <div class="col-xl-6">
                            <label for="amountDeposit" class="form-label">Deposit Amount</label>
                            <div class="input-group"> 
                                <input type="number" value="{{ old('amount') }}" required style="font-size: 14px" step="any" class="form-control" name="amount" id="amountDeposit" placeholder="Amount">
                                <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                            </div>
                            @error('amount')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label" for="duration-type">Choose withdrawal method</label>
                            <div class="input-group"> 
                                <select name="roi_duration" id="duration-type" class="form-control py-2">
                                    <option value="coin">Cryptocurrency</option>
                                    <option value="bank">Bank Account</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="my-4">
                        <h4 class="text-center fs-13">You are about to make a withdrawal of <strong class="fw-bold text-primary amount-val">100USD</strong></h4>
                        <p class="text-center text-muted fs-10">Exchange Rate: 1USD - 0.99928USDT</strong></p>
                    </div>
                    <div id="bank" class="">
                        <div class="my-2">
                            <p class="text-center fs-12 fw-medium">Confirm you are making a withrawal to your account detail below</p>
                        </div>
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12" style="max-width: 500px;">
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Name</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="John Doe" disabled>
                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                </div>
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Number</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="0092431552" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13">
                                </div>
                                <div class="input-group my-3">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Bank Name</button>
                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="Dukas Copy Swiss" disabled>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="card"  class="btn btn-primary-transparent" style="width: 100%;" >Confirm Withdrawal</button>
                    <button type="button" class="btn btn-secondary-transparent" style="width: 100%;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            {{-- <form method="POST" action="{{ route('withdraw') }}" id="withdrawalForm">
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="amountWithdraw">Amount</label>
                            <input type="number" required value="{{ old('amount') }}" style="height: 45px; font-size: 14px" step="any" class="form-control" name="amount" id="amountWithdraw" placeholder="Amount">
                            @error('amount')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group my-3">
                            <input type="hidden" name="type" value="deposit">
                            <label for="paymentDeposit" class="form-label">Account Type</label>
                            <select name="account_type" style="height: 45px; font-size: 14px" class="form-control text-dark" required id="paymentDeposit">
                                <option value="">Select Account</option>
                                <option value="savings">Savings</option>
                                <option value="investment">Investments</option>
                                <option value="trading">Trade</option>
                            </select>
                            @error('payment')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                    <div class="small text-info mt-2">Your withdrawal will be paid to the account details</div>
                    <div class="alert alert-primary my-2">
                        <table>
                            <tr>
                                <td>Bank Name:</td>
                                <td><span class="ml-3">{{ auth()->user()['bank_name'] }}</span></td>
                            </tr>
                            <tr>
                                <td>Account Name:</td>
                                <td><span class="ml-3">{{ auth()->user()['account_name'] }}</span></td>
                            </tr>
                            <tr>
                                <td>Account Number:</td>
                                <td><span class="ml-3">{{ auth()->user()['account_number'] }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="small text-primary">
                        <a class="text-warning" href="{{ route('profile') }}">
                            Change Acconunt Details
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if(\App\Models\Setting::all()->first()['withdrawal'] == 1)
                        <button type="submit" class="btn btn-primary">Process Withdrawal</button>
                    @else
                        <button type="button" disabled class="btn btn-secondary">Unavailable</button>
                    @endif
                </div>
            </form> --}}
        </div>
    </div>
</div>

<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>


<script>
    $(document).ready(function() {
    // 1. Set "Cryptocurrency" as the default option and the amount to 100
    $('#duration-type').val('coin');
    $('#amountDeposit').val(100);

    // 2. Show/hide the correct div based on the selected deposit method
    function toggleMethod() {
        var method = $('#duration-type').val();
        if (method === 'coin') {
            $('#crypto').removeClass('d-none');
            $('#bank').addClass('d-none');
        } else if (method === 'bank') {
            $('#bank').removeClass('d-none');
            $('#crypto').addClass('d-none');
        }
    }

    toggleMethod(); // Initial load check

    $('#duration-type').on('change', function() {
        toggleMethod();
    });

    // 3. Dynamically update the deposit amount in the summary text
    $('#amountDeposit').on('input', function() {
        var amount = $(this).val() || 0; // Set to 0 if the input is empty
        $('.amount-val').text(amount + 'USD');
    });

    // Function to handle copy to clipboard
    function copyToClipboard(text, button) {
        // Use the modern clipboard API to copy text
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                // Change button text on successful copy
                $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');
                
                // Revert button text after 3 seconds
                setTimeout(function() {
                    $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
                }, 3000);
            }).catch(function(error) {
                console.error('Failed to copy text: ', error);
            });
        } else {
            // Fallback to older execCommand method (for older browsers)
            var tempInput = $("<input>");
            $("body").append(tempInput);
            tempInput.val(text).select();
            document.execCommand("copy");
            tempInput.remove();

            // Change button text on successful copy
            $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');
            
            // Revert button text after 3 seconds
            setTimeout(function() {
                $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
            }, 3000);
        }
    }

    // Attach click event for copy buttons
    $('.copy-btn').on('click', function() {
        // Find the input field next to the button and get its value
        var textToCopy = $(this).closest('.input-group').find('input').val();
        copyToClipboard(textToCopy, this);
    });
});

</script>


<script>
    // Convert the PHP data into JavaScript arrays
    var dates = @json($dates->toArray());
    var alignedSavings = @json($alignedSavings->toArray());
    var alignedInvestments = @json($alignedInvestments->toArray());
    var alignedTrading = @json($alignedTrading->toArray());

    var options = {
        series: [{
            name: 'Savings',
            data: alignedSavings // Use the aligned savings data from the controller
        }, {
            name: 'Investments',
            data: alignedInvestments // Use the aligned investments data
        }, {
            name: 'Trading',
            data: alignedTrading // Use the aligned trading data
        }],
        chart: {
            height: 320,
            type: 'area'
        },
        colors: ["#8274ff", "#ff6937", "#58c437"],
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
            categories: dates,
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
                    cssClass: 'apexcharts-yaxis-label',
                },
            }
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    // Initialize the chart
    var chart = new ApexCharts(document.querySelector("#area-spline"), options);
    chart.render();

    // Function to update the chart based on time filter (daily, weekly, monthly)
    function updateChart(timeframe) {
        var filteredDates = [];
        var filteredSavings = [];
        var filteredInvestments = [];
        var filteredTrading = [];

        if (timeframe === 'daily') {
            filteredDates = dates; // Use original daily data
            filteredSavings = alignedSavings;
            filteredInvestments = alignedInvestments;
            filteredTrading = alignedTrading;
        } else if (timeframe === 'weekly') {
            // Group data by week
            var groupedData = groupDataByTimeframe(dates, alignedSavings, alignedInvestments, alignedTrading, 'week');
            filteredDates = groupedData.dates;
            filteredSavings = groupedData.savings;
            filteredInvestments = groupedData.investments;
            filteredTrading = groupedData.trading;
        } else if (timeframe === 'monthly') {
            // Group data by month
            var groupedData = groupDataByTimeframe(dates, alignedSavings, alignedInvestments, alignedTrading, 'month');
            filteredDates = groupedData.dates;
            filteredSavings = groupedData.savings;
            filteredInvestments = groupedData.investments;
            filteredTrading = groupedData.trading;
        }

        // Update chart data
        chart.updateOptions({
            xaxis: {
                categories: filteredDates
            },
            series: [{
                name: 'Savings',
                data: filteredSavings
            }, {
                name: 'Investments',
                data: filteredInvestments
            }, {
                name: 'Trading',
                data: filteredTrading
            }]
        });
    }

    // Helper function to group data by week or month
    function groupDataByTimeframe(dates, savings, investments, trading, timeframe) {
        var groupedDates = [];
        var groupedSavings = [];
        var groupedInvestments = [];
        var groupedTrading = [];

        var currentSumSavings = 0;
        var currentSumInvestments = 0;
        var currentSumTrading = 0;
        var currentTimeFrame = null;

        for (var i = 0; i < dates.length; i++) {
            var date = new Date(dates[i]);
            var currentFrameKey = (timeframe === 'week') ? getWeekNumber(date) : date.getMonth();

            if (currentTimeFrame === null) {
                currentTimeFrame = currentFrameKey;
            }

            if (currentFrameKey !== currentTimeFrame) {
                groupedDates.push(formatDateForTimeframe(currentTimeFrame, timeframe));
                groupedSavings.push(currentSumSavings);
                groupedInvestments.push(currentSumInvestments);
                groupedTrading.push(currentSumTrading);

                currentSumSavings = 0;
                currentSumInvestments = 0;
                currentSumTrading = 0;
                currentTimeFrame = currentFrameKey;
            }

            currentSumSavings += savings[i];
            currentSumInvestments += investments[i];
            currentSumTrading += trading[i];
        }

        // Push the last group
        groupedDates.push(formatDateForTimeframe(currentTimeFrame, timeframe));
        groupedSavings.push(currentSumSavings);
        groupedInvestments.push(currentSumInvestments);
        groupedTrading.push(currentSumTrading);

        return {
            dates: groupedDates,
            savings: groupedSavings,
            investments: groupedInvestments,
            trading: groupedTrading
        };
    }

    // Get the week number of a date
    function getWeekNumber(d) {
        var date = new Date(d);
        var oneJan = new Date(date.getFullYear(), 0, 1);
        return Math.ceil((((date - oneJan) / 86400000) + oneJan.getDay() + 1) / 7);
    }

    // Format date for week or month display
    function formatDateForTimeframe(frameKey, timeframe) {
        if (timeframe === 'week') {
            return 'Week ' + frameKey;
        } else if (timeframe === 'month') {
            return 'Month ' + (frameKey + 1); // Months are zero-indexed in JS
        }
    }
</script>


@endsection
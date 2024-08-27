@extends('layouts.user.index')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Ecommerce</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Dashboards
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ecommerce</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button>
                <button type="button" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-upload-2-line me-2"></i> Export report
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-9">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="main-card-icon primary mb-4">
                                        <div
                                        class="avatar avatar-lg bg-primary border border-primary border-opacity-10">
                                        <div class="avatar avatar-sm bg-white-transparent svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <rect width="256" height="256" fill="none" />
                                                <rect x="32" y="72" width="192" height="136" rx="8"
                                                    opacity="0.2" />
                                                <rect x="32" y="72" width="192" height="136" rx="8"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="16" />
                                                <path d="M88,96V64a40,40,0,0,1,80,0V96" fill="none"
                                                    stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="16" />
                                            </svg>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="ms-1">
                                        <span class="d-block mb-2">Savings Balance</span>
                                        <h4 class="fw-semibold mb-0">&#36; {{ number_format($savings, 2) }}</h4>
                                    </div>
                                </div>
                                <!-- <span class="text-success">0.45%<i
                                        class="ti ti-arrow-narrow-up ms-1 d-inline-block"></i></span><span
                                    class="fs-12 text-muted ms-1">This week</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="main-card-icon primary mb-4">
                                        <div
                                            class="avatar avatar-lg bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <path
                                                        d="M62.55,144H188.1a16,16,0,0,0,15.74-13.14L216,64H48Z"
                                                        opacity="0.2" />
                                                    <path
                                                        d="M180,184H83.17a16,16,0,0,1-15.74-13.14L41.92,30.57A8,8,0,0,0,34.05,24H16"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <circle cx="84" cy="204" r="20" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <circle cx="180" cy="204" r="20" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <path d="M62.55,144H188.1a16,16,0,0,0,15.74-13.14L216,64H48"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="ms-1">
                                        <span class="d-block mb-2">Investment Balance</span>
                                        <h4 class="fw-semibold mb-0">&#36; {{ number_format($investment, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="main-card-icon primary mb-4">
                                        <div
                                            class="avatar avatar-lg bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <path d="M128,128h24a40,40,0,0,1,0,80H128Z" opacity="0.2" />
                                                    <path d="M128,48H112a40,40,0,0,0,0,80h16Z" opacity="0.2" />
                                                    <line x1="128" y1="24" x2="128" y2="232" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <path
                                                        d="M184,88a40,40,0,0,0-40-40H112a40,40,0,0,0,0,80h40a40,40,0,0,1,0,80H104a40,40,0,0,1-40-40"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="ms-1">
                                        <span class="d-block mb-2">Tradning Balance</span>
                                        <h4 class="fw-semibold mb-0">&#36;{{ number_format($trading, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Order Status
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="p-2 fs-12 text-muted"
                                        data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i
                                            class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu"
                                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 28px);"
                                        data-popper-placement="bottom-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="order-status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card card-bg-primary ecommerce-card">
                            <div class="card-header border-bottom-0">
                                <div class="card-title text-fixed-white">
                                    Sales Overview
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="d-flex align-items-start gap-3 px-3">
                                    <div class="main-card-icon secondary p-0">
                                        <div
                                            class="avatar avatar-lg p-2 bg-white-transparent svg-white shadow-sm">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M96,40l33.52,88H56Zm104,88H129.52L160,208Z"
                                                        opacity="0.2"></path>
                                                    <path
                                                        d="M240,128a8,8,0,0,1-8,8H204.94l-37.78,75.58A8,8,0,0,1,160,216h-.4a8,8,0,0,1-7.08-5.14L95.35,60.76,63.28,131.31A8,8,0,0,1,56,136H24a8,8,0,0,1,0-16H50.85L88.72,36.69a8,8,0,0,1,14.76.46l57.51,151,31.85-63.71A8,8,0,0,1,200,120h32A8,8,0,0,1,240,128Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="mb-2">Total Sales</div>
                                        <div class="text-muted mb-0 fs-12 d-flex align-items-center">
                                            <h5 class="fs-4 mb-0 flex-fill fw-medium text-fixed-white">
                                                12,564
                                            </h5>
                                            <a href="javascript:void(0)" class="text-primary fw-semibold">View
                                                All <i class="fe fe-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="audience-report"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Recent Orders
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="p-2 fs-12 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="true"> Sort By <i
                                            class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> </a>
                                    <ul class="dropdown-menu" role="menu"
                                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 28px);"
                                        data-popper-placement="bottom-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Month</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="circle-container">
                                    <div id="recent-orders" class="p-3"></div>
                                    <div class="accets-circle-style"></div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-12">Delivered</p>
                                        <h6 class="fw-semibold">65.7%</h6>
                                    </div>
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-12">Cancelled</p>
                                        <h6 class="fw-semibold">23.2%</h6>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p class="text-muted mb-1 fs-12">Pending</p>
                                        <h6 class="fw-semibold">10.5%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->

        <!-- Start:: row-3 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Recent Invoices</div>
                        <div class="d-flex flex-wrap gap-2">
                            <div>
                                <input class="form-control form-control-sm" type="text"
                                    placeholder="Search Here" aria-label=".form-control-sm example">
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                    data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i
                                        class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">New</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_All"
                                                    value="" aria-label="...">
                                            </span>
                                        </th>
                                        <th>Customer</th>
                                        <th>Order Id </th>
                                        <th class="text-center">Quantity</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Ordered Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_1"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/15.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0)" class="fs-14">Simon Cowall</a>
                                                    <span
                                                        class="d-block text-muted fs-12">simoncowall2143@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">#1537890</span>
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-transparent">Shipped</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold fs-14">$4320.29</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">25,Nov 2022</span>
                                        </td>
                                        <td>
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_2"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/4.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascirpt:void(0);" class="fs-14">Meisha Kerr</a>
                                                    <span
                                                        class="d-block text-muted fs-12">meishakerr789@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">#1539078</span>
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-transparent">Cancelled</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold fs-14">$6745.99</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">29,Nov 2022</span>
                                        </td>
                                        <td>
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_3"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/5.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascirpt:void(0);" class="fs-14">Jessica</a>
                                                    <span
                                                        class="d-block text-muted fs-12">jessicastellar@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">#1539832</span>
                                        </td>
                                        <td class="text-center">
                                            2
                                        </td>
                                        <td>
                                            <span class="badge bg-info-transparent">Under Process</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold fs-14">$1176.89</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">04,Dec 2022</span>
                                        </td>
                                        <td>
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_4"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/6.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascirpt:void(0);" class="fs-14">Amanda B</a>
                                                    <span
                                                        class="d-block text-muted fs-12">amandabella786@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">#1539832</span>
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-transparent">Shipped</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold fs-14">$1899.99</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">10,Dec 2022</span>
                                        </td>
                                        <td>
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_5"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/11.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascirpt:void(0);" class="fs-14">Jason
                                                        Stathman</a>
                                                    <span
                                                        class="d-block text-muted fs-12">jasonstathman549@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">#1538267</span>
                                        </td>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-transparent">Pending</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold fs-14">$1867.29</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">18,Dec 2022</span>
                                        </td>
                                        <td>
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center border-bottom-0">
                                            <span>
                                                <input class="form-check-input" type="checkbox" id="order_6"
                                                    value="" aria-label="...">
                                            </span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                        <img src="../assets/images/faces/13.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <a href="javascirpt:void(0);" class="fs-14">Khabib
                                                        Hussain</a>
                                                    <span
                                                        class="d-block text-muted fs-12">khabibhussain645@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="fw-semibold">#1537890</span>
                                        </td>   
                                        <td class="border-bottom-0 text-center">
                                            1
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="badge bg-primary-transparent">Success</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="fw-semibold fs-14">$2439.99</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <span class="text-muted">24,Dec 2022</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="hstack gap-2 fs-1">
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-primary-light btn-wave"><i
                                                        class="ri-download-2-line"></i></a>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm btn-secondary-light btn-wave"><i
                                                        class="ri-edit-line"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <div> Showing 6 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                            <div class="ms-auto">
                                <nav aria-label="Page navigation" class="pagination-style-4">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled"> <a class="page-link"
                                                href="javascript:void(0);"> Prev </a> </li>
                                        <li class="page-item active"><a class="page-link"
                                                href="javascript:void(0);">1</a></li>
                                        <li class="page-item"><a class="page-link"
                                                href="javascript:void(0);">2</a></li>
                                        <li class="page-item"> <a class="page-link text-primary"
                                                href="javascript:void(0);"> next </a> </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-3 -->

    </div>
</div>
<!-- End::app-content -->


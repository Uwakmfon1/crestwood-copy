@extends('layouts.user.index')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
    @include('partials.users.alert')
        <!-- Page Header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Profile</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Overview</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- <div class="d-flex gap-2">
                <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button>
                <button type="button" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-upload-2-line me-2"></i> Export report
                </button>
            </div> -->
        </div>
        <!-- Page Header Close -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-9">
                <div class="card custom-card profile-card">
                    <img height="160" src="https://img.freepik.com/free-vector/gradient-purple-striped-background_23-2149583760.jpg" class="card-img-top" alt="...">
                    <div class="card-body p-4 pb-0 position-relative">
                        <span class="avatar avatar-xxl avatar-rounded bg-info online">
                            <img width="40" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTr3jhpAFYpzxx39DRuXIYxNPXc0zI5F6IiMQ&s" alt="">
                        </span>
                        @if(auth()->user()->getAvatar())
                            <span class="avatar avatar-xxl avatar-rounded bg-info online">
                                <img width="80px"  src="{{ auth()->user()->getAvatar() }}" style="border-radius: 5px" alt="{{ auth()->user()['name'] }}">
                            </span>
                        @else
                            <span class="avatar avatar-xxl avatar-rounded bg-info online">
                                <img width="40" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTr3jhpAFYpzxx39DRuXIYxNPXc0zI5F6IiMQ&s" alt="">
                            </span>
                        @endif
                        <div
                            class="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div>
                                <h5 class="fw-semibold mb-1"><h6>{{ auth()->user()['name'] }}</h6></h5>
                                <span class="d-block fw-medium text-muted mb-1">{{ auth()->user()['email'] }}</span>
                                <p class="fs-12 mb-0 fw-medium text-muted"> <span class="me-3"><i
                                            class="ri-building-line me-1 align-middle"></i>{{ auth()->user()['created_at']->format('F d, Y') }}</span>
                                </p>
                            </div>
                            <div class="d-flex mb-0 flex-wrap gap-4">
                                <div class="py-2 px-3 rounded d-flex align-items-center border  gap-3">
                                    <div class="main-card-icon secondary">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M136,108A52,52,0,1,1,84,56,52,52,0,0,1,136,108Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">${{ number_format($balance, 2)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Wallet</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M224,118.31V200a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V118.31h0A191.14,191.14,0,0,0,128,144,191.08,191.08,0,0,0,224,118.31Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M104,112a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H112A8,8,0,0,1,104,112ZM232,72V200a16,16,0,0,1-16,16H40a16,16,0,0,1-16-16V72A16,16,0,0,1,40,56H80V48a24,24,0,0,1,24-24h48a24,24,0,0,1,24,24v8h40A16,16,0,0,1,232,72ZM96,56h64V48a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8ZM40,72v41.62A184.07,184.07,0,0,0,128,136a184,184,0,0,0,88-22.39V72ZM216,200V131.63A200.25,200.25,0,0,1,128,152a200.19,200.19,0,0,1-88-20.36V200H216Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($trading)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Trade</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M208,40H48a8,8,0,0,0-8,8V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V48A8,8,0,0,0,208,40ZM57.78,216A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,70.22,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM68.67,208A64.45,64.45,0,0,1,87.8,182.2a64,64,0,0,1,80.4,0A64.45,64.45,0,0,1,187.33,208ZM208,208h-3.67a79.87,79.87,0,0,0-46.69-50.29,48,48,0,1,0-59.28,0A79.87,79.87,0,0,0,51.67,208H48V48H208V208Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Savings</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M208,40H48a8,8,0,0,0-8,8V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V48A8,8,0,0,0,208,40ZM57.78,216A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,70.22,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM68.67,208A64.45,64.45,0,0,1,87.8,182.2a64,64,0,0,1,80.4,0A64.45,64.45,0,0,1,187.33,208ZM208,208h-3.67a79.87,79.87,0,0,0-46.69-50.29,48,48,0,1,0-59.28,0A79.87,79.87,0,0,0,51.67,208H48V48H208V208Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Investment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-xl-3">
                        <div class="card custom-card">
                            <div class="card-body">
                                <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 d-sm-flex d-inline-block"
                                    role="tablist">
                                    <li class="nav-item m-1" role="presentation">
                                        <a class="nav-link active" id="profile-about-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile-about-tab-pane" type="button" role="tab"
                                            aria-controls="profile-about-tab-pane" aria-selected="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M224,128a95.76,95.76,0,0,1-31.8,71.37A72,72,0,0,0,128,160a40,40,0,1,0-40-40,40,40,0,0,0,40,40,72,72,0,0,0-64.2,39.37h0A96,96,0,1,1,224,128Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M221.35,104.11a8,8,0,0,0-6.57,9.21A88.85,88.85,0,0,1,216,128a87.62,87.62,0,0,1-22.24,58.41,79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75A88,88,0,0,1,128,40a88.76,88.76,0,0,1,14.68,1.22,8,8,0,0,0,2.64-15.78,103.92,103.92,0,1,0,85.24,85.24A8,8,0,0,0,221.35,104.11ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM237.66,45.66l-32,32a8,8,0,0,1-11.32,0l-16-16a8,8,0,0,1,11.32-11.32L200,60.69l26.34-26.35a8,8,0,0,1,11.32,11.32Z">
                                                </path>
                                            </svg>
                                            About Me</a>
                                    </li>
                                    <li class="nav-item m-1" role="presentation">
                                        <a class="nav-link" id="edit-profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#edit-profile-tab-pane" type="button" role="tab"
                                            aria-controls="edit-profile-tab-pane" aria-selected="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M215.17,127.43,184,72H72L40.83,127.43a8,8,0,0,0,.73,8.29L128,248l86.43-112.28A8,8,0,0,0,215.17,127.43ZM128,152a20,20,0,1,1,20-20A20,20,0,0,1,128,152Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M222.33,123.89c-.06-.13-.12-.26-.19-.38L192,69.9V32a16,16,0,0,0-16-16H80A16,16,0,0,0,64,32V69.92L33.86,123.51c-.07.12-.13.25-.2.38a15.94,15.94,0,0,0,1.46,16.57l.11.14,86.44,112.28a8,8,0,0,0,12.67,0L220.77,140.6l.11-.14A15.92,15.92,0,0,0,222.33,123.89ZM176,32V64H80V32ZM128,144a12,12,0,1,1,12-12A12,12,0,0,1,128,144Zm8,80.5V158.83a28,28,0,1,0-16,0v65.66L48,131,76.69,80H179.32L208,131Z">
                                                </path>
                                            </svg> Edit Profile</a>
                                    </li>
                                    <li class="nav-item m-1" role="presentation">
                                        <a class="nav-link" id="timeline-tab" data-bs-toggle="tab"
                                            data-bs-target="#timeline-tab-pane" type="button" role="tab"
                                            aria-controls="timeline-tab-pane" aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M192,184v32a8,8,0,0,1-8,8H72a8,8,0,0,1-8-8V184Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M200,75.64V40a16,16,0,0,0-16-16H72A16,16,0,0,0,56,40V76a16.07,16.07,0,0,0,6.4,12.8L114.67,128,62.4,167.2A16.07,16.07,0,0,0,56,180v36a16,16,0,0,0,16,16H184a16,16,0,0,0,16-16V180.36a16.08,16.08,0,0,0-6.35-12.76L141.27,128l52.38-39.59A16.09,16.09,0,0,0,200,75.64ZM178.23,176H77.33L128,138ZM72,216V192H184v24ZM184,75.64,128,118,72,76V40H184Z">
                                                </path>
                                            </svg> TimeLine</a>
                                    </li>
                                    <li class="nav-item m-1" role="presentation">
                                        <a class="nav-link" id="gallery-tab" data-bs-toggle="tab"
                                            data-bs-target="#gallery-tab-pane" type="button" role="tab"
                                            aria-controls="gallery-tab-pane" aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M224,56V178.06l-39.72-39.72a8,8,0,0,0-11.31,0L147.31,164,97.66,114.34a8,8,0,0,0-11.32,0L32,168.69V56a8,8,0,0,1,8-8H216A8,8,0,0,1,224,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z">
                                                </path>
                                            </svg> Gallery</a>
                                    </li>
                                    <li class="nav-item m-1" role="presentation">
                                        <a class="nav-link" id="friends-tab" data-bs-toggle="tab"
                                            data-bs-target="#friends-tab-pane" type="button" role="tab"
                                            aria-controls="friends-tab-pane" aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M136,108A52,52,0,1,1,84,56,52,52,0,0,1,136,108Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                                </path>
                                            </svg> Friends</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title"> Followers </div> <a href="javascript:void(0);"
                                    class="fs-12 text-muted tag-link"> View All<i
                                        class="ti ti-arrow-narrow-right ms-1"></i> </a>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/1.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Amelia Turner</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/14.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Henry Morgan</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/3.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Aurora Reed</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/10.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Leo Phillips</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/5.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Ava Taylor</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lh-1"> <span class="avatar avatar-sm avatar-rounded">
                                                    <img src="../assets/images/faces/7.jpg" alt=""> </span>
                                            </div>
                                            <div class="flex-fill"> <span class="fw-medium">Luna Park</span>
                                            </div>
                                            <div> <button class="btn btn-sm btn-icon btn-primary-light"> <i
                                                        class="ri-add-line lh-1 align-middle"></i> </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xl-12">
                        <div class="tab-content" id="profile-tabs">
                            <div class="tab-pane show active p-0 border-0" id="profile-about-tab-pane"
                                role="tabpanel" aria-labelledby="profile-about-tab" tabindex="0">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-3">
                                        <form class="forms-sample row" id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group col-md-6">
                                                <label class="form-label text-muted fs-12" for="exampleInputUsername1">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ old('name') ?? auth()->user()['name'] }}" name="name" id="exampleInputUsername1" placeholder="Name">
                                                @error('name')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="email">Email address <span class="text-danger">*</span></label>
                                                <input type="email" value="{{ auth()->user()['email'] }}" class="form-control" disabled name="email" id="email" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="country">Country <span class="text-danger">*</span></label>
                                                <select name="country" id="country" class="form-control text-dark">
                                                    {{-- @foreach(\App\Models\User::$countries as $key => $country)
                                                            <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">{{ $country['phonecode']}}</option>
                                                        @endforeach --}}
                                                        <option value="">Select Country</option>
                                                        @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                                            <option value="{{ $country->name }}"
                                                                @if(old('country') !== null && old('country') == $country->name)
                                                                    selected
                                                                @elseif(auth()->user()->country == $country->name && old('country') === null)
                                                                    selected
                                                                @elseif(auth()->user()->country === null && $country->name == 'Nigeria')
                                                                    selected
                                                                @endif
                                                            >
                                                                {{ ucwords($country->name) }}
                                                            </option>
                                                        @endforeach

                                                </select>
                                                @error('country')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="phone">Phone <span class="text-danger">*</span></label>
                                                <div class="d-flex mb-3">
                                                    <select name="phone_code" style="width: 25%" class="form-control text-muted">
                                                        @foreach(\App\Models\User::$countries as $key => $country)
                                                            <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">+{{ $country['phonecode']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required value="{{ old('phone') ?? auth()->user()['phone'] }}">
                                                </div>
                                                @error('phone')
                                                <span class="text-danger small" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="state">State <span class="text-danger">*</span></label>
                                                <select class="form-select @error('state') is-invalid @enderror" name="state" id="state">
                                                    @if(old('country') || auth()->user()['country'])
                                                        <option value="">Select State</option>
                                                        @foreach(\App\Models\Country::query()->where('name', old('country') ?? auth()->user()['country'])->first()->states()->orderBy('name')->get() as $state)
                                                            <option value="{{ $state->name }}" @if((old('state') ?? auth()->user()['state']) == $state->name) selected @endif>{{ ucwords($state->name) }}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected value="">Select A Country</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="city">City <span class="text-danger">*</span></label>
                                                <input type="text" value="{{ old("city") ?? auth()->user()['city'] }}" class="form-control" name="city" id="city" placeholder="City">
                                                @error('city')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="form-label mt-2 text-muted fs-12" for="address">Address <span class="text-danger">*</span></label>
                                                <input type="text" value="{{ old("address") ?? auth()->user()['address'] }}" class="form-control" name="address" id="address" placeholder="Address">
                                                @error('address')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="avatar">Avatar</label>
                                                <input type="file" id="avatar" name="avatar" class="form-control"/>
                                                @error('avatar')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="id">Valid Identification </label>
                                                <input type="file" id="id" name="id" class="form-control"/>
                                                @error('id')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-4 pt-4">
                                                <h6 class="card-title">Bank Information</h6>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="bankList">Bank Name <span class="text-danger">*</span></label>
                                                <select name="bank_name" class="form-control text-dark" id="bankList">
                                                    @if(count($banks) > 0)
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option @if(old("bank_name") == $bank['name'] || auth()->user()['bank_name'] == $bank['name']) selected @endif value="{{ $bank['name'] }}" data-code="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Error Fetching Banks</option>
                                                    @endif
                                                </select>
                                                @error('bank_name')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <input type="hidden" id="bankCode" value="@if(count($banks) > 0) @foreach($banks as $bank) @if(auth()->user()['bank_name'] == $bank['name']) {{ $bank['code'] }} @endif @endforeach @endif">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="account_number">Account Number <span class="text-danger">*</span></label>
                                                <input type="text" value="{{ old("account_number") ?? auth()->user()['account_number'] }}" class="form-control" name="account_number" id="account_number" placeholder="Account Number">
                                                @error('account_number')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="form-label mt-2 text-muted fs-12" for="account_name" class="d-flex justify-content-between">
                                                    <span class="d-block">Account Name <span class="text-danger">*</span></span>
                                                    <span id="verifyingDisplay" class="small d-block"></span>
                                                </label>
                                                <input type="text" value="{{ old("account_name") ?? auth()->user()['account_name'] }}" readonly class="form-control" name="account_name" id="account_name" placeholder="Account Name">
                                                @error('account_name')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-4 pt-4">
                                                <h6 class="card-title">Next of Kin</h6>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="nk_name">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" value="{{ old("nk_name") ?? auth()->user()['nk_name'] }}" class="form-control" name="nk_name" id="nk_name" placeholder="Full Name">
                                                @error('nk_name')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label mt-2 text-muted fs-12" for="nk_phone">Phone <span class="text-danger">*</span></label>
                                                <div class="d-flex mb-3">
                                                    <select name="phone_code" style="height: 40px; font-size: 15px; width: 25%" class="form-control">
                                                        @foreach(\App\Models\User::$countries as $key => $country)
                                                            <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">{{ $country['phonecode']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control" name="nk_phone" id="nk_phone" placeholder="Phone" required value="{{ old('nk_phone') ?? auth()->user()['nk_phone'] }}">
                                                </div>
                                                @error('nk_phone')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="form-label mt-2 text-muted fs-12" for="nk_address">Address</label>
                                                <input type="text" value="{{ old("nk_address") ?? auth()->user()['nk_address'] }}" style="height: 40px; font-size: 15px" class="form-control" name="nk_address" id="nk_address" placeholder="Address">
                                                @error('nk_address')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-0 border-0" id="edit-profile-tab-pane" role="tabpanel"
                                aria-labelledby="edit-profile-tab" tabindex="0">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item p-4">
                                                <span class="fw-medium fs-15 d-block mb-3">Personal Info
                                                    :</span>
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">User Name :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="Ethan Brown">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">First Name :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="Ethan">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Last Name :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="Brown">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Designation :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="Chief Executive Officer (C.E.O)">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-4">
                                                <span class="fw-medium fs-15 d-block mb-3">Contact Info :</span>
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Email :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="email" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="your.email@example.com">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Phone :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="+1 (555) 123-4567">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Website :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="www.yourwebsite.com">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Location :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="Georgia, Washington D.C">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-4">
                                                <span class="fw-medium fs-15 d-block mb-3">Social Info :</span>
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Github :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="github.com/spruko">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Twitter :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="twitter.com/spruko.me">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Linkedin :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder"
                                                            value="linkedin.com/in/spruko">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Portfolio :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Placeholder" value="spruko.com/">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-4">
                                                <span class="fw-medium fs-15 d-block mb-3">About :</span>
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">Biographical Info :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <textarea class="form-control" id="text-area" rows="4">Hello there! I'm Ethan Brown, a dedicated CEO enthusiast hailing from Pune. My passion for developing fuels my exploration of the intricate nuances within software. Whether delving into designing or mastering new techniques, I'm always fueled by an insatiable thirst for knowledge and growth.
                                                    </textarea>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-4">
                                                <span class="fw-medium fs-15 d-block mb-3">Skills :</span>
                                                <div class="row gy-4 align-items-center">
                                                    <div class="col-xl-3">
                                                        <div class="lh-1">
                                                            <span class="fw-medium">skills :</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9">
                                                        <input class="form-control"
                                                            id="choices-text-preset-values" type="text"
                                                            value="Time Management, UX/UI Design, Cloud Computing, Version Control, Web Development, Problem-Solving, Continuous Learning, Customer Service, Budgeting and Finance, Leadership, Data Analysis, Adaptability"
                                                            placeholder="This is a placeholder">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-0 border-0" id="timeline-tab-pane" role="tabpanel"
                                aria-labelledby="timeline-tab" tabindex="0">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-4">
                                        <ul class="list-unstyled profile-timeline">
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm bg-primary-transparent avatar-rounded profile-timeline-avatar">
                                                        E
                                                    </span>
                                                    <p class="mb-2">
                                                        <span class="fw-semibold">Embarking on a fresh journey!
                                                            Ready to embrace new challenges and create
                                                            unforgettable experiences.<span
                                                                class="float-end fs-11 text-muted">24,Dec 2024 -
                                                                14:34</span>
                                                    </p>
                                                    <p class="profile-activity-media mb-0">
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-17.jpg"
                                                                alt="">
                                                        </a>
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-18.jpg"
                                                                alt="">
                                                        </a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                        <img src="../assets/images/faces/11.jpg" alt="">
                                                    </span>
                                                    <p class="mb-2">
                                                        Achieved a personal milestone today! &#127942; <span
                                                            class="text-primary fw-medium text-decoration-underline">#Hard
                                                            work pays off</span>.<span
                                                            class="float-end fs-11 text-muted">18,Dec 2024 -
                                                            12:16</span>
                                                    </p>
                                                    <p class="text-muted mb-0">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                        Repudiandae, repellendus rem rerum excepturi aperiam
                                                        ipsam temporibus inventore ullam tempora eligendi libero
                                                        sequi dignissimos cumque, et a sint tenetur consequatur
                                                        omnis!
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                        <img src="../assets/images/faces/4.jpg" alt="">
                                                    </span>
                                                    <p class="text-muted mb-2">
                                                        <span class="text-default">Participated in a
                                                            thought-provoking webinar covering [topic]. Always
                                                            striving to expand my knowledge horizons!
                                                            &#128218;</span>.<span
                                                            class="float-end fs-11 text-muted">21,Dec 2024 -
                                                            15:32</span>
                                                    </p>
                                                    <p class="profile-activity-media mb-0">
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/file-manager/3.png"
                                                                alt="">
                                                        </a>
                                                        <span class="fs-11 text-muted">432.87KB</span>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm bg-success-transparent avatar-rounded profile-timeline-avatar">
                                                        P
                                                    </span>
                                                    <p class="text-muted mb-2">
                                                        <span class="text-default">Shared a mouthwatering recipe
                                                            I experimented with. Cooking adventures are way to
                                                            explore creativity in the kitchen!
                                                            &#127858;</span>.<span
                                                            class="float-end fs-11 text-muted">28,Dec 2024 -
                                                            18:46</span>
                                                    </p>
                                                    <p class="profile-activity-media mb-2">
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-70.jpg"
                                                                alt="">
                                                        </a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                        <img src="../assets/images/faces/5.jpg" alt="">
                                                    </span>
                                                    <p class="text-muted mb-1">
                                                        <span class="text-default">Enjoyed a weekend getaway to
                                                            <span
                                                                class="fw-semibold text-primary text-decoration-underline">#Africa</span>.
                                                            Nature therapy at its best!</span>.<span
                                                            class="float-end fs-11 text-muted">11,Dec 2024 -
                                                            11:18</span>
                                                    </p>
                                                    <p class="text-muted">you are already feeling the tense
                                                        atmosphere of the video playing in the background</p>
                                                    <p class="profile-activity-media mb-0">
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-59.jpg"
                                                                class="m-1" alt="">
                                                        </a>
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-60.jpg"
                                                                class="m-1" alt="">
                                                        </a>
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-61.jpg"
                                                                class="m-1" alt="">
                                                        </a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <span
                                                        class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                        <img src="../assets/images/media/media-39.jpg" alt="">
                                                    </span>
                                                    <p class="mb-1">
                                                        Celebrated a dear friend's birthday with a surprise
                                                        bash! Nothing beats the joy of creating moments with
                                                        loved ones! &#127881;<span
                                                            class="float-end fs-11 text-muted">24,Dec 2024 -
                                                            14:34</span>
                                                    </p>
                                                    <p class="profile-activity-media mb-0">
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-26.jpg"
                                                                alt="">
                                                        </a>
                                                        <a href="javascript:void(0);">
                                                            <img src="../assets/images/media/media-29.jpg"
                                                                alt="">
                                                        </a>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-0 border-0" id="gallery-tab-pane" role="tabpanel"
                                aria-labelledby="gallery-tab" tabindex="0">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-40.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-40.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-41.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-41.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-42.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-42.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-43.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-43.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-44.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-44.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-45.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-45.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-46.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-46.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-60.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-60.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-26.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-26.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-32.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-32.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-30.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-30.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-31.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-31.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-46.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-46.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-59.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-59.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-61.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-61.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="../assets/images/media/media-42.jpg"
                                                    class="glightbox card" data-gallery="gallery1">
                                                    <img src="../assets/images/media/media-42.jpg" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-0 border-0" id="friends-tab-pane" role="tabpanel"
                                aria-labelledby="friends-tab" tabindex="0">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/2.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Luna Park</p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    lunapark2912@gmail.com</p>
                                                                <span class="badge bg-primary-transparent">Team
                                                                    Member</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/15.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Tristan Sawyer</p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    tristansawyer98@gmail.com</p>
                                                                <span class="badge bg-success-transparent">Team
                                                                    Lead</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/5.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Juniper Cruz</p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    junipercruz43@gmail.com</p>
                                                                <span class="badge bg-primary-transparent">Team
                                                                    Member</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/11.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Marina Silva</p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    marinasilva34@gmail.com</p>
                                                                <span class="badge bg-warning-transparent">Team
                                                                    Manager</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/7.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Daxton Reed</p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    daxtonreed45@gmail.com</p>
                                                                <span class="badge bg-primary-transparent">Team
                                                                    Member</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                <div class="card custom-card shadow-none border">
                                                    <div class="card-body p-4">
                                                        <div class="text-center">
                                                            <span class="avatar avatar-xl avatar-rounded">
                                                                <img src="../assets/images/faces/12.jpg" alt="">
                                                            </span>
                                                            <div class="mt-2">
                                                                <p class="mb-0 fw-semibold">Willow Blake </p>
                                                                <p class="fs-12 op-7 mb-1 text-muted">
                                                                    willowblake9456@gmail.com</p>
                                                                <span class="badge bg-primary-transparent">Team
                                                                    Member</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap justify-content-center">
                                                            <div class="btn-list">
                                                                <button
                                                                    class="btn btn-sm btn-light btn-wave">Block</button>
                                                                <button
                                                                    class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a aria-label="anchor"
                                                                    class="btn btn-primary-light btn-icon btn-sm btn-wave"
                                                                    href="javascript:void(0);"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Message</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Edit</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">View</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="text-center">
                                                    <button class="btn btn-primary-light btn-wave">Show
                                                        All</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header">
                        <div class="card-title">
                            Personal Info
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Name :</span>
                                <span class="text-muted">{{ $user->name }}</span>
                            </div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Email :</span><span
                                        class="text-muted">{{ $user->email }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Phone :</span><span class="text-muted">+1
                                {{ $user->phone ?? 'Not Set' }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Address :</span><span
                                        class="text-muted">{{ $user->address }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <span class="fw-medium me-2">Joined :</span>
                                    <span class="text-muted">{{ auth()->user()['created_at']->format('F d, Y') }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Referral Code:</span>
                                <span class="text-muted">
                                    <div class="d-flex my-2">
                                        <input type="text" id="refCode" class="form-control" value="{{ auth()->user()['ref_code'] }}" disabled>
                                        <button onclick="copyToClipboard('refCode')" class="btn btn-primary btn-sm">Copy </button>
                                    </div>
                                </span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Referral Link:</span>
                                <span class="text-muted">
                                    <div class="d-flex my-2">
                                        <input type="text" id="refLink" class="form-control" value="{{ url('/register?ref=').auth()->user()['ref_code'] }}" disabled>
                                        <button onclick="copyToClipboard('refLink')" class="btn btn-primary btn-sm">Copy </button>
                                    </div>
                                </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Identification
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(auth()->user()['identification'])
                            <div class="mt-2">
                                <img class="img-fluid" style="border-radius: 5px" src="{{ asset(auth()->user()['identification']) }}" alt="Identification">
                            </div>
                            <div class="mt-2 text-right">
                                <button onclick="confirmFormSubmit('downloadFileForm')" class="btn btn-sm btn-primary"><i class="icon-sm" data-feather="download"></i></button>
                            </div>
                            <form id="downloadFileForm" action="{{ route('download') }}" method="POST">
                                @csrf
                                <label>
                                    <input type="hidden" name="path" value="{{ auth()->user()['identification'] }}">
                                </label>
                            </form>
                        @else
                            <div class="mt-2">
                                <img class="img-fluid px-2 py-2" style="border-radius: 5px; max-width: 200px;" src="https://cdn.icon-icons.com/icons2/1760/PNG/512/4105938-account-card-id-identification-identity-card-profile-user-profile_113929.png" alt="Identification">
                                <p class="px-3">
                                    Not set...
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card custom-card">
                        <div class="card-body">
                            <h6 class="card-title fs-15">Change Password</h6>
                            <form class="forms-sample" @if(!auth()->user()->authenticatedWithSocials()) action="{{ route('password.custom.update') }}" method="POST"  @endif id="changePasswordForm">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="old_password">Old Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="old_password" class="form-control" id="old_password" autocomplete="off" placeholder="Old Password">
                                    @error('old_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="new_password">Old Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="new_password" class="form-control" id="new_password" autocomplete="off" placeholder="New Password">
                                    @error('new_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="confirm_password">Confirm Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" placeholder="Confirm Password">
                                </div>
                                @if(auth()->user()->authenticatedWithSocials())
                                    <button disabled type="button" class="btn btn-primary mr-2 my-3">Change Password</button>
                                @else
                                    <button type="button" onclick="confirmFormSubmit('changePasswordForm')" class="btn btn-primary mr-2 mt-3">Change Password</button>
                                @endif
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->

    </div>
</div>
<!-- End::app-content -->


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            $("select").attr("data-trigger", "");
            var countryID = $(this).val();
            if(countryID)
                $.ajax({
                    url: '/getStates/'+encodeURI(countryID),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        // $('#state').removeAttr('data-trigger');
                    $('select[name="state"]').empty()
                        .append('<option value="">Select State</option>')
                    $.each(data, function(key, value) {
                        // console.log(value.name, key);
                        $('select[name="state"]').append('<option value="'+ value.name +'">'+ value.name.charAt(0).toUpperCase() + value.name.slice(1) +'</option>');
                        });
                    }

                });

            else
                $('select[name="state"]').empty()
                    .append('<option value="">Select A Country</option>')

        });
    });

    function getPhoneCode(obj){
        document.getElementById('phone_code').innerHTML = obj.options[obj.selectedIndex].getAttribute('data-code');
        document.getElementById('phone_code_input').value = obj.options[obj.selectedIndex].getAttribute('data-code');
    }
    $(document).ready(function (){
        let bankList = $('#bankList');
        let bankCode = $('#bankCode');
        let accountNumber = $('#account_number');
        let accountName = $('#account_name');
        let verifyingDisplay = $('#verifyingDisplay');
        bankList.on('change', function (){
            $("#bankList option").each(function(){
                if($(this).val() === $('#bankList').val()){
                    bankCode.val($(this).attr('data-code'))
                }
            })
            verifyAccountNumber();
        });
        accountNumber.on('input', verifyAccountNumber);
        function verifyAccountNumber(){
            if (bankList.val() && accountNumber.val().length === 10 && bankCode.val()){
                verifyingDisplay.text('Verifying account number...');
                verifyingDisplay.removeClass('d-none');
                verifyingDisplay.removeClass('text-danger');
                verifyingDisplay.removeClass('text-success');
                verifyingDisplay.addClass('text-info');
                $.ajax({
                    url: "https://api.paystack.co/bank/resolve",
                    data: { account_number: accountNumber.val(), bank_code: bankCode.val().trim() },
                    type: "GET",
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('Authorization', 'Bearer {{ env('PAYSTACK_SECRET_KEY') }}');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('Accept', 'application/json');
                    },
                    success: function(res) {
                        verifyingDisplay.removeClass('text-info');
                        verifyingDisplay.addClass('text-success');
                        verifyingDisplay.text('Account details verified');
                        accountName.val(res.data.account_name);
                    },
                    error: function (err){
                        let msg = 'Error processing verification';
                        verifyingDisplay.removeClass('text-info');
                        verifyingDisplay.addClass('text-danger');
                        if (parseInt(err.status) === 422){
                            msg = 'Account details doesn\'t match any record';
                        }
                        verifyingDisplay.text(msg);
                    }
                });
            }else{
                accountName.val("");
                verifyingDisplay.addClass('d-none');
            }
        }
    });
</script>
@endsection
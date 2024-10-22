@extends('layouts.user.index')

@section('content')

<div class="main-content app-content">
            <div class="container-fluid">
            @include('partials.users.alert') 
                <!-- Start::page-header -->
                <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-2">Create Ticket</h1>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Support</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                        </ol>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('support.index') }}" class="btn btn-primary-transparent btn-wave waves-effect waves-light"> 
                            <i class="ri-arrow-left me-2"></i>  Tickets
                        </a>
                    </div>
                </div>
                <!-- End::page-header -->

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <form action="{{ route('support.store') }}" method="POST">
                            @csrf
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label for="subject" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject...">
                                            @error('subject')
                                                <strong class="small text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="priority" class="form-label">Priority</label>
                                            <select class="form-control" name="urgency" id="priority">
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="high">High</option>
                                            </select>
                                            @error('priority')
                                                <strong class="small text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="body" class="form-label">Body</label>
                                            <textarea name="body" id="body" class="form-control" cols="3" rows="10"  placeholder="Enter your concerns..."></textarea>
                                            @error('body')
                                                <strong class="small text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-list text-start">
                                        <button type="submit" class="btn btn-sm btn-primary px-5">Create Ticket</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--End::row-1 -->

            </div>
        </div>

@endsection
@extends('layouts.user.index')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        @include('partials.users.alert') 

        <div class="col-xl-8 my-3">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <p class="h5 fw-semibold mb-0">{{ $support->subject }}</p>
                                
                                @if($support['status'] == 'pending')
                                    <span class="badge bg-warning-transparent">Pending</span>
                                @elseif($support['status'] == 'open')
                                    <span class="badge bg-success-transparent">Open</span>
                                @elseif($support['status'] == 'closed')
                                    <span class="badge bg-danger-transparent">Closed</span>
                                @endif
                            </div>
                            <div class="d-sm-flex align-items-cneter">
                                <div class="d-flex align-items-center flex-fill">
                                    <span class="avatar avatar-sm avatar-rounded me-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="" class="bg bg-dark-transparent">
                                    </span>
                                    <div>
                                        <p class="mb-0 fw-medium">{{ $user->first_name }} {{ $user->last_name }} - <span class="fs-12 text-muted fw-normal">{{ $support['created_at']->format('d M, Y \- h:i') }}</span></p>
                                        <p class="mb-0 text-muted"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="mb-4">
                                {{ $support->body }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header">
                            <div class="card-title">
                                Responds
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                            @foreach($response as $reply)
                                <li class="list-group-item border-0 border-bottom">
                                    <div class="d-flex align-items-start gap-3 flex-wrap">
                                        <div>
                                            <span class="avatar avatar-md p-1 bg-light avatar-rounded">
                                                <img width="30" class="rounded-circle" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-fill w-50">
                                            <span class="fw-bold d-block mb-1 fs-14">{{ $reply->sender }}</span>
                                            <span class="d-block mb-3 fs-12">{{ $reply->message }}</span>
                                            <div class="">
                                                <!-- <span class="badge bg-primary-transparent"><i class="ri-thumb-up-line me-1"></i>10 Likes</span> -->
                                                <span class="badge bg-primary-transparent"><i class="ri-chat-4-line me-1"></i>{{ $reply['created_at']->format('d M, Y \- h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if($response->count() < 1)
                                <div class="">
                                    <p class="text-center py-4">No Respnse yet</p>
                                </div>
                            @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                Reply
                            </div>
                        </div>
                        <form action="{{ route('support.reply', $support->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="message" class="form-label">Write Comment</label>
                                        <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <button class="btn btn-primary-light">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
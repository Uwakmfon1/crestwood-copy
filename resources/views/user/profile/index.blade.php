@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row flex-md-row flex-column-reverse profile-body">

        <div class="col-md-4 left-wrapper">
            <div class="row flex-md-column flex-column-reverse">
                <div class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="d-flex mb-3 align-items-center">
                                @if(auth()->user()->getAvatar())
                                    <img width="80px"  src="{{ auth()->user()->getAvatar() }}" style="border-radius: 5px" alt="{{ auth()->user()['name'] }}">
                                @else
                                    <div class="custom-name-avatar custom-name-avatar-lg" style="border-radius: 5px;">{{ auth()->user()->getNameAvatar() }}</div>
                                @endif
                                <div class="ml-2">
                                    <h6>{{ auth()->user()['name'] }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="card-title mb-0">About</h6>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Joined:</label>
                                <p class="text-muted">{{ auth()->user()['created_at']->format('F d, Y') }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Address:</label>
                                <p class="text-muted">{{ auth()->user()['address'] ?? 'Not Set' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                                <p class="text-muted">{{ auth()->user()['email'] }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Phone:</label>
                                <p class="text-muted">{{ auth()->user()['phone'] ?? 'Not Set' }}</p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Referral Code:</label>
                                <div>
                                    <input type="text" id="refCode" style="border: none; width: 100%" value="{{ auth()->user()['ref_code'] }}">
                                </div>
                                <button onclick="copyToClipboard('refCode')" class="btn btn-primary btn-sm">Copy referral code</button>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Referral Link:</label>
                                <div>
                                    <input type="text" id="refLink" style="border: none; width: 100%;" value="{{ url('/register?ref=').auth()->user()['ref_code'] }}">
                                </div>
                                <button onclick="copyToClipboard('refLink')" class="btn btn-primary btn-sm">Copy referral link</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-5 mb-2">
                                <h6 class="card-title mb-0">Identification</h6>
                            </div>
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
                                    <p class="text-muted">Not Set</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5">
                    <div class="card rounded">
                        <div class="card-body">
                            <h6 class="card-title">Change Password</h6>
                            <form class="forms-sample" @if(!auth()->user()->authenticatedWithSocials()) action="{{ route('password.custom.update') }}" method="POST"  @endif id="changePasswordForm">
                                @csrf
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif style="height: 40px; font-size: 15px" name="old_password" class="form-control" id="old_password" autocomplete="off" placeholder="Old Password">
                                    @error('old_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Old Password</label>
                                    <input type="password" style="height: 40px; font-size: 15px" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="new_password" class="form-control" id="new_password" autocomplete="off" placeholder="New Password">
                                    @error('new_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" style="height: 40px; font-size: 15px" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" placeholder="Confirm Password">
                                </div>
                                @if(auth()->user()->authenticatedWithSocials())
                                    <button disabled type="button" class="btn btn-primary mr-2">Change Password</button>
                                @else
                                    <button type="button" onclick="confirmFormSubmit('changePasswordForm')" class="btn btn-primary mr-2">Change Password</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-5 middle-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <h6 class="card-title">Personal Information</h6>
                    <form class="forms-sample row" id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="exampleInputUsername1">Name <span class="text-danger">*</span></label>
                            <input type="text" style="height: 40px; font-size: 15px" class="form-control" value="{{ old('name') ?? auth()->user()['name'] }}" name="name" id="exampleInputUsername1" placeholder="Name">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email address <span class="text-danger">*</span></label>
                            <input type="email" style="height: 40px; font-size: 15px" value="{{ auth()->user()['email'] }}" class="form-control" disabled name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select name="country" id="country" style="height: 40px; font-size: 15px" class="form-control text-dark">
                                {{-- @foreach(\App\Models\User::$countries as $key => $country)
                                        <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">{{ $country['phonecode']}}</option>
                                    @endforeach --}}
                                <option selected value="">Select Country</option>
                                @foreach(\App\Models\Country::query()->orderBy('name')->get() as $country)
                                    <option value="{{ $country->name }}" @if((old('country') ?? auth()->user()['country']) == $country->name) selected @elseif('Nigeria' == $country->name) selected @endif>{{ ucwords($country->name) }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <div class="d-flex mb-3">
                                <select name="phone_code" style="height: 40px; font-size: 15px; width: 25%" class="text-dark">
                                    @foreach(\App\Models\User::$countries as $key => $country)
                                        <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">{{ $country['phonecode']}}</option>
                                    @endforeach
                                </select>
                                <input style="height: 40px; font-size: 15px" type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required value="{{ old('phone') ?? auth()->user()['phone'] }}">
                            </div>
                            @error('phone')
                            <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">State <span class="text-danger">*</span></label>
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
                            <label for="city">City <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old("city") ?? auth()->user()['city'] }}" style="height: 40px; font-size: 15px" class="form-control" name="city" id="city" placeholder="City">
                            @error('city')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old("address") ?? auth()->user()['address'] }}" style="height: 40px; font-size: 15px" class="form-control" name="address" id="address" placeholder="Address">
                            @error('address')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="avatar">Avatar</label>
                            <input type="file" style="height: 40px; font-size: 15px" id="avatar" name="avatar" class="form-control-file"/>
                            @error('avatar')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="id">Valid Identification </label>
                            <input type="file" style="height: 40px; font-size: 15px" id="id" name="id" class="form-control-file"/>
                            @error('id')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <h6 class="card-title">Bank Information</h6>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bankList">Bank Name <span class="text-danger">*</span></label>
                            <select name="bank_name" style="height: 40px; font-size: 15px" class="form-control text-dark" id="bankList">
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
                            <label for="account_number">Account Number <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old("account_number") ?? auth()->user()['account_number'] }}" style="height: 40px; font-size: 15px" class="form-control" name="account_number" id="account_number" placeholder="Account Number">
                            @error('account_number')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="account_name" class="d-flex justify-content-between">
                                <span class="d-block">Account Name <span class="text-danger">*</span></span>
                                <span id="verifyingDisplay" class="small d-block"></span>
                            </label>
                            <input type="text" value="{{ old("account_name") ?? auth()->user()['account_name'] }}" readonly style="height: 40px; font-size: 15px" class="form-control" name="account_name" id="account_name" placeholder="Account Name">
                            @error('account_name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <h6 class="card-title">Next of Kin</h6>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nk_name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old("nk_name") ?? auth()->user()['nk_name'] }}" style="height: 40px; font-size: 15px" class="form-control" name="nk_name" id="nk_name" placeholder="Full Name">
                            @error('nk_name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nk_phone">Phone <span class="text-danger">*</span></label>
                            <div class="d-flex mb-3">
                                <select name="phone_code" style="height: 40px; font-size: 15px; width: 25%" class="text-dark">
                                    @foreach(\App\Models\User::$countries as $key => $country)
                                        <option @if(old("phone_code") == $country['phonecode'] || auth()->user()['phone_code'] == $country['phonecode']) selected @elseif($key == 159) selected @endif value="{{$country['phonecode']}}">{{ $country['phonecode']}}</option>
                                    @endforeach
                                </select>
                                <input style="height: 40px; font-size: 15px" type="text" class="form-control" name="nk_phone" id="nk_phone" placeholder="Phone" required value="{{ old('nk_phone') ?? auth()->user()['nk_phone'] }}">
                            </div>
                            @error('nk_phone')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nk_address">Address</label>
                            <input type="text" value="{{ old("nk_address") ?? auth()->user()['nk_address'] }}" style="height: 40px; font-size: 15px" class="form-control" name="nk_address" id="nk_address" placeholder="Address">
                            @error('nk_address')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" onclick="confirmFormSubmit('profileForm')" class="btn btn-primary mr-2">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

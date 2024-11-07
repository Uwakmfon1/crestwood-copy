@extends('layouts.user.index')

@section('styles')


@endsection

@section('content')

<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    select:focus {
        appearance: none;
    }
</style>


<div class="main-content app-content">
    <div class="container-fluid">

    @include('partials.users.alert')


        <div class="card mt-4 mx-auto" style="max-width: 800px;">
            <div class="my-4">
                <h5 class="modal-title text-center fw-bold fs-16" id="nairaDepositModalLabel">Complete KYC</h5>
                <div class="d-none" id="back-arrow" style="position: absolute; top: 28px; left: 20px; cursor: pointer;">
                    <i class="fe fe-x  me-2"></i>
                </div>
            </div>
            <div id="screen-holder">
                <div class="screen-one">
                    <div class="mx-auto" style="max-width: 550px;">
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12">
                                <div class="my-1">
                                    <p class="text-left fs-12 fw-medium">Personal Information:</p>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">First Name</button>
                                            <input type="text" name="first_name" class="form-control fw-bold" aria-label="Stock Quantity" value="{{ $user->first_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Last Name</button>
                                            <input type="text" name="last_name" class="form-control fw-bold" aria-label="Stock Quantity" value="{{ $user->last_name }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Email Address</button>
                                        <input type="text" name="first_name" class="form-control fw-bold" aria-label="Stock Quantity" value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Phone Number</button>
                                        <input type="text" name="last_name" class="form-control fw-bold" aria-label="Stock Quantity" value="{{ $user->phone }}" disabled>
                                    </div>
                                </div>
                                <div class="input-group my-2">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Date of Birth</button>
                                    <!-- <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value=""> -->
                                    <input type="date" class="form-control fw-bold" name="dob" id="bod">
                                </div>
                                <div class="input-group my-2">
                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">SSN/TIN</button>
                                    <input type="number" name="ssn" class="form-control fw-bold" placeholder="Social Security Number (SSN) or Tax-Identification Number (TIN)" value="">
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Address</button>
                                        <textarea name="address" id="" class="form-control fw-bold" placeholder="Enter home address..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                <button type="button" class="btn btn-transparent border-0 text-muted px-4" disabled><i class="fe fe-arrow-left"></i> Previous</button>
                                <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">Next <i class="fe fe-arrow-right"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="screen-two d-none">
                    <div class="mx-auto" style="max-width: 550px;">
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12">
                                <div class="my-1">
                                    <p class="text-left fs-12 fw-medium">Employment Status:</p>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <img class="bg-dark bg-opacity-10 rounded-circle p-2" width="50" height="50" src="https://static.thenounproject.com/png/2086733-200.png" alt="">
                                         <select name="" id="" class="form-control fw-medium py-3 text-muted rounded-3 mx-2" >
                                            <option value="">--Select Employment Status--</option>
                                            <option value="employed">Employed</option>
                                            <option value="selfemployed">Self-employed</option>
                                            <option value="unemployed">Unemployed</option>
                                            <option value="retired">Retired</option>
                                         </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                <button type="button" class="btn btn-dark-transparent px-4"><i class="fe fe-arrow-left"></i> Previous </button>
                                <button type="button" class="btn btn-success-transparent px-4" id="nextScreenButtonOne">Next <i class="fe fe-arrow-right"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="screen-three d-none">
                    <div class="mx-auto" style="max-width: 550px;">
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12">
                                <div class="my-1">
                                    <p class="text-left fs-12 fw-medium">Annual Income Range:</p>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <img class="bg-dark bg-opacity-10 rounded-circle p-2" width="50" height="50" src="https://static.thenounproject.com/png/2086733-200.png" alt="">
                                         <select name="" id="" class="form-control fw-medium py-3 text-muted rounded-3 mx-2" >
                                            <option value="">--Select Annual Income Range--</option>
                                            <option value="employed">Less than $50K</option>
                                            <option value="selfemployed">$50k - $100K</option>
                                            <option value="unemployed">Over $100K</option>
                                         </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                <button type="button" class="btn btn-dark-transparent px-4"><i class="fe fe-arrow-left"></i> Previous </button>
                                <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">Next <i class="fe fe-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="screen-four d-none">
                    <div class="mx-auto" style="max-width: 550px;">
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col-xl-12">
                                <div class="my-1">
                                    <p class="text-left fs-12 fw-medium">Source Of Funds:</p>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="input-group my-1">
                                        <img class="bg-dark bg-opacity-10 rounded-circle p-2" width="50" height="50" src="https://static.thenounproject.com/png/2086733-200.png" alt="">
                                         <select name="" id="" class="form-control fw-medium py-3 text-muted rounded-3 mx-2" >
                                            <option value="">--Select Source Of Funds--</option>
                                            <option value="salary">Salary</option>
                                            <option value="investment">Investment</option>
                                            <option value="business">Business Income</option>
                                            <option value="others">Others</option>
                                         </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                <button type="button" class="btn btn-dark-transparent px-4"><i class="fe fe-arrow-left"></i> Previous </button>
                                <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">Sumbit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Array of screen names
    const screens = ['one', 'two', 'three', 'four'];
    let currentIndex = 0; // Start with screen-one

    function showScreen(screenName) {
        $('.screen-one, .screen-two, .screen-three, .screen-four').addClass('d-none');
        $(`.screen-${screenName}`).removeClass('d-none');
    }

    // Display the default screen on load
    showScreen(screens[currentIndex]);

    // Next button functionality
    $('#nextScreenButton, #nextScreenButtonOne').click(function() {
        if (currentIndex < screens.length - 1) {
            currentIndex++;
            showScreen(screens[currentIndex]);
        }
    });

    // Previous button functionality
    $('.btn-grey, .btn-dark-transparent').click(function() {
        if (currentIndex > 0) {
            currentIndex--;
            showScreen(screens[currentIndex]);
        }
    });
});



</script>


@endsection
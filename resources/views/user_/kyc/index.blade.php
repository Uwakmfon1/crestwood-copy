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
                <form action="{{ route('kyc.post') }}" method="post">
                    @csrf
                    <div class="screen-one">
                        <div class="mx-auto" style="max-width: 550px;">
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12">
                                    <div class="my-1">
                                        <p class="text-left fs-13 fw-bold">Personal Information:</p>
                                    </div>

                                    <!-- First Name and Last Name -->
                                    <div class="row my-2">
                                        <div class="col-6">
                                            <div class="form-group my-1">
                                                <label for="first_name" class="fs-10 fw-bold text-muted">First Name</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control fw-bold" value="{{ $user->first_name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group my-1">
                                                <label for="last_name" class="fs-10 fw-bold text-muted">Last Name</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control fw-bold" value="{{ $user->last_name }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="form-group my-2">
                                        <label for="email" class="fs-10 fw-bold text-muted">Email Address</label>
                                        <input type="text" id="email" name="email" class="form-control fw-bold" value="{{ $user->email }}" disabled>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="form-group my-2">
                                        <label for="phone" class="fs-10 fw-bold text-muted">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control fw-bold" value="{{ $user->phone }}" disabled>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="form-group my-2">
                                        <label for="dob" class="fs-10 fw-bold text-muted">Date of Birth</label>
                                        <input type="date" id="dob" name="dob" class="form-control fw-bold">
                                    </div>

                                    <!-- SSN/TIN -->
                                    <div class="form-group my-2">
                                        <label for="ssn" class="fs-10 fw-bold text-muted">SSN/TIN</label>
                                        <input type="number" id="ssn" name="ssn" class="form-control fw-bold" placeholder="Social Security Number (SSN) or Tax-Identification Number (TIN)">
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group my-2">
                                        <label for="address" class="fs-10 fw-bold text-muted">Address</label>
                                        <textarea id="address" name="address" class="form-control fw-bold" placeholder="Enter home address..."></textarea>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between my-4 float-end" style="max-width: 550px;">
                                    <button type="button" class="btn btn-transparent border-0 text-muted px-1" disabled>
                                        <i class="fe fe-arrow-left"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">
                                        Next <i class="fe fe-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="screen-two d-none">
                        <div class="mx-auto" style="max-width: 550px;">
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12">
                                    <div class="my-1">
                                        <p class="text-left fs-13 fw-bold">Employment Status:</p>
                                    </div>
                                    
                                    <!-- Employment Status Options -->
                                    <div class="col-12 my-3">
                                        <div class="form-check-group"> 
                                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                    <input class="form-check-input mx-3" type="radio" name="employment_status" value="employed">
                                                    <label class="form-check-label mx-3" for="employed">
                                                    Employed
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                    <input class="form-check-input mx-3" type="radio" name="employment_status" value="selfemployed">
                                                    <label class="form-check-label mx-3" for="selfemployed">
                                                        Self-employed
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                    <input class="form-check-input mx-3" type="radio" name="employment_status" value="unemployed">
                                                    <label class="form-check-label mx-3" for="unemployed">
                                                        Unemployed
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                    <input class="form-check-input mx-3" type="radio" name="employment_status" value="retired">
                                                    <label class="form-check-label mx-3" for="retired">
                                                        Retired
                                                    </label>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                    <button type="button" class="btn btn-dark-transparent px-4">
                                        <i class="fe fe-arrow-left"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButtonOne">
                                        Next <i class="fe fe-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="screen-three d-none">
                        <div class="mx-auto" style="max-width: 550px;">
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12">
                                    <div class="my-1">
                                        <p class="text-left fs-13 fw-bold">Annual Income Range:</p>
                                    </div>
                                    
                                    <!-- Annual Income Range Options -->
                                    <div class="col-12 my-3">
                                        <div class="form-check-group"> 
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="income_range" value="less_than_50k">
                                                <label class="form-check-label mx-3" for="less_than_50k">
                                                Less than $50K
                                                </label>
                                            </div>
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="income_range" value="50k_100k">
                                                <label class="form-check-label mx-3" for="50k_100k">
                                                    $50K - $100K
                                                </label>
                                            </div>
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="income_range" value="over_100k">
                                                <label class="form-check-label mx-3" for="over_100k">
                                                    Over $100K
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                    <button type="button" class="btn btn-dark-transparent px-4">
                                        <i class="fe fe-arrow-left"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary-transparent px-4" id="nextScreenButton">
                                        Next <i class="fe fe-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="screen-four d-none">
                        <div class="mx-auto" style="max-width: 550px;">
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12">
                                    <div class="my-1">
                                        <p class="text-left fs-13 fw-bold">Source Of Funds:</p>
                                    </div>
                                    
                                    <!-- Source Of Funds Options -->
                                    <div class="col-12 my-3">
                                        <div class="form-check-group"> 
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="source_of_funds" value="salary">
                                                <label class="form-check-label mx-3" for="salary">
                                                Salary
                                                </label>
                                            </div>
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="source_of_funds" value="investment">
                                                <label class="form-check-label mx-3" for="investment">
                                                    Investment
                                                </label>
                                            </div>
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="source_of_funds" value="business">
                                                <label class="form-check-label mx-3" for="business">
                                                    Business Income
                                                </label>
                                            </div>
                                            <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                                <input class="form-check-input mx-3" type="radio" name="source_of_funds" value="others">
                                                <label class="form-check-label mx-3" for="others">
                                                    Others
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                    <button type="button" class="btn btn-dark-transparent px-4">
                                        <i class="fe fe-arrow-left"></i> Previous
                                    </button>
                                    <button type="submit" class="btn btn-primary-transparent px-4" id="nextScreenButton">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
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

    $(document).on('click', '.form-check', function() {
        const radioInput = $(this).find('input[type="radio"]');
        radioInput.prop('checked', true); // Select the radio button
        radioInput.trigger('change'); // Trigger change event in case there is a listener
    });
});



</script>


@endsection
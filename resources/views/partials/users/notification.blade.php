@php
    $user = auth()->user();
@endphp

@if(auth()->user()['is_id_approved'] !== 'approved')
    <div class="alert alert-info d-flex justify-content-between align-items-center mt-3" role="alert">
        
            <div>
                Account Verification Required: Kindly verify your KYC to have full access to our system

                <strong><a href="{{ route('profile') }}" class="text-info fw-bold">Click here</a></strong>.
            </div>
            <div>
                <button type="button" class="btn-close text-info" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
    </div>
@endif
@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simplemde/simplemde.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.email') }}">Email</a></li>
            <li class="breadcrumb-item active" aria-current="page">New</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row inbox-wrapper">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.email.store') }}" id="emailForm" method="POST" class="row">
                        @csrf
                        <div class="col-lg-12 email-content">
                            <div class="email-head">
                                <div class="email-head-title d-flex align-items-center">
                                    New Email
                                </div>
                            </div>
                            <div class="email-compose-fields">
                                <div class="to">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="type" @if(old('type')) @if(old('type')  == 'single') checked @endif @else checked @endif id="singleRadio" value="single">
                                                Single
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" @if(old('type') == 'bulk') checked @endif name="type" id="bulkRadio" value="bulk">
                                                Bulk
                                            </label>
                                        </div>
                                        @error('type')
                                        <span class="text-danger small" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="to">
                                    <div class="form-group row py-0">
                                        <label for="to" class="col-md-1 control-label">To:</label>
                                        <div class="col-md-11">
                                            <div id="emailRecipient" class="form-group">
                                                <input id="to" name="to" value="{{ old('to') }}" class="form-control" type="text" placeholder="Enter Recipient Email">
                                            </div>
                                            @error('to')
                                            <span class="d-block text-danger small" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="recipients" style="display: none">
                                    <div class="form-group row py-0">
                                        <label for="to" class="col-md-1 control-label">Recipients:</label>
                                        <div class="col-md-11">
                                            <div id="emailRecipients" class="form-group">
                                                <input id="emails" name="recipients" value="{{ old('recipients') }}" class="form-control" type="text" placeholder="Enter Recipients Email">
                                            </div>
                                            <span class="d-block text-danger small" role="alert">
                                                <strong id="tagMax" style="display: none !important;">Maximum of 50 recipients</strong>
                                            </span>
                                            @error('emails')
                                                <span class="d-block text-danger small" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="to cc">
                                    <div class="form-group row pt-1 pb-3">
                                        <label for="cc" class="col-md-1 control-label">Cc</label>
                                        <div class="col-md-11">
                                            <span class="text-info small">Use comma to separate emails to cc</span>
                                            <input class="form-control" id="cc" name="cc" value="{{ old('cc') }}" type="email" placeholder="Cc">
                                        </div>
                                    </div>
                                </div>
                                <div class="subject">
                                    <div class="form-group row py-0">
                                        <label for="subject" class="col-md-1 control-label">Subject</label>
                                        <div class="col-md-11">
                                            <input class="form-control" name="subject" value="{{ old('subject') }}" id="subject" type="text" placeholder="Subject">
                                            @error('subject')
                                            <span class="text-danger small" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email editor">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label sr-only" for="customTextArea">Descriptions </label>
                                        <textarea class="form-control" name="body" id="customTextArea" rows="5">{{ old('body') }}</textarea>
                                        @error('body')
                                        <span class="text-danger small" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="platform" @if(old('platform')) @if(old('platform')  == 'email') checked @endif @else checked @endif value="email">
                                                Email Only
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" @if(old('platform') == 'notification') checked @endif name="platform" value="notification">
                                                In-app Notification Only
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" @if(old('platform') == 'both') checked @endif name="platform" value="both">
                                                Both Email & In-app Notification Only
                                            </label>
                                        </div>
                                        @error('platform')
                                            <span class="text-danger small" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 my-2">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" checked name="notification" value="yes" class="form-check-input">
                                            Send in-app notifications
                                        </label>
                                    </div>
                                </div> --}}
                                <div class="email action-send">
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <button class="btn btn-primary btn-space" onclick="confirmFormSubmit('emailForm')" type="button">Send Email</button>
                                        </div>
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
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simplemde/simplemde.min.js') }}"></script>
    <script src="{{ asset('assets/js/email.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        $(function() {
            'use strict';
            $('#emails').tagsInput({
                'width': '100%',
                'height': '75%',
                'interactive': true,
                'defaultText': 'Add',
                'removeWithBackspace': true,
                'minChars': 0,
                'maxChars': 100,
                'placeholderColor': '#F60780',
                'onAddTag': function(tag) {
                    const len = $(this).val().split(',').length;
                    if (len > 50) {
                        $('#emails').removeTag(tag);
                        $('#tagMax').show();
                    }
                },
                'onRemoveTag': function() {
                    $('#tagMax').hide();
                }
            });
        });
    </script>
    <script>
        CKEDITOR.replace( 'customTextArea' );
        $(document).ready(function (){
            let singleRadio = $('#singleRadio');
            let bulkRadio = $('#bulkRadio');
            let emailRecipient = $('#emailRecipient');
            let emails = $('#emails');
            singleRadio.on('change', checkFormType);
            bulkRadio.on('change', checkFormType);
            checkFormType();
            emailRecipient.on('change', function() {
                if (emailRecipient.find(":selected").text() === 'Specified Recipients') {
                    $('.recipients').show();
                } else {
                    $('.recipients').hide();
                }
            });
            function checkFormType(){
                if (singleRadio.prop('checked')){
                    $('.cc').show();
                    emailRecipient.html('<input id="to" name="to" class="form-control" type="email" required placeholder="Enter Recipient Email">');
                }else if(bulkRadio.prop('checked')){
                    $('.cc').hide();
                    $('#cc').val('');
                    emailRecipient.html('<select id="to" name="to" required class="form-control text-dark w-100">' +
                        '<option value="">Select Recipient</option>' +
                        '<option value="Specified Recipients">Specified Recipients</option>' +
                        '<option value="All verified users">All verified users</option>' +
                        // '<option value="Users with active investments">Users with active investments</option>' +
                        // '<option value="Users with gold units">Users with gold units</option>' +
                    '</select>');
                }
            }
        });
    </script>
@endsection

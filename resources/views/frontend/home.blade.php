@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">

                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p style="text-align: center;">Welcome to the new look ACH - Secure Portal.</p>

                        <div class="row justify-content-center">
                            <div class="col-md-4 rounded green-bg" style="margin: .5rem;" onclick="window.location='{{ route('frontend.profile.index') }}';">
                                <p class="button-bold"><i class="fa fa-user" aria-hidden="true"></i> Your Profile</p>
                                <p>Check your contact details and update your profile with us</p>
                            </div>
                            <div class="col-md-4 rounded blue-bg"  style="margin: .5rem;" onclick="window.location='{{ route('frontend.uploads.index') }}'">
                                <p class="button-bold"><i class="fa fa-upload" aria-hidden="true"></i> Upload Files</p>
                                <p>Upload a series of files securely and send us a message</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4 rounded yellow-bg"  style="margin: .5rem;" onclick="window.location='{{ route('frontend.history.index') }}'">
                                <p class="button-bold"><i class="fa fa-history" aria-hidden="true"></i> History</p>
                                <p>Review the history of your interactions with our system</p>
                            </div>
                            <div class="col-md-4 rounded red-bg"  style="margin: .5rem;" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <p class="button-bold"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</p>
                                <p>All done? Click here to logout</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <p style="text-align: center;padding:1rem;">
                        <img alt="{{ config('app.name') }} Logo" src="{{ asset('img/logo_large.gif') }}" style="width: 85%; "/>
                    </p>
                    <h2 style="text-align: center;">{{ trans('panel.site_title') }}</h2>
                    <p class="text-muted">{{ trans('global.reset_password') }}</p>

                    <p>Strong passwords only consisting of:-</p>
                    <ol>
                        <li>At least 8 characters long.</li>
                        <li>At least 1 uppercase character.</li>
                        <li>At least 1 symbol.</li>
                    </ol>

                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.request') }}">
                        @csrf
                        <input name="token" value="{{ $token }}" type="hidden">
                        <div class="form-group">
                            <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ $email ?? old('email') }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" name="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                    {{ trans('global.reset_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
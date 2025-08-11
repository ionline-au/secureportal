@extends('layouts.frontend')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.my_profile') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.update") }}">
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.company_name') }}</label>
                                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', auth()->user()->company_name) }}">
                                @if($errors->has('company_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.contact_number') }}</label>
                                <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', auth()->user()->contact_number) }}" required>
                                @if($errors->has('contact_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('contact_number') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.full_address') }}</label>
                                <input class="form-control {{ $errors->has('full_address') ? 'is-invalid' : '' }}" type="text" name="full_address" id="full_address" value="{{ old('full_address', auth()->user()->full_address) }}" >
                                @if($errors->has('full_address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('full_address') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.postal_address') }}</label>
                                <input class="form-control {{ $errors->has('postal_address') ? 'is-invalid' : '' }}" type="text" name="postal_address" id="postal_address" value="{{ old('postal_address', auth()->user()->postal_address) }}" >
                                @if($errors->has('postal_address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('postal_address') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.principal_place_of_business') }}</label>
                                <input class="form-control {{ $errors->has('principal_place_of_business') ? 'is-invalid' : '' }}" type="text" name="principal_place_of_business" id="principal_place_of_business" value="{{ old('principal_place_of_business', auth()->user()->principal_place_of_business) }}" >
                                @if($errors->has('principal_place_of_business'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('principal_place_of_business') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="display: none;">
                    <div class="card-header">
                        Your Dedicated Accountant
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input class="form-control" type="text" value="{{ $accountant->name }}" disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.change_password') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.profile.password") }}">
                            @csrf
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control" type="password" name="password" id="password" required>
                                @if($errors->has('password'))
                                    <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
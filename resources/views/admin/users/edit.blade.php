@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="company_name">{{ trans('cruds.user.fields.company_name') }}</label>
                    <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $user->company_name) }}">
                    @if($errors->has('company_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('company_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.company_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="is_staff">{{ trans('cruds.user.fields.user_or_client') }}</label>
                    <select class="form-control {{ $errors->has('is_staff') ? 'is-invalid' : '' }}" type="text" name="is_staff" id="is_staff" value="{{ old('user_or_client', '') }}" required>
                        <option value="0" @if($user->is_staff == 0) selected="selected" @endif()>Client</option>
                        <option value="1" @if($user->is_staff == 1) selected="selected" @endif()>Staff Member</option>
                    </select>
                    @if($errors->has('is_staff'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_staff') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.company_name_helper') }}</span>
                </div>
                <div class="form-group" id="hide_display_staff_selector" @if($user->is_staff == 1) style="display: none;" @endif()>
                    <label for="assigned_staff">{{ trans('cruds.user.fields.assigned_staff') }}</label>
                    <select class="form-control {{ $errors->has('assigned_staff_email') ? 'is-invalid' : '' }}" type="text" name="assigned_staff_email" id="assigned_staff_email" value="{{ old('assigned_staff_email', '') }}">
                        <option value="">Select Staff</option>
                        @if($all_staff)
                            @foreach($all_staff as $key => $staff_name)
                                <option id="{{ $staff_name->id }}" @if($user->assigned_staff_email == $staff_name->email) selected="selected" @endif()>{{ $staff_name->email }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('assigned_staff_email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('assigned_staff_email') }}
                        </div>
                    @endif
                    {{--<span class="help-block">{{ trans('cruds.user.fields.company_name_helper') }}</span>--}}
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="contact_number">{{ trans('cruds.user.fields.contact_number') }}</label>
                    <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $user->contact_number) }}">
                    @if($errors->has('contact_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('contact_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.contact_number_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="full_address">{{ trans('cruds.user.fields.full_address') }}</label>
                    <input class="form-control {{ $errors->has('full_address') ? 'is-invalid' : '' }}" type="text" name="full_address" id="full_address" value="{{ old('full_address', $user->full_address) }}">
                    @if($errors->has('full_address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('full_address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.full_address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="postal_address">{{ trans('cruds.user.fields.postal_address') }}</label>
                    <input class="form-control {{ $errors->has('postal_address') ? 'is-invalid' : '' }}" type="text" name="postal_address" id="postal_address" value="{{ old('postal_address', $user->postal_address) }}">
                    @if($errors->has('postal_address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('postal_address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.postal_address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="postal_address">{{ trans('cruds.user.fields.principal_place_of_business') }}</label>
                    <input class="form-control {{ $errors->has('principal_place_of_business') ? 'is-invalid' : '' }}" type="text" name="principal_place_of_business" id="principal_place_of_business" value="{{ old('principal_place_of_business', $user->principal_place_of_business) }}">
                    @if($errors->has('principal_place_of_business'))
                        <div class="invalid-feedback">
                            {{ $errors->first('principal_place_of_business') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.postal_address_helper') }}</span>
                </div>
                <div class="form-group" style="display: none;">
                    <label for="uploads">{{ trans('cruds.user.fields.uploads') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('uploads') ? 'is-invalid' : '' }}" id="uploads-dropzone"></div>
                    @if($errors->has('uploads'))
                        <div class="invalid-feedback">
                            {{ $errors->first('uploads') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.uploads_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                        @foreach($roles as $id => $roles)
                            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('roles'))
                        <div class="invalid-feedback">
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        jQuery(document).on('change', '#is_staff', function(){
            if (jQuery(this).val() == 1) {
                jQuery('#hide_display_staff_selector').hide();
            } else {
                jQuery('#hide_display_staff_selector').show();
            }
        });
    </script>
    <script>
        var uploadedUploadsMap = {}
        Dropzone.options.uploadsDropzone = {
            url: '{{ route('admin.users.storeMedia') }}',
            maxFilesize: 64, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 64
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="uploads[]" value="' + response.name + '">')
                uploadedUploadsMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedUploadsMap[file.name]
                }
                $('form').find('input[name="uploads[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($user) && $user->uploads)
                var files =
                        {!! json_encode($user->uploads) !!}
                        for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="uploads[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
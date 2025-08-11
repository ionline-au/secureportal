@extends('layouts.frontend')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.upload') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.uploads.update", [$user->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.uploads_name') }}</label>
                                <input class="form-control {{ $errors->has('uploads_name') ? 'is-invalid' : '' }}" type="text" name="uploads_name" id="uploads_name" value="" required>
                                @if($errors->has('uploads_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('uploads_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <p style="text-align: center;font-size:12px;">Upload as many files as you like of any type, note that each file can be a max of 64meg.</p>
                                <div class="needsclick dropzone {{ $errors->has('uploads') ? 'is-invalid' : '' }}" id="uploads-dropzone"></div>
                                @if($errors->has('uploads'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('uploads') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.uploads_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.upload_files') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var uploadedUploadsMap = {}
        Dropzone.options.uploadsDropzone = {
            url: '{{ route('frontend.profile.update') }}',
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
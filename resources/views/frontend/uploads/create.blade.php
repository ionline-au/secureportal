@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.upload.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.uploads.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="name_id" value="{{ $name_id }}">
                        <div class="form-group">
                            <label class="required" for="upload_name">{{ trans('cruds.upload.fields.upload_name') }}</label>
                            <input class="form-control" type="text" name="upload_name" id="upload_name" value="{{ old('upload_name', '') }}" required>
                            @if($errors->has('upload_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('upload_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="upload">{{ trans('cruds.upload.fields.upload') }}</label>
                            <div class="needsclick dropzone" id="upload-dropzone">
                            </div>
                            @if($errors->has('upload'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('upload') }}
                                </div>
                            @endif
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="name_id">{{ trans('cruds.upload.fields.name') }}</label>
                            <select class="form-control select2" name="name_id" id="name_id">
                                @foreach($names as $id => $entry)
                                    <option value="{{ $id }}" {{ old('name_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.upload.fields.name_helper') }}</span>
                        </div>
                        -->
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
@endsection

@section('scripts')
<script>
    var uploadedUploadMap = {}
Dropzone.options.uploadDropzone = {
    url: '{{ route('frontend.uploads.storeMedia') }}',
    maxFilesize: 64, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 64
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="upload[]" value="' + response.name + '">')
      uploadedUploadMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedUploadMap[file.name]
      }
      $('form').find('input[name="upload[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($upload) && $upload->upload)
          var files =
            {!! json_encode($upload->upload) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="upload[]" value="' + file.file_name + '">')
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
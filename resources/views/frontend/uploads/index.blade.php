@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="{{ route('frontend.uploads.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.upload.title_singular') }}
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.upload.title_singular') }} {{ trans('global.list') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Upload">
                                <thead>
                                <tr>
                                    <th width="75">
                                        {{ trans('cruds.upload.fields.date') }}
                                    </th>
                                    <th width="250">
                                        {{ trans('cruds.upload.fields.upload_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.upload.fields.upload') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($uploads as $key => $upload)
                                        <tr data-entry-id="{{ $upload->id }}">
                                            <td>
                                                {{ date('d-m-Y', strtotime($upload->created_at)) }}
                                            </td>
                                            <td>
                                                {{ $upload->upload_name ?? '' }}
                                            </td>
                                            <td>
                                                <ul class="files_ul_front">
                                                    @foreach($upload->upload as $key => $media)
                                                        <!--<li><a href="{{ route('frontend.uploads.record_download') }}?file={{ env('PUBLIC_DOWNLOAD_PATH') . $media->id . '/' . $media->file_name }}">{{ substr($media->file_name, 14) }}</a></li>-->
                                                        <li><a href="{{ env('PUBLIC_DOWNLOAD_PATH') . $media->id . '/' . $media->file_name }}">{{ substr($media->file_name, 14) }}</a></li>
                                                    @endforeach
                                                </ul>
                                                <!--
                                                    @if($old_download = DB::select("select * from media where name = '" . addslashes($upload->upload_name) . "' LIMIT 1"))
                                                        <ul class="files_ul_front">
                                                            @foreach($old_download as $key_old => $media_old)
                                                                {{--<li><a href="/storage/999999999/{{ $media_old->file_name }}" target="_blank">{{ substr($media_old->file_name, 14) }}</a></li>--}}
                                                                <p style="text-align: center;padding:0;margin:0;">Old Data Not Available - Please Check Back Soon</p>
                                                            @endforeach
                                                        </ul>
                                                    @endif()
                                                -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('upload_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('frontend.uploads.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 50,
            });
            let table = $('.datatable-Upload:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
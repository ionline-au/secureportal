@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.uploads.create') }}">
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
                <table class=" table table-bordered table-striped table-hover datatable datatable-Upload" style="width: 100%">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th>
                            Date
                        </th>
                        <th>
                            Customer Name
                        </th>
                        <th>
                            {{ trans('cruds.upload.fields.upload_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.upload.fields.upload') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uploads as $key => $upload)
                        <tr>
                            <td></td>
                            <td>
                                @if($upload->updated_at) {{ date('d/m/Y', strtotime($upload->updated_at)) }} @else() N/A @endif()
                            </td>
                            <td>
                                {{ $upload->name->name ?? '' }}
                            </td>
                            <td>
                                {{ $upload->upload_name ?? '' }}
                            </td>
                            <td>
                                <ul class="files_ul">
                                    @if($upload->upload)
                                        @foreach($upload->upload as $key => $media)
                                            <li><a href="{{ $media->getUrl() }}" target="_blank">{{ substr($media->file_name, 14) }}</a></li>
                                        @endforeach
                                    @else()
                                        <li>No File Found</li>
                                    @endif()
                                    <!--
                                        @if($old_download = DB::select("select * from media where name = '" . addslashes($upload->upload_name) . "' LIMIT 1"))
                                            @foreach($old_download as $key_old => $media_old)
                                                <li><a href="/storage/999999999/{{ str_replace('\'','',$media_old->file_name) }}" target="_blank">{{ substr($media_old->file_name, 14) }}</a></li>
                                                {{--<p style="text-align: center;padding:0;margin:0;">Old Data Not Available - Please Check Back Soon</p>--}}
                                            @endforeach
                                        @endif()
                                    -->
                                </ul>
                            </td>
                            <td>

                                <?php $hasMedia = false; // i hate me?>
                                @if($upload->upload)
                                    @foreach($upload->upload as $key => $media)
                                        @if($media->getUrl()) <?php $hasMedia = true; ?> @endif()
                                    @endforeach
                                @endif()

                                @if(!$old_download)
                                    @if($hasMedia)
                                        <p style="text-align: center;padding:0;margin:0;">
                                            <a href="{{ route('admin.uploads.downloadall', ['id' => $upload->id]) }}" class="btn btn-primary btn-sm">DOWNLOAD ALL</a>
                                        </p>
                                    @endif()
                                @else()
                                    {{--<p style="text-align: center;padding:0;margin:0;">Bulk Download Not Available</p>--}}
                                @endif()
                                    <p style="text-align: center;padding:0;margin:0;margin-top:5px;">
                                        <a href="{{ route('admin.uploads.remove', ['id' => $upload->id]) }}" class="btn btn-danger btn-sm">DELETE UPLOAD</a>
                                    </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
                url: "{{ route('admin.uploads.massDestroy') }}",
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
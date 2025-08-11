@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.oldfiles.title') }} {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <p style="text-align: center;font-size:12px;">The files below are older than 12 months, they can be removed if you want. Tick the files for removal and press the "REMOVE ALL" button.</p>
                <table class="table table-bordered table-striped table-hover datatable datatable-User" style="width: 100%;">
                    <thead>
                    <tr>
                        <th width="20"></th>
                        <th width="100">
                            {{ trans('cruds.oldfiles.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.oldfiles.fields.upload_name') }}
                        </th>
                        <th width="150">
                            {{ trans('cruds.oldfiles.fields.date') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($old_files as $key => $file)
                            <tr data-entry-id="{{ $file->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $file->id }}
                                </td>
                                <td>
                                    {{ $file->upload_name }}
                                </td>
                                <td>
                                    {{ $file->created_at }}
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
            @can('user_delete')
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
            let table = $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
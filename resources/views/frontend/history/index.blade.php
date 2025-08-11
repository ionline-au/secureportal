@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.history.title') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                                <thead>
                                <tr>
                                    <th width="5%">
                                        {{ trans('cruds.history.fields.id') }}
                                    </th>
                                    <th width="20%">
                                        {{ trans('cruds.history.fields.date_time') }}
                                    </th>
                                    <th width="10%">
                                        {{ trans('cruds.history.fields.type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.history.fields.notes') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($history as $key => $hist)
                                        <tr>
                                            <td>
                                                {{ $hist->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $hist->created_at ?? '' }}
                                            </td>
                                            <td>
                                                {{ $hist->type ?? '' }}
                                            </td>
                                            <td>
                                                {{ $hist->notes ?? '' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <p style="text-align: center;padding:0;margin:0;">No History Found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
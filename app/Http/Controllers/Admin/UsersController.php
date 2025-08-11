<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\History;
use App\Models\Role;
use App\Models\User;
use App\Models\Upload;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with(['roles'])->get(); // dont need the media relationship

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $all_staff = User::all()->where('is_staff', 1);

        return view('admin.users.create', compact('roles', 'all_staff'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        foreach ($request->input('uploads', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('uploads');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        $all_staff = User::all()->where('is_staff', 1);

        return view('admin.users.edit', compact('roles', 'user', 'all_staff'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        if (count($user->uploads) > 0) {
            foreach ($user->uploads as $media) {
                if (!in_array($media->file_name, $request->input('uploads', []))) {
                    $media->delete();
                }
            }
        }
        $media = $user->uploads->pluck('file_name')->toArray();
        foreach ($request->input('uploads', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $user->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('uploads');
            }
        }

        return redirect()->route('admin.users.index');
    }

    public function history(Request $request)
    {
        if ($request->input('user_id')) {
            $history = History::orderBy('id','desc')->where('user_id', $request->input('user_id'))->get();
            $user = User::findOrFail($request->input('user_id'));
            return view('admin.users.history', compact('user','history'));
        } else {
            abort_if(true, Response::HTTP_FORBIDDEN, 'User Not Found');
        }
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // find all the files and remove them
        $delete_files = Upload::where('name_id', $user->id)->get();
        if ($delete_files) {
            foreach ($delete_files as $delete_file) {
                $file = Upload::find($delete_file->name_id);
                if ($file) {
                    $file->delete();
                }
            }
        }

        // delete the user
        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        if ($request->input('ids')) {
            foreach ($request->input('ids') as $id) {
                // then remove that user
                User::find($id)->delete();

                // find all the files and remove them
                $delete_files = Upload::where('name_id', $id)->get();
                if (is_array($delete_files)) {
                    foreach ($delete_files as $delete_file) {
                        $file = Upload::find($delete_file->name_id);
                        if ($file) {
                            $file->delete();
                        }
                    }
                }
            }
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new User();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

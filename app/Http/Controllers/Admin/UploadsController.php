<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUploadRequest;
use App\Http\Requests\StoreUploadRequest;
use App\Http\Requests\UpdateUploadRequest;
use App\Mail\ProfileUpdatedMail;
use App\Mail\SendUserUploadNoticeMail;
use App\Models\Upload;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UploadsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {

        if ($request->input('user_id')) {
            $uploads = Upload::with(['name', 'media'])->where('name_id', $request->input('user_id'))->get();
        } else {
            $uploads = Upload::with(['name', 'media'])->get();
        }

        // now get the old downloads
        foreach ($uploads as $key => $upload) {
            if ($upload->media == '') {
                $uploads[$key]->old_download = DB::select("select * from media where name = '" . $upload->upload_name . "' LIMIT 1");
            }
        }

        return view('admin.uploads.index', compact('uploads'));
    }

    public function create()
    {
        $names = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.uploads.create', compact('names'));
    }

    public function store(StoreUploadRequest $request)
    {

        $upload = Upload::create($request->all());
        foreach ($request->input('upload', []) as $file) {
            $upload->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('upload');
        }
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $upload->id]);
        }

        // send the user a mail
        $user = User::find($request->input('name_id'));
        Mail::to($user->email)->send(new SendUserUploadNoticeMail());

        return redirect()->route('admin.uploads.index');
    }

    public function edit(Upload $upload)
    {
        $names = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $upload->load('name');
        return view('admin.uploads.edit', compact('names', 'upload'));
    }

    public function update(UpdateUploadRequest $request, Upload $upload)
    {
        $upload->update($request->all());
        if (count($upload->upload) > 0) {
            foreach ($upload->upload as $media) {
                if (!in_array($media->file_name, $request->input('upload', []))) {
                    $media->delete();
                }
            }
        }
        $media = $upload->upload->pluck('file_name')->toArray();
        foreach ($request->input('upload', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $upload->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('upload');
            }
        }
        return redirect()->route('admin.uploads.index');
    }

    public function show(Upload $upload)
    {
        $upload->load('name');
        return view('admin.uploads.show', compact('upload'));
    }

    public function remove(Request $request)
    {
        $remove = Upload::findOrFail($request->input('id'));
        $remove->delete();
        return back();
    }

    public function destroy(Upload $upload)
    {
        $upload->delete();
        return back();
    }

    public function massDestroy(MassDestroyUploadRequest $request)
    {
        Upload::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        $model = new Upload();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');
        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    // makes a zip and downloads all the files
    public function downloadall(Request $request)
    {

        // get the uploads
        $upload = $request->all();
        $uploads = Upload::with(['name', 'media'])->find($upload['id']);

        $media = $uploads->relationsToArray()['media'];

        // mash them into an array and then compress using ziparchive and return
        if (is_array($media)) {
            $zip = new \ZipArchive();
            $fileName = 'client_download_archive_' . date('d-m-Y', strtotime('now')) . '_' . uniqid() . '.zip';
            if ($zip->open(env('ZIPS_PATH') . $fileName, \ZipArchive::CREATE) == TRUE) {

                foreach ($media as $key => $value) {
                    $path = env('PUBLIC_PATH') . $value['id'] . '/' . $value['file_name'];
                    $zip->addFile($path);
                }
            }
            $zip->close();
            return response()->download(env('ZIPS_PATH') . $fileName);
        }
    }
}
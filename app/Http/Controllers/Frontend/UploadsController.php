<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUploadRequest;
use App\Http\Requests\StoreUploadRequest;
use App\Http\Requests\UpdateUploadRequest;
use App\Mail\UploadCompletedByClient;
use App\Models\History;
use App\Models\Upload;
use App\Models\User;
use Gate;
use Mail;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use const http\Client\Curl\AUTH_ANY;

class UploadsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $uploads = Upload::with(['name', 'media'])->where('name_id', Auth::id())->get();

        // check to see if this user has the order_column 999999999 - if so this is an imported user and thus has the files stores elsewhere
        $old_files = DB::select('select * from uploads where name_id = ' . Auth::id());
        if ($old_files) {
            foreach ($old_files as $old_file) {
                $uploads->old_download = DB::select("select * from media where name = '" . addslashes($old_file->upload_name)  . "' LIMIT 1");
            }
        }
        return view('frontend.uploads.index', compact('uploads'));
    }

    public function create()
    {
        $names = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $name_id = Auth::id();
        return view('frontend.uploads.create', compact('names', 'name_id'));
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

        // message info to say that upload has been completed - get the accountant email, else post it to info@
        $data = ['client_name' => User::findOrFail($request->name_id)->name, 'upload_name' => $request->upload_name, 'number_of_files' => count($request->upload), 'date_time_of_upload' => Carbon::now()->format('l jS \of F Y h:i:s A')];
        $user = User::findOrFail(Auth::id());
        if ($user->assigned_staff_email != '') {
            $accountant_email = $user->assigned_staff_email;
        } else {
            $accountant_email = config('app.default_admin_email_account');
        }
        if (filter_var($accountant_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to([$accountant_email,' info@acountinghouse.com'])->send(new UploadCompletedByClient($data));
        }

        // history
        History::insertEvent(Auth::id(), 'upload', 'Uploaded File(s): ' . $request->upload_name);

        return redirect()->route('frontend.uploads.index');

    }

    public function edit(Upload $upload)
    {
        $names = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $upload->load('name');
        return view('frontend.uploads.edit', compact('names', 'upload'));
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

        return redirect()->route('frontend.uploads.index');
    }

    public function show(Upload $upload)
    {
        $upload->load('name');
        return view('frontend.uploads.show', compact('upload'));
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

    /**
     * Stores the file download log then downloads the file
     */
    public function record_download(Request $request)
    {
        $friendly_name = explode('/', str_replace('/storage/app/public/','', $request->input('file')));
        $friendly_name = substr($friendly_name[3], 14);
        History::insertEvent(Auth::id(), 'download', 'Downloaded File: ' . $friendly_name);
        return redirect($request->input('file'));
    }
}
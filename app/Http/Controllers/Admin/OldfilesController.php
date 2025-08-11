<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\Upload;
use App\Models\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OldfilesController extends Controller
{
    public function index()
    {
        $old_files = Upload::where('created_at', '<', Carbon::now()->subMonth(config('app.old_file_months')) )->get();
        return view('admin.oldfiles.index', compact('old_files'));
    }
}

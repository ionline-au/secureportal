<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\ProfileUpdatedMail;
use App\Models\History;
use App\Models\User;
use Gate;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{

    public function index()
    {
        $accountant = User::findOrFail('1');
        return view('frontend.profile', compact('accountant'));
    }

    public function update(UpdateProfileRequest $request)
    {

        $user = auth()->user();
        $user->update($request->validated());
        $user->save();
        Mail::to(config('app.default_admin_email_account'))->send(new ProfileUpdatedMail($request->all()));
        History::insertEvent(Auth::id(), 'profile', 'User Profile Updated');
        return redirect()->route('frontend.profile.index')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();
        $user->update([
            'email' => time() . '_' . $user->email,
        ]);
        $user->delete();
        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());
        History::insertEvent(Auth::id(), 'password', 'User Password Updated');
        return redirect()->route('frontend.profile.index')->with('message', __('global.change_password_success'));
    }

}

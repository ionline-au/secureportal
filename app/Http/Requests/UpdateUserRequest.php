<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                /*'unique:users,email,' . request()->route('user')->id,*/
            ],
            'assigned_staff_email' => [
                ''
            ],
            'contact_number' => [
                'string',
                'nullable',
            ],
            'full_address' => [
                'string',
                'nullable',
            ],
            'postal_address' => [
                'string',
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}

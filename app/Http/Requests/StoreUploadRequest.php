<?php

namespace App\Http\Requests;

use App\Models\Upload;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'upload_name' => [
                'string',
                'required',
            ],
        ];
    }
}

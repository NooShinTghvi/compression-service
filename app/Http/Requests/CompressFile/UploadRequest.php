<?php

namespace App\Http\Requests\CompressFile;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:1000']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

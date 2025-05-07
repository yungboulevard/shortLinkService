<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:' . config('redirect.slugLength', 50),
                'regex:/^[a-zA-Z0-9]+$/', 
                'unique:links,slug', 
            ],
            'expires_at' => 'nullable|date|after:now',
        ];
    }
}

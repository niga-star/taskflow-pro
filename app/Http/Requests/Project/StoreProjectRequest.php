<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'min:2', 'max:8', 'alpha_num', 'uppercase', 'unique:projects,key'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

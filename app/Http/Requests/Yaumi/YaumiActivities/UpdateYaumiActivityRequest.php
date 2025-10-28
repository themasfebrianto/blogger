<?php

namespace App\Http\Requests\Yaumi\YaumiActivities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateYaumiActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}

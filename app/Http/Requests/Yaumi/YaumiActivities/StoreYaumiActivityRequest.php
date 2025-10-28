<?php

namespace App\Http\Requests\Yaumi\YaumiActivities;

use Illuminate\Foundation\Http\FormRequest;

class StoreYaumiActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kalau hanya admin yang boleh tambah, bisa ubah di sini
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}

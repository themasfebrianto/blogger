<?php

namespace App\Http\Requests\Yaumi\YaumiLogs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateYaumiLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kalau hanya admin yang boleh tambah, bisa ubah di sini
        return true;
    }

    // StoreYaumiLogRequest.php
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'activity_id' => ['required', 'exists:yaumi_activities,id'],
            'date' => ['required', 'date'],
            'value' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}

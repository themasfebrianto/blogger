<?php

namespace App\Http\Requests\Yaumi\YaumiStreaks;

use Illuminate\Foundation\Http\FormRequest;

class UpdateYaumiStreakRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Kalau hanya admin yang boleh tambah, bisa ubah di sini
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_streak' => ['required', 'integer', 'min:0'],
            'longest_streak' => ['required', 'integer', 'min:0'],
            'last_logged_date' => ['nullable', 'date'],
        ];
    }
}

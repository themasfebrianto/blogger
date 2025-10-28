<?php

namespace App\Http\Requests\Yaumi\YaumiStreaks;

use Illuminate\Foundation\Http\FormRequest;

class StoreYaumiStreakRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'activity_id' => ['required', 'exists:yaumi_activities,id'],
            'date' => ['required', 'date'],
        ];
    }
}

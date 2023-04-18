<?php

namespace App\Http\Requests\Frontsite;

use Illuminate\Foundation\Http\FormRequest;

class AddMusicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'external_music_id'=> 'required|string',
            'title' => 'required|string'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;


class StoreRequest extends FormRequest
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
            'title' => 'required|string|min:5',
            'category_id'=>'required|integer',
            'author_id' =>'required|integer',//butuhh check author_id ada di db/enggak
            'image'=>'required|image',
            'released_date' => 'required|date'
        ];
    }
}

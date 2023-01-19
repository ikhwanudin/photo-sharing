<?php

namespace App\Domains\Photo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPhotoRequest extends FormRequest
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
            'title' => ['string', 'max:144'],
            'description' => ['string'],
        ];
    }
}

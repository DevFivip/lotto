<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'number' => 'required',
            'nombre' => ['string', 'max:255', 'required'],
            'limit_cant' => ['required'],
            'limit_price_usd' => ['required'],
            'status' => ['required'],
        ];
        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

        $usu = isset($this->route()->parameters['usuario']) ? $this->route()->parameters['usuario'] : null;

        $rules =  [
            'taquilla_name' => 'required|min:5|max:255',
            'name' => 'required|min:5|max:255',
            'email' => ['string', 'max:255', 'email', 'required', Rule::unique('users')->ignore($usu)],
            'monedas' => ['required'],
        ];

        if ($this->method() == 'POST') {
            $rules['passwordConfirm'] = 'sometimes|required_with:password|same:password';
            $rules['password'] = 'sometimes|required|string|min:6';
        }

        return $rules;
    }


    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => 'verifique los datos para continuar',
    //         'errors'      => $validator->errors()
    //     ], 422));
    // }
}

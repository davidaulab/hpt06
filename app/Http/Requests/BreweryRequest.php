<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BreweryRequest extends FormRequest
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
            //
            'name'          => 'required', 
            'description'   => 'required',
            'long'          => 'required',
            'lat'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'description.required' => 'El campo descripción es obligatorio',
            'long.required' => 'El campo longitud es obligatorio',
            'lat.required' => 'El campo latitud es obligatorio',
            
        ];
    }
}

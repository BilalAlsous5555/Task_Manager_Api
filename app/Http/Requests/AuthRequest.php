<?php

namespace App\Http\Requests;

use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log as FacadesLog;

use function Pest\Laravel\json;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email'=> 'required|email|string|unique:users,email',
            'password'=> 'required|string|min:8'
        ];
    }
    public function messages()
    {
        return 
            [
            'name.string' => 'name should be string !',
            'email.unique' => 'email should be unique !',
            'password.min' => 'password length should be at least 8 charactes !'
            ];
    }
    public function prepareForValidation()
    {
        Hash::make($this->password);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
            'success' =>false ,
            'message' => 'validation_error',
            'errors' => $validator->errors(),
        ], 422));
    }
}

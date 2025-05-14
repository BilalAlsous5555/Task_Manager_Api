<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
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
            'task_content' =>'required|string|max:255|',
            'priority' =>'required|boolean|' ,
            'user_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id',
        ];
    }
    protected function failedValidation(ValidationValidator $validator)
    {
        
            throw new HttpResponseException(response()->json(
                [
                'success' =>false ,
                'message' => 'validation_error',
                'errors' => $validator->errors(),
            ], 422));
        
    }


}

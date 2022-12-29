<?php

namespace IBekzod\Uploader\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class PaginationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return config('uploader.authorize', false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'page' => 'sometimes|numeric',
            'limit' => 'sometimes|numeric'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'message' => $validator->errors()->first()
        ], 422);
        throw new ValidationException($validator, $response);
    }
    public function all($keys = null)
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }
}

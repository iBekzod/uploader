<?php

namespace IBekzod\Uploader\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class UploadUpdateRequest extends FormRequest
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
        $rules = config('uploader.rules', []);
        $collected_rules = [];
        if (array_key_exists('mimes', $rules))
            $collected_rules[] = 'mimes:' . $rules['mimes'];
        if (array_key_exists('size', $rules) && array_key_exists('limit_max', $rules['size']) && $rules['size']['limit_max'] && array_key_exists('max', $rules['size']))
            $collected_rules[] = 'max:' . $rules['max'];
        if (array_key_exists('size', $rules) && array_key_exists('limit_min', $rules['size']) && $rules['size']['limit_min'] && array_key_exists('min', $rules['size']))
            $collected_rules[] = 'min:' . $rules['min'];
        if (array_key_exists('attachments', $rules) && array_key_exists('limit_min_quantity', $rules['attachments']) && $rules['attachments']['limit_min_quantity'] && array_key_exists('min_quantity', $rules['attachments']))
            $multiple_file_rules[] = 'min:' . $rules['min_quantity'];
        if (array_key_exists('attachments', $rules) && array_key_exists('limit_max_quantity', $rules['attachments']) && $rules['attachments']['limit_max_quantity'] && array_key_exists('max_quantity', $rules['attachments']))
            $multiple_file_rules[] = 'max:' . $rules['max_quantity'];
        return [
            'type' => 'sometimes|string',
            'attachment' => array_merge(['required_without:attachments'], $collected_rules),
            'attachments.*' => array_merge(['required_without:attachment'], $collected_rules),
            'attachments' => array_merge(['required_without:attachment'], $multiple_file_rules),
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

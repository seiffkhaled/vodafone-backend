<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|array',
            'type.*' => 'in:mail,database',
            'emails' => 'array|required',
            'emails.*' => 'email',
            'message' => 'required|array',
            'message.0'=> 'string|nullable',
            'message.1'=> 'array|nullable',
            'message.1.*' => 'string|nullable',
            'message.2'=> 'string|nullable',
            'subject' => [
                'string',
                Rule::requiredIf(function () {
                    return in_array('mail', $this->input('type', []));
                }),
                'nullable'
            ],
            'attachments' => 'nullable|array',
            'view' => [
                'string',
                Rule::requiredIf(function () {
                    return in_array('mail', $this->input('type', []));
                }),
                'nullable'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'emails.required' => __('notifications.emails_required'),
            'emails.array' => __('notifications.emails_array'),
            'message.required' => __('notifications.message_required'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}

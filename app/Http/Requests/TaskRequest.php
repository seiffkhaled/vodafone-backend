<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'user_id'=> 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'=> 'required|date',
            'completion_date' => 'nullable|date|after:start_date',
            'due_date' => 'required|date|after:start_date',
            'status' => 'nullable|string|in:Pending,Completed,Overdue',
        ];
    }
}

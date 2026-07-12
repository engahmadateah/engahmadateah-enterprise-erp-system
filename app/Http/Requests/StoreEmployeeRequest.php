<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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

        'department_id' => 'required',

        'first_name' => 'required',

        'last_name' => 'required',

        'email' => 'required|email|unique:employees,email',

        'phone' => 'nullable',

        'position' => 'required',

        'salary' => 'required|numeric',

        'join_date' => 'required|date',

        'avatar' => 'nullable|image|max:2048',

    ];
}
}

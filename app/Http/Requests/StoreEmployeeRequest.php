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

        'department_id' => 'required|exists:departments,id',

        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',

        'email' => 'required|email|max:255|unique:employees,email|unique:users,email',

        'phone' => 'nullable|string|max:50',
        'position' => 'required|string|max:100',
        'salary' => 'required|numeric|min:0|max:999999999',

        'join_date' => 'required|date',

        'avatar' => 'nullable|image|max:2048',

    ];
}
}

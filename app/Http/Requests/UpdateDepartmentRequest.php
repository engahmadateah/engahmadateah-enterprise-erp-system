<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|max:255',

            'code' => [

                'required',

                Rule::unique('departments')
                    ->ignore(
                        $this->route('department')->id
                    ),

            ],

            'description' => 'nullable',

        ];
    }
}
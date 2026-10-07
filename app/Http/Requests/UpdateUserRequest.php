<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
    
            'name' => 'required|max:255',
    
            'email' => [
    
                'required',
                'email',
    
                Rule::unique('users')
    ->ignore($this->route('user')->id)
    
            ],
    
            'phone' => 'nullable|max:30',
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
    
        ];
    }
}

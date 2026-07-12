<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    
            'email' => 'required|email|unique:users,email',
    
            'phone' => 'nullable|max:30',
    
            'password' => 'required|min:8',
    
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array{
        $on_update_for_password = $this->method() == 'PUT' ? "" : 'required';
        $on_update_for_email = $this->method() == "PUT" ? "": "|required|unique:users,email";
        return [
            'name' => 'required',
            'email' => 'email'.$on_update_for_email,
            'password' => $on_update_for_password.'|min:8|max:16',
            'role_name' => 'required',
        ];
    }
}

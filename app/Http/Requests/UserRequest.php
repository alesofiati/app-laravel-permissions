<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserService;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserService::can("user-create");
    }

    public function attributes(): array
    {
        return [
            "name" => "nome",
            "email" => "e-mail",
            "password" => "senha",
            "password_confirmation" => "comfirmação de senha",
            "role" => "perfil"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userId = request()->route('user');
        return [
            "name" => "required",
            "email" => "required|email|unique:users,email,{$userId}",
            "role" => "required",
            "password" => "required|confirmed|min:6",
            "password_confirmation" => "required|min:6"
        ];
    }

    public function messages(): array
    {
        return [
            "password.confirmed" => "As senhas não são identicas"
        ];
    }
}

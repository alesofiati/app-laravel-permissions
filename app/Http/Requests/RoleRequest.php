<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserService;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserService::can("role-create");
    }

    public function attributes(): array
    {
        return [
            "role" => "perfil",
            "permissions" => "permissões"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "role" => "required|min:4",
            "permissions" => "required"
        ];
    }
}

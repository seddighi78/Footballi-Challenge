<?php

namespace App\Http\Requests\Auth;

use App\Rules\GithubUsername;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $username
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:users,username', 'max:255', new GithubUsername()],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }
}

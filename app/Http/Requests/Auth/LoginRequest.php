<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required'
        ];
    }

    public function getCredentials()
    {
        $name = $this->get('name');
        if ($this->isEmail($name)) {
            return [
                'email' => $name,
                'password' => $this->get('password')
            ];
        }
        return $this->only('name', 'password');
    }

    private function isEmail($email)
    {
        $factory = $this->container->make(Factory::class);

        return !$factory->make(
            ['name' => $email],
            ['name' => 'email']
        );
    }
}

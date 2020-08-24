<?php

namespace App\Http\Requests;

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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10|numeric|unique:users',
            'password' => 'required|min:5'
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'email không được để trống!',
            'email.email' => 'email không đúng định dạng!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.min' => 'Mật khẩu không được nhỏ hơn 5 ký tự',
        ];
    }
}

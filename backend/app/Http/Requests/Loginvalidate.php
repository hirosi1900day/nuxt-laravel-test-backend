<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Loginvalidate extends FormRequest
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
            'email' => 'required|max:255|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages() {
        return [
            'email.required' => 'メールアドレスが必要です',
            'password.required' => 'パスワードは必須です',
            'password.min:8' => '最低8文字以上で入力してくだい'
        ];
       
    }
}


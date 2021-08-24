<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Registervalidate extends FormRequest
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
            'email_token' => 'required|unique',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function messages() {
        return [
            'email.required' => 'トークンが設定されていません',
            'email.unique' => 'すでに登録されています',
            'password.required' => 'パスワードは必須です',
            'password.min:8' => '最低8文字以上で入力してくだい'
        ];
       
    }
}

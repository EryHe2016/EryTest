<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'username' => 'required|regex:/\w{8,20}/',
            'password' => 'required',
            'checkcode' => 'captcha'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.regex' => '用户名规则不正确，8到20为字母数字下划线',
            'password.required' => '密码不能为空',
            'checkcode.captcha' => '验证码不正确'
        ];
    }
}

<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function show()
    {
        return view('home.login');
    }

    /**
     * 生成验证码
     */
    public function captcha(Request $request)
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        //$builder->save('./images/out.jpg');
        //header('Content-type: image/jpeg');
        $captcha = $builder->output();
        $request->session()->flash('captcha', $captcha);
        return response($captcha)->header('Content-Type', 'image/jpeg');
    }

    public function login(LoginRequest $request)
    {
        //验证表单数据
        $request->validate();
    }
}

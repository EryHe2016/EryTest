<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class LoginController extends Controller
{
    /**
     * 加载登录视图
     */
    public function login()
    {
        return view('admin.login.login');
    }

    /**
     * 验证用户登录
     */
    public function dologin(Request $request)
    {
        //验证
        $this->validate($request, [
            'email' => 'required|exists:users,email'
        ], [
            'email.required' => '账户名不能为空',
            'email.exists' => '账号名不存在'
        ]);
        //实例化用户对象
        $user = User::where('email', $request->input('email'))->first();
        //验证密码
        if(Hash::check($request->input('password'), $user->password)){
            //写入登录状态
            session(['user_id'=>$user->id]);
            return redirect('/admin');
        }else{
            return back();
        }
    }

    /**
     * 用户退出登录
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 用户的添加页面显示
     */
    public function add()
    {
        return view('admin.user.add');
    }

    /**
     * 新增用户
     */
    public function insert(Request $request)
    {
        //表单验证
        $this->validate($request, [
            'username'=>'required|regex:/\w{8,20}/',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|same:repassword'
        ], [
            'username.required'=>'用户名不能为空',
            'username.regex'=>'用户名规则不正确，8到20为字母数字下划线',
            'email.required'=>'邮箱不能为空',
            'email.email'=>'邮箱格式不正确',
            'email.unique'=>'该邮箱已经被使用',
            'password.required'=>'密码不能为空',
            'password.same'=>'两次密码不一致'
        ]);
        //dd($request);
        //验证通过 插入数据库
        $user = new User;
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->intro = $request->input('intro');
        $user->remember_token = str_random(50);
        //文件上传
        if($request->hasFile('profile')){
            //文件上传目录
            $path = './images/'.date('Ymd');
            //获取上传文件后缀
            $extension = $request->file('profile')->getClientOriginalExtension();
            //文件名
            $fileName = time().rand(1000, 9999).'.'.$extension;
            //文件上传
            $request->file('profile')->move($path, $fileName);

            $user->profile = trim($path, '.').'/'.$fileName;
        }
        if($user->save()){
            return redirect('/user/index')->with('info', '添加成功');
        }else{
            return back()->with('info', '添加失败');
        }
    }

    /**
     * 用户列表页显示
     */
    public function index(Request $request)
    {
        //1.每页展示的数量
        //2.检索的条件
        $users = User::orderBy('id', 'desc')
            ->where(function($query) use ($request){
                $keyword = $request->input('keyword');
                if(!empty($keyword)){
                    $query->where('name', 'like', '%'.$keyword.'%');//关键字搜索
                }
            })
            ->paginate($request->input('num', 10)); //  若传递的参数有页数就展示没有默认为10

        return view('admin.user.index', ['users'=>$users,'request'=>$request]);
    }

    /**
     * 用户信息编辑视图展示
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user'=>$user]);
    }

    /**
     * 更新用户信息
     */
    public function update(Request $request)
    {
        //验证
        $this->validate($request, [
            'username'=>'required|regex:/\w{8,20}/',
            'email'=>'required|email'
        ], [
            'username.required'=>'用户名不能为空',
            'username.regex'=>'用户名规则不对，8到20为字母数字或者下划线',
            'email.required'=>'邮箱不能为空',
            'email.email'=>'邮箱格式不正确'
        ]);
        //验证通过 更新数据
        $user = User::findOrFail($request->input('id'));    //先查出当前用户id的相关数据
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->intro = $request->input('intro');
        if($user->save()){
            return redirect('/user/index')->with('info', '更新成功');
        }else{
            return back()->with('info', '更新失败');
        }
    }

    /**
     * 删除用户
     */
    public function delete($id){
        $user = User::findOrFail($id);  //若是查不到数据就跳转到404页面
        //读取用户的头像信息
        $path = $user->profile;
        if(file_exists($path)){
            unlink($path);
        }
        if($user->delete()){
            return redirect('/user/index')->with('info', '删除成功');
        }else{
            return back()->with('info', '删除失败');
        }
    }
}

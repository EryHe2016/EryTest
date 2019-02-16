<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cate;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    /**
     * 分了列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cates = $this->getCates();
        return view('admin.cate.index', ['cates'=>$cates,'request'=>$request]);
    }

    /**
     * 获取所有分类信息
     */
    public static function getCates()
    {
        $cates = Cate::select(DB::raw('*,concat(path,",",id) as paths'))->orderBy('paths')->get();
        //遍历数组 调整分类的名称
        foreach($cates as $cate){
            //判断当前分类是几级分类
            $num = count(explode(',', $cate['paths']))-1;
            $prefix = str_repeat('|------', $num);
            $cate->name = $prefix.$cate->name;
        }
        return $cates;
    }

    /**
     * 展示新增分类页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates = Cate::get();
        return view('admin.cate.add', ['cates'=>$cates]);
    }

    /**
     * 新增分类
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //一级分类的p_id和path 都是0
        if($data['pid']==0){
            $data['path'] = 0;
        }else{//如果不是顶级分类
            //读取父分类的信息
            $info = Cate::find($data['pid']);
            $data['path'] = $info['path'].','.$info['id'];
        }
        $cate = new Cate;
        $cate->name = $data['name'];
        $cate->p_id = $data['pid'];
        $cate->path = $data['path'];
        if($cate->save()){
            return redirect('/cate/create')->with('info', '分类添加成功');
        }else{
            return back()->with('info', '分类添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 展示编辑分类试图
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取当前分类信息
        $info = Cate::find($id);
        //获取所有分类信息
        $cates = $this->getCates();
        return view('admin.cate.edit', ['info'=>$info, 'cates'=>$cates]);
    }

    /**
     * 更新分类信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        //实例化当前分类模型
        $cate = Cate::findOrFail($id);
        if($data['pid']==0){
            $data['path'] = 0;
        }else{
            $info = Cate::find($data['pid']);
            $data['path'] = $info->path.','.$info->id;
        }
        $cate->name = $data['name'];
        $cate->p_id = $data['pid'];
        $cate->path = $data['path'];
        if($cate->save()){
            return redirect('/cate')->with('info', '更新分类成功');
        }else{
            return back()->with('info', '更新分类失败');
        }
    }

    /**
     * 删除分类数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Cate::findOrFail($id);
        //需要删除当前分类下的所有子分类
        $path = $cate->path.','.$cate->id;
        DB::table('cates')->where('path', 'like', $path.'%')->delete();
        if($cate->delete()){
            return redirect('/cate')->with('info', '删除成功');
        }else{
            return back()->with('info', '删除失败');
        }
    }
}

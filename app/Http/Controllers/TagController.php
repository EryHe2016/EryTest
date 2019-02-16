<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * 标签列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取所有标签
        $tags = Tag::orderBy('id')
            ->where(function($query) use ($request){
                $keyword = $request->input('keyword');
                if(!empty($keyword)){
                    $query->where('name', 'like', '%'.$keyword.'%');
                }
            })
            ->paginate($request->input('num', 10));
        return view('admin.tag.index', ['tags'=>$tags, 'request'=>$request]);
    }

    /**
     * 标签新增页面展示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.add');
    }

    /**
     * 新增tag标签
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request, [
            'name'=>'required|unique:tags,name',
        ], [
            'name.required'=>'标签名不能为空',
            'name.unique'=>'标签已经存在'
        ]);
        $tag = new Tag;
        $tag->name = $request->input('name');
        if($tag->save()){
            return redirect('/tag/create')->with('info', '标签添加成功');
        }else{
            return back()->with('info', '标签添加失败');
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
     * 展示编辑标签页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取标签信息
        $info = Tag::findOrFail($id);
        return view('admin.tag.edit', ['info'=>$info]);
    }

    /**
     * 更新标签信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //实例化标签模型
        $tag = Tag::find($id);
        //验证
        $this->validate($request, [
            'name'=>'required|unique:tags,name,'.$id,
        ], [
            'name.required'=>'标签名不能为空',
            'name.unique'=>'标签已经存在'
        ]);

        $tag->name = $request->input('name');
        if($tag->save()){
            return redirect('/tag')->with('info', '标签更新成功');
        }else{
            return back()->with('info', '标签更新失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        if($tag->delete()){
            return redirect('/tag')->with('info', 'tag标签删除成功');
        }else{
            return back()->with('info', 'tag标签删除失败');
        }
    }

    /**
     * 获取所有标签信息
     */
    public static function getTags()
    {
        $tags = Tag::orderBy('id')->get();
        return $tags;
    }
}

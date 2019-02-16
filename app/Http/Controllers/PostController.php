<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * 文章列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取所有文章
        $posts = Post::orderBy('id')
            ->where(function($query) use ($request){
                $keyword = $request->input('keyword');
                if(!empty($keyword)){
                    $query->where('title', 'like', '%'.$keyword.'%');
                }
            })
            ->paginate($request->input('num', 10));
        return view('admin.post.index', ['posts'=>$posts, 'request'=>$request]);
    }

    /**
     * 加载文章添加视图
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有分类数据
        $cates = CateController::getCates();
        //获取所有标签数据
        $tags = TagController::getTags();
        return view('admin.post.add', ['cates'=>$cates, 'tags'=>$tags]);
    }

    /**
     * 新增文章数据
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $post = new Post;
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->cate_id = $data['cate_id'];
        //新增文章用户
        $post->user_id = rand(1,10);
        //主图上传
        if($request->hasFile('img')){
            $path = './images/post/'.date('Ymd');
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileName = time().rand(1000,9999).'.'.$extension;
            //上传文件到指定目录
            $request->file('img')->move($path, $fileName);
            //将路径保存到数据库
            $post->img = trim($path.'/'.$fileName, '.');
        }
        if($post->save()){
            if($post->tags()->sync($request->tag_id)){
                return redirect('/post/create')->with('info', '文章添加成功');
            }
        }else{
            return back()->with('info', '文章添加失败');
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
     * 展示文章编辑页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取文章数据
        $info = Post::findOrFail($id);
        //获取所有分类数据
        $cates = CateController::getCates();
        //获取所有的标签数据
        $tags = TagController::getTags();
        //获取当前文章已经绑定的标签数据
        $allTag = $info->tags;
        $ids = [];
        foreach($allTag as $val){
            $ids[] = $val->id;
        }
        return view('admin.post.edit', ['info'=>$info, 'cates'=>$cates, 'tags'=>$tags, 'ids'=>$ids]);
    }

    /**
     * 更新文章信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $post = Post::findOrFail($id);
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->cate_id = $data['cate_id'];
        //主图上传
        if($request->hasFile('img')){
            $path = './images/post/'.date('Ymd');
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileName = time().rand(1000,9999).'.'.$extension;
            //上传文件到指定目录
            $request->file('img')->move($path, $fileName);
            //删除原有的主图
            $img = $post->img;
            @unlink('.'.$img);  //./images/post/20190201/15490050591867.jpg
            //将路径保存到数据库
            $post->img = trim($path.'/'.$fileName, '.');
        }
        if($post->save()){
            if($post->tags()->sync($request->tag_id)){
                return redirect('/post')->with('info', '文章更新成功');
            }
        }else{
            return back()->with('info', '文章更新失败');
        }
    }

    /**
     * 删除文章
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        @unlink('.'.$post->img);
        if($post->delete()){
            $post->tags()->detach();
            return redirect('/post')->with('info', 'success!');
        }else{
            return bakc()->with('info', 'fail!');
        }
    }

    /**
     * ceshi
     */
    public function test(){

    }
}

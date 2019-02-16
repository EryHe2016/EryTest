@extends('layout.admin')

@section('title', '文章添加')

@section('content')
<script type="text/javascript" charset="utf-8" src="{{asset('/plugins/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('/plugins/ueditor/ueditor.all.min.js')}}"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="{{asset('/plugins/ueditor/lang/zh-cn/zh-cn.js')}}"></script>

<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>文章添加</span>
    </div>
    @if (count($errors) > 0)
    <div class="mws-form-message error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="mws-panel-body no-padding">
        <form class="mws-form" action="{{url('/post/'.$info->id)}}" method="post" enctype="multipart/form-data">
            <div class="mws-form-inline">
                <div class="mws-form-row">
                    <label class="mws-form-label">文章名称</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name="title" value="{{$info->title}}">
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">所属分类</label>
                    <div class="mws-form-item">
                        <select class="small" name="cate_id">
                            <option value="0">请选择</option>
                            @foreach($cates as $cate)
                            <option value="{{$cate->id}}" @if($info->cate_id == $cate->id) selected @endif>{{$cate->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">文章主图</label>
                    <div class="mws-form-item">
                        <img src="{{$info->img}}">
                        <input type="file" class="small" name="img">
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">文章详情</label>
                    <div class="mws-form-item">
                        <textarea id="editor" name="content" style="width:900px;height:400px;">{{$info->content}}</textarea>
                    </div>
                </div>

                <div class="mws-form-row bordered">
                    <label class="mws-form-label">标签</label>
                    <div class="mws-form-item clearfix">
                        <ul class="mws-form-list inline">
                            @foreach($tags as $tag)
                            <li><label><input type="checkbox" name="tag_id[]" @if(in_array($tag->id, $ids)) checked @endif value="{{$tag->id}}">{{$tag->name}}</label></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mws-button-row">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <input type="submit" value="更新" class="btn btn-danger">
                <input type="reset" value="重置" class="btn ">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

</script>
@endsection


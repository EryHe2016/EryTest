@extends('layout.admin')

@section('title', '用户列表')

@section('content')
<link rel="stylesheet" href="{{asset('/admins/css/index.css')}}">
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
		<span>
			<i class="icon-table">
            </i>
			用户列表
		</span>
    </div>
    <div class="mws-panel-body no-padding">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">

            <form action="{{url('/post')}}">
                <div id="DataTables_Table_1_length" class="dataTables_length">
                    <label>
                        显示
                        <select size="1" name="num" aria-controls="DataTables_Table_1">
                            <option value="10" @if($request->input('num')==10) selected @endif>
                                10
                            </option>
                            <option value="25" @if($request->input('num')==25) selected @endif>
                                25
                            </option>
                            <option value="50" @if($request->input('num')==50) selected @endif>
                                50
                            </option>
                            <option value="100" @if($request->input('num')==100) selected @endif>
                                100
                            </option>
                        </select>
                        条
                    </label>
                </div>
                <div class="dataTables_filter" id="DataTables_Table_1_filter">
                    <label>
                        关键字:
                        <input type="text" value="{{$request->input('keyword')}}" name="keyword" aria-controls="DataTables_Table_1">
                        <button class="btn btn-info">搜索</button>
                    </label>
                </div>
            </form>
            <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1"
                   aria-describedby="DataTables_Table_1_info">
                <thead>
                <tr role="row">
                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                        style="width: 100px;">
                        ID
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                        style="width: 205px;">
                        文章标题
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending"
                        style="width: 193px;">
                        所属分类
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending"
                        style="width: 135px;">
                        主图
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                        style="width: 102px;">
                        操作
                    </th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @foreach($posts as $post)
                <tr class="odd even ">
                    <td class=" sorting_1">
                        {{$post->id}}
                    </td>
                    <td class=" ">
                        {{$post->title}}
                    </td>
                    <td class=" ">
                        {{$post->cate->name}}
                    </td>
                    <td class=" ">
                        <img src="{{$post->img}}" width="50" alt="">
                    </td>

                    <td class=" ">
                        <a href="{{url('/post/'.$post->id.'/edit')}}" class="btn"><i class="icon-pencil"></i></a>
                        <form action="{{url('/post/'.$post->id)}}" method="post" style="display:inline">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-warning"><i class="icon-remove-sign"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">

                <div id="pages">
                    {!! $posts->appends($request->only(['num','keyword']))->render() !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
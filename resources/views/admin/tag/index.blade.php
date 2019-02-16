@extends('layout.admin')

@section('title', '标签列表')

@section('content')
<link rel="stylesheet" href="{{asset('/admins/css/index.css')}}">
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
		<span>
			<i class="icon-table">
            </i>
			标签列表
		</span>
    </div>
    <div class="mws-panel-body no-padding">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">

            <form action="">
                <div id="DataTables_Table_1_length" class="dataTables_length">
                    <label>
                        显示
                        <select size="1" name="num" aria-controls="DataTables_Table_1">
                            <option value="10" @if($request->num == 10) selected @endif>
                                10
                            </option>
                            <option value="25" @if($request->num == 25) selected @endif>
                                25
                            </option>
                            <option value="50" @if($request->num == 50) selected @endif>
                                50
                            </option>
                            <option value="100" @if($request->num == 100) selected @endif>
                                100
                            </option>
                        </select>
                        条
                    </label>
                </div>
                <div class="dataTables_filter" id="DataTables_Table_1_filter">
                    <label>
                        关键字:
                        <input type="text" value="{{$request->keyword}}" name="keyword" aria-controls="DataTables_Table_1">
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
                        style="width: 160px;">
                        ID
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                        style="width: 205px;">
                        tag名称
                    </th>

                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                        style="width: 102px;">
                        操作
                    </th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @foreach($tags as $tag)
                <tr class="even  odd  ">
                    <td class=" sorting_1">
                        {{$tag->id}}
                    </td>
                    <td class=" ">
                        {{$tag->name}}
                    </td>

                    <td class=" ">
                        <a href="/tag/{{$tag->id}}/edit" class="btn"><i class="icon-pencil"></i></a>
                        <form action="/tag/{{$tag->id}}" style="display:inline" method="post">
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
                    {!! $tags->appends($request->only(['num', 'keyword']))->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
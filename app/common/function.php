<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2019/1/31
 * Time: 10:44
 */

function test(){
    return 'iloveyou';
}

/**
 * 获取分类名称通过分类id
 */
function getCateNameById($id)
{
    if(!$id){
        return '无';
    }
    $cate = \App\Cate::find($id);
    if($cate->name){
        return $cate->name;
    }else{
        return '顶级分类';
    }
}

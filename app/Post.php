<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * 文章和tag是多对多关系
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tags', 'post_id', 'tag_id')->withTimestamps();
    }

    /**
     * 文章和分类是属于关系 cate和post是一对多关系
     */
    public function cate()
    {
        return $this->belongsTo('App\Cate', 'cate_id', 'id');
        //参数一: 所属的模型 参数二: 当前文章表中分类表的外键cate_id 参数三: 参数一的主键ID
    }
}

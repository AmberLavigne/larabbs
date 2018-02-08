<?php

namespace App\Models;

class Topic extends Model
{

    protected $table = 'topics';
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function category()
    {
        #一个话题属于一个分类
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function user()
    {
        #user 一个话题拥有一个作者。
        return $this->belongsTo(User::class,'user_id','id');
    }
}

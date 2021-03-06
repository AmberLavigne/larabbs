<?php

namespace App\Models;

class Topic extends Model
{

    protected $table = 'topics';
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

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

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;

            default:
                $query = $this->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function getRouteKeyName()
    {
        # 重写http://larabbs.test/topics/1   路由传递的键名
        return 'id';
    }

    public function link($params = [])
    {
        return route('topics.show',array_merge([$this->id,$this->slug],$params));
    }
    public function replies()
    {
        #一个帖子下面有很多回复。
        return $this->hasMany(Reply::class,'topic_id','id');
    }
}

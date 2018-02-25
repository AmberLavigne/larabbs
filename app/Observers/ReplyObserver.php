<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content,'user_topic_body'); //处理 XSS 安全问题
    }

    public function updating(Reply $reply)
    {
        //
    }
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count',1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));  //这是重点 $topic->user 传入的就是文章作者。
    }
}
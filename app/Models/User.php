<?php

namespace App\Models;


use  Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    use Notifiable {
        notify as protected laravelNotify;
    }
    use HasRoles;
    /**
     * The attributes that are mass assignable.$fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则忽略。
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar','phone',
        'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class,'user_id','id');
    }
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     *  一个用户拥有多条评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 通知消息  ReplyObserver  调用
     * @param $instance
     */
    public function notify($instance)
    {
       if($this->id == Auth::id()){
           return;
       }
       $this->increment('notification_count');
       $this->laravelNotify($instance);

    }
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }
    public function setAvatarAttribute($path){
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if(!starts_with($path,'http')){
            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }

    // Rest omitted for brevity

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

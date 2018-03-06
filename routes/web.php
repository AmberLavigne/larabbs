<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@root')->name('root');

//Auth::routes();  这一个相当于下面三类
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//用户
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

//话题
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');

//分类列表话题
Route::resource('categories','CategoriesController',['only'=>['show']]);

//话题上传图片
Route::post('upload_image','TopicsController@uploadImage')->name('topics.upload_image');
//评论
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
//消息通知
Route::resource('notifications', 'NotificationsController',['only'=>'index']);
//无权限提醒页面
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

Route::get('sss',function(){
    $arr = [9,10,11,12,29];
    $tmp = 8;

    $len=count($arr);
    for($i=1;$i<$len; $i++) {
        $arr[$len]=$tmp;
        //内层循环控制，比较并插入
        for($j=$len;$j>=0;$j--) {
            if($tmp <$arr[$j-1]){
                //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                $arr[$j-1] = $arr[$j];
                $arr[$j] = $arr[$j-1];
            } else {
                //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    print_r($arr);

});



































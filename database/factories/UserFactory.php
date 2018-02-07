<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|Faker 是一个假数据生成库，sentence() 是 faker 提供的 API ，随机生成『小段落』文本。我们用来填充 introduction 个人简介字段。
|Carbon 是 PHP DateTime 的一个简单扩展，这里我们使用 now() 和 toDateTimeString() 来创建格式如 2017-10-13 18:42:40 的时间戳。
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $now = Carbon::now()->toDateTimeString();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password?:$password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'introduction' => $faker->sentence(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});

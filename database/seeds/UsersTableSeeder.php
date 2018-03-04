<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 顶部使用 use 关键词引入必要的类。
     * factory(User::class) 根据指定的 User 生成模型工厂构造器，对应加载 UserFactory.php 中的工厂设置。
     * times(10) 指定生成模型的数量，此处我们只需要生成 10 个用户数据。
     * make() 方法会将结果生成为 集合对象。
     * each() 是 集合对象 提供的 方法，用来迭代集合中的内容并将其传递到回调函数中。
     * use 是 PHP 中匿名函数提供的本地变量传递机制，匿名函数中必须通过 use 声明的引用，才能使用本地变量。
     * makeVisible() 是 Eloquent 对象提供的方法，可以显示 User 模型 $hidden 属性里指定隐藏的字段，此操作确保入库时数据库不会报错。
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];
        $users = factory(User::class)->times(10)->make()->each(
            function($user,$index) use($faker,$avatars)
            {
                $user->avatar = $faker->randomElement($avatars);
            }
        );
        $user_array =$users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($user_array);
        $user = User::find(1);
        $user->name = 'yujiaxing';
        $user->email = 'yujiaxing@qq.com';
        $user->password = bcrypt('123456');
        $user->avatar = 'http://larabbs.test/uploads/images/avatars/201802/06//1_1517929252_2mjetZPHBK.jpg';
        $user->save();
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');

    }
}

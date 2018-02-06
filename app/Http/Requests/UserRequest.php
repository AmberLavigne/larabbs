<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.权限验证
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// 表示所有权限都通过；
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        #dimensions 尺寸
        return [
            'name'=>'required|between:3,25|regex:/^[A-Z0-9a-z\-\_]+$/|unique:users,name,'.AUth::id(),
            'email'=>'required|email',
            'introduction'=>'max:80',
            'avatar'=>'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_width=200',
        ];
    }
    #unique:table,column,except,idColumn
    #强迫 Unique 规则忽略指定 ID：
    #如果你想在进行字段唯一性验证时忽略指定 ID 。
    #例如，在「更新个人资料」页面会包含用户名、邮箱和地点。这时你会想要验证更新的 E-mail 值是否唯一。
    #如果用户仅更改了用户名字段而没有改 E-mail 字段，
    #就不需要抛出验证错误，因为此用户已经是这个 E-mail 的拥有者了。

    public function messages()
    {
        return[
            'name.unique'=>'用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持中英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }

}

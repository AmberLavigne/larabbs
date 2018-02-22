<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    //

    public function show(Request $request,Category $category,Topic $topic)
    {
        #{{ route('categories.show',$topic->category->id) }}  视图点击
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->WithOrder($request->order)->where('category_id', $category->id)->paginate(20);
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category'));
    }
}
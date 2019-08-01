<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class Posts extends Controller
{
    public function index()
    {
        $list = Post::paginate(5);
        return view('admin.post.index', ['list' => $list]);
    }

    public function add()
    { }

    public function edit()
    { }
}
<?php

namespace App\Http\Controllers;

use Wink\WinkPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = WinkPost::with('tags')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->simplePaginate(12);
        return view('blog.index', [
            'posts' => $posts
        ]);
    }
}

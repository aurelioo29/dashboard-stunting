<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestPosts = Post::published()
            ->orderByDesc('published_at')
            ->take(6)
            ->get(['id', 'slug', 'title', 'excerpt', 'cover_image', 'published_at']);

        return view('welcome', compact('latestPosts'));
    }
}

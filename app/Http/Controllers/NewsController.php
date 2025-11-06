<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show(string $slug)
    {
        // Cari by slug; kalau nggak ketemu, coba by id numerik
        $post = Post::published()
            ->when(!ctype_digit($slug), fn($q) => $q->where('slug', $slug))
            ->when(ctype_digit($slug), fn($q) => $q->orWhere('id', (int)$slug))
            ->firstOrFail();

        // Related / baca lainnya (3)
        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get(['id', 'slug', 'title', 'cover_image']);

        return view('news.show', compact('post', 'related'));
    }
}

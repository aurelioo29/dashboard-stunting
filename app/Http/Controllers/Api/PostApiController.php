<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostApiController extends Controller
{
    /**
     * GET /api/posts
     * Ambil 10 postingan terbaru yang sudah dipublish.
     */
    public function index()
    {
        $posts = Post::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->take(10)
            ->get()
            ->map(function ($post) {
                return [
                    'id'            => $post->id,
                    'type'          => $post->type,              // news / tips
                    'title'         => $post->title,
                    'slug'          => $post->slug,
                    'excerpt'       => $post->excerpt,
                    'cover_image'   => $post->cover_image 
                                        ? url('storage/' . $post->cover_image)
                                        : null,
                    'published_at'  => $post->published_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $posts,
        ]);
    }

    /**
     * GET /api/posts/{slug}
     * Ambil detail 1 postingan lengkap.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => $post->id,
                'type'          => $post->type,
                'title'         => $post->title,
                'slug'          => $post->slug,
                'excerpt'       => $post->excerpt,
                'content'       => $post->content,
                'cover_image'   => $post->cover_image 
                    ? url('storage/' . $post->cover_image)
                    : null,
                'published_at'  => $post->published_at,
                'author'        => [
                    'id'    => $post->user->id,
                    'name'  => $post->user->name,
                ],
            ],
        ]);
    }
}

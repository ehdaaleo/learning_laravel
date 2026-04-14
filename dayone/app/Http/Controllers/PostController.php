<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    private function getPosts()
    {
        return [
            1 => [
                'id' => 1,
                'title' => 'Post1 title',
                'description' => 'post1 description',
                'image' => 'post1.jpeg'
            ],
            2 => [
                'id' => 2,
                'title' => 'Post2 title',
                'description' => 'post2 description',
                'image' => 'post2.jpeg'
            ],
            3 => [
                'id' => 3,
                'title' => 'Post3 title',
                'description' => 'post3 description',
                'image' => 'post3.jpeg'
            ],
            4 => [
                'id' => 4,
                'title' => 'Post4 title',
                'description' => 'post4 description',
                'image' => 'post4.jpg'
            ]
        ];
    }

    public function index()
    {
        $posts = $this->getPosts();
        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        $posts = $this->getPosts();
        $post = $posts[$id] ?? null;
        
        if (!$post) {
            abort(404, 'Post not found');
        }
        
        return view('posts.show', compact('post'));
    }
}
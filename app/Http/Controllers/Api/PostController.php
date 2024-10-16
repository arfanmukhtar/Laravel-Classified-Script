<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    // Apply authentication middleware to protect all endpoints
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        // Retrieve all posts
        $posts = Post::all();

        return response()->json(['data' => $posts]);
    }

    public function getPostsByCategory($categoryId)
    {
        // Retrieve posts by the provided category ID
        $posts = Post::where('category_id', $categoryId)->get();

        return response()->json(['data' => $posts]);
    }

    public function getPostsByLocation($locationId)
    {
        // Retrieve posts by the provided category ID
        $posts = Post::where('category_id', $categoryId)->get();

        return response()->json(['data' => $posts]);
    }
}

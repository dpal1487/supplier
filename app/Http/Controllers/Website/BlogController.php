<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Controllers\Dashboard\FileController;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Str;
use Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(10);

        if (count($blogs) > 0) {
            return BlogResource::collection($blogs);
        } else {
            return response()->json(['data' => null]);
        }
    }
    public function singleBlog(Request $request, $slug)
    {
        $blog = Blog::with('image')->where('slug', $slug)->first();
        $data = new BlogResource($blog);
        return response()->json(['data' => $data, 'success' => true]);
    }
}

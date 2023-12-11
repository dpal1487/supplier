<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogListResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ImageResource;
use App\Models\Blog;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = new Blog();
        if (!empty($request->q)) {
            $blogs = $blogs
                ->where('title', 'like', "%$request->q")
                ->orWhere('content', 'like', "%$request->q%");
        }
        if (!empty($request->s) || $request->s != '') {
            $blogs = $blogs->where('is_published', '=', $request->s);
        }
        return Inertia::render('Blog/Index', [
            'blogs' => BlogListResource::collection($blogs->paginate(10)->appends($request->all())),
        ]);
    }

    public function statusUpdate(Request  $request)
    {
        if (Blog::where(['id' => $request->id])->update(['is_published' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Unpublished" : "Published";
            return response()->json(['message' => "Your Blog has been " . $status, 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
    public function create()
    {
        return Inertia::render('Blog/Form');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'is_published' => $request->status,
        ]);
        if ($blog) {
            Image::where(['id' => $request->image['id']])->update(['entity_id' => $blog->id, 'entity_type' => 'blog']);

            return redirect('blog')->with('flash', [
                'success' => true,
                'message' => 'Blog create successfully',
            ]);
        }
        return redirect('blog');
    }

    public function show(Request $request, $id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            return Inertia::render('Blog/Show', [
                'blog' => new BlogResource($blog),
            ]);
        }

        return redirect('blog');
    }


    public function edit(Blog $blog)
    {
        if ($blog) {
            $image = Image::where(['entity_id' => $blog->id, 'entity_type' => 'blog'])->first();
            return Inertia::render('Blog/Form', [
                'blog' => new BlogResource($blog),
                'image' => $image ?  new ImageResource($image) : null,
            ]);
        }
        return redirect('blog');
    }


    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        if ($blog) {
            $update = Blog::where(['id' => $blog->id])->update([
                'title' => $request->title,
                'content' => $request->content,
                'is_published' => $request->status,
            ]);
            if ($update) {
                Image::where('id', $request->image['id'])->update(['entity_id' => $blog->id, 'entity_type' => 'blog']);
                return redirect('blog')->with('flash', [
                    'success' => true,
                    'message' => 'Blog updated successfully',
                ]);
            }
            return redirect('blog')->with('flash', [
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Blog not updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if ($blog->delete()) {
            return response()->json(['success' => true, 'message' => 'Blog has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}

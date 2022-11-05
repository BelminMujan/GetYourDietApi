<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Blog;

class BlogController extends Controller
{
    public function createBlog(Request $request){
        $blog = new Blog();
        $blog->save();
        return response()->json([
            "id" => $blog->id
         ], 201);
    }

    public function deleteBlog(Request $request){
        Blog::destroy(request()->id);
    }

    public function saveBlog(Request $request) {
        $validated = $request->validate([
            "id" => "required",
            "title" => "required|string",
            "subtitle" => "required|string"
        ]);
        $name = NULL;
        Log::Info($request->content);
        $blog = Blog::where("id", $request->get("id"))->firstOrFail();
        if($request->file("cover")) {
            $image = $request->file('cover');
            $name = "blog-cover-".$id."-".time().".".$image->getClientOriginalExtension();
            \Image::make($image)->save(public_path('images/').$name);
        }
      
         $blog->title = $validated["title"];
         $blog->subtitle = $validated["subtitle"];
         $blog->cover=$name;
         $blog->time_to_read = $request->time_to_read;
         $blog->content = $request->content;
         $blog->save();
         return response()->json([
            "blog" => $blog
         ], 200);
    }

    public function getAllBlogs(Request $request){
        $blogs = Blog::all();
        return response()->json([
            "blogs" => $blogs
        ], 200);
    }
}
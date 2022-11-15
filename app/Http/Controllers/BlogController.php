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
        Log::Info($request);
        $validated = $request->validate([
            "id" => "required",
            "title" => "required|string",
            "subtitle" => "required|string"
        ]);
        $name = NULL;
        $blog = Blog::where("id", $request->get("id"))->firstOrFail();
        if($request->file("cover")) {
            $image = $request->file('cover');
            $name = "blog-cover-".$validated["id"]."-".time().".".$image->getClientOriginalExtension();
            \Image::make($image)->save(public_path('images/blog/cover/').$name);
        }
        $content = NULL;
        if($cn = $request->get("content")){
            foreach ($cn as $i => $c) {
                $content[$i] = ["type" => "content", 'value' => $c];
            }
        }
        if($imgs = $request->file("images")){
            foreach ($imgs as $i => $img) {
                $name = "blog-image-".$validated["id"]."-".$i."-".time().".".$img->getClientOriginalExtension();
                $content[$i] = ["type" => "image", "value" => $name];
                \Image::make($img)->save(public_path("images/blog/images/").$name);
            }
        }
        Log::Info($content);
      
         $blog->title = $validated["title"];
         $blog->subtitle = $validated["subtitle"];
         $blog->cover=$name;
         $blog->time_to_read = $request->time_to_read;
         $blog->content = $content;
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
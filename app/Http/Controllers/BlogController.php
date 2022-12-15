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
        $blog = Blog::where("id", $request->get("id"))->firstOrFail();
        if($request->file("cover")) {
            $image = $request->file('cover');
            $c_name = "blog-cover-".$request->id."-".time().".".$image->getClientOriginalExtension();
            \Image::make($image)->save(storage_path('app/public/images/blog/cover/').$c_name);
            $blog->cover=@$c_name;
        }
        $content = NULL;
        if($cn = $request->get("content")){
            foreach ($cn as $i => $c) {
                $content[intval($i)] = ["type" => "content", 'value' => $c];
            }
        }
        if($imgs = $request->file("images")){
            foreach ($imgs as $i => $img) {
                $name = "blog-image-".$request->id."-".$i."-".time().".".$img->getClientOriginalExtension();
                $content[intval($i)] = ["type" => "image", "value" => $name];
                \Image::make($img)->save(storage_path("app/public/images/blog/images/").$name);
            }
        }
        ksort($content);
        Log::Info($content);
        $blog->title = $request->title;
        $blog->subtitle = $request->subtitle;
        $blog->time_to_read = $request->time_to_read;
        $blog->content = $content;
        $blog->save();
        return response()->json([
        "blog" => $blog
        ], 200);
    }

    public function getAllBlogs(Request $request){
        $blogs = Blog::select('id','title','created_at')->get();
        return response()->json([
            "blogs" => $blogs
        ], 200);
    }

    public function getBlog(Request $request){
        $blog = Blog::find(request()->id);
        return response()->json($blog, 200);
    }
}
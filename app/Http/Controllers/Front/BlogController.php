<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Str;

class BlogController extends Controller
{
    public function categoryBlogList(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {

            $categories = BlogCategory::all();
            $categoryBlogs = [];
            foreach ($categories as $category) {
                $blog = Blog::where('category_id', $category->id)->get();

                array_push($categoryBlogs, ["category" => $category, "blogs" => $blog]);
            }
            $featured = Blog::where('featured', 1)->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["categoryBlogs" => $categoryBlogs, 'featured_blogs' => $featured], "msg" => "Successfully fetched categories with blogs"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function blogCategories(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {

            $categories = BlogCategory::all();
            $obj = ["Status" => true, "success" => 1, "data" => ["categories" => $categories], "msg" => "Successfully fetched categories with blogs"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    public function blogDetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $blog = Blog::find($request->id);
            $obj = ["Status" => true, "success" => 1, "data" => ["blog" => $blog], "msg" => "Successfully fetched  blog"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function consultantBlogs(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $blogs = Blog::with('category')->where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["blogs" => $blogs], "msg" => "Successfully fetched  blog"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function createConsultantBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'token' => 'required',
            'user_id' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $data = $request->all();

        $slug = Str::slug($request->title);
        $data['slug'] = $slug;
        $data['is_approved'] = 0;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/blog/');
            $image->move($path, $image_name);

            $data['image_path'] = '/assets/admin/blog/' . $image_name;
        }
        if ($created = Blog::create($data)) {
            $obj = ["Status" => true, "success" => 1, "msg" => "Successfully added Blog"];
            return response()->json($obj);
        }
    }
    public function deleteConsultantBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'blog_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $blog = Blog::find($request->blog_id);
            if ($blog) {
                $blog->delete();
                $obj = ["Status" => true, "success" => 1, "msg" => "Blog Successfully Deleted"];
            } else {
                $obj = ["Status" => false, "success" => 0, "msg" => "Blog does not Exist"];
            }

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function updateConsultantBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'blog_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $blog = Blog::find($request->blog_id);
            if ($blog) {
                $data = $request->all();
                if ($request->hasFile('image')) {

                    $image = $request->file('image');
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $path = public_path('assets/admin/blog/');
                    $image->move($path, $image_name);

                    $data['image_path'] = '/assets/admin/blog/' . $image_name;
                }
                $blog->update($data);
                $obj = ["Status" => true, "success" => 1, "msg" => "Blog Successfully Updated"];
            } else {
                $obj = ["Status" => false, "success" => 0, "msg" => "Blog does not Exist"];
            }

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function allBlogs(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {

            $allBlogs = Blog::where('is_approved', 1)->with('user')->with('category')->orderBy('id', 'desc')->get();
            $obj = ["Status" => true, "success" => 1, "data" => ['allBlogs' => $allBlogs], "msg" => "Successfully fetched All Blogs blogs"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function blogDetailWithSlug(Request $request)
    {
        $slug = $request->slug;
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {

            $blog = Blog::where('slug', $slug)->with('user')->first();
            $obj = ["Status" => true, "success" => 1, "data" => ["blog" => $blog], "msg" => "Successfully fetched  blog"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function allFeaturedPosts(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {

            $featuredBlogs = Blog::where('featured', 1)->where('is_approved', 1)->with('user')->orderBy('id', 'desc')->with('category')->get();
            $obj = ["Status" => true, "success" => 1, "data" => ['featuredBlogs' => $featuredBlogs], "msg" => "Successfully fetched All featured blogs"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
}

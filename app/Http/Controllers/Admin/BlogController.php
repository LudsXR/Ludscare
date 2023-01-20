<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Str;

class BlogController extends Controller
{
    public function showBlogList()
    {
        $blogs = Blog::orderBy('id','desc')->get();
        return view('new_admin.blog.list',compact('blogs'));
    }
    public function addBlog()
    {
        $categories=BlogCategory::all();
        return view('new_admin.blog.add',compact('categories'));
    }
    public function saveBlog(Request $request)
    {
        $rules = [
    		'title' => 'required',
            'category_id'=>'required'
    	];

    	$request->validate($rules);


        $data = $request->all();

        $slug = Str::slug($request->title);
        $data['slug']= $slug;

        if($request->hasFile('image')){

            $image = $request->file('image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $path = public_path('assets/admin/blog/');
            $image->move($path,$image_name);

            $data['image_path'] = '/assets/admin/blog/'.$image_name;

        }
        $data['user_id']= 1;
        if($created = Blog::create($data)){

			$notify[] = ['success', 'Blog has been added'];
        	return redirect()->route('admin.blog.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
    public function blogDetail($id)
    {
       $detail = Blog::find($id);
       $categories=BlogCategory::all();
       return view('new_admin.blog.edit',compact('detail','categories'));
    }

    public function blogUpdate(Request $request){

    	$data = $request->all();

    	if($request->hasFile('image')){

			$image = $request->file('image');
			$image_name = time().'_'.$image->getClientOriginalName();
			$path = public_path('assets/admin/blog/');
			$image->move($path,$image_name);

			$data['image_path'] = '/assets/admin/blog/'.$image_name;

		}

		$blog = Blog::find($request->id);
		if($blog->update($data)){
			$notify[] = ['success', 'Blog has been updated'];
        	return redirect()->route('admin.blog.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }


    public function blogDelete($id){
    	$blog = Blog::find($id);
    	if($blog->delete()){

			$notify[] = ['success', 'Blog has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}

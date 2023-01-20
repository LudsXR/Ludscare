<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorCategory;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Storage;
class MentorCategoryController extends Controller
{
    public function showMentorCategoryList()
    {
        $mentor_categories = MentorCategory::all();
        return view('new_admin.mentor_category.list',compact('mentor_categories'));
    }
    public function addMentorCategory()
    {
        $parent_category = MentorCategory::where('parent_id',0)->get();
        return view('new_admin.mentor_category.add',compact('parent_category'));
    }
    public function saveMentorCategory(Request $request)
    {
        $rules = [
    		'name' => 'required|unique:mentor_category,name',
    	];

    	$request->validate($rules);


        $data = $request->all();
        $slug = Str::slug($request->name);
        $data['slug']= $slug;
        if($request->hasFile('image')){

            $image = $request->file('image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $path = public_path('assets/admin/mentorCategories/');
            $image->move($path,$image_name);
            // $path = Storage::disk('s3');
            // dd($path);

            // $path = Storage::disk('s3')->put('mentorCategories',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);

            $data['image_path'] = '/assets/admin/mentorCategories/'.$image_name;
            // $data['image_path'] = $path;


        }

        if($created = MentorCategory::create($data)){

			$notify[] = ['success', 'Mentor Category has been added'];
        	return redirect()->route('admin.mentor.category.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }
    public function mentorCategoryDetail($id)
    {
       $detail = MentorCategory::find($id);
       $parent_category = MentorCategory::where('parent_id',0)->get();
       return view('new_admin.mentor_category.edit',compact('detail','parent_category'));
    }

    public function mentorCategoryUpdate(Request $request){

    	$data = $request->all();
        $category = MentorCategory::find($request->id);
    	if($request->hasFile('image')){


			$image = $request->file('image');

            // $ar=explode('/',$category->image_path);
            // if(isset($ar[3]) &&  isset($ar[4])){
            //     $folder=$ar[3];
            //     $imageName=$ar[4];
            //     Storage::disk('s3')->delete($folder.'/'.$imageName);
            // }
			$image_name = time().'_'.$image->getClientOriginalName();
			$path = public_path('assets/admin/mentorCategories/');
			$image->move($path,$image_name);

			$data['image_path'] = '/assets/admin/mentorCategories/'.$image_name;
            // $path = Storage::disk('s3')->put('mentorCategories',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);
            // $data['image_path'] = $path;
		}


		if($category->update($data)){
			$notify[] = ['success', 'Mentor Category has been updated'];
        	return redirect()->route('admin.mentor.category.list')->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}

    }

    public function deleteSubMentorCategory($sub_cat)
    {
        foreach($sub_cat->subCategories as $sub_cat1)
        {
            $this->deleteSubMentorCategory($sub_cat1);
        }
        if($sub_cat->image_path){
            $ar=explode('/',$sub_cat->image_path);
            if(isset($ar[3]) &&  isset($ar[4])){
                $folder=$ar[3];
                $imageName=$ar[4];
                Storage::disk('s3')->delete($folder.'/'.$imageName);
            }
            // Storage::disk('s3')->delete($sub_cat->image_path);
        }
        $sub_cat->delete();
    }

    public function mentorCategoryDelete($id){

    	$category = MentorCategory::find($id);
        foreach($category->subCategories as $sub_cat)
        {
            $this->deleteSubMentorCategory($sub_cat);
        }
        // if($category->image_path){
        //     $ar=explode('/',$category->image_path);
        //     if(isset($ar[3]) &&  isset($ar[4])){
        //         $folder=$ar[3];
        //         $imageName=$ar[4];
        //         Storage::disk('s3')->delete($folder.'/'.$imageName);
        //     }
        //     // Storage::disk('s3')->delete($category->image_path);
        // }
    	if($category->delete()){

			$notify[] = ['success', 'Category has been deleted'];
        	return back()->withNotify($notify);
		}else{
			$notify[] = ['error', 'Something problem in internal system'];
        	return back()->withNotify($notify);
		}
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Mentor;
use App\Models\MentorBank;
use App\Models\MentorCategory;
use App\Models\MentorEducation;
use App\Models\MentorExperience;
use App\Models\MentorCardDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorAssignCategory;
use App\Models\MentorOccupation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function showPendingMentorList()
    {
        $pending_mentors = Mentor::where('status', 0)->orderBy('id', 'DESC')->get();
        foreach ($pending_mentors as $pending_mentor) {
            $assigned_category = MentorAssignCategory::where('mentor_id', $pending_mentor->user_id)->orderBy('id', 'DESC')->first();
            if (!is_null($assigned_category)) {
                $category = MentorCategory::where('id', $assigned_category->category_id)->first();
                $pending_mentor['category'] = $category;
            }
        }
        return view('new_admin.mentor.pending_list', compact('pending_mentors'));
    }
    public function showAcceptedMentorList()
    {
        $approved_mentors = Mentor::where('status', 1)->orderBy('id', 'DESC')->get();


        foreach ($approved_mentors as $approved_mentor) {
            $assigned_category = MentorAssignCategory::where('mentor_id', $approved_mentor->user_id)->orderBy('id', 'DESC')->first();
            if (!is_null($assigned_category)) {
                $category = MentorCategory::where('id', $assigned_category->category_id)->first();
                $approved_mentor['category'] = $category;
            }
        }
        return view('new_admin.mentor.approved_list', compact('approved_mentors'));
    }
    public function showRejectedMentorList()
    {
        $rejected_mentors = Mentor::where('status', 2)->orderBy('id', 'DESC')->get();

        foreach ($rejected_mentors as $rejected_mentor) {
            $assigned_category = MentorAssignCategory::where('mentor_id', $rejected_mentor->user_id)->orderBy('id', 'DESC')->first();
            if (!is_null($assigned_category)) {
                $category = MentorCategory::where('id', $assigned_category->category_id)->first();
                $rejected_mentor['category'] = $category;
            }
        }
        return view('new_admin.mentor.rejected_list', compact('rejected_mentors'));
    }
    public function addMentor()
    {
        $countries = Country::all();
        // dd($countries);
        $mentor_parent_categories = MentorCategory::where('parent_id', 0)->get();
        // dd($mentor_parent_categories);
        // $child_categories = MentorCategory::where('parent_id',$detail->parent_category_id)->get();
        $banks = MentorBank::all();
        // dd($banks);
        $occupations = MentorOccupation::all();
        return view('new_admin.mentor.add', compact('countries', 'mentor_parent_categories', 'banks', 'occupations'));
    }
    public function saveMentor(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required| regex:/(.+)@(.+)\.(.+)/i | unique:' . 'users',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }

        $data = $request->all();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/mentor/');
            $image->move($path, $image_name);

            $data['image_path'] = 'assets/admin/mentor/' . $image_name;
            // $path = Storage::disk('s3')->put('mentors',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);
            // $data['image_path'] = $path;

        }

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($created = User::create($data)) {
            $mentor_data = [
                // 'parent_category_id' => $request->parent_category_id,
                // 'mentor_category_id' => $request->mentor_category_id,
                'status' => 0,
                'is_profile_completed' => 0,
                // 'user_id' => $created->user_id
            ];
            $mentor = $created->mentor()->create($mentor_data);
            // if(isset($request->categories)&&!empty($request->categories) ){
            //     foreach($request->categories as $category){
            //         if(!empty($category)){
            //             MentorAssignCategory::create(['mentor_id'=>$created->id,'category_id'=>$category]);
            //         }

            //     }

            // }

            // if(
            //     (isset($request->account_title)&&!empty($request->account_title))&&
            //     (isset($request->account_number)&&!empty($request->account_number))&&
            //     (isset($request->bank)&&!empty($request->bank))
            // ){
            //     $bank_details = [
            //         'account_title' => $request->account_title,
            //         'account_number' => $request->account_number,
            //         'bank' => $request->bank,
            //         'mentor_id' => $mentor->user_id
            //     ];
            //     $mentor->bank()->create($bank_details);
            // }




            // Mentor::create($mentor_data);
            $notify = ["msg" => 'Mentor has been added', 'mentor_id' => $created->id];
            return response()->json($notify);
            // return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify = ["msg" => 'Something problem in internal system'];
            return response()->json($notify);
            // $notify[] = ['error', 'Something problem in internal system'];
            // return back()->withNotify($notify);
        }
    }
    public function saveBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_title' => 'required',
            'account_number' => 'required',
            'bank' => 'required',
            'mentor_id' => 'required'


        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $bank_details = [
            'account_title' => $request->account_title,
            'account_number' => $request->account_number,
            'bank' => $request->bank,
            'mentor_id' => $request->mentor_id
        ];
        MentorCardDetail::create($bank_details);
        $notify = ["msg" => 'Mentor Bank Detail has been added'];
        return response()->json($notify);
    }
    public function saveSkills(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'categories' => 'required',
            'mentor_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        // print_r($request->categories);
        // var_dump($request->categories);
        // die(1);

        if (isset($request->categories) && !empty($request->categories)) {
            MentorAssignCategory::where('mentor_id', $request->mentor_id)->delete();
            $categories = explode(',', $request->categories);
            for ($i = 0; $i < count($categories); $i++) {
                if (!empty($categories[$i])) {
                    MentorAssignCategory::create(['mentor_id' => $request->mentor_id, 'category_id' => $categories[$i]]);
                }
            }
        }
        $notify = ["msg" => 'Mentor skill has been added'];
        return response()->json($notify);
    }
    public function mentorDetail($id)
    {
        $detail = Mentor::where('user_id', $id)->with('education', 'bank')->first();
        $countries = Country::all();
        $assignedCategories = MentorAssignCategory::where('mentor_id', $id)->orderBy('id', 'DESC')->pluck('category_id')->all();
        $occupations = MentorOccupation::all();
        // dd($assignedCategories);
        $mentor_parent_categories = MentorCategory::where('parent_id', 0)->get(); // all parent categories of system
        $child_categories = [];
        $child_sub_categories = [];
        if (count($assignedCategories) == 3) {
            $child_categories = MentorCategory::where('parent_id', $assignedCategories[2])->get(); // all parent categories of system
            $child_sub_categories = MentorCategory::where('parent_id', $assignedCategories[1])->get(); // all parent categories of system

        } else if (count($assignedCategories) == 2) {
            $child_categories = MentorCategory::where('parent_id', $assignedCategories[1])->get();
        }

        // dd($detail->user->password);
        $banks = MentorBank::all();
        return view('new_admin.mentor.edit', compact('detail', 'countries', 'child_categories', 'mentor_parent_categories', 'banks', 'child_sub_categories', 'assignedCategories', 'occupations'));
    }
    //make featured to Mentor
    public function mentorFeatureUpdate(Request $request)
    {
        $data = $request->all();
        $mentor = Mentor::where('user_id', $request->id)->first();
        if ($mentor->update(['is_featured' => $request->is_featured])) {
            $notify[] = ['success', 'Mentor has been Featured'];
            return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }
    public function mentorUpdate(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $user = User::where('id', $request->id)->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // $ar=explode('/',$user->image_path);
            // if(isset($ar[3]) &&  isset($ar[4])){
            //     $folder=$ar[3];
            //     $imageName=$ar[4];
            //     Storage::disk('s3')->delete($folder.'/'.$imageName);
            // }
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/mentor/');
            $image->move($path, $image_name);
            $data['image_path'] = 'assets/admin/mentor/' . $image_name;
            // $path = Storage::disk('s3')->put('mentors',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);
            // $data['image_path'] = $path;
        }
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($user->update($data)) {
            $notify[] = ['success', 'Mentor has been updated'];
            return redirect()->back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }

    //delete Mentors
    public function mentorDelete($id)
    {
        $mentor = Mentor::find($id);
        if ($mentor->user->image_path) {
            $ar = explode('/', $mentor->user->image_path);
            if (isset($ar[3]) &&  isset($ar[4])) {
                $folder = $ar[3];
                $imageName = $ar[4];
                Storage::disk('s3')->delete($folder . '/' . $imageName);
            }
        }

        $mentor->user()->delete();
        if ($mentor->delete()) {

            $notify[] = ['success', 'Mentor has been deleted'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }


    public function mentorStatusUpdate($status, $id)
    {
        $mentor = Mentor::find($id);
        if ($mentor->update(['status' => $status])) {
            $notify[] = ['success', 'Mentor Status has been updated'];
            return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }

    public function mentorEducationUpdate(Request $request)
    {
        $index = 0;
        foreach ($request->id as $id) {
            $education = MentorEducation::find($id);
            $education->institute = $request->institute[$index];
            $education->degree = $request->degree[$index];
            $education->subject = $request->subject[$index];
            $education->period = $request->period[$index];
            if (isset($request->image[$index])) {
                // $ar=explode('/',$education->image_path);
                // if(isset($ar[3]) &&  isset($ar[4])){
                //     $folder=$ar[3];
                //     $imageName=$ar[4];
                //     Storage::disk('s3')->delete($folder.'/'.$imageName);
                // }
                $image = $request->file('image')[$index];
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('assets/admin/mentorEducation/');
                $image->move($path, $image_name);
                $education->image_path = 'assets/admin/mentor/' . $image_name;
                // $path = Storage::disk('s3')->put('mentorEducation',$image,'public-read');
                // $path = Storage::disk('s3')->url($path);
                // $education->image_path = $path;
            }

            $education->save();
            $index++;
        }
        $notify[] = ['success', 'Mentor Education has been updated'];
        return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
    }

    public function mentorExperienceUpdate(Request $request)
    {
        $index = 0;
        foreach ($request->id as $id) {
            $education = MentorExperience::find($id);
            $education->company = $request->company[$index];
            $education->from = $request->from[$index];
            $education->to = $request->to[$index];
            if (isset($request->image[$index])) {
                $ar = explode('/', $education->image_path);
                if (isset($ar[3]) &&  isset($ar[4])) {
                    $folder = $ar[3];
                    $imageName = $ar[4];
                    Storage::disk('s3')->delete($folder . '/' . $imageName);
                }

                $image = $request->file('image')[$index];
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('assets/admin/mentor/');
                $image->move($path, $image_name);
                $education->image_path = 'assets/admin/mentorEducation/' . $image_name;
                // $path = Storage::disk('s3')->put('mentorEducation',$image,'public-read');
                // $path = Storage::disk('s3')->url($path);
                // $education->image_path = $path;


            }

            $education->save();
            $index++;
        }
        $notify[] = ['success', 'Mentor Experience has been updated'];
        return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
    }

    public function mentorSkillUpdate(Request $request)
    {

        $mentor = Mentor::find($request->id);
        if ($mentor) {
            MentorAssignCategory::where('mentor_id', $mentor->user_id)->delete();
            $categories = $request->categories;
            foreach ($categories as $category) {
                $category = intval($category);
                if (!empty($category) && is_int($category)) {
                    MentorAssignCategory::create([
                        'mentor_id' => $mentor->user_id,
                        'category_id' => $category
                    ]);
                }
            }




            $notify[] = ['success', 'Mentor Category has been updated'];
            return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }

    public function mentorBankDetailUpdate(Request $request)
    {

        $skill = $request->all();

        $bank = MentorCardDetail::where('mentor_id', $request->id)->first();
        if (is_null($bank)) {
            $mentor = new MentorCardDetail();
            $mentor->mentor_id = $request->id;
            $mentor->account_number = $request->account_number;
            $mentor->account_title = $request->account_title;
            $mentor->bank = $request->bank;
            $mentor->save();
            $notify[] = ['success', 'Mentor Bank Details has been Saved'];
            return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else if ($bank->update($skill)) {

            $notify[] = ['success', 'Mentor Bank Details has been updated'];
            return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Something problem in internal system'];
            return back()->withNotify($notify);
        }
    }
    public function mentorShowAddEducation()
    {
        $mentors = Mentor::with('user')->get();
        return view('new_admin.mentor.add_education', compact('mentors'));
    }
    public function saveEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'degree' => 'required',
            'mentor_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $data = $request->all();
        if ($request->has('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/mentorEducation/');
            $image->move($path, $image_name);
            $data['image_path'] = 'assets/admin/mentorEducation/' . $image_name;
            // $path = Storage::disk('s3')->put('mentorEducation',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);
            // $data['image_path'] = $path;
        }
        $created = MentorEducation::create($data);
        if ($created) {
            $notify = ["msg" => 'Mentor Education has been added'];
            return response()->json($notify);
            // return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify = ["msg" => 'Something problem in internal system'];
            return response()->json($notify);
            // $notify[] = ['error', 'Something problem in internal system'];
            // return back()->withNotify($notify);
        }
    }
    public function saveExperience(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'company' => 'required',
                'mentor_id' => 'required',
                'from'  => 'required|date',
                'to'    => 'required|date|after:from',
            ],
            [
                'to.after' => 'The Date to field must be a greater sto From Date.',
            ]
        );
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $data = $request->all();
        if ($request->has('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = public_path('assets/admin/mentorExperience/');
            $image->move($path, $image_name);
            $data['image_path'] = 'assets/admin/mentorExperience/' . $image_name;
            // $path = Storage::disk('s3')->put('mentorEducation',$image,'public-read');
            // $path = Storage::disk('s3')->url($path);
            // $data['image_path'] = $path;
        }
        $created = MentorExperience::create($data);
        if ($created) {
            $notify = ["msg" => 'Mentor Experience has been added'];
            return response()->json($notify);
            // return redirect()->route('admin.mentor.pending.list')->withNotify($notify);
        } else {
            $notify = ["msg" => 'Something problem in internal system'];
            return response()->json($notify);
            // $notify[] = ['error', 'Something problem in internal system'];
            // return back()->withNotify($notify);
        }
    }
    public function mentorAddEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            // 'institute' => 'required|string',
            'degree' => 'required|string',
            // 'subject'=>'required|string',
            // 'period'=>'required|string',
            // 'image'=>'required',

        ]);
        if ($validator->fails()) {


            $notify[] = ['error', 'Validation Failed'];
            return back()->withNotify($notify);
        } else {
            $data = $request->all();

            if ($request->has('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('assets/admin/mentorEducation/');
                $image->move($path, $image_name);
                $data['image_path'] = 'assets/admin/mentorEducation/' . $image_name;
                // $path = Storage::disk('s3')->put('mentorEducation',$image,'public-read');
                // $path = Storage::disk('s3')->url($path);
                // $data['image_path'] = $path;
            }
            $created = MentorEducation::create($data);
            if ($created) {
                $notify[] = ['success', 'Mentor Eduaction Details has been added'];
                return redirect()->route('admin.mentor.add.education')->withNotify($notify);
            } else {
                $notify[] = ['error', 'Something problem in internal system'];
                return back()->withNotify($notify);
            }
        }
    }
    public function mentorShowAddExperience()
    {
        $mentors = Mentor::with('user')->get();
        return view('new_admin.mentor.add_experience', compact('mentors'));
    }
    public function mentorAddExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'company' => 'required|string',
            // 'from'=>'required|date',
            // 'to'=>'required|date',
            // 'image'=>'required',

        ]);
        if ($validator->fails()) {

            $notify[] = ['error', 'Validation Failed'];
            return back()->withNotify($notify);
        } else {
            $data = $request->all();
            if ($request->has('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('assets/admin/mentorExperience/');
                $image->move($path, $image_name);
                $data['image_path'] = 'assets/admin/mentorExperience/' . $image_name;
                // $path = Storage::disk('s3')->put('mentorExperience',$image,'public-read');
                // $path = Storage::disk('s3')->url($path);
                // $data['image_path'] = $path;
            }

            $created = MentorExperience::create($data);
            if ($created) {
                $notify[] = ['success', 'Mentor Experience Details has been added'];
                return redirect()->route('admin.mentor.add.experience')->withNotify($notify);
            } else {
                $notify[] = ['error', 'Something problem in internal system'];
                return back()->withNotify($notify);
            }
        }
    }
}

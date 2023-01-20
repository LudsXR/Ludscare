<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorEducation;
use Illuminate\Support\Facades\Storage;
class MentorEducationController extends Controller
{
    //Save Mentor Education
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'institute' => 'required|string',
            'degree' => 'required|string',
            'subject' => 'required|string',
            'period' => 'required|string',
            'image'=>'required|mimes:png,jpg,jpeg,pdf,doc,docx',
            'mentor_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $institute=$request->institute;
            $degree=$request->degree;
            $subject=$request->subject;
            $period=$request->period;
            $mentor_id=$request->mentor_id;

            $file_name='';
            if($request->hasFile('image')){

                $image = $request->file('image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $path = public_path('assets/mentorEducation/');
                $image->move($path,$image_name);

                $file_name = 'assets/mentorEducation/'.$image_name;

            }
            $education=MentorEducation::create(
                [
                    'mentor_id'=>$mentor_id,
                    'institute'=>$institute,
                    'degree'=>$degree,
                    'subject'=>$subject,
                    'period'=>date("Y", strtotime($period)),
                    'image_path'=>!empty($file_name) ? $file_name : ''
                ]
            );
            $obj=["Status"=>true,"success"=>1,"data"=>["education"=>$education],"msg"=>"Mentor Education Added Successfully"];

            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //update Mentor Education
    public function update(Request $request){
        $token="123";
        $validator = Validator::make($request->all(), [
            'institute' => 'required|string',
            'degree' => 'required',
            'subject' => 'required|string',
            'period' => 'required|string',
            'image'=>'required|mimes:png,jpg,jpeg,pdf,doc,docx',
            'mentor_id'=>'required',
            'id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        if ($request->token==$token){
            $institute=$request->institute;
            $degree=$request->degree;
            $subject=$request->subject;

            $period=$request->period;
            $mentor_id=$request->mentor_id;
            $id=$request->id;
            $file_name='';
            if($request->hasFile('image')){

                $image = $request->file('image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $path = public_path('assets/mentorEducation/');
                $image->move($path,$image_name);

                $file_name = 'assets/mentorEducation/'.$image_name;

            }
            $education=MentorEducation::where('id',$id)->update([
                    'mentor_id'=>$mentor_id,
                    'institute'=>$institute,
                    'degree'=>$degree,
                    'subject'=>$subject,
                    'period'=>date("Y", strtotime($period)),
                    'image_path'=>!empty($file_name) ? $file_name : ''
            ]);
            $obj=["Status"=>true,"success"=>1,"data"=>["education"=>$education],"msg"=>"Mentor Education Updated Successfully"];

            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //list Mentor Education
    public function list(Request $request){
        $token="123";
        if ($request->token==$token){
            $experiences=MentorEducation::where('mentor_id',$request->mentor_id)->get();
            $obj=["Status"=>true,"success"=>1,"data"=>["educations"=>$experiences],"msg"=>"Mentor Education fetched Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //Delete Mentor Education
    public function destroy(Request $request){
        $token="123";
        if ($request->token==$token){
            $education=MentorEducation::find($request->id);
            $experiences=MentorEducation::destroy($request->id);
            $obj=["Status"=>true,"success"=>1,"data"=>["educations"=>$experiences],"msg"=>"Mentor Education Deleted Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}

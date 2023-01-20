<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorExperience;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class MentorExperienceController extends Controller
{
    //Save Mentor Experience
    public function save(Request $request){
        //return response()->json($request->file());
        $validator = Validator::make($request->all(), [
            'company' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'image'=>'required|mimes:png,jpg,jpeg,pdf,doc,docx',
            'mentor_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $company=$request->company;
            $from=$request->from;
            $to=$request->to;
            $mentor_id=$request->mentor_id;
            $file_name='';
            if($request->hasFile('image')){

                $image = $request->file('image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $path = public_path('assets/mentorExperience/');
                $image->move($path,$image_name);

                $file_name = 'assets/mentorExperience/'.$image_name;


            }
            $education=MentorExperience::create(
                [
                    'mentor_id'=>$mentor_id,
                    'company'=>$company,

                    'from'=>date("Y-m-d", strtotime($from)),
                    'to'=>date("Y-m-d", strtotime($to)),
                    'image_path'=>!empty($file_name) ? $file_name : ''
                ]
            );

            $obj=["Status"=>true,"success"=>1,"data"=>["experience"=>$education],"msg"=>"Mentor Experience Added Successfully"];

            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //update Mentor Experience
    public function update(Request $request){
        //return response()->json($request->file());
        $validator = Validator::make($request->all(), [
            'company' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'image'=>'required|mimes:png,jpg,jpeg,pdf,doc,docx',
            'mentor_id'=>'required',
            'id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $company=$request->company;
            $from=$request->from;
            $to=$request->to;
            $mentor_id=$request->mentor_id;
            $id=$request->id;

            $file_name='';
            if($request->hasFile('image')){

                $image = $request->file('image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $path = public_path('assets/mentorExperience/');
                $image->move($path,$image_name);

                $file_name = 'assets/mentorExperience/'.$image_name;

            }
            $education=MentorExperience::where('id',$id)->update(
                [
                    'mentor_id'=>$mentor_id,
                    'company'=>$company,
                    'from'=>$from,
                    'to'=>$to,
                    'image_path'=>!empty($file_name) ? $file_name : ''
                ]
            );
            $obj=["Status"=>true,"success"=>1,"data"=>["experience"=>$education],"msg"=>"Mentor Experience Updated Successfully"];

            return response()->json($obj);

        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //List Mentor Experience
    public function list(Request $request){
        $validator = Validator::make($request->all(), [

            'mentor_id'=>'required'
        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $experiences=MentorExperience::where('mentor_id',$request->mentor_id)->get();
            $obj=["Status"=>true,"success"=>1,"data"=>["experiences"=>$experiences],"msg"=>"Mentor Experience fetched Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    //Delete Mentor Experience
    public function destroy(Request $request){
        $token="123";
        if ($request->token==$token){
            $experiences=MentorExperience::find($request->id);
            if($experiences->image_path){
                $ar=explode('/',$experiences->image_path);
                if(isset($ar[3]) &&  isset($ar[4])){
                    $folder=$ar[3];
                    $imageName=$ar[4];
                    Storage::disk('s3')->delete($folder.'/'.$imageName);
                }
            }
            $experiences=MentorExperience::destroy($request->id);
            $obj=["Status"=>true,"success"=>1,"data"=>["experiences"=>$experiences],"msg"=>"Mentor Experience Deleted Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
}

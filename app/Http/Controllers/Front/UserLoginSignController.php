<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Mentor;
use App\Models\Mentee;
use Illuminate\Support\Facades\Validator;
use App\AgoraToken\Src\RtcTokenBuilder;
use App\Models\MentorSchedule;
use App\Models\Rating;
use App\Events\UserOnline;
use App\Models\BookAppointment;
use App\Models\MentorAssignCategory;
use Mail;
use Illuminate\Support\Str;;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hash;

class UserLoginSignController extends Controller
{
    //Combine Login Sign up

    public function loginSignup(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $request->validate([
                'phone' => 'required|string',
            ]);

            $phone = $request->phone;
            $role = $request->role;
            $user = User::where('phone', '=', $phone)->get();




            //user Exist then Login
            if (count($user) > 0) {

                $tokenResult = $user[0]->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                //update user status and broadcast event to pusher
                $status_user = User::where('id', $user[0]->id)->first();
                if ($status_user->update(["online_status" => "online"])) {
                    broadcast(new UserOnline($status_user));
                    // \Artisan::call('queue:listen');
                }


                if ($role == "Mentor") {

                    $mentor = Mentor::where('user_id', $user[0]->id)->get();
                    if (count($mentor) > 0) {
                        $obj = ["Status" => true, "success" => 1, "data" =>
                        [
                            'AccessToken' => $tokenResult->accessToken,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString(),


                            'role' => $role, "is_login" => 1, "userDetail" => $user, 'is_profile_complete' => $mentor[0]->is_profile_completed
                        ], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $status_user, 'role' => $role]);
                        return response()->json($obj);
                    } else {
                        $mentor = Mentor::create(['user_id' => $user[0]->id, 'status' => 0]);
                        $obj = ["Status" => true, "success" => 1, "data" => [
                            'AccessToken' => $tokenResult->accessToken,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString(),
                            'role' => $role,
                            "is_login" => 1, "userDetail" => $user, 'is_profile_complete' => 0
                        ], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $status_user, 'role' => $role]);
                        return response()->json($obj);
                    }
                } else {
                    $mentee = Mentee::where('user_id', $user[0]->id)->first();
                    if ($mentee) {
                        $obj = ["Status" => true, "success" => 1, "data" => [
                            'AccessToken' => $tokenResult->accessToken,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString(),
                            'role' => $role, "is_login" => 1, "userDetail" => $user
                        ], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $status_user, 'role' => $role]);
                        return response()->json($obj);
                    } else {
                        $mentee = Mentee::create(['user_id' => $user[0]->id]);
                        $obj = ["Status" => true, "success" => 1, "data" => [
                            'AccessToken' => $tokenResult->accessToken,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString(),
                            'role' => $role, "is_login" => 1, "userDetail" => $user
                        ], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $status_user, 'role' => $role]);
                        return response()->json($obj);
                    }
                }
            }
            //User Doesn't Exist Sign up then Login
            else if (count($user) == 0) {
                $newUser = new User();
                $newUser->phone = $phone;

                $newUser->save();

                $tokenResult = $newUser->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $status_user = User::where('id', $newUser->id)->first();
                if ($status_user->update(["online_status" => "online"])) {
                    broadcast(new UserOnline($status_user));
                    // \Artisan::call('queue:listen');
                }
                $usersign = User::where('id', $newUser->id)->get();
                $user_role = Role::where('name', '=', $role)->get();
                RoleUser::create(['role_id' => $user_role[0]->id, 'user_id' => $newUser->id]);
                if ($role == 'Mentor') {

                    $mentor = Mentor::create(['user_id' => $newUser->id, 'status' => 0]);

                    $obj = ["Status" => true, "success" => 1, "data" => [
                        'AccessToken' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString(),
                        'role' => $role, "is_login" => 0, "userDetail" => $usersign, 'is_profile_complete' => 0
                    ], "msg" => "User Sign Up and Login Successfully"];
                    session(['userDetail' => $status_user, 'role' => $role]);
                    return response()->json($obj);
                } else {

                    Mentee::create(['user_id' => $newUser->id]);
                    $obj = ["Status" => true, "success" => 1, "data" => [
                        'AccessToken' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString(),
                        'role' => $role, "is_login" => 0, "userDetail" => $usersign
                    ], "msg" => "User Sign Up and Login Successfully"];
                    session(['userDetail' => $status_user, 'role' => $role]);
                    return response()->json($obj);
                }
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }

    //logout and set status offline
    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $user = User::find($request->user_id);
            $user->online_status = 'offline';
            $user->save();
            session()->forget('userDetail');
            session()->forget('role');

            $obj = ["Status" => true, "success" => 1, "msg" => "Successfully Logout"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Login Api Function

    public function login(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $request->validate([
                'phone' => 'required|string',
            ]);

            $phone = $request->phone;
            $role = $request->role;
            $role_user = Role::where('name', $role)->get();
            $user = User::where('phone', '=', $phone)->get();

            if (count($user) == 0) {
                $obj = ["Status" => false, "success" => 0, "msg" => "No User Exist on This Phone Number"];

                return response()->json($obj);
            }

            if (count($user) > 0) {
                if ($role == "Mentor") {

                    $mentor = Mentor::where('user_id', $user[0]->id)->get();
                    if (count($mentor) > 0) {
                        $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => is_null($mentor[0]->is_profile_complete) ? 0 : 1, "userDetail" => $user], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $user, 'role' => $role]);
                        return response()->json($obj);
                    } else {
                        $mentor = Mentor::create(['user_id' => $user[0]->id, 'status' => 0]);
                        $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => is_null($mentor->is_profile_complete) ? 0 : 1, "userDetail" => $user], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $user, 'role' => $role]);
                        return response()->json($obj);
                    }
                } else {
                    $mentee = Mentee::where('user_id', $user[0]->id)->first();
                    if ($mentee) {
                        $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => 1, "userDetail" => $user], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $user, 'role' => $role]);
                        return response()->json($obj);
                    } else {
                        $mentee = Mentee::create(['user_id' => $user[0]->id]);
                        $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => 1, "userDetail" => $user], "msg" => "Logged in Successfully"];
                        session(['userDetail' => $user, 'role' => $role]);
                        return response()->json($obj);
                    }
                }
            }

            $obj = ["Status" => false, "success" => 0, "msg" => "Please Sign up"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }





    // Sign up Api Function

    public function signup(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $request->validate([
                'phone' => 'required|string',
            ]);
            $phone = $request->phone;
            $role = $request->role;



            $user = User::where('phone', '=', $phone)->get();
            if (count($user) > 0) {
                $obj = ["Status" => false, "success" => 0, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "userDetail" => $user], "msg" => "User Phone Already exist In Database Please Login !"];
                // $obj=json_encode($obj);
                return response()->json($obj);
            }
            $newUser = new User();
            $newUser->phone = $phone;

            $newUser->save();

            $usersign = User::where('id', $newUser->id)->get();
            $user_role = Role::where('name', '=', $role)->get();
            RoleUser::create(['role_id' => $user_role[0]->id, 'user_id' => $newUser->id]);
            if ($role == 'Mentor') {

                $mentor = Mentor::create(['user_id' => $newUser->id, 'status' => 0]);
                //$mentor=Mentor::where('user_id',$newUser->id)->get();
                $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => is_null($mentor->is_profile_complete) ? 0 : 1, "userDetail" => $usersign], "msg" => "User Sign Up Successfully"];
                //$obj=json_encode($obj);
                return response()->json($obj);
            } else {

                Mentee::create(['user_id' => $newUser->id]);
                $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", 'role' => $role, "is_profile_complete" => 1, "userDetail" => $usersign], "msg" => "User Sign Up Successfully"];
                //$obj=json_encode($obj);
                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Update User Profile
    public function updateProfile(Request $request)
    {

        //return response()->json($data);
        $token = "123";
        if ($request->token == $token) {
            $id = $request->mentor_id;
            $user = User::find($id);
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'mentor_id' => 'required',
                    'father_name' => 'required|string',
                    'cnic' => 'required',
                    'address' => 'required|string',
                    'gender' => 'required|string',
                    'religion' => 'required|string',
                    'dob' => 'required',
                    'occupation' => 'required',
                    'country' => 'required',
                    'city' => 'required|string',
                    'about' => 'required|string',

                ]
            );
            if ($validator->fails()) {

                $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
                return response()->json($obj);
            }
            $image = $request->file('picture');

            //upload user picture
            if ($request->hasFile('picture') && $image->isValid()) {
                $image = $request->file('picture');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $path = public_path('assets/mentorProfile/');
                $image->move($path, $image_name);
                $data['image_path'] = '/assets/mentorProfile/' . $image_name;
            }

            //received params

            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $father_name = $request->father_name;
            $cnic = $request->cnic;
            $address = $request->address;
            $gender = $request->gender;
            $religion = $request->religion;
            $dob = date('Y-m-d', strtotime($request->dob));
            $occupation = $request->occupation;
            $country = $request->country;
            $city = $request->city;
            $email = $request->email;
            $about = $request->about;

            //Updating Records

            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->father_name = $father_name;
            $user->cnic = $cnic;
            $user->address = $address;
            $user->gender = $gender;
            $user->religion = $religion;
            $user->dob = date('Y-m-d', strtotime($dob));
            $user->occupation = $occupation;
            $user->country = $country;
            $user->city = $city;
            $user->about = $about;
            if ($email) {
                $user->email = $email;
            }


            if ($request->hasFile('picture')) {
                $user->image_path = $data['image_path'];
            }
            $user->save();
            $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", "userDetail" => $user], "msg" => "User Profile Updated Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    //Get User by ID
    public function getUserByID(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $id = $request->user_id;
            $mentor = Mentor::where('user_id', $id)->get();
            $user = '';
            if (count($mentor) > 0) {
                $rating = Rating::where('mentor_id', $id)->avg('rating');
                $ratings = Rating::with('mentee')->where('mentor_id', $id)->get();
                $user = User::select(['id', 'first_name', 'last_name', 'email', 'image_path', 'created_at', 'country', 'father_name', 'cnic', 'gender', 'dob', 'city', 'address', 'occupation', 'religion', 'online_status', 'phone', 'about'])->with(['mentor', 'user_country', 'educations', 'experiences', 'card_detail'])->where('id', $id)->first();
                $user['ratingsAvg'] = round($rating);
                $user['ratings'] = $ratings;

                $user['register_date'] = date('d-M-Y', strtotime($user->created_at));
                $mentor_categories = MentorAssignCategory::with('category')->where('mentor_id', $id)->orderBy('id', 'DESC')->get();
                $user->mentor['categories'] = $mentor_categories;

                //schedule types available

                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', DB::raw('min(fee) as fee'))->where('mentor_id', $id)->with('appointment_type')->groupBy('appointment_type_id')->get();
                $user['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where('mentor_id', $id)->whereIn('appointment_type_id', [3, 6])->with('appointment_type')->get();
                $user['without_schedule_types'] = $chat_type;
                //need made Dynamic
                $user->mentor['about'] = "dsads asdsdasdsa ";
                $user->mentor['experience'] = 4;
                //total completed Appointments
                $appointmentCount = BookAppointment::where([['mentor_id', $id], ['appointment_status', 2]])->count();
                $user['appointmentCount'] = $appointmentCount;
                $days = 0;
                $years = 0;
                $months = 0;
                foreach ($user->experiences as $experience) {
                    $to = Carbon::parse($experience->to);
                    $from = Carbon::parse($experience->from);
                    $days += $to->diffInDays($from);
                    $months += $to->diffInMonths($from);
                    $years += $to->diffInYears($from);
                }
                $user['experience_work'] = ['days' => $days, 'months' => $months, 'years' => $years];
            } else {
                $user = User::where('id', $id)->first();
            }


            $obj = ["Status" => true, "success" => 1, "data" => ["userDetail" => $user], "msg" => "User Profile got Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Mentor Profile Completion and Account Approval Status
    public function mentorStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            //'book_file'=>'required|max:20048'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedule = MentorSchedule::where('mentor_id', $request->mentor_id)->get();
            $schedule = 0;
            if (count($mentorSchedule) > 0) {
                $schedule = 1;
            }
            $mentor = Mentor::select('status', 'is_profile_completed')->where('user_id', $request->mentor_id)->first();
            $obj = ["Status" => true, "success" => 1, "data" => ["mentor" => $mentor, "schedule" => $schedule], "msg" => " Got Mentor info Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Update Profile Completion Status
    public function mentorProfileCompletion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            //'book_file'=>'required|max:20048'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor = Mentor::where('user_id', $request->mentor_id)->update([

                'is_profile_completed' => 1
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", "mentor" => $mentor], "msg" => " Mentor Profile Completed Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Generate Agora Token live
    public function generate_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel' => 'required',
            //'book_file'=>'required|max:20048'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $appID = config('services.agora.app_id');
            $appCertificate = config('services.agora.app_certificate');
            $channelName = $request->channel;
            $uid = (int) mt_rand(1000000000, 9999999999);
            $uidStr = strval($uid);
            $role = RtcTokenBuilder::RoleAttendee;
            $expireTimeInSeconds = 2400;
            $currentTimestamp = (new \DateTime("now", new \DateTimeZone('Asia/Karachi')))->getTimestamp();
            $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

            $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, null, $role, $privilegeExpiredTs);



            $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", "token" => $token], "msg" => " Got Successfully Agora Token"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    public function getMentorPublicDetails(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $id = $request->mentor_id;
            $rating = Rating::where('mentor_id', $id)->avg('rating');
            $ratingCount = Rating::where('mentor_id', $id)->count();

            $user = User::select('id', 'first_name', 'last_name', 'father_name', 'gender', 'city', 'country', 'image_path', 'online_status')->with([
                'mentor',
                'educations', 'experiences', 'user_country' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->where('id', $id)->first();
            $user['ratingsAvg'] = round($rating);
            $user['ratingCount'] = $ratingCount;
            $mentor_categories = MentorAssignCategory::with('category')->where('mentor_id', $id)->orderBy('id', 'ASC')->get();
            $user->mentor['categories'] = $mentor_categories;
            $obj = ["Status" => true, "success" => 1, "data" => ["AccessToken" => "hgyhjjj", "userDetail" => $user], "msg" => "User Profile got Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    public function signup_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'fb_id' => (empty($request->fb_id)) ? Null : $request->fb_id
        ]);
        $user->save();
        // $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        // if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        if ($request->role == "Mentor") {
            Mentor::create(['user_id' => $user->id]);
        } else if ($request->role == "Mentee") {
            Mentee::create(['user_id' => $user->id]);
        }
        $obj = [
            "Status" => true, "success" => 1,
            'AccessToken' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            "data" => ["user" => $user, 'role' => $request->role],
            'msg' => 'Successfully Signup and Login'
        ];
        return response()->json($obj);
    }
    public function login_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'msg' => 'Invalid Email or Password', "Status" => false, "success" => 0,
            ]);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        // if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $role = '';
        if ($request->role == "Mentor") {
            $mentor = Mentor::where('user_id', $user->id)->first();
            if ($mentor) {
                $role = 'Mentor';
            } else {
                $obj = [
                    "Status" => false, "success" => 0,

                    'msg' => 'Selected Wrong Role'
                ];
                return response()->json($obj);
            }
        } else if ($request->role == "Mentee") {
            $mentee = Mentee::where('user_id', $user->id)->first();
            if ($mentee) {
                $role = 'Mentee';
            } else {
                $obj = [
                    "Status" => false, "success" => 0,

                    'msg' => 'Selected Wrong Role'
                ];
                return response()->json($obj);
            }
        }
        $obj = [
            "Status" => true, "success" => 1,
            'AccessToken' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            "data" => ["user" => $user, 'role' => $role],
            'msg' => 'Successfully Login'
        ];
        return response()->json($obj);
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            $obj = [
                "Status" => true, "success" => 1,
                'msg' => "Forget Password link has been sent to Email."
            ];
            return response()->json($obj);
        } else {
            $obj = [
                "Status" => false, "success" => 0,
                'msg' => "No Email Found !"
            ];
            return response()->json($obj);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            // return back()->withInput()->with('error', 'Invalid token!');
            $obj = [
                "Status" => false, "success" => 0,
                'msg' => 'Invalid token!'
            ];
            return response()->json($obj);
        }

        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
        $obj = [
            "Status" => true, "success" => 1,
            'msg' => 'Successfully Updated Password'
        ];
        return response()->json($obj);
    }
}

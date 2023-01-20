<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorCategory;
use App\Models\Mentor;
use App\Models\MentorSchedule;
use App\Models\Rating;
use App\Models\MentorAssignCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MentorCategoryController extends Controller
{
    //Mentor Category List Api Function
    public function index(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $mentorCategories = MentorCategory::where('parent_id', 0)->get();



            foreach ($mentorCategories as $mentorCategory) {
                $mentors = MentorAssignCategory::select('mentor_id')->where('category_id', $mentorCategory->id)->get();

                $mentor_ids = [];
                foreach ($mentors as $mentor) {
                    array_push($mentor_ids, $mentor->mentor_id);
                }


                $mentorCount = Mentor::has('schedule')->where('status', 1)->whereIn('user_id', $mentor_ids)->count();

                $mentorCategory['mentor_p_count'] = $mentorCount;
            }

            $obj = ["Status" => true, "success" => 1, "data" => ["mentorCategories" => $mentorCategories], "msg" => "Got Successfully Mentor Categories"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    //Category wise mentor
    public function categoryMentor(Request $request)
    {
        $token = "123";
        $category = $request->category_id;
        $city = $request->city;
        $country = $request->country;

        if ($request->token == $token) {

            $mentorCategory = MentorCategory::where('id', $category)->first();
            $mentor_cat_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $category)->get();
            $mentor_ids = [];
            foreach ($mentor_cat_ids as $mentor) {
                array_push($mentor_ids, $mentor->mentor_id);
            }
            $mentors = Mentor::has('schedule')->whereIn('user_id', $mentor_ids)->where('status', 1)
                ->with([
                    'user' => function ($q) use ($city, $country) {
                        $q->orWhere('city', $city);
                        $q->with(['user_country' => function ($q) use ($country) {
                            // $q->select('name');
                            $q->orWhere('name', $country);
                        }]);
                    }

                ])->get();
            foreach ($mentors as $mentor) {
                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', 'fee')->where('mentor_id', $mentor->user_id)->with('appointment_type')->distinct()->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where('mentor_id', $mentor->user_id)->whereIn('appointment_type_id', [3, 6])->with('appointment_type')->get();
                $mentor['without_schedule_types'] = $chat_type;
                $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
                $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();

                $mentor['rating'] = round($rating);
                $mentor['ratingCount'] = $ratingCount;
                if ($chat_type->isEmpty()) {
                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
                } else if ($schedule_types->isEmpty()) {
                    $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                } else {

                    $minFee = (count($schedule_types) > 0 ? $schedule_types[0]->fee : (count($chat_type) > 0 ? $chat_type[0]->fee : 0));
                }
                foreach ($schedule_types as $schedule_type) {
                    if ($minFee > $schedule_type->fee)
                        $minFee = $schedule_type->fee;
                }
                foreach ($chat_type as $chat) {
                    if ($minFee > $chat->fee)
                        $minFee = $chat->fee;
                }
                $mentor['fee'] = $minFee;
                $mentor['category'] = $mentorCategory;
            }

            $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => $mentors], "msg" => "Got Successfully Mentors"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    //get featured mentors
    public function featuredMentors(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {

            $mentors = DB::table('mentor')
                ->select(['users.first_name', 'users.last_name', 'users.image_path', 'mentor.user_id', 'users.gender'])

                ->join('users', 'users.id', '=', 'mentor.user_id')
                ->where('mentor.status', 1)
                ->where('mentor.is_featured', 1)
                ->get();
            foreach ($mentors as $mentor) {
                $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
                $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();
                $ratingMax = Rating::where('mentor_id', $mentor->user_id)->max('rating');
                $mentor->ratingAvg = round($rating);
                $mentor->ratingCount = $ratingCount;
                $mentor->topRating = $ratingMax;
                $category_id = MentorAssignCategory::select('category_id', 'id')->where('mentor_id', $mentor->user_id)->orderBy('id', 'desc')->first();
                $mentorCategory = '';
                if ($category_id) {
                    $mentorCategory = MentorCategory::where('id', $category_id->category_id)->first();
                }

                $mentor->category = $mentorCategory;
            }
            $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => $mentors], "msg" => "Got Successfully Featured Mentors"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function mentorWithPriceRange(Request $request)
    {
        $token = "123";
        $slug = $request->slug;
        $city = $request->city;
        $country = $request->country;
        $fromPrice = $request->minPrice;
        $toPrice = $request->maxPrice;

        if ($request->token == $token) {
            $category = MentorCategory::where('slug', $slug)->first();
            if (is_null($category)) {
                $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => []], "msg" => "No Category Exist with this Slug"];
                return response()->json($obj);
            }

            $mentor_cat_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $category->id)->get();
            $mentor_ids = [];
            foreach ($mentor_cat_ids as $mentor) {
                array_push($mentor_ids, $mentor->mentor_id);
            }

            $mentors = Mentor::has('schedule')->whereIn('user_id', $mentor_ids)
                //    ->orWhere('mentor_category_id','=',$category->id)
                ->where('status', 1)->with(
                    [
                        'user' => function ($q) use ($city, $country) {
                            $q->orWhere('city', $city);
                            $q->with(['user_country' => function ($q) use ($country) {
                                // $q->select('name');
                                $q->orWhere('name', $country);
                            }]);
                        },
                        'schedule' => function ($q) use ($fromPrice, $toPrice) {
                            $q->whereBetween('fee', [$fromPrice, $toPrice]);
                        }


                    ]
                )->get()->makeHidden(['email']);
            //    return response()->json($mentors);


            $newMentor = [];
            foreach ($mentors as $mentor) {
                if (is_null($mentor->schedule)) {

                    continue;
                }

                $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', 'fee')->where('mentor_id', $mentor->user_id)->with('appointment_type')

                    ->distinct()->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor->user_id], ['appointment_type_id', 3]])->with('appointment_type')

                    ->get();
                $mentor['without_schedule_types'] = $chat_type;
                $mentor['rating'] = round($rating);

                $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();


                $mentor['ratingCount'] = $ratingCount;

                if ($chat_type->isEmpty()) {
                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
                } else if ($schedule_types->isEmpty()) {
                    $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                } else {

                    $minFee = (count($schedule_types) > 0 ? $schedule_types[0]->fee : (count($chat_type) > 0 ? $chat_type[0]->fee : 0));
                }
                foreach ($schedule_types as $schedule_type) {
                    if ($minFee > $schedule_type->fee)
                        $minFee = $schedule_type->fee;
                }
                foreach ($chat_type as $chat) {
                    if ($minFee > $chat->fee)
                        $minFee = $chat->fee;
                }
                $mentor['fee'] = $minFee;
                $mentor['category'] = $category;
                array_push($newMentor, $mentor);
            }
            $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => $newMentor], "msg" => "Got Successfully Mentors"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function categoryMentorWithSlug(Request $request)
    {
        $token = "123";
        $slug = $request->slug;
        $city = $request->city;
        $country = $request->country;
        if ($request->token == $token) {
            $category = MentorCategory::where('slug', $slug)->first();
            if (is_null($category)) {
                $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => []], "msg" => "No Category found with provided slug"];
                return response()->json($obj);
            }


            $mentor_cat_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $category->id)->get();
            $mentor_ids = [];
            foreach ($mentor_cat_ids as $mentor) {
                array_push($mentor_ids, $mentor->mentor_id);
            }

            $mentors = Mentor::has('schedule')->whereIn('user_id', $mentor_ids)
                //    ->orWhere('mentor_category_id','=',$category->id)
                ->where('status', 1)->with(
                    [
                        'user' => function ($q) use ($city, $country) {
                            $q->orWhere('city', $city);
                            $q->with(['user_country' => function ($q) use ($country) {
                                // $q->select('name');
                                $q->orWhere('name', $country);
                            }]);
                        }


                    ]
                )->get();
            foreach ($mentors as $mentor) {

                $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', DB::raw('min(fee) as fee'))->where('mentor_id', $mentor->user_id)->with('appointment_type')->groupBy('appointment_type_id')->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor->user_id], ['appointment_type_id', 3]])->with('appointment_type')->get();
                $mentor['without_schedule_types'] = $chat_type;
                $mentor['rating'] = round($rating);

                if ($chat_type->isEmpty()) {
                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
                } else if ($schedule_types->isEmpty()) {
                    $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                } else {

                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                }
                foreach ($schedule_types as $schedule_type) {
                    if ($minFee > $schedule_type->fee)
                        $minFee = $schedule_type->fee;
                }
                foreach ($chat_type as $chat) {
                    if ($minFee > $chat->fee)
                        $minFee = $chat->fee;
                }
                $mentor['fee'] = $minFee;
                $mentor['category'] = $category;
            }
            $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => $mentors], "msg" => "Got Successfully Mentors"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function CategoriesListWeb(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $mentorCategories = MentorCategory::where('parent_id', 0)->with(['subCategories' => function ($q) {
                $q->with('subCategories');
            }])->get();
            $allcat = MentorCategory::all();
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorCategories" => $mentorCategories, "allcat" => $allcat], "msg" => "Got Successfully Mentor Categories"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function CategoriesList(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $mentorCategories = MentorCategory::where('parent_id', 0)->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorCategories" => $mentorCategories], "msg" => "Got Successfully Mentor Categories"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function GetChildMentorCategories(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $mentorCategories = MentorCategory::with('subCategories')->where('parent_id', $request->parent_id)->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorCategories" => $mentorCategories], "msg" => "Got Successfully Mentor Child Categories"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];

        return response()->json($obj);
    }
    public function getTopRatedMentor()
    {
        DB::statement("SET SQL_MODE=''");
        $mentors = DB::table('mentor')
            ->select(['mentor.user_id', 'users.first_name', 'users.last_name', 'users.image_path', DB::raw('MAX(rt.rating) AS topRating')])
            ->join('ratings AS rt', 'rt.mentor_id', '=', 'mentor.user_id')
            ->join('users', 'users.id', '=', 'mentor.user_id')
            ->join('mentor_schedules', 'mentor_schedules.mentor_id', '=', 'mentor.user_id')

            ->groupBy('mentor.user_id')
            ->paginate(10);


        foreach ($mentors as $mentor) {
            // dd($mentor);
            $assign_category = MentorAssignCategory::where('mentor_id', $mentor->user_id)->orderBy('id', 'DESC')->first();

            if (isset($assign_category)) {
                $category = MentorCategory::where('id', $assign_category->category_id)->first();
                $mentor->category = $category;
            }

            $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();
            $ratingAvg = Rating::where('mentor_id', $mentor->user_id)->avg('rating');


            $mentor->ratingCount = $ratingCount;
            $mentor->ratingAvg = round($ratingAvg);
        }
        $obj = ["Status" => true, "success" => 1, "data" => ["topRatedMentors" => $mentors], "msg" => "Got Successfully Top Rated Mentor"];
        return response()->json($obj);
    }
    public function categoriesWithMentors(Request $request)
    {
        if ($request->has('category_id')) {
            $mentor_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $request->category_id)->pluck('mentor_id');


            $mentors = Mentor::has('schedule')->with(['user'])->whereIn('user_id', $mentor_ids)->where('status', 1)->paginate(10);

            foreach ($mentors as $mentor) {

                $assign_category = MentorAssignCategory::where('mentor_id', $mentor->user_id)->orderBy('id', 'DESC')->first();
                $mentor_category = MentorCategory::where('id', $assign_category->category_id)->first();
                $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();
                $ratingAvg = Rating::where('mentor_id', $mentor->user_id)->avg('rating');

                $mentor->category = $mentor_category;
                $mentor->ratingCount = $ratingCount;
                $mentor->ratingAvg = round($ratingAvg);
            }
            $category['mentors'] = $mentors;
            $obj = ["Status" => true, "success" => 1, "data" => ["categories" => $category], "msg" => "Got Successfully Categories with Mentors"];
            return response()->json($obj);
        } else {
            $categories = MentorCategory::where('parent_id', 0)->get();

            foreach ($categories as $category) {
                $mentor_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $category->id)->pluck('mentor_id');


                $mentors = Mentor::has('schedule')->with(['user'])->whereIn('user_id', $mentor_ids)->where('status', 1)->paginate(10);

                foreach ($mentors as $mentor) {

                    $assign_category = MentorAssignCategory::where('mentor_id', $mentor->user_id)->orderBy('id', 'DESC')->first();
                    $mentor_category = MentorCategory::where('id', $assign_category->category_id)->first();
                    $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();
                    $ratingAvg = Rating::where('mentor_id', $mentor->user_id)->avg('rating');

                    $mentor->category = $mentor_category;
                    $mentor->ratingCount = $ratingCount;
                    $mentor->ratingAvg = round($ratingAvg);
                }
                $category['mentors'] = $mentors;
                // return response()->json($category);

            }
            $obj = ["Status" => true, "success" => 1, "data" => ["categories" => $categories], "msg" => "Got Successfully Categories with Mentors"];
            return response()->json($obj);
        }
    }
}

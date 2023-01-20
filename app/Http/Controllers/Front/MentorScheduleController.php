<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use Illuminate\Http\Request;
use App\Models\MentorSchedule;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorHolidayDate;
use App\Models\MentorScheduleSlot;



class MentorScheduleController extends Controller
{
    //get mentor Chat Fee
    public function getChatFee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
            ])->first();
            if (is_null($fee)) {
                $obj = ["Status" => true, "success" => 1, "data" => ["chatFee" => ''], "msg" => "Successfully got Chat Fee"];
            } else {
                $obj = ["Status" => true, "success" => 1, "data" => ["chatFee" => $fee], "msg" => "Successfully got Chat Fee"];
            }

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //save mentor Chat Fee
    public function saveAppointmentTypeChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = $request->fee;
            $already_exist = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
            ])->first();
            if ($already_exist) {
                $already_exist->update([
                    'fee' => $fee
                ]);
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorChatFee" => $already_exist], "msg" => "Successfully Updated   Fee"];

                return response()->json($obj);
            } else {
                $mentorSchedule = MentorSchedule::create([
                    'mentor_id' => $mentor_id,
                    'appointment_type_id' => $appointment_type_id,

                    'fee' => $fee,
                    'day' => "",
                    'is_holiday' => 0,
                    'is_active' => 1





                ]);
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorChatFee" => $mentorSchedule], "msg" => "Successfully Saved  Chat Fee"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //save mentor Schedule
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required',
            'fee' => 'required|min:100|numeric',
            'day' => 'required',

            'slots' => 'required|array',
            "interval" => "required"
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = $request->fee;
            $day = $request->day;

            $interval = $request->interval;

            MentorSchedule::where([
                ['mentor_id', $mentor_id], ['appointment_type_id', $appointment_type_id]
            ])->update([
                'fee' => $fee,
            ]);
            $already_exist = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
                ['day', $day]

            ])->first();
            if ($already_exist) {
                $already_exist->update([
                    'fee' => $fee,
                    'is_holiday' => 0,
                    'is_active' => 1,
                    'appointment_type_id' => $appointment_type_id
                ]);
                MentorScheduleSlot::where('schedule_id', $already_exist->id)->delete();
                foreach ($request->slots as $slot) {
                    $time = new \DateTime($slot);
                    $time->add(new \DateInterval('PT' . $interval . 'M'));

                    $stamp = $time->format('H:i:s');
                    MentorScheduleSlot::create([
                        'schedule_id' => $already_exist->id,
                        'start_time' => date('h:i a', strtotime($slot)),
                        'end_time' => date('h:i a', strtotime($stamp)),
                        'slot_duration' => $interval,
                        'is_active' => 1,
                        'shift_id' => 1
                    ]);
                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedule" => $already_exist], "msg" => "Successfully Updated Mentor Schedule"];

                return response()->json($obj);
            } else {

                $newRecord = MentorSchedule::create([
                    'mentor_id' => $mentor_id,
                    'appointment_type_id' => $appointment_type_id,
                    'day' => $day,
                    'fee' => $fee,
                    'is_holiday' => 0,
                    'is_active' => 1,
                    'appointment_type_id' => $appointment_type_id
                ]);
                foreach ($request->slots as $slot) {
                    $time = new \DateTime($slot);
                    $time->add(new \DateInterval('PT' . $interval . 'M'));

                    $stamp = $time->format('H:i:s');
                    MentorScheduleSlot::create([
                        'schedule_id' => $newRecord->id,
                        'start_time' => date('h:i:s a', strtotime($slot)),
                        'end_time' => date('h:i:s a', strtotime($stamp)),
                        'slot_duration' => $interval,
                        'is_active' => 1,
                        'shift_id' => 1
                    ]);
                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedule" => $newRecord], "msg" => "Successfully Saved Mentor Schedule"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    //get mentor Schedule
    public function getMentorSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), ['mentor_id' => 'required',]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::where('mentor_id', $request->mentor_id)->has('schedule_slots')->with(['schedule_slots' => function ($q) {
                $q->orderBy('start_time', 'ASC');
            }])->get();
            $fee = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
            ])->whereIn('appointment_type_id', [3, 6])->get();

            $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules, 'mentorWithoutSchedule' => is_null($fee) ? [] : $fee], "msg" => "Successfully Got Mentor Schedules"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Delete Mentor Schedule Slots
    public function deleteMentorSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required',]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            if ($request->appointment_type_id == 3) {
                MentorSchedule::destroy($request->id);
            }

            MentorScheduleSlot::where('schedule_id', $request->id)->delete();
            $obj = ["Status" => true, "success" => 1, "msg" => "Mentor Schedule Deleted Successfully"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //Save Holiday against Date
    public function saveHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'date' => "required|date",
            'is_holiday' => "required",
            'comment' => "required"
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $date = $request->date;
            $is_holiday = $request->is_holiday;
            $comment = $request->comment;
            $created = MentorHolidayDate::create([
                'mentor_id' => $mentor_id,
                'date' => $date,
                'is_holiday' => $is_holiday,
                'comment' => $comment
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorHolidayDate" => $created], "msg" => "Successfully Saved Mentor Holiday Date"];

            return response()->json($obj);
        }

        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    public function getHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $holidayDate = MentorHolidayDate::where('mentor_id', $request->mentor_id)->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["holidayDate" => $holidayDate], "msg" => "Successfully Got Mentor Holiday Dates"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function updateHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'date' => "required|date",
            'is_holiday' => "required",
            'comment' => "required"
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $date = $request->date;
            $is_holiday = $request->is_holiday;
            $comment = $request->comment;
            $updated = MentorHolidayDate::where('mentor_id', $mentor_id)->update([
                'date' => $date,
                'is_holiday' => $is_holiday,
                'comment' => $comment
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorHolidayDate" => $updated], "msg" => "Successfully Updated Mentor Holiday Date"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }

    public function getAvailableDaysWeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['is_holiday', 0],
                ['appointment_type_id', $request->appointment_type_id]
            ])->orderBy('id', 'ASC')->get();
            if (count($mentorSchedules) > 0) {
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            } else {
                $created = [
                    ['day' => 'monday', 'is_holiday' => 1], ['day' => 'tuesday', 'is_holiday' => 1], ['day' => 'wednesday', 'is_holiday' => 1], ['day' => 'thursday', 'is_holiday' => 1], ['day' => 'friday', 'is_holiday' => 1], ['day' => 'saturday', 'is_holiday' => 1], ['day' => 'sunday', 'is_holiday' => 1]
                ];
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $created], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function getAvailableDays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id]
            ])->orderBy('id', 'ASC')->get();
            if (count($mentorSchedules) > 0) {
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            } else {
                $created = [
                    ['day' => 'monday', 'is_holiday' => 0], ['day' => 'tuesday', 'is_holiday' => 0], ['day' => 'wednesday', 'is_holiday' => 0], ['day' => 'thursday', 'is_holiday' => 0], ['day' => 'friday', 'is_holiday' => 0], ['day' => 'saturday', 'is_holiday' => 0], ['day' => 'sunday', 'is_holiday' => 0]
                ];
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $created], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function markDayHoliday(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required',
            // 'day'=>'required',
            // 'is_holiday'=>'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $obj_avail = $request->availability;

            $already = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
                ['appointment_type_id', $request->appointment_type_id]
            ])->first();
            if ($already) {
                foreach ($obj_avail as $key => $value) {
                    MentorSchedule::where([
                        ['mentor_id', $request->mentor_id], ['day', $key], ['appointment_type_id', $request->appointment_type_id]
                    ])->update([
                        'day' => $key,
                        'is_holiday' => $value
                        //  ,'appointment_type_id'=>$request->appointment_type_id
                    ]);
                }
                // $already->update([
                //     'is_holiday'=>$request->is_holiday,

                // ]);
                $obj = ["Status" => true, "success" => 1, "msg" => "Successfully Updated Availablity"];

                return response()->json($obj);
            } else {
                foreach ($obj_avail as $key => $value) {


                    $created = MentorSchedule::create([
                        'mentor_id' => $request->mentor_id,
                        'appointment_type_id' => $request->appointment_type_id,
                        'fee' => 0,
                        'day' => $key,
                        'is_holiday' => $value,
                        'is_active' => 0
                    ]);
                }

                $obj = ["Status" => true, "success" => 1, "msg" => "Successfully Updated Availablity"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function getMentorDateSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'date' => 'required',
            'appointment_type_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $timestamp = strtotime($request->date);
            $day = strtolower(date('l', $timestamp));
            $date = date('Y-m-d', strtotime($request->date));
            $scheduleSlots = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
                ['day', $day], ['appointment_type_id', $request->appointment_type_id]
            ])->with(['schedule_slots' => function ($q) {
                $q->orderBy('id', 'ASC');
            }])->first();
            if (isset($scheduleSlots->schedule_slots) && count($scheduleSlots->schedule_slots) > 0) {
                foreach ($scheduleSlots->schedule_slots as $scheduleSlot) {
                    $is_disabled = BookAppointment::where('mentor_id', $request->mentor_id)->where('date', $date)->where('is_paid', 1)->where(function ($q) use ($scheduleSlot) {
                            $q->where(function ($z)  use ($scheduleSlot) {
                                $z->where('time', '>', $scheduleSlot->start_time)->where('time', '<', $scheduleSlot->end_time);
                            })
                                ->orWhere(function ($x)  use ($scheduleSlot) {
                                    $x->where('end_time', '>', $scheduleSlot->start_time)->where('end_time', '<=', $scheduleSlot->end_time);
                                });
                        })->count();

                    $scheduleSlot['is_booked'] = $is_disabled;
                }
            }
            $obj = ["Status" => true, "success" => 1, "data" => ['schedule' => $scheduleSlots], "msg" => "Successfully Got Slots"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function availableMentorAppointmentTypes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id')->where('mentor_id', $request->mentor_id)->with('appointment_type')->distinct()->get();

            $obj = ["Status" => true, "success" => 1, "data" => ['schedule_types' => $schedule_types], "msg" => "Successfully Got Schedule Types for mentor"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    public function getMentorFeeByAppointmentType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $fee = MentorSchedule::where([['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id]])->first();

            $obj = ["Status" => true, "success" => 1, "data" => ['mentor_fee' => $fee], "msg" => "Successfully Got Appointment Type Fee for mentor"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
    //get Scheduled Available Days of Mentor
    public function getScheduledAvailableDays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
            'appointment_type_id' => 'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::has('schedule_slots')->select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id], ['is_holiday', 0]
            ])->orderBy('id', 'ASC')->get();

            $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Token Incorrect"];
        return response()->json($obj);
    }
}

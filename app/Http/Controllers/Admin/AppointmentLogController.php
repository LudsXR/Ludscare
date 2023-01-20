<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
class AppointmentLogController extends Controller
{
    public function getAppointmentLog(){
        $appointments=BookAppointment::has('mentor')->has('mentee')->with(['mentor','mentee'])->orderBy('id','DESC')->get();
        // dd($appointments);
        return view('new_admin.appointment.list',compact('appointments'));
    }
}

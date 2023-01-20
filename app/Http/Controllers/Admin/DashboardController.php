<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Mentee;
use App\Models\Mentor;
use App\Models\BookAppointment;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $menteeCount=Mentee::count();
        $mentorCount=Mentor::where('status',1)->count();
        $appointment_completed=BookAppointment::where('appointment_status',2)->count();
        $appointment_pending=BookAppointment::where('appointment_status',0)->count();
        $appointment_cancel=BookAppointment::where('appointment_status',3)->count();
        $appointment_accepted=BookAppointment::where('appointment_status',1)->count();

        return view('new_admin.dashboard.dashboard',compact('menteeCount','mentorCount'
        ,'appointment_completed','appointment_pending','appointment_cancel','appointment_accepted'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentee;
use App\Models\BookAppointment;
use App\Models\Mentor;
use App\Models\User;
class LedgerController extends Controller
{


    public function mentee_list(){
        $mentees=Mentee::has('appointments')->with('user')->get();
        foreach($mentees as $mentee){
            $payment=BookAppointment::where('mentee_id',$mentee->user_id)->sum('payment');
            $mentee['total_payment']=$payment;
        }

        return view('new_admin.ledger.mentee_list',compact('mentees'));


    }
    public function mentee_appointments($id){
        $appointments=BookAppointment::where('mentee_id',$id)->with([
            'mentee'
            ,'mentor'])->get();
        return view('new_admin.ledger.mentee_appointments',compact('appointments'));

    }
    public function mentor_list(){
        $mentors=Mentor::has('appointments')->with('user')->get();
        foreach($mentors as $mentor){
            $payment=BookAppointment::where('mentor_id',$mentor->user_id)->sum('payment');
            $mentor['total_payment']=$payment;
        }
        return view('new_admin.ledger.mentor_list',compact('mentors'));
    }
    public function mentor_appointments($id){
        $appointments=BookAppointment::where('mentor_id',$id)->with([
            'mentee'
            ,'mentor'])->get();
        return view('new_admin.ledger.mentor_appointments',compact('appointments'));
    }
    public function mentee_refund($id,$payment,$appointment_id){
        // dd($id,$payment,$appointment_id);
        $user=User::find($id);
        $transaction=$user->deposit($payment);
        BookAppointment::find($appointment_id)->update([
            'refund'=>1
        ]);
        return redirect('admin/mentee-appointments/'.$id);
    }

}

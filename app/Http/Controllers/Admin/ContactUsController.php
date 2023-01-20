<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
class ContactUsController extends Controller
{
    public function list()
    {
        $contactuslist=ContactUs::orderBy('id','DESC')->get();

        return view('new_admin.contact_us.list',compact('contactuslist'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
  public function contact()
  {

    return view('frontend.pages.contact_us');

  }
  public function store(Request $request)
   {
       $validation = Validator::make($request->all(), [
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'email:filter', 'max:255'],
            'phone' => ['required', 'string'],
           'message' => ['required', 'string']
       ]);

       if ($validation->fails()) {
           return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
       }

       $name = $request->name;
       $email = $request->email;
       $msg = $request->message;

       $msg = "
Name: $name \n
Email: $email \n
Phone: $phone \n
Message: $msg
       ";

       $receiver = "sayeed@globalskills.com.bd";
       Mail::to($receiver)->send(new ContactMail($msg));
      
       return response()->json(['code' => 200, 'msg' => 'Thanks for contacting us, we will get back to you soon.']);
   }
}

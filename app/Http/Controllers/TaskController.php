<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\LoginRequest;


class TaskController extends Controller
{
    public function index (){
        return view('task');
    }
    
    public function mail(Request $request){
        $request['email'] = trim($request['email']);
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc,dns']
        ]);
        if($validator->fails()){
            $request->flash();
            return back()->withErrors($validator)->withInput();
        }
        Mail::to('rugilestasionyte@gmail.com')->send(new LoginRequest($request->email));
        return back()->with('message', 'Thank you for request. I will write you back as soon as possible');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function index(){
        //Did session has  key name 'user' 
        if(Session::has('user'))
        {
            //Pull the key name 'user' from sesssion
            Session::pull('user');
            return redirect(route('home'));
        }
        return "no";
    }
}

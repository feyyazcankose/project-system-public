<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{   
    //global variables
    public $request,$user,$route;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function admin(){
        $request=$this->request;
       
        //request is validate
        $request->validate(['email'=>"required|email",'password'=>"required"]);
       
        //get admin from db
        $user = Admin::where('email', $request->email)->first();
       
        //is there the user
        if($user)
        {
            $this->user=$user;
            $this->route="admin";
            return $this->check();
        } else {
            return back() -> with("status",["E posta adresi sistemde kayıtlı değildir.","danger"]);
        }
    }

    public function teacher(){
        $request=$this->request;
        
        //request is validate
        $request->validate(['sicil'=>"required|max:4",'password'=>"required"]);
        
        //get the teacher from db
        $user = Teacher::where('sicil', $request->sicil)->first();

        //is there the teacher?
        if($user)
        {
            $this->user=$user;
            $this->route="teacher";
            return $this->check();
        } else {
            return back() -> with("status",["Sicil numarası sistemde kayıtlı değildir.","danger"]);
        }
    }


    public function student(){
        $request=$this->request;
        
        //request is validate
        $request->validate(['student_number'=>"required|min:9|max:9",'password'=>"required"]);
        
        //get the user from table student
        $user = Student::where('student_number', $request->student_number)->first();

        //is there the user? 
        if($user)
        {
            $this->user=$user;
            $this->route="student";
            return $this->check();
        } else {
            return back() -> with("status",["Öğrenci numarası sistemde kayıtlı değildir.","danger"]);
        }
    }

    public function check(){
        $request=$this->request;
        $user=$this->user;
        $route=$this->route;

        //Check password the user
        if(Hash::check($request->password,$user->password))
        {
            //Put a create user from session   
            $request->session()->put('user',$user);
            return redirect(route($route.".home"))->with('success','Giriş Başarılı');
        } else {
            return back() -> with("status",["Şifre yanlış.","danger"]);
        }

        
    }


  
}
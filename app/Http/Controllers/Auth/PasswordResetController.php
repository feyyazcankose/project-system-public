<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use App\Mail\PasswordMail;
use Hash;
use Mail;

class PasswordResetController extends Controller
{

  public function student_forgot(){
    return view('front.auth.student_forgot_password');
  }

  public function student_new_password(Request $request){
    $student = Student::where('email', $request->email)->first();

    $mail = $request->email;
    $rand=rand(10000,99999);

    if($student == null){
      return redirect()->back()->with(['error' => 'Bu mail sistemde kayıtlı değil']);

    }

    Student::where('email', $request->email)->update([
'password'=>Hash::make($rand)
]);

    Mail::to($mail) -> send(new PasswordMail($rand));

    return redirect('/login/student')->with(['success' => 'Yeni şifre gönderildi']);

  }




  public function teacher_forgot(){
    return view('front.auth.teacher_forgot_password');
  }

  public function teacher_new_password(Request $request){
    $student = Teacher::where('email', $request->email)->first();

    $mail = $request->email;
    $rand=rand(10000,99999);

    if($student == null){
      return redirect()->back()->with(['error' => 'Bu mail sistemde kayıtlı değil']);
    }

    Teacher::where('email', $request->email)->update([
'password'=>Hash::make($rand)
]);

    Mail::to($mail) -> send(new PasswordMail($rand));

    return redirect('/login/teacher')->with(['success' => 'Yeni şifre gönderildi']);

  }




  public function admin_forgot(){
    return view('front.auth.admin_forgot_password');
  }

  public function admin_new_password(Request $request){
    $student = Admin::where('email', $request->email)->first();

    $mail = $request->email;
    $rand=rand(10000,99999);

    if($student == null){
      return redirect()->back()->with(['error' => 'Bu mail sistemde kayıtlı değil']);
    }

    Admin::where('email', $request->email)->update([
  'password'=>Hash::make($rand)
  ]);

    Mail::to($mail) -> send(new PasswordMail($rand));

    return redirect('/login/admin')->with(['success' => 'Yeni şifre gönderildi']);

  }

}

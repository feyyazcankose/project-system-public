<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\Teacher;
use App\Models\Role;
use Closure;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\File;

class TeacherProfilController extends Controller
{
    public function get()
    {

        $user = Session()->get('user');
        $kullanici = Teacher::where("id", $user->id)->first();

        $dizi = [
            "id" => $kullanici->id,
            "Adsoyad" => $kullanici->name,
            "Email" => $kullanici->email,
            "Rol" => $kullanici->appellation,
            "ProfilFoto" => $kullanici->picture,
            "Sicil" => $kullanici->sicil,

        ];
        return view("back.teacher.profile", $dizi);
    }

    public function update(Request $request)
    {
        $user = Session()->get('user');

        //TODO: PROFİL FOTO YÜKLEME ALANI AMA KAYIT ATMIYOR !
        if (isset($request->file) && $request->file != null) {

            //New file name
            $fileName = rand(0, 1000000) . '.' . $request->file->getClientOriginalExtension();

            //is use file name in admin table 
            while (isset(DB::table('teachers')->where('picture', $fileName)->get()->id))
                $fileName = rand(0, 1000000) . '.' . $request->file->getClientOriginalExtension();

            //has a file picture?

            if (isset(DB::table('teachers')->where('id', $user->id)->first()->picture))
                $oldFile = DB::table('teachers')->where('id', $user->id)->first()->picture;


            $response = $request->file->move(public_path('user_picture/teachers'), $fileName);

            //old file picture remove
            //public_path('user_picture/admins').'/'.$oldFile
            if ($response && isset($oldFile) && $oldFile != "default.png")
                unlink(public_path('user_picture/teachers/' . $oldFile));

            //update database in admins 
            DB::table('teachers')->where('id', $user->id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "picture" => $fileName,
            ]);
        } else {
            DB::table('teachers')->where('id', $user->id)->update([
                "name" => $request->name,
                "email" => $request->email,

            ]);
        }
        $user = DB::table('teachers')->where('id', $user->id)->first();
        Session()->put('user', $user);
        return back()->with('status', ['Başarılı!', 'success']);
    }


    public function changePassword(Request $request)
    {
        $user = Session()->get('user');

        $sifre = $user->password;
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $sifre)) {
            return back()->with("status", ["Eski şifre yanlış girildi!", "success"]);
        }

        Teacher::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return back()->with("status", ["Şifre değiştirme işlemi başarılı !", "success"]);
    }
}

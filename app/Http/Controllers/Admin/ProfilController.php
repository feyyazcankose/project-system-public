<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\FormStorage;
use App\Http\Controllers\TableStorage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\Admin;
use App\Models\Role;
use Closure;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    public function get()
    {

        $user = Session()->get('user');
        $kullanici = Admin::where("id", $user->id)->first();
        # $sifre = $user->password;

        $dizi = [
            "id" => $kullanici->id,
            "Adsoyad" => $kullanici->name,
            "Email" => $kullanici->email,
            "Rol" => $kullanici->appellation,
            "ProfilFoto" => $kullanici->picture,

        ];
        return view("back.admin.profile", $dizi);
    }

    public function update(Request $request)
    {
        $user = Session()->get('user');

        //TODO: PROFİL FOTO YÜKLEME ALANI AMA KAYIT ATMIYOR !
        if (isset($request->file) && $request->file != null) {

            //New file name
            $fileName = rand(0, 1000000) . '.' . $request->file->getClientOriginalExtension();

            //is use file name in admin table 
            while (isset(DB::table('admins')->where('picture', $fileName)->get()->id))
                $fileName = rand(0, 1000000) . '.' . $request->file->getClientOriginalExtension();

            //has a file picture?

            if (isset(DB::table('admins')->where('id', $user->id)->first()->picture))
                $oldFile = DB::table('admins')->where('id', $user->id)->first()->picture;


            $response = $request->file->move(public_path('user_picture/admins'), $fileName);

            //old file picture remove
            //public_path('user_picture/admins').'/'.$oldFile
            if ($response && isset($oldFile) && $oldFile != "default.png")
                unlink(public_path('user_picture/admins/' . $oldFile));

            //update database in admins 
            DB::table('admins')->where('id', $user->id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "picture" => $fileName,
            ]);
        } else {
            DB::table('admins')->where('id', $user->id)->update([
                "name" => $request->name,
                "email" => $request->email,

            ]);
        }
        $user = DB::table('admins')->where('id', $user->id)->first();
        Session()->put('user', $user);
        # return redirect(route('admin.profile'));
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
            return back()->with('status', ['Eski şifre yanlış girildi !', "danger"]);
        }

        Admin::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return back()->with("status", ["Şifre değiştirme işlemi başarılı !", "success"]);
    }
}

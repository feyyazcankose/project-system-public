<?php

namespace App\Http\Middleware\Project\Student\Status;

use Closure;
use Illuminate\Http\Request;

class Project
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
            $assign_id=$request->assign->id;
            $projects=\App\Models\Project::where('assign_id',$assign_id)->orderBy('created_at','desc')->first();

            if(!isset($projects->status) || $projects->status==2 ){
                return $next($request);
            }
            else if($projects->status == 0)
            {
                $data['explain']="<b>".$projects->title."</b> Başlığına sahip projeniz <b>beklemede</b> bu yüzden işleme devam edemezsiniz.<br> Danışmanınızın onayı değiştirmesi bekleniyor.";
                $data['route']="student.project.list";
                $data['button']="Proje Listem";
                return redirect()->route('student.error')->with('error',$data);
            }
            else if($projects->status == 1)
            {
                //Yeni proje önerisinde bulunamaz!
                $data['explain']="Tebrikler <b>".strtoupper($projects->title)."</b> Başlığına sahip projenizin önerisi <b>Onaylanmış.</b><br>Öneri adımını tamamladınız 🙌🙌";
                $data['route']="student.report.add";
                $data['button']="Rapor Oluştur";

                return redirect()->route('student.success')->with('success',$data);
            }
    }
}

<?php

namespace App\Http\Middleware\Project\Teacher;

use App\Models\Admin;
use App\Models\Assign;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\PeriodTeacher;
use Closure;
use Illuminate\Http\Request;

class IsAssign
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
        $assign=Assign::all()->toArray();
        $period=Period::where('active',true)->first();
        $teacherId=Session()->get('user')->id;
        $periodTeacher=PeriodTeacher::where('teacher_id',$teacherId)->where('period_id',$period->id)->first();
        if(isset($periodTeacher)!=null)
        {
            if($assign==null)
            {
                    $admins=Admin::all(['email']);
                    $data['explain']="Sistemde <b>".$period->period_title."</b> dönemine ait size atanmış herhangi bir <b>öğrenci</b> bulunamadı!<br>       Lütfen yönetici ile iletişime geçin.";
                    $data['explain'].=" Aşağıdaki e posta adreslerini kullanarak iletişime geçebilirsiniz.<br><br>";
                    foreach ($admins as $admin) {
                        $data['explain'].="<b><a href='mailto:".$admin->email."'>".$admin->email."</b></a><br>";
                    }
    
                    return redirect()->route('teacher.error')->with('error',$data);
               
    
            }
            
            $active=Assign::where('period_teacher_id',$periodTeacher->id)->first();
    
            if($active==null)
            {
                    $data['explain']="<b>".$period->period_title."</b> döneminde size öğrenci atanamamıştır.<br>Bunun nedeni öğrenci sayısının az veya öğretmen sayısının fazla olasından kaynaklanmaktadır.";
                    return redirect()->route('teacher.error')->with('error',$data);
            }
            
        }

        return $next($request);
    }

}

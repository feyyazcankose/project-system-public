<?php

namespace App\Http\Middleware\Project\Student;

use App\Models\Assign;
use App\Models\Period;
use App\Models\PeriodStudent;
use Closure;
use Illuminate\Http\Request;

class IsPeriod
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
        $user = session()->get('user');
        $assign=$request->assign;



        if($assign->get()->toArray()==null)
        {
            $data['explain']="Dönem için atama işlemi yapılmadı! Bu yüzden veri oluşturamazsınız.<br> Lütfen yönetici ile iletişime geçin!";
            return redirect()->route('student.error')->with('error',$data);
        }
        else if(!isset($assign->where('students.id',$user->id)->first()->id))
        {
            $data['explain']="Aktif dönemde kayıtlı değilsiniz. Veri oluşturmazsınız.";
            return redirect()->route('student.error')->with('error',$data);
        }
        

        $activePeriod=Period::where('active',1)->first(); //aktif dönem
        $periodStudent=PeriodStudent::where('period_id',$activePeriod->id)->where('student_id',$user->id)->first();//period student id
        
        if($periodStudent!=null)
            $assign=Assign::where('period_student_id',$periodStudent->id)->first(); //assign get
        
        
        if($assign==null)
        {
            $data['explain']="Kayıtlı olduğunuz dönem aktif değil bu yüzden ekleme işlemi yapamazsınız!<br> Sistem yöneticisi ile iletişime geçin.";
            return redirect()->route('student.error')->with('error',$data);  
        }  
        $request->assign = $assign;
        return $next($request);
    }
}

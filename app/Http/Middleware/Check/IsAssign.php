<?php

namespace App\Http\Middleware\Check;

use App\Models\Assign;
use App\Models\Period;
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
        

        if($assign==null)
            return $next($request);
        else 
        {
            $period=Period::where('active',true)->first()->id;
            $active=Assign::join('period_students','period_students.id','period_student_id')->where('period_id',$period)->first();    
            if($active==null)
                return $next($request);

            $data['explain']="Sistemdeki aktif dönemde görevlendirme işlemini tamamladığınız için döneme yeni kayıt yapamazsınız!";
            $data['route']="admin.assign.page";
            $data['button']="Görevlendirme Listesi";
        }

        
        return redirect()->route('admin.error')->with('error',$data);
    }
}

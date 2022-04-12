<?php

namespace App\Http\Middleware\Project\Student;

use App\Models\Admin;
use App\Models\Assign;
use App\Models\Period;
use App\Models\PeriodStudent;
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
        $assign = new Assign;
        $user = session()->get('user');


        $data = $assign
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('students','students.id','period_students.student_id')
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',true);

        $request->assign=$data;
        return $next($request);


        
    }
}

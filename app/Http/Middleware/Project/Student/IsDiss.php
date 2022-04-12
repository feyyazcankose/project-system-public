<?php

namespace App\Http\Middleware\Project\Student;

use App\Models\Dissertation;
use Closure;
use Illuminate\Http\Request;

class IsDiss
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
        $report = $request->report;
        $diss = Dissertation::where('report_id', $report->id)->orderBy('created_at', 'desc')->first();

        if (!isset($diss->status)) {
            $data['explain'] = "Tez Oluşturulmadı! Lütfen tez oluşturun.";
            $data['route'] = "student.diss.add";
            $data['button'] = "Tez Oluştur";

            return redirect()->route('student.error')->with('error', $data);
        }

        $request->diss = $diss;
        return $next($request);
    }
}

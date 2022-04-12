<?php

namespace App\Http\Middleware\Project\Student;


use Closure;
use Illuminate\Http\Request;
use App\Models\Report;

class IsReport
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
        $project = $request->project;
        $report = Report::where('project_id', $project->id)->orderBy('created_at', 'desc')->first();

        if (!isset($report->status)) {
            $data['explain'] = "Rapor Oluşturulmadı! Lütfen rapor oluşturun.";
            $data['route'] = "student.report.add";
            $data['button'] = "Rapor Oluştur";

            return redirect()->route('student.error')->with('error', $data);
        }

        $request->report = $report;
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Project\Student;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;

class IsProject
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
        $assign_id = $request->assign->id;
        $project = Project::where('assign_id', $assign_id)->orderBy('created_at', 'desc')->first();


        if (!isset($project->status)) {
            $data['explain'] = "Herhangi bir proje oluşturulmadı! Lütfen proje oluşturun.";
            $data['route'] = "student.project.add";
            $data['button'] = "Proje Oluştur";

            return redirect()->route('student.error')->with('error', $data);
        }

        $request->project = $project;
        return $next($request);
    }
}

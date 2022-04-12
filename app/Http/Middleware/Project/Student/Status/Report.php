<?php

namespace App\Http\Middleware\Project\Student\Status;

use Closure;
use Illuminate\Http\Request;

class Report
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

        if ($project->status == 2) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz <b>red ediledi</b> rapor oluşturamazsınız. Lütfen yeni proje oluşturun.";
            $data['route'] = "student.project.add";
            $data['button'] = "Proje oluştur";
            return redirect()->route('student.error')->with('error', $data);
        } else if ($project->status == 0) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz <b>beklemede</b> bu yüzden işleme devam edemezsiniz.<br> Danışmanınızın onayı değiştirmesi bekleniyor.";
            $data['route'] = "student.project.list";
            $data['button'] = "Proje Listem";
            return redirect()->route('student.error')->with('error', $data);
        }



        $report = \App\Models\Report::where('project_id', $project->id)->orderBy('created_at', 'desc')->first();
        // dd($report);

        if (!isset($report->status) || $report->status == 2) {
            return $next($request);
        } else if ($report->status == 0) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz için gönderdiğiniz rapor <b>Beklemede</b> bu yüzden rapor oluşturamazsınız. <br>Danışmanın onayı değiştirmesi bekleniyor.</br>";
            $data['route'] = "student.report.list";
            $data['button'] = "Raporları Listele";
            return redirect()->route('student.error')->with('error', $data);
        } else if ($report->status == 1) {
            //Yeni proje önerisinde bulunamaz!

            $data['explain'] = "Tebrikler <b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz için gönderdiğiniz rapor <b>Onaylanmış</b><br>Rapor adımını tamamladınız 🙌🙌";
            $data['route'] = "student.diss.add";
            $data['button'] = "Tez Oluştur";

            return redirect()->route('student.success')->with('success', $data);
        }
    }
}

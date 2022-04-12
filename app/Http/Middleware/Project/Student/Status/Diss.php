<?php

namespace App\Http\Middleware\Project\Student\Status;

use App\Models\Dissertation;
use Closure;
use Illuminate\Http\Request;

class Diss
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
        // dd($request);

        $project = $request->project;

        if ($report->status == 2) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projenizin raporu <b>Red edilmiş</b> bu yüzden tez oluşturamazsınız. Lütfen yeni rapor oluştrun.";
            $data['route'] = "student.report.add";
            $data['button'] = "Rapor Oluştur";
            return redirect()->route('student.error')->with('error', $data);
        } else if ($report->status == 0) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz için gönderdiğiniz rapor <b>Beklemede</b> bu yüzden tez oluşturamazsınız. <br>Danışmanın onayı değiştirmesi bekleniyor.</br>";
            $data['route'] = "student.report.list";
            $data['button'] = "Raporları Listele";
            return redirect()->route('student.error')->with('error', $data);
        }


        $diss = Dissertation::where('report_id', $report->id)->orderBy('created_at', 'DESC')->first();

        if (!isset($diss->status) || $diss->status == 2) {
            return $next($request);
        } else if ($diss->status == 0) {
            $data['explain'] = "<b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz için gönderdiğiniz tez <b>Beklemede</b> bu yüzden tez oluşturamazsınız. <br>Danışmanın onayı değiştirmesi bekleniyor.</br>";
            $data['route'] = "student.diss.list";
            $data['button'] = "Tezleri Listele";
            return redirect()->route('student.error')->with('error', $data);
        } else if ($diss->status == 1) {
            //Yeni proje önerisinde bulunamaz!
            $data['explain'] = "Tebrikler <b>" . strtoupper($project->title) . "</b> Başlığına sahip projeniz için gönderdiğiniz tez <b>Onaylanmış</b><br>Tüm adımları tamamladınız 🙌🙌";
            return redirect()->route('student.success')->with('success', $data);
        }
    }
}

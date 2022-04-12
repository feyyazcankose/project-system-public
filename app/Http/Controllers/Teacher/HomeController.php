<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use App\Models\Dissertation;
use App\Models\Project;
use App\Models\Report;
use App\Models\Period;
use App\Models\PeriodTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function get(){

        $user = Session()->get('user');
      //  $ogrenciSayisi=Student::where("id",$user->id)->first();
        $period=Period::where('active',true)->first();
     
        $project = new Project();
        $report = new Report();
        $diss = new Dissertation();
        $assign = new Assign();

        
        // $son5ogrenci = DB::table('dissertations')->take(5)->get();
        //öneriler için
        if(isset($period->id)!=null)
        {
        
        $ogrenciSayisi = $assign
        ->join('period_teachers','assigns.period_teacher_id','period_teachers.id')
        ->join('period_students','assigns.period_student_id','period_students.id')

        ->where('period_teachers.teacher_id',$user->id)
        ->where('period_teachers.period_id',$period->id)
        ->get("period_students.*")->toArray();

        $ogrenciSayisi= count($ogrenciSayisi);
        
        
        
        
        $projectList=$project
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',1)
        ->where('teachers.id',$user->id);

        $projectCount = count($projectList->get()->toArray());

        $projectList=$projectList
        ->orderBy('projects.created_at','desc')
        ->limit(5)
        ->get(['students.name as student_name','students.picture as student_picture','students.student_number','projects.title as project_title','periods.period_title as period','teachers.name as teacher_name','teachers.sicil','projects.status'])
        ->each(function ($item){
            if($item->status == 1)
                $item->durum="Onaylandı";
            else if($item->status == 0)
                $item->durum="Beklemede";
            else if($item->status == 2)
                $item->durum="Red Edildi";
        });
        
        $reportList=$report
        ->join('projects','projects.id','reports.project_id')
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->orderBy('reports.created_at','desc')
        ->where('periods.active',1)
        ->where('teachers.id',$user->id);


        $reportCount = count($reportList->get()->toArray());


        $reportList=$reportList
        ->get(['students.name as student_name','students.student_number','students.picture as student_picture','projects.title as project_title','periods.period_title as period','teachers.name as teacher_name','teachers.sicil','reports.status'])
        ->each(function ($item){
        if($item->status == 1)
            $item->durum="Onaylandı";
        else if($item->status == 0)
            $item->durum="Beklemede";
        else if($item->status == 2)
            $item->durum="Red Edildi";
        });


        $dissList=$diss
        ->join('reports','reports.id','dissertations.report_id')
        ->join('projects','projects.id','reports.project_id')
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',1)
        ->where('teachers.id',$user->id);

        

        $dissCount = count($dissList->get()->toArray());


        $dissList=$dissList
        ->orderBy('dissertations.created_at','desc')
        ->limit(5)
        ->get(['students.name as student_name','students.student_number','students.picture as student_picture','projects.title as project_title','periods.period_title as period','teachers.name as teacher_name','teachers.sicil','dissertations.status'])
        ->each(function ($item){
            if($item->status == 1)
                $item->durum="Onaylandı";
            else if($item->status == 0)
                $item->durum="Beklemede";
            else if($item->status == 2)
                $item->durum="Red Edildi";
        });
        $period=$period->period_title;
        
        }
        else
        {
            $ogrenciSayisi=0;
            $projectCount=0;
            $dissCount=0;
            $reportCount=0;
            $projectList=null;
            $reportList=null;
            $dissList=null;
            $period="Oluşturulmadı!";
        }    


        $dizi = [
            "ogrenciSayisi"=>$ogrenciSayisi,
            "projeSayisi"=>$projectCount,
            "raporSayisi"=>$reportCount,
            "tezSayisi"=>$dissCount,
            "project"=>$projectList,
            "report"=>$reportList,
            "diss"=>$dissList,
            "period"=>$period,
            "user_name"=>$user->name
        ];

        return view("back.teacher.home",$dizi);
    }

}

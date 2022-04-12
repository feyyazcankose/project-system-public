<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assign;
use App\Models\Dissertation;
use App\Models\Project;
use App\Models\Report;
use App\Models\Period;
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
        
        $teacher = $assign
        ->join('period_teachers','assigns.period_teacher_id','period_teachers.id')
        ->join('teachers','teachers.id','period_teachers.teacher_id')
        ->join('period_students','assigns.period_student_id','period_students.id')
        ->where('period_teachers.period_id',$period->id)
        ->where('period_students.student_id',$user->id)
        ->first(["teachers.email","teachers.name","teachers.picture"]);

        // dd($teacher);
        
        
        
        $projectList=$project
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',1)
        ->where('students.id',$user->id)
        ->orderBy('projects.created_at','desc')
        ->first("projects.status");
        if(isset($projectList->status)!=null)
        $projectList=($projectList->status== 0 ? 'Beklemede 😓': ($projectList->status==1 ? 'Onaylandı 😘': ($projectList->status==2 ? 'Red Edildi 😯' : '')));
        else
        $projectList= 'Oluşturulmadı 😱';
        
        $reportList=$report
        ->join('projects','projects.id','reports.project_id')
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',1)
        ->where('students.id',$user->id)
        ->orderBy('reports.created_at','desc')
        ->first("reports.status");
        if(isset($reportList->status)!=null)
        $reportList=($reportList->status== 0 ? 'Beklemede 😓': ($reportList->status==1 ? 'Onaylandı 😘': ($reportList->status==2 ? 'Red Edildi 😯' : '')));
        else
        $reportList= 'Oluşturulmadı 😱';

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
        ->where('students.id',$user->id)
        ->orderBy('dissertations.created_at','desc')
        ->first("dissertations.status");
        if(isset($dissList->status)!=null)
        $dissList=($dissList->status== 0 ? 'Beklemede 😓': ($dissList->status==1 ? 'Onaylandı 😘': ($dissList->status==2 ? 'Red Edildi 😯' : '')));
        else
        $dissList= 'Oluşturulmadı 😱';

        $period=$period->period_title;
        
        }
        else
        {
            $projectList=null;
            $reportList=null;
            $dissList=null;
            $period="Oluşturulmadı!";
        }    


        $dizi = [
            "project"=>$projectList,
            "report"=>$reportList,
            "diss"=>$dissList,
            "period"=>$period,
            "user_name"=>$user->name,
            'teacher'=>$teacher
        ];

        // dd($dizi);

        return view("back.student.home",$dizi);
    }
}

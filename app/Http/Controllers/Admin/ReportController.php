<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(){
        $report= new Report();
        $data['items']=$report
        //projeye bağlanmak
        ->join('projects','projects.id','reports.project_id')
        
        //assign bağlanmak
        ->join('assigns','assigns.id','projects.assign_id')

        //öğretmeni almak
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('teachers','teachers.id','period_teachers.teacher_id') 

        //Öğrenciyi almak
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('students','students.id','period_students.student_id') 

        //Peirodu almak
        ->join('periods','periods.id','period_students.period_id')

        //sıralama

        ->orderBy('reports.created_at','desc')

        //getirilecek verileri belirlemek
        ->get(['periods.period_title','students.name as student_name','students.student_number','projects.title as project_title','periods.period_title as period','teachers.name as teacher_name','teachers.sicil','reports.status'])
        //veriler içine yeni veri atamak
        ->each(function ($item){
            $item->durum = strtoupper(($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : ''))));
            $item->class = ($item->status == 0 ? "text-dark" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
            
        });
        return view('back.admin.report.list',$data);
    }
}

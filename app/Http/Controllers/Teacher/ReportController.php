<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use App\Models\FileSystem;
use App\Models\Key;
use App\Models\Period;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function get($event=null){
        // $this->getInfo();
        $reportStatus=[0,1,2];
        
        if(!empty($event) && $event=='approve')
            $reportStatus=['1'];
        else if(!empty($event) && $event=='reject')
            $reportStatus=['2'];
        else if(!empty($event) && $event=='wait')
            $reportStatus=['0'];

        $activePeriod = Period::where('active', true)->first(); //aktif dönem
        $user = session()->get('user');
        $reports=new Report;

        $data['items'] = $reports
        //proje bağlama
        ->join('projects','projects.id','reports.project_id')
        //atama bağlama
        ->join('assigns','assigns.id','projects.assign_id')
        //periof teacher bağlama
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        
        

        //students getirme
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('students','students.id','period_students.student_id')
        
        //dönemi getirelim

        ->join('periods','periods.id','period_teachers.period_id')


        //koşullar
        ->whereIn('reports.status',$reportStatus)
        ->where('period_teachers.teacher_id',$user->id)
        ->where('projects.status',1)
        // ->where('periods.active',1)

        //sıralama
        ->orderBy('reports.created_at','DESC')

        //getirilecek veriler
        ->get(['periods.period_title','periods.active','projects.title','reports.status','reports.id','students.name as student_name'])

        //ekstra eklemeler
        ->each(function($item){  
            $item->file=FileSystem::where('report_id',$item->id)->get(['file_url'])->toArray();
            $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
            $item->class = ($item->status == 0 ? "text-white" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
            $item->btn=($item->active ? true : [false,"Aktif olmayan dönem için işlem yapamazsınız!"] );
        });


        $data['action'] = "teacher.report.form";
        return view('back.teacher.report.list',$data);
    }
    
   
    public function updateReject(Request $request){
        Report::where('id',$request->id)->update([
            'status'=>2,
            'explain'=>$request->explain
        ]);

        return redirect()->route('teacher.report.list')->with('status',["Güncelleme işlemi başarılı","success"]);
    }

    public function updateApprove($id){
        Report::where('id',$id)->update([
            'status'=>1,
            'explain'=>null

        ]);
        return redirect()->route('teacher.report.list')->with('status',["Güncelleme işlemi başarılı","success"]);
    }
}

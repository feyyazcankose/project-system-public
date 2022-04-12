<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Dissertation;
use App\Models\Period;
use App\Models\Report;
use Illuminate\Http\Request;

class DissController extends Controller
{
    public function get($event=null){
        // $this->getInfo();
        $dissStatus=[0,1,2];
        
        if(!empty($event) && $event=='approve')
            $dissStatus=[1];
        else if(!empty($event) && $event=='reject')
            $dissStatus=[2];
        else if(!empty($event) && $event=='wait')
            $dissStatus=[0];

        $activePeriod = Period::where('active', true)->first(); //aktif dönem
        $user = session()->get('user');
   
        $diss=new Dissertation;

        $data['items'] = $diss
        //report ile bağlama
        ->join('reports','reports.id','dissertations.report_id')
        //proje bağlama
        ->join('projects','projects.id','reports.project_id')
        //atama bağlama
        ->join('assigns','assigns.id','projects.assign_id')
        //period teacher bağlama
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        
        

        //students getirme
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('students','students.id','period_students.student_id')
        
        //dönemi getirelim

        ->join('periods','periods.id','period_teachers.period_id')


        //koşullar
        ->whereIn('dissertations.status',$dissStatus)
        ->where('period_teachers.teacher_id',$user->id)
        ->where('projects.status',1)

        //sıralama
        ->orderBy('dissertations.created_at','DESC')

        //getirilecek veriler
        ->get(['periods.period_title','periods.active','projects.title','dissertations.status','dissertations.id','students.name as student_name','dissertations.pdf_url','dissertations.word_url'])

        //ekstra eklemeler
        ->each(function($item){  
            $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
            $item->class = ($item->status == 0 ? "text-white" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
            $item->btn=($item->active ? true : [false,"Aktif olmayan dönem için işlem yapamazsınız!"] );
            
        });
                    
        return view('back.teacher.diss.list',$data);
    }


    public function updateReject(Request $request){
        Dissertation::where('id',$request->id)->update([
            'status'=>2,
            'explain'=>$request->explain
        ]);

        return redirect()->route('teacher.diss.list')->with('status',["Güncelleme işlemi başarılı","success"]);
    }

    public function updateApprove($id){
        Dissertation::where('id',$id)->update([
            'status'=>1,
            'explain'=>null

        ]);
        return redirect()->route('teacher.diss.list')->with('status',["Güncelleme  başarılı","success"]);
    }
}

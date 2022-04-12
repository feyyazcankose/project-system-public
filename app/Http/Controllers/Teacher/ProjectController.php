<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use App\Models\Assign;
use App\Models\Key;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\PeriodTeacher;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    
    public $Keys=array(),$TotalKey=array(),$TotalKey2=0;
    

   

    public function get(Request $request){
        $disabled=isset($request->disabled)!=null ? $request->disabled : false;
        $data['table']=TableStorage::teacherProject($disabled);
        return view('back.teacher.project.list',$data);
    }
    
    
    public function detail($id){
      
       $data['detail']=$this->detailProject($id);

       Key::where('project_id',$id)->each(function ($item) use ($id){
            Key::where('project_id','!=',$id)->where('key',$item->key)->each(function ($item2) use ($item){
                    if(!empty($item2))
                    {
                        $this->TotalKey[$item2->project_id][]=$item->key;
                        $this->TotalKey2++;
                        if(!empty($this->Keys))
                        {
                            $status=true;
                            foreach($this->Keys as $key)
                                if($item2->project_id==$key)
                                    $status=false;
    
                            if($status)
                            array_push($this->Keys,$item2->project_id);
    
                        }
                        else
                            array_push($this->Keys,$item2->project_id);
                    }
            });
        });

        foreach ($this->TotalKey as $key => $value) {
            $this->TotalKey[$key] = implode(', ',$value);
        }
        if($this->TotalKey2>=2)
            $data['similar']=TableStorage::projectSimilar($this->Keys,$this->TotalKey);

        $period=Period::where('active',true)->first();
        $teacherId=Session()->get('user')->id;
        $periodTeacher=PeriodTeacher::where('teacher_id',$teacherId)->where('period_id',$period->id)->first();
        if(isset($periodTeacher)==null)
            $data['disabled']=true;
            
        return view('back.teacher.project.detail',$data);
    }

    public function detailProject($id){
        $data=Project::join("assigns","assigns.id","projects.assign_id")
        ->join("period_students","period_students.id","assigns.period_student_id")
        ->join("students","period_students.student_id","students.id")
        ->where('projects.id',$id)
        ->get(["students.name as student_name","projects.title","projects.material","projects.goal","projects.created_at","students.email","students.student_number","projects.id","students.phone_number"])
        ->each(function($item){
            $item->keys=Key::where('project_id',$item->id)->get(['key'])->toArray();
        })->first();

        return $data;

    }


    public function updateReject(Request $request){
        Project::where('id',$request->id)->update([
            'status'=>2,
            'explain'=>$request->explain
        ]);

        return redirect()->route('teacher.project.list')->with('status',["Güncelleme işlemi başarılı","success"]);
    }

    public function updateApprove($id){
        Project::where('id',$id)->update([
            'status'=>1,
            'explain'=>null

        ]);
        return redirect()->route('teacher.project.list')->with('status',["Güncelleme işlemi başarılı","success"]);

    }

    public function wait(){
        $data['table']=TableStorage::teacherWaitProject();
        return view('back.teacher.project.list',$data);
    }

    public function reject(){
        $data['table']=TableStorage::teacherRejectProject();
        return view('back.teacher.project.list',$data);
    }

    public function approve(){
        $data['table']=TableStorage::teacherApproveProject();
        return view('back.teacher.project.list',$data);
    }
}

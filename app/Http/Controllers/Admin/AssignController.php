<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use Illuminate\Http\Request;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\Period;
use App\Models\PeriodTeacher;
use App\Models\Assign;
use App\Models\PeriodStudent;
use Illuminate\Foundation\Bootstrap\HandleExceptions;

class AssignController extends Controller
{
    
    //Global Variables
    public $students,$teachers,$teacherCount,$studentCount,$period;
    
    
    //This is the constructor method
    public function __construct(){

        $this->period = Period::where('active',true)->first();
        if($this->period!=null)
        {
            $this->teachers=PeriodTeacher::where('period_id',$this->period->id)->join('teachers','teachers.id','period_teachers.teacher_id')->get()->toArray();
            $this->students=PeriodStudent::where('period_id',$this->period->id)->join('students','students.id','period_students.student_id')->get()->toArray();
            $this->teacherCount=count($this->teachers);
            $this->studentCount=count($this->students);
        }
        

    
    }

    //Method task create to view assin
    public function get(){
           

        if(Period::all()->toArray()==null)
        {
            $data['block']="Sistemde kayıtlı dönem bulunamadı. Atama işlemini yapabilmek için lütfen önce dönem ekleyin.";
            $data['route']="admin.period";
            $data['title']="Dönem Ekle";
        }
      
        else if($this->period==null)
        {
            $data['block']="Sistemde seçili dönem bulunamadı. <br> Atama işlemini yapabilmek için lütfen önce dönem seçin.";
            $data['route']="admin.period.list";
            $data['title']="Dönem Seç";
        }
        else if(Assign::join('period_students','period_students.id','period_student_id')
                        ->where('period_students.period_id',$this->period->id)
                        ->get()
                        ->toArray()!=null)
            $data['table'] =TableStorage::assign();
        else if($this->studentCount==0)//öğrenci var mı?
        {
            $data['block']="Sistemde <b>".$this->period->period_title."</b> döneme ait kayıtlı öğrenci bulunamadı. <br> Atama işlemini yapabilmek için lütfen önce öğrenci ekleyin.";
            $data['route']="admin.student.add";
            $data['title']="Öğrenci Ekle";
        }
        else if($this->teacherCount==0)//danışman var mı?
        {
            $data['block']="Sistemde <b>".$this->period->period_title."</b> döneme ait  danışman öğretmen bulunamadı. <br>Atama işlemini yapabilmek için lütfen önce öğretmen ekleyin.";
            $data['route']="admin.teacher.add";
            $data['title']="Öğretmen Ekle";

        }
        else if($this->studentCount>=$this->teacherCount)//öğrenci sayısı danışman sayısından fazla mı?
        {
            $bolum=$this->studentCount/$this->teacherCount;
            if($bolum>10)//Herhangi Bir öğretmene ondan fazla öğrenci düşüyor mu?
            {
                $data['block']="Bir bölüm hocasında <b>en fazla</b> 10 öğrenci olabilir. Öğrenci sayınız fazla ve bölüm hocalarınızın sayısı yetersiz. İkisinden birini değiştirmeyi deneyin";
                $data['route']="admin.teacher.add";
                $data['title']="Öğretmen Ekle";
            }


        }
        
        
     
       
        if($this->period!=null)
        $data["period"]=$this->period->period_title; 


        return view('back.admin.assign',isset($data)?$data:[]);
    }

    //in order assign processs
    public function create(){

       $i=0;$j=0;
        while($this->studentCount>$i){
            if($j>=$this->teacherCount)
                $j=0;
            try {
                $period_student_id=PeriodStudent::where('student_id',$this->students[$i]['id'])->where('period_id',$this->period->id)->first()->id;
                $period_teacher_id=PeriodTeacher::where('teacher_id',$this->teachers[$j]['id'])->where('period_id',$this->period->id)->first()->id;
                $res=Assign::where('period_student_id',$period_student_id)->where('period_teacher_id',$period_teacher_id)->first();
                if($res==null)
                {
                    $response=Assign::create([
                        'period_student_id'=> $period_student_id,
                        'period_teacher_id'=> $period_teacher_id,
                    ]);

                    if($response)
                        $data['status']=['Atama işlemi başarılı','success'];
                    else
                        $data['status']=['Atama işlemi başarısız','danger'];
                }
                else
                    $data['status']=['Atama işlemi önceden yapılmış','success'];
                
                $i++;$j++;
            } catch (HandleExceptions $e) {
                $data['status']=['Atama işlemlerinde hata tespit edildi !','danger'];
                break;
            }
        }
        $data['table']=TableStorage::assign();
        return redirect(route('admin.assign.page'))->with($data);
    }   


}

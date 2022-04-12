<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Form;
use App\Http\Controllers\FormStorage;
use App\Http\Controllers\TableStorage;
use App\Models\Role;
use App\Models\Teacher;

use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Illuminate\Support\Facades\DB;
//These are for sending mails
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoMailTeacher;
use App\Mail\PasswordMail;
use App\Models\Assign;
use App\Models\Dissertation;
use App\Models\Period;
use App\Models\PeriodTeacher;
use App\Models\Project;
use App\Models\Report;

class TeacherController extends Controller
{

    public $error=array();
    public $teacher=array();
    public $teacher_id=array();


    public function get(){
        $data['table']=TableStorage::teacher();
        // $data['all_table']=TableStorage::teacher();

        $period=Period::where('active',true)->first();
        $data['period']=$period->period_title." Öğretmenleri";
        $active=Assign::join('period_students','period_students.id','period_student_id')->where('period_id',$period->id)->first();
        if($active==null)
        {
            $data['form']=FormStorage::teacherForm();
            $data['excel']=FormStorage::teacherExcel();
            $data['system_ex']="admin.teacher.system";
        }
        $data['open']="teacher";

        return view("back.admin.users.list",$data);
    }

    public function add(){
        // $data['all_table']=TableStorage::teacher();
        $data['form']=FormStorage::teacherForm();
        $data['excel']=FormStorage::teacherExcel();
        $data['title']="Yeni Danışman Ekle";
        $data['period']=Period::where('active',true)->first()->period_title." Öğretmenleri";
        $data['system_ex']="admin.teacher.system";
        $data['open']="teacher";

        return view("back.admin.users.add",$data);
    }

    public function create(Request $request){
        $response=false;
        //Validation process for request
        $request->validate(
            [
                'sicil'=>'required|min:4|max:4|unique:teachers',
                'name' => 'required',
                'email'=>'required|email|unique:teachers',
                'appellation' =>'required',
            ]
        );

        $email=$request->email;
        $sicil=$request->sicil;

       
       
        $rand=rand(10000,99999);

        $data = [
        'name' => $request -> name,
        'sicil' => $request -> sicil,
        'rand' => $rand,
      ];

    

            //get active period id from database in periods table

            //Add password and role_id in request
            $request->request->add(['password' => Hash::make($rand)]);
            $request->request->add(['role_id' => Role::where('title','teacher')->first()->id]);

            //create new teacher
            $response=Teacher::create($request->all());
            $period=Period::where('active',true)->first()->id;
            PeriodTeacher::create([
                'teacher_id'=>$response->id,
                'period_id'=>$period
            ]);

            if($response)//is added a new teacher in teacher table?
            {
                $status = ['Kayıt işlemi başarılı' ,'success'];

                //Sending mail upon successfull registiration. This line redirects to the mailable class.
                Mail::to($response) -> send(new InfoMailTeacher($data));

            }
            else
                $status= ['Kayıt işlemi başarısız','danger'];

            return redirect(route('admin.teacher.list'))->with('status',$status);

    }

    public function excel(Request $request){

        //get active period id from database in periods table

        FastExcel::import($request->file('file'),function($line) {
        $rand=rand(10000,99999);
        $email=Teacher::where('email',$line['email'])->first();
        $sicil=Teacher::where('sicil',$line['sicil'])->first();

        $data = [
        'name' => $line['name'],
        'sicil' => $line['sicil'],
        'rand' => $rand,
      ];


        if(isset($email->email) || isset($sicil->email))
        {
            if(isset($email->email))
            $this->error[]='Öğretmen sisteme eklenemedi: <b>'.$line['email']."</b> e-posta adresine  sahip öğrenci sisteminizde mevcut. Eklemek istediğiniz öğretmenin email adresini lütfen tekrar kontrol ediniz.";
            if(isset($sicil->email))
            $this->error[]='Öğretmen sisteme eklenemedi: <b>'.$line['sicil']."</b> sicil numarasına sahip öğretmen sisteminizde mevcut. Eklemek istediğiniz öğretmenin sicil numarasını lütfen tekrar kontrol ediniz.";

        }
        else{

            $create= Teacher::create(
            [
                'sicil' => $line['sicil'],
                'name' =>  $line['name'],
                'appellation' =>  $line['appellation'],
                'email' =>  $line['email'],
                'password' => Hash::make($rand),
                'role_id'=>2
            ]
            );
            $period=Period::where('active',true)->first()->id;
            PeriodTeacher::create([
                'teacher_id'=>$create->id,
                'period_id'=>$period
            ]);
            if($create)
            {
              //Sending mail upon successfull import. This line redirects to the mailable class.
              Mail::to($line['email']) -> send(new InfoMailTeacher($data));

            }

                return $create;
            }

            });

            $status=$this->error!=null? [$this->error,"danger"] : ["Kayıt Başarılı.","success"];
            return redirect(route('admin.teacher.list'))->with('status',$status);


    }

    public function getOld(){
        $period=Period::where('active',true)->first();
        $data['items']=PeriodTeacher::where('period_id','!=',$period->id)
        ->join('teachers','period_teachers.teacher_id','teachers.id')
        ->join('periods','periods.id','period_teachers.period_id')
        ->each(function ($item) use ($period) {
            $student=PeriodTeacher::where('teacher_id',$item->teacher_id)->where('period_id',$period->id)->first();
           if($student==null)
           {
            if($this->teacher==null || !in_array($item->teacher_id,$this->teacher_id))
            {
                $this->teacher_id[]=$item->teacher_id;
                $this->teacher[$item->teacher_id]=["id"=>$item->teacher_id,"name"=>$item->name,"periods"=>[$item->period_title],"sicil"=>$item->sicil];

            }
            else
                array_push($this->teacher[$item->teacher_id]["periods"],$item->period_title);
           }
        });
        return view("back.admin.system_ex.teacher",['items'=>$this->teacher,'active_period'=> $period->period_title]);
    }

    public function createOld(Request $request){
        $period=Period::where('active',true)->first()->id;
        if(isset($request->check))
        {
            foreach($request->check as $id )
            {
                PeriodTeacher::create([
                    'teacher_id'=>$id,
                    'period_id'=>$period
                ]);
            }
            $status = ['Kayıt işlemi başarılı' ,'success'];

        }
        else
        $status = ['Kayıt işlemi başarısız. Öğretmen seçilmedi' ,'danger'];

        return redirect(route('admin.teacher.list'))->with('status',$status);
    }
}

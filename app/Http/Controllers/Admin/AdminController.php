<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FormStorage;
use App\Http\Controllers\TableStorage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//Models
use App\Models\Admin;
use App\Models\Student;
use App\Models\Role;

//These are for sending mails
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoMailAdmin;
use App\Models\Dissertation;
use App\Models\Period;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\Facades\FastExcel;


class AdminController extends Controller
{

    public $error=array();

    public function home(){

        $user = Session()->get('user');
      //  $ogrenciSayisi=Student::where("id",$user->id)->first();
        $period=Period::where('active',true)->first();
     
        $project = new Project;
        $report = new Report;
        $diss = new Dissertation;

    
        
        

        
        // $son5ogrenci = DB::table('dissertations')->take(5)->get();
        //öneriler için
        if(isset($period->id)!=null)
        {
        
        $ogrenciSayisi = count(DB::table('period_students')->where('period_id',$period->id)->get()->toArray());
        $ogretmenSayisi = count(DB::table('period_teachers')->where('period_id',$period->id)->get()->toArray());
        
        
        
        $projectList=$project
        ->join('assigns','assigns.id','projects.assign_id')
        ->join('period_students','period_students.id','assigns.period_student_id')
        ->join('period_teachers','period_teachers.id','assigns.period_teacher_id')
        ->join('students','students.id','period_students.student_id') 
        ->join('teachers','teachers.id','period_teachers.teacher_id') 
        ->join('periods','periods.id','period_students.period_id')
        ->where('periods.active',1);

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
        ->where('periods.active',1);

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
        ->where('periods.active',1);
        

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
            $ogretmenSayisi=0;
            $projectCount=0;
            $dissCount=0;
            $reportCount=0;
            $son5ogrenci=0;
            $projectList=null;
            $reportList=null;
            $dissList=null;
            $period="Oluşturulmadı!";
        }    


        $dizi = [
            "ogrenciSayisi"=>$ogrenciSayisi,
            "ogretmenSayisi"=>$ogretmenSayisi,
            "projeSayisi"=>$projectCount,
            "raporSayisi"=>$reportCount,
            "tezSayisi"=>$dissCount,
            // "son5Ogrenci"=>$son5ogrenci,
            "project"=>$projectList,
            "report"=>$reportList,
            "diss"=>$dissList,
            "period"=>$period,
            "user_name"=>$user->name
        ];

       
        return view("back.admin.home",$dizi);
    }


    public function get(){

        $data['table']=TableStorage::admin();
        $data['excel']=FormStorage::adminExcel();
        $data['form']=FormStorage::adminForm();
        $data['open']="admin";

        return view("back.admin.users.list",$data);

    }
    public function add(){
        $data['excel']=FormStorage::adminExcel();
        $data['form']=FormStorage::adminForm();
        $data['title']="Yeni Yönetici Ekle";
        $data['open']="admin";
        return view("back.admin.users.add",$data);
    }

    public function create(Request $request){
        $response=false;
        //this request validation
        $request->validate([
            'email' =>'email|required|unique:teachers',
            'name' =>'required',
            'appellation' =>'required',
        ]);

        $rand=rand(10000,99999);

        $data = [
        'name' => $request -> name,
        'email' => $request -> email,
        'rand' => $rand,
        ];

        //is has admin table mail with requeset
        if(Admin::where('email',$request->email))
        {
            //add password and role_id in the request attribute
            $request->request->add(['password' => Hash::make($rand)]);
            $request->request->add(['role_id' => Role::where('title','admin')->first()->id]);

            //create new row in db table admin
            $response =Admin::create($request->all());
        }
        else //use the mail in admin table
            $status=["E posta adresi kullanımda."];


        if($response)//is added a new admin in admin table?
        {
            $status = ['Kayıt işlemi başarılı' ,'success'];

            //Sending mail upon successfull registiration. This line redirects to the mailable class.
            Mail::to($response) -> send(new InfoMailAdmin($data));
        }
        else
            $status= ['Kayıt işlemi başarısız','danger'];

        return redirect(route('admin.admin.list'))->with('status',$status);

    }
    public function up(Request $request){

    }

    public function excel(Request $request){

        FastExcel::import($request->file('file'),function($line) {
        $rand=rand(10000,99999);
        $email=Admin::where('email',$line['email'])->first();

        $data = [
        'name' => $line['name'],
        'email' => $line['email'],
        'rand' => $rand,
      ];


        if(isset($email->email))
        {
            if(isset($email->email))
            $this->error[]='Admin sisteme eklenemedi: <b>'.$line['email']."</b> e-posta adresine  sahip admin sisteminizde mevcut. Eklemek istediğiniz adminin email adresini lütfen tekrar kontrol ediniz.";

        }
        else{

            $create= Admin::create(
            [
                'name' =>  $line['name'],
                'appellation' =>  $line['appellation'],
                'email' =>  $line['email'],
                'password' => Hash::make($rand),
                'role_id'=>1
            ]
            );

            if($create)
            {
                //Sending mail upon successfull import. This line redirects to the mailable class.
                Mail::to($line['email']) -> send(new InfoMailAdmin($data));

            }

                return $create;
            }

            });

            $status=$this->error!=null? [$this->error,"danger"] : ["Kayıt Başarılı.","success"];
            return redirect(route('admin.admin.list'))->with('status',$status);


    }
}

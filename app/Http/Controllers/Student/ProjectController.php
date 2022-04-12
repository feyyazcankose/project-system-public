<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use App\Models\Project;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\Key;
use App\Models\Assign;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public $User;
    public $ActivePeriod;
    public $PeriodStudent;
    public $Assign;
    public $Keys=array();
    private  $responses=array();
    private  $benzer=0;


    public function get(){
        $data['table']=TableStorage::studentProject();
        return view('back.student.project.list',$data);
    }

    public function add(Request $request){
        return view('back.student.project.add');
    }

    public function create(Request $request){


        //validation
        $request->validate([
            "title"=>"required",
            "goal"=>"min:200|required|max:500",
            "material"=>"min:300|required|max:500",
            "keys"=>"required"
        ]);
        //validate keys 
        $data['keys']=$request->keys;
        foreach ($request->keys as $key=>$value)        
         if($value==null)
          $data['key_index'][]=$key;

        if(isset($data['key_index']))
        {
            $data['error_key']="Anahtar kelime 5 adet olmak zorunda!";
            return redirect()->back()->withInput()->with($data);
        }

        //text search kısmı olacak
        $similarMeterial=$this->similarRate($request->material,"material");
        $similarGoal=$this->similarRate($request->goal,"goal");

        if($similarGoal<=30 && $similarMeterial<=30)//eklenebilir.
        {
            $this->getInfo();
            $request->request->add(['assign_id' => $this->Assign->id]);
            $response=Project::create($request->all());

            if($response)
            {
                foreach($request->keys as $key)
                {
                    Key::create([
                        'project_id'=>$response->id,
                        'key'=> $key
                    ]);
                }

                $data=["Tebrikler proje önerisinde bulundunuz. 👏👏","success"];

            }
            else
                $data=["Proje önerisinde bulunulamadı !","danger"];


            //email kısmı
            


            return redirect()->route('student.project.list')->with('status',$data);
        }
        else//eklenemez
        {
            $data['success']['title']="Başlık başarılı";
            $data['success']['keys']="Anahtar kelimeler başarılı";
            
            if($similarGoal>30)//amaç 30 üstü ise hata yazdır.
            {
                $goalError="Projenin amacı sistemdeki diğer projeler ile <b>%".round($similarGoal)."</b> oranında benzer. Benzerlik oranı %30 altında olamalı!";
                $data['goal']=$goalError;
            }
            else
                $data['success']['goal']="Projenin amacı başarılı. Benzerlik oranı: <b>%".round($similarGoal)."</b>";
            
            
            
            if($similarMeterial>30)//meterial 30 üstü ise hata yazdır.
            {
                $meterialError="Projenin materyal, yöntem ve araştırma olanakları sistemdeki diğer projeler ile <b>%".round($similarMeterial)."</b> oranında benzer. Benzerlik oranı %30 altında olamalı!";
                $data['meterial']=$meterialError;
            }
            else
                $data['success']['meterial']="Projenin materyal, yöntem ve araştırma olanakları başarılı. Benzerlik oranı: <b>%".round($similarMeterial)."</b>";



            return redirect()->back()->withInput()->with($data);
        }
    }

  
    private function similarRate($search,$col){
        if(!empty($search)){
            // $response = Project::where($col, $search)->get()->toArray();
            $response=$this->algolia($search,$col);
            if(!empty($response))//Tamamı başka yerde geçiyor mu?
                return 100;
            else//Tamamı başka yerde geçmiyorsa
            {

                $sentences= explode('. ', str_replace("\r\n",' ',$search));//cümleleri ayırıyoruz.
                foreach ($sentences as $key => $sentence) {//cümleleri tek tek aratıyoruz.
                    if(!empty($sentence)) {
                        $response=$this->algolia($sentence,$col);
                        if(!empty($response))
                        {
                            $this->benzer+=strlen($sentence);
                            $this->responses['sentence'][]=[$sentence=>$response];

                        }
                        else//cümle benzemiyor o halde cümlenin kelimelerine bakalım.
                        {
                            $words=explode(' ',$sentence);
                            foreach($words as $word)
                            {
                                $response=$this->algolia($word,$col);
                                if(!empty($response))
                                {
                                    $this->benzer+=strlen($word);
                                    $this->responses['words'][]=[$word=>$response];
                                }

                            }
                        }
                    }
                }
            }
            if(!empty($this->responses))//Benzerlik oranı hesaplama
            {

                // dd(...[$similar,$this->responses,$this->benzer,strlen($search)]);
                return ($this->benzer*100)/strlen($search);
            }
            else
                return 0;
        }
    }

    private function algolia($item,$lang){
        $response = Project::search($item, function ($algolia, $query, $options) use ($lang) {
            $options = array_merge($options, [
                'restrictSearchableAttributes' => [$lang],
            ]);

            return $algolia->search($query, $options);
        })->get()->toArray();
        if(!empty($response))
            return $response;
    }

    

    public function detail($id){
        $data['table']=TableStorage::studentProject();
        $data['detail']=Project::join("assigns","assigns.id","projects.assign_id")
                                ->join("period_teachers","period_teachers.id","assigns.period_teacher_id")
                                ->join("teachers","period_teachers.teacher_id","teachers.id")
                                ->where('projects.id',$id)
                                ->get(["teachers.name as teacher_name","projects.explain","projects.title","projects.material","projects.goal","projects.created_at","teachers.email","teachers.appellation","projects.id"])
                                ->each(function($item){
                                    $item->keys=Key::where('project_id',$item->id)->get(['key'])->toArray();
                                })->first();
        return view('back.student.project.detail',$data);
    }

    public function getInfo(){
        $this->User = session()->get('user');
        $this->ActivePeriod=Period::where('active',1)->first(); //aktif dönem
        $this->PeriodStudent=PeriodStudent::where('period_id',$this->ActivePeriod->id)->where('student_id',$this->User->id)->first();//period student id
        if($this->PeriodStudent!=null)
            $this->Assign=Assign::where('period_student_id',$this->PeriodStudent->id)->first(); //assign get
        




    }

}

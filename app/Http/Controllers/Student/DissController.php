<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use App\Models\Dissertation;
use App\Models\FileSystem;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;

class DissController extends Controller
{
    public $User;
    public $ActivePeriod;
    public $PeriodStudent;
    public $Assign;
    public $Project;
    public $Report;
    public $Keys = array();


    public function get()
    {
        // $this->getInfo();
        $user = session()->get('user');
        $diss = new Dissertation();
        $data['items'] = $diss
            //Rapora bağlanmak
            ->join('reports', 'reports.id', 'dissertations.report_id')

            //Proje bağlanmak
            ->join('projects', 'projects.id', 'reports.project_id')

            //assign bağlanmak
            ->join('assigns', 'assigns.id', 'projects.assign_id')

            //teacher bağlanmak
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrenci bağlanmak
            ->join('period_students', 'period_students.id', 'assigns.period_student_id')
            ->join('students', 'students.id', 'period_students.student_id')

            //Peirodu almak
            ->join('periods', 'periods.id', 'period_students.period_id')

            //koşullar
            ->where('projects.status', 1)
            ->where('students.id', $user->id)

            //Sıralama
            ->orderBy('dissertations.created_at', 'desc')


            //Getirilecekleri belirlemek
            ->get(['periods.period_title', 'projects.title', 'dissertations.explain', 'dissertations.status', 'dissertations.id', 'teachers.name as teacher_name', 'dissertations.word_url', 'dissertations.pdf_url'])

            ///Ekler
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
            });

        // dd($data);
        return view('back.student.diss.list', $data);
    }

    public function add(Request $request)
    {
        $data['title'] = $request->project->title;
        return view('back.student.diss.add', $data);
    }

    public function create(Request $request)
    {
        $this->getInfo();
        $request->validate([
            'file' => "required|array|min:2|max:2"
        ]);


        //project id
        $user = $this->User;
        $fileUserName = $this->fileName($user->name);
        $fileNames = array();


        foreach ($request->file as  $value) {
            //file upload
            $prefix = $fileUserName . '_' . $user->student_number;
            $fileExtension = $value->getClientOriginalExtension();
            $fileName = $prefix . '_' . rand(111111, 999999) . '.' . $fileExtension;
            $upload = $value->move(public_path('documents_diss_' . $prefix), $fileName);
            $fileNames[] = $prefix . '\\' . $fileName;
        }

        if ($upload) {
            Dissertation::create([
                'report_id' => $this->Report->id,
                'pdf_url' => $fileNames[0],
                'word_url' => $fileNames[1]
            ]);
        }

        return redirect()->route('student.diss.list')->with('status', ['Tez yükleme başarılı', 'success']);
    }

    public function getInfo()
    {
        $this->User = session()->get('user');
        $this->ActivePeriod = Period::where('active', true)->first(); //aktif dönem
        $this->PeriodStudent = PeriodStudent::where('period_id', $this->ActivePeriod->id)->where('student_id', $this->User->id)->first(); //period student id
        if ($this->PeriodStudent != null) {
            $this->Assign = Assign::where('period_student_id', $this->PeriodStudent->id)->first(); //assign get
            $this->Project = Project::where('assign_id', $this->Assign->id)->orderBy('created_at', 'DESC')->first(); // project get
            $this->Report = Report::where('project_id', $this->Project->id)->orderBy('created_at', 'DESC')->first(); // project get
        }
    }


    public function fileName($file)
    {
        $file = strtolower($file);
        $search  = array('ı', 'İ', 'ü', 'Ü', 'ö', 'Ö', 'ğ', 'Ğ', 'ç', 'Ç', ' ');
        $replace = array('i', 'i', 'u', 'u', 'o', 'o', 'g', 'g', 'c', 'c', '_');
        return str_replace($search, $replace, $file);
    }
}

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use App\Models\Assign;
use App\Models\FileSystem;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\Project;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public $User;
    public $ActivePeriod;
    public $PeriodStudent;
    public $Assign;
    public $Project;
    public $Keys = array();


    public function get()
    {
        // $this->getInfo();
        $user = session()->get('user');

        $repot = new Report();

        $data['items'] = $repot

            //proje öneri tablosundan asign almak için
            ->join('projects', 'projects.id', 'reports.project_id')
            ->join('assigns', 'assigns.id', 'projects.assign_id')

            //teacher ulaşmak
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Student ulaşmak
            ->join('period_students', 'period_students.id', 'assigns.period_student_id')
            ->join('students', 'students.id', 'period_students.student_id')

            //Bulunduğu periodları almak
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //koşullar
            ->where('projects.status', 1)
            ->where('students.id', $user->id)

            //sıralı yazdırmak
            ->orderBy('reports.created_at', 'desc')

            //getirilecek veriler
            ->get(['projects.title', 'reports.status', 'reports.explain', 'reports.id', 'teachers.name as teacher_name', 'periods.period_title'])

            //raporları tek tek almak için
            ->each(function ($item) {
                $item->file = FileSystem::where('report_id', $item->id)->get(['file_url'])->toArray();
                $item->case = strtoupper(($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : ''))));
                $item->class = ($item->status == 0 ? "text-dark" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
            });


        return view('back.student.report.list', $data);
    }

    public function add(Request $request)
    {
        $data['title'] = strtoupper($request->project->title);
        return view('back.student.report.add', $data);
    }

    public function create(Request $request)
    {
        $this->getInfo();
        $request->validate([
            'file' => "required|array|min:6|max:6"
        ]);


        //project id
        $user = $this->User;
        $fileUserName = $this->fileName($user->name);
        $repot = Report::create([
            'project_id' => $this->Project->id,
            'status' => 0
        ]);
        foreach ($request->file as  $value) {
            //file upload
            $prefix = $fileUserName . '_' . $user->student_number;
            $fileExtension = $value->getClientOriginalExtension();
            $file_name = $prefix . '_' . rand(111111, 999999) . '.' . $fileExtension;
            $upload = $value->move(public_path('documents_reports_' . $prefix), $file_name);
            if ($upload) {
                FileSystem::create([
                    'report_id' => $repot->id,
                    'file_url' => $prefix . '\\' . $file_name
                ]);
            }
        }


        return redirect()->route('student.report.list')->with('status', ['Rapor yükleme başarılı', 'success']);
    }

    public function getInfo()
    {
        $this->User = session()->get('user');
        $this->ActivePeriod = Period::where('active', true)->first(); //aktif dönem
        $this->PeriodStudent = PeriodStudent::where('period_id', $this->ActivePeriod->id)->where('student_id', $this->User->id)->first(); //period student id
        if ($this->PeriodStudent != null) {
            $this->Assign = Assign::where('period_student_id', $this->PeriodStudent->id)->first(); //assign get
            $this->Project = Project::where('assign_id', $this->Assign->id)->orderBy('created_at', 'desc')->first(); // project get
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

<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableStorage;
use App\Models\Dissertation;
use App\Models\FileSystem;
use App\Models\Period;
use App\Models\PeriodTeacher;
use App\Models\Report;
use Illuminate\Http\Request;

class TeacherUserController extends Controller
{

  public function get()
  {
    $user = session()->get('user');

    $activePeriod = Period::where('active', true)->first(); //aktif dönem

    $periodTeacher = PeriodTeacher::where('period_id', $activePeriod->id)->where('teacher_id', $user->id)->first(); //period student id

    if (isset($periodTeacher->id) != null) {
      $data["table"] = TableStorage::teacherUsers();
      return view('back.teacher.users', $data);
    }

    $data['explain'] = "<b>" . $activePeriod->period_title . "</b> döneminde size öğrenci atanmadı.";
    return redirect()->route('teacher.error')->with('error', $data);
  }

  public function userProject($id)
  {

    $data["table"] = TableStorage::studentIdProject($id);
    return view('back.teacher.users', $data);
  }

  public function userReport($id)
  {
    $user = session()->get('user');
    $reports = new Report;

    $data['items'] = $reports
      //proje bağlama
      ->join('projects', 'projects.id', 'reports.project_id')
      //atama bağlama
      ->join('assigns', 'assigns.id', 'projects.assign_id')
      //periof teacher bağlama
      ->join('period_teachers', 'period_teachers.id', 'assigns.period_student_id')



      //students getirme
      ->join('period_students', 'period_students.id', 'assigns.period_student_id')
      ->join('students', 'students.id', 'period_students.student_id')

      //dönemi getirelim

      ->join('periods', 'periods.id', 'period_teachers.period_id')


      //koşullar
      ->where('period_teachers.teacher_id', $user->id)
      ->where('students.id', $id)
      ->where('projects.status', 1)

      //sıralama
      ->orderBy('reports.created_at', 'DESC')

      //getirilecek veriler
      ->get(['periods.period_title', 'periods.active', 'projects.title', 'reports.status', 'reports.id', 'students.name as student_name'])

      //ekstra eklemeler
      ->each(function ($item) {
        $item->file = FileSystem::where('report_id', $item->id)->get(['file_url'])->toArray();
        $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
        $item->class = ($item->status == 0 ? "text-dark" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
        $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
      });


    return view('back.teacher.report.list', $data);
  }

  public function userDiss($id)
  {
    $user = session()->get('user');
    $diss = new Dissertation;

    $data['items'] = $diss
      //report ile bağlama
      ->join('reports', 'reports.id', 'dissertations.report_id')
      //proje bağlama
      ->join('projects', 'projects.id', 'reports.project_id')
      //atama bağlama
      ->join('assigns', 'assigns.id', 'projects.assign_id')
      //period teacher bağlama
      ->join('period_teachers', 'period_teachers.id', 'assigns.period_student_id')



      //students getirme
      ->join('period_students', 'period_students.id', 'assigns.period_student_id')
      ->join('students', 'students.id', 'period_students.student_id')

      //dönemi getirelim

      ->join('periods', 'periods.id', 'period_teachers.period_id')


      //koşullar
      ->where('period_teachers.teacher_id', $user->id)
      ->where('students.id', $id)
      ->where('projects.status', 1)

      //sıralama
      ->orderBy('dissertations.created_at', 'DESC')

      //getirilecek veriler
      ->get(['periods.period_title', 'periods.active', 'projects.title', 'dissertations.status', 'dissertations.id', 'students.name as student_name', 'dissertations.pdf_url', 'dissertations.word_url'])

      //ekstra eklemeler
      ->each(function ($item) {
        $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
        $item->class = ($item->status == 0 ? "text-dark" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
        $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
      });

    return view('back.teacher.diss.list', $data);
  }
}

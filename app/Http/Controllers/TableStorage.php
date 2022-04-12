<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Table;
use App\Models\Admin;
use App\Models\Assign;
use App\Models\FileSystem;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Period;
use App\Models\PeriodStudent;
use App\Models\PeriodTeacher;
use App\Models\Project;
use App\Models\Report;

class TableStorage extends Controller
{

    /**
     * 
     * Admin Prosess Table
     * 
     */

    //Sistemdeki Yöneticileri Getiriyor
    static public function admin()
    {
        $table = new Table();
        $table->columns = [
            'Ad Soyad',
            'Ünvan',
            'Email',
        ];
        $table->rows = ['name', 'appellation', 'email'];
        $table->items = Admin::all($table->rows);

        return $table->create();
    }


    //Sistemdeki Öğretmeneleri Getiriyor
    static public function teacher()
    {
        $table = new Table();
        $table->columns = [
            'Ad Soyad',
            'Email',
            'Sicil',
            'Ünvan'
        ];
        $period = Period::where('active', true)->first()->id;
        $table->rows = ['name', 'email', 'sicil', 'appellation'];
        $table->items = PeriodTeacher::where('period_id', $period)->join('teachers', 'teachers.id', '=', 'period_teachers.teacher_id')->get();
        return $table->create();
    }


    //Sistemdeki Öğrencileri Getiriyor
    static public function student()
    {
        $period = Period::where('active', true)->first()->id;
        $table = new Table();
        $table->columns = [
            'Öğrenci Numarası',
            'TCKN',
            'Ad Soyad',
            'Email',
            'Okul',
            'Fakülte',
            'Bölüm'
        ];
        $table->rows = ['student_number', 'tc', 'name', 'email', 'university', 'faculty', 'departman'];
        $table->items = PeriodStudent::where('period_id', $period)->join('students', 'students.id', '=', 'period_students.student_id')->get();


        return $table->create();
    }


    //Sistemdeki Atama işlemini Getiriyor
    static public function assign()
    {
        $period = Period::where('active', true)->first()->id;
        $table = new Table();
        $table->columns = [
            'Danışman Ad Soyad',
            'Danışman Sicil Numarası',
            'Öğrenci Ad Soyad',
            'Öğrenci Numarası',
        ];
        $table->rows = ['teacher_name', 'sicil', 'student_name', 'student_number'];
        $table->items = Assign::join('period_students', 'period_students.id', 'period_student_id')
            ->join('period_teachers', 'period_teachers.id', 'period_teacher_id')
            ->join('students', 'students.id', 'period_students.student_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')
            ->where('period_students.period_id', $period)->
            // ->select('teachers.name as teacher_name','teachers.sicil','students.name as student_name','students.student_number')
            get(['teachers.name as teacher_name', 'teachers.sicil', 'students.name as student_name', 'students.student_number'])->toArray();
        return $table->create();
    }



    /**
     * 
     * Students Prosess Table
     * 
     */


    //Öğrenciye kendi önerilerini gösteriyor
    static public function studentProject()
    {

        $user = session()->get('user');
        $table = new Table();
        $table->columns = [
            'Proje Başlığı',
            'Proje Durumu',
            'Dönem',
            'Proje Tarihi',
            'Danışman Hoca',
            'Açıklama',
        ];
        $table->rows = ['title', 'case', 'period_title', 'created_at', 'teacher_name', 'explain'];

        $table->items =   PeriodStudent::join('assigns', 'assigns.period_student_id', 'period_students.id')
            ->join("period_teachers", "period_teachers.id", "assigns.period_teacher_id")
            ->join('periods', 'periods.id', 'period_students.period_id')
            ->join("teachers", "period_teachers.teacher_id", "teachers.id")
            ->join('projects', 'projects.assign_id', 'assigns.id')
            ->where('student_id', $user->id)
            ->orderBy('projects.created_at', 'desc')
            ->get(['projects.title', 'projects.goal', "projects.created_at", 'projects.explain', 'projects.material', 'projects.status', 'periods.period_title', "teachers.name as teacher_name", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "" : ($item->status == 1 ? "text-success" : ($item->status == 2 ? "text-danger" : '')));
                $item->route = "student.project.detail";
                $item->explain = $item->explain != null ? substr($item->explain, 0, 20) . '...' : 'Açıklama Yok';
                $item->btn = "Detay";
            });



        $table->btns = [
            [
                "name" => "Detay",
                "route" => "student.project.detail",
                "class" => "btn btn-primary"
            ]
        ];


        return $table->create();
    }

    //Öğrenciye Kendi yüklediği raporları gösteriyor
    static public function studentReport()
    {

        $user = session()->get('user');

        $activePeriod = Period::where('active', true)->first(); //aktif dönem

        $periodStudent = PeriodStudent::where('period_id', $activePeriod->id)->where('student_id', $user->id)->first(); //period student id

        if ($periodStudent != null)
            $assign = Assign::where('period_student_id', $periodStudent->student_id)->first(); //assign get

        $table = new Table();
        $table->columns = [
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Danışman Hoca',
            'Detay Görüntüle'
        ];
        $table->rows = ['title', 'case', 'created_at', 'teacher_name', 'action'];

        $table->items = Report::join('projects', 'projects.id', 'reports.project_id')
            ->where('projects.status', 1)->get(['projects.title', 'reports.status', 'reports.id'])
            ->each(function ($item) {
                $item->file = FileSystem::where('report_id', $item->id)->get();
            });


        dd($table->items);

        $table->columns = [
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
        ];
        $table->rows = ['title', 'case', 'created_at', 'student_name', 'student_number'];
        $table->items = Project::join("assigns", "assigns.id", "projects.assign_id")
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")
            ->where('assign_id', $assign->id)
            ->get(["projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
            });


        $table->btns = [
            [
                "name" => "Detay",
                "route" => "student.project.detail",
                "class" => "btn btn-primary"
            ]
        ];


        return $table->create();
    }


    /**
     * 
     * Teacher Prosess Table
     * 
     */



    //Öğretemene gönderilen tüm projeleri getiriyor
    static public function teacherProject($disabled = false)
    {

        $user = session()->get('user');

        $period = Period::where('active', true)->first();





        $table = new Table();
        $table->columns = [
            'Dönem',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
        ];
        $table->rows = ['period_title', 'title', 'case', 'created_at', 'student_name', 'student_number'];


        $assign = new Assign;
        $table->items = $assign
            //teacher getirmek
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrencileri almak
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")

            //Dönemi alalım
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //project bağlamak
            ->join('projects', 'projects.assign_id', "assigns.id")

            //koşullar
            ->where('teachers.id', $user->id)
            // ->where('')

            //sıralama
            ->orderBy('projects.created_at', 'DESC')


            ->get(["periods.period_title", "periods.active", "projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white " : ($item->status == 1 ? "text-success " : ($item->status == 2 ? "text-danger " : '')));
                $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
            });


        //  dd($table->items);


        // $table->action = "teacher.project.form";
        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-info"
            ],
            [
                "name" => "Onay",
                "route" => "teacher.project.up.approve",
                "class" => "btn btn-success"
            ],
            [
                "name" => "Red",
                "route" => "teacher.project.explain",
                "class" => "btn btn-danger",
                "form" => true
            ]


        ];

        return $table->create();
    }

    //Öğretemenin kabul ettiği tüm projeleri getiriyor
    static public function teacherApproveProject()
    {

        $user = session()->get('user');


        $table = new Table();
        $table->columns = [
            'Dönem',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
        ];
        $table->rows = ['period_title', 'title', 'case', 'created_at', 'student_name', 'student_number'];


        $assign = new Assign;
        $table->items = $assign
            //teacher getirmek
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrencileri baülamak
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")

            //Dönemi alalım
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //project bağlamak
            ->join('projects', 'projects.assign_id', "assigns.id")

            //koşullar
            ->where('teachers.id', $user->id)
            ->where('projects.status', 1)

            //sıralama
            ->orderBy('projects.created_at', 'DESC')


            ->get(["periods.period_title", "periods.active", "projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white " : ($item->status == 1 ? "text-success " : ($item->status == 2 ? "text-danger " : '')));
                $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
            });



        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-primary"
            ],
            [
                "name" => "Onay",
                "route" => "teacher.project.up.approve",
                "class" => "btn btn-success"
            ],
            [
                "name" => "Red",
                "route" => "teacher.project.explain",
                "class" => "btn btn-danger",
                "form" => true
            ]

        ];


        return $table->create();
    }
    //Öğretemenin Red ettiği tüm projeleri getiriyor
    static public function teacherRejectProject()
    {

        $user = session()->get('user');


        $table = new Table();
        $table->columns = [
            'Dönem',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
        ];
        $table->rows = ['period_title', 'title', 'case', 'created_at', 'student_name', 'student_number'];


        $assign = new Assign;
        $table->items = $assign
            //teacher getirmek
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrencileri baülamak
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")

            //Dönemi alalım
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //project bağlamak
            ->join('projects', 'projects.assign_id', "assigns.id")

            //koşullar
            ->where('teachers.id', $user->id)
            ->where('projects.status', 2)

            //sıralama
            ->orderBy('projects.created_at', 'DESC')


            ->get(["periods.period_title", "periods.active", "projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white " : ($item->status == 1 ? "text-success " : ($item->status == 2 ? "text-danger " : '')));
                $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
            });



        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-primary"
            ],
            [
                "name" => "Onay",
                "route" => "teacher.project.up.approve",
                "class" => "btn btn-success"
            ],
            [
                "name" => "Red",
                "route" => "teacher.project.explain",
                "class" => "btn btn-danger",
                "form" => true
            ]

        ];


        return $table->create();
    }
    //Öğretemenin Beklemeye aldığı tüm projeleri getiriyor
    static public function teacherWaitProject()
    {

        $user = session()->get('user');


        $table = new Table();
        $table->columns = [
            'Dönem',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
        ];
        $table->rows = ['period_title', 'title', 'case', 'created_at', 'student_name', 'student_number'];


        $assign = new Assign;
        $table->items = $assign
            //teacher getirmek
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrencileri baülamak
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")

            //Dönemi alalım
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //project bağlamak
            ->join('projects', 'projects.assign_id', "assigns.id")

            //koşullar
            ->where('teachers.id', $user->id)
            ->where('projects.status', 0)

            //sıralama
            ->orderBy('projects.created_at', 'DESC')


            ->get(["periods.period_title", "periods.active", "projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white " : ($item->status == 1 ? "text-success " : ($item->status == 2 ? "text-danger " : '')));
                $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
            });



        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-primary"
            ],
            [
                "name" => "Onay",
                "route" => "teacher.project.up.approve",
                "class" => "btn btn-success"
            ],
            [
                "name" => "Red",
                "route" => "teacher.project.explain",
                "class" => "btn btn-danger",
                "form" => true
            ]
        ];


        return $table->create();
    }
    //Öğretmene atanan tüm öğrencileri getiriyor
    static public function teacherUsers()
    {

        $user = session()->get('user');

        $assign = new Assign;

        $activePeriod = Period::where('active', true)->first(); //aktif dönem

        $periodTeacher = PeriodTeacher::where('period_id', $activePeriod->id)->where('teacher_id', $user->id)->first(); //period student id

        $table = new Table();
        $table->columns = [
            'Öğrenci Numarası',
            'Öğrenci Adı',
            'Öğrenci TCKN',
            'Bölümü',
        ];
        $table->rows = ['student_number', 'name', 'tc', 'departman'];

        $table->items = $assign
            //teacher
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //period
            ->join('periods', 'periods.id', 'period_teachers.period_id')


            //student
            ->join('period_students', 'period_students.id', 'assigns.period_student_id')
            ->join('students', 'students.id', 'period_students.student_id')


            //koşullar
            ->where('periods.active', 1)

            ->get(["students.student_number", "students.name", "students.tc", "students.departman", "students.id as action"]);



        $table->btns = [
            [
                "name" => "Önerileri",
                "route" => "teacher.project.user",
                "class" => "btn btn-primary"
            ],
            [
                "name" => "Raporları",
                "route" => "teacher.report.user",
                "class" => "btn btn-info"
            ],
            [
                "name" => "Tezleri",
                "route" => "teacher.diss.user",
                "class" => "btn btn-danger"
            ],
        ];

        return $table->create();
    }

    //Öğretmene atanan tüm öğrencilerinin tek tek önerilerini getiriyor
    static public function studentIdProject($id)
    {
        $user = session()->get('user');

        $table = new Table();
        $table->columns = [
            'Dönem',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
        ];
        $table->rows = ['period_title', 'title', 'case', 'created_at', 'student_name'];

        $assign = new Assign;
        $table->items = $assign
            //teacher getirmek
            ->join('period_teachers', 'period_teachers.id', 'assigns.period_teacher_id')
            ->join('teachers', 'teachers.id', 'period_teachers.teacher_id')

            //Öğrencileri baülamak
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("students", "period_students.student_id", "students.id")

            //Dönemi alalım
            ->join('periods', 'periods.id', 'period_teachers.period_id')

            //project bağlamak
            ->join('projects', 'projects.assign_id', "assigns.id")

            //koşullar
            ->where('teachers.id', $user->id)
            ->where('students.id', $id)
            // ->where('')

            //sıralama
            ->orderBy('projects.created_at', 'DESC')


            ->get(["periods.period_title", "periods.active", "projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "projects.id as action"])
            ->each(function ($item) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                $item->class = ($item->status == 0 ? "text-white " : ($item->status == 1 ? "text-success " : ($item->status == 2 ? "text-danger " : '')));
                $item->btn = ($item->active ? true : [false, "Aktif olmayan dönem için işlem yapamazsınız!"]);
            });


        // dd($table->items);


        // $table->action = "teacher.project.form";

        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-info"
            ],
            [
                "name" => "Onay",
                "route" => "teacher.project.up.approve",
                "class" => "btn btn-success"
            ],
            [
                "name" => "Red",
                "route" => "teacher.project.explain",
                "class" => "btn btn-danger",
                "form" => true
            ]


        ];

        return $table->create();
    }

    //Benzer projedeki kelimelerin listesini gösteren table 
    static public function projectSimilar($projectId, $similarKeys)
    {
        $user = session()->get('user');

        $activePeriod = Period::where('active', true)->first(); //aktif dönem

        $periodTeacher = PeriodTeacher::where('period_id', $activePeriod->id)->where('teacher_id', $user->id)->first(); //period student id



        $table = new Table();
        $table->columns = [
            'Kelimeler',
            'Proje Başlığı',
            'Proje Durumu',
            'Proje Tarihi',
            'Öğrenci Adı',
            'Öğrenci Numarası',
            'Dönem',
        ];
        $table->rows = ['keys', 'title', 'case', 'created_at', 'student_name', 'student_number', 'period'];


        $table->items = Assign::join('projects', 'projects.assign_id', "assigns.id")
            ->join("period_students", "period_students.id", "assigns.period_student_id")
            ->join("periods", "periods.id", "period_students.period_id")
            ->join("students", "period_students.student_id", "students.id")
            ->whereIn('projects.id', $projectId)
            ->get(["projects.title", "projects.status", "projects.created_at", "students.name as student_name", "students.student_number", "periods.period_title as period", "projects.id as action"])
            ->each(function ($item) use ($similarKeys) {
                $item->case = ($item->status == 0 ? "Beklemede" : ($item->status == 1 ? "Onaylandı" : ($item->status == 2 ? "Red Edildi" : '')));
                foreach ($similarKeys as $key => $value) {
                    if ($item->action == $key) {
                        $item->keys = $value;
                    }
                }
            });
        $table->btns = [
            [
                "name" => "Detay",
                "route" => "teacher.project.detail",
                "class" => "btn btn-primary"
            ],

        ];


        return $table->create();
    }
}

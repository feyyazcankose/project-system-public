<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Form;
use App\Http\Controllers\FormStorage;
use App\Http\Controllers\TableStorage;
use App\Models\Student;
use App\Models\Role;
use App\Models\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

//These are for sending mails
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoMailStudent;

use App\Models\Assign;
use App\Models\PeriodStudent;

class StudentController extends Controller
{

    public $error = array();
    public $student = array();
    public $student_id = array();





    public function get()
    {
        $data['table'] = TableStorage::student();
        $period = Period::where('active', true)->first();

        $data['period'] = $period->period_title . " Öğrencileri";
        $data['open'] = "student";
        $active = Assign::join('period_students', 'period_students.id', 'period_student_id')->where('period_id', $period->id)->first();

        if ($active == null) {
            $data['form'] = FormStorage::studentForm();
            $data['excel'] = FormStorage::studentExcel();
            $data['system_ex'] = "admin.student.system";
        }

        return view("back.admin.users.list", $data);
    }

    public function add()
    {
        $data['form'] = FormStorage::studentForm();
        $data['excel'] = FormStorage::studentExcel();
        $data['period'] = Period::where('active', true)->first()->period_title . " Öğrencileri";

        $data['title'] = "Yeni Öğrenci Ekle";
        $data['system_ex'] = "admin.student.system";
        $data['open'] = "student";
        // dd($data);
        return view("back.admin.users.add", $data);
    }

    public function create(Request $request)
    {

        $response = false;
        //Requset validation
        $request->validate(
            [
                'tc' => 'required|min:11|max:11|unique:students',
                'student_number' => 'required|min:9|max:9|unique:students',
                'name' => 'required',
                'phone_number' => 'required|min:11|max:11',
                'birth' => 'required',
                'university' => 'required',
                'faculty' => 'required',
                'departman' => 'required',
                'email' => 'required|email|unique:students'
            ]
        );


        $email = $request->email;
        $student_number = $request->student_number;
        $tc = $request->tc;



        $rand = rand(10000, 99999);

        $data = [
            'name' => $request->name,
            'student_number' => $request->student_number,
            'rand' => $rand,
        ];

        //validation process for Uniqe data in student table  step 2
        //get active period id from database in periods table

        //Add password and role_id in request
        $request->request->add(['password' => Hash::make($rand)]);
        $request->request->add(['role_id' => Role::where('title', 'student')->first()->id]);


        //create a new student
        $response = Student::create($request->all());

        //period add
        $period = Period::where('active', true)->first()->id;
        PeriodStudent::create([
            'student_id' => $response->id,
            'period_id' => $period
        ]);



        if ($response) //is added a new student in student table?
        {
            $status = ['Kayıt işlemi başarılı', 'success'];

            //Sending mail upon successfull registiration. This line redirects to the mailable class.
            Mail::to($response)->send(new InfoMailStudent($data));
        } else
            $status = ['Kayıt işlemi başarısız', 'danger'];


        return redirect(route('admin.student.list'))->with('status', $status);
    }

    public function excel(Request $request)
    {
        //get active period id from database in periods table
        $period = Period::where('active', true)->first()->id;

        FastExcel::import($request->file('file'), function ($line) use ($period) {
            $rand = rand(10000, 99999);
            $email = Student::where('email', $line['email'])->first();
            $student_number = Student::where('student_number', $line['student_number'])->first();
            $tc = Student::where('tc', $line['tc'])->first();

            $data = [
                'name' => $line['name'],
                'student_number' => $line['student_number'],
                'rand' => $rand,
            ];

            if (isset($email->email) || isset($student_number->email) || isset($tc->email)) {
                if (isset($email->email))
                    $this->error[] = 'Öğrenci sisteme eklenemedi: <b>' . $line['email'] . "</b> e-posta adresine  sahip öğrenci sisteminizde mevcut. Eklemek istediğiniz öğrencinin email adresini lütfen tekrar kontrol ediniz.";
                if (isset($student_number->email))
                    $this->error[] = 'Öğrenci sisteme eklenemedi: <b>' . $line['student_number'] . "</b> öğrenci numarasına sahip öğrenci sisteminizde mevcut. Eklemek istediğiniz öğrencinin numarasını lütfen tekrar kontrol ediniz.";
                if (isset($tc->tc))
                    $this->error[] = 'Öğrenci sisteme eklenemedi: <b>' . $line['tc'] . "</b> TCKN sahip öğrenci sisteminizde mevcut. Eklemek istediğiniz TCKN lütfen tekrar kontrol ediniz.";
            } else {

                $create = Student::create(
                    [
                        'tc' =>  $line['tc'],
                        'student_number' => $line['student_number'],
                        'name' =>  $line['name'],
                        'phone_number' =>  $line['phone_number'],
                        'birth' =>  $line['birth'],
                        'university' =>  $line['university'],
                        'faculty' =>  $line['faculty'],
                        'departman' =>  $line['departman'],
                        'email' =>  $line['email'],
                        'password' => Hash::make($rand),
                        'role_id' => 3,
                    ]
                );

                if ($create) {
                    //Sending mail upon successfull import. This line redirects to the mailable class.
                    Mail::to($line['email'])->send(new InfoMailStudent($data));

                    //Peirod add
                    $period = Period::where('active', true)->first()->id;
                    PeriodStudent::create([
                        'student_id' => $create->id,
                        'period_id' => $period
                    ]);
                }

                return $create;
            }
        });

        $status = $this->error != null ? [$this->error, "danger"] : ["Kayıt Başarılı.", "success"];
        return redirect(route('admin.student.list'))->with('status', $status);
    }

    public function getOld()
    {
        $period = Period::where('active', true)->first();
        $data['items'] = PeriodStudent::where('period_id', '!=', $period->id)
            ->join('students', 'period_students.student_id', 'students.id')
            ->join('periods', 'periods.id', 'period_students.period_id')
            ->each(function ($item) use ($period) {
                $student = PeriodStudent::where('student_id', $item->student_id)->where('period_id', $period->id)->first();
                if ($student == null) {
                    if ($this->student == null || !in_array($item->student_id, $this->student_id)) {
                        $this->student_id[] = $item->student_id;
                        $this->student[$item->student_id] = ["id" => $item->student_id, "name" => $item->name, "periods" => [$item->period_title], "student_number" => $item->student_number];
                    } else
                        array_push($this->student[$item->student_id]["periods"], $item->period_title);
                }
            });

        return view("back.admin.system_ex.student", ['items' => $this->student, 'active_period' => $period->period_title]);
    }

    public function createOld(Request $request)
    {
        $period = Period::where('active', true)->first()->id;
        if (isset($request->check)) {
            foreach ($request->check as $id) {
                PeriodStudent::create([
                    'student_id' => $id,
                    'period_id' => $period
                ]);
            }
            $status = ['Kayıt işlemi başarılı', 'success'];
        } else
            $status = ['Kayıt işlemi başarısız. Öğrenci seçilmedi', 'danger'];
        return redirect(route('admin.student.list'))->with('status', $status);
    }
}

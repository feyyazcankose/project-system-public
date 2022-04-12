<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;



// Admin Contollers
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssignController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\DissController as AdminDissController;


// Student Controllers
use App\Http\Controllers\Student\StudentProfilController;
use App\Http\Controllers\Student\ProjectController;
use App\Http\Controllers\Student\ReportController;
use App\Http\Controllers\Student\DissController;
use App\Http\Controllers\Student\HomeController as HomeStudentController;

// Teacher Contollers
use App\Http\Controllers\Teacher\TeacherProfilController;
use App\Http\Controllers\Teacher\TeacherUserController;
use App\Http\Controllers\Teacher\ProjectController as ProjectTeacherController;
use App\Http\Controllers\Teacher\ReportController as  ReportTeacherController;
use App\Http\Controllers\Teacher\DissController as  DissTeacherController;
use App\Http\Controllers\Teacher\HomeController as HomeTeacherController;


//Auth Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;


use App\Http\Controllers\Auth\PasswordResetController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */



Route::middleware('is.login')->get('/', function () {
    return view('front.home');
})->name('home');

Route::prefix('login')->name('login.')->middleware('is.login')->group(function () {
    Route::get('student', function () {
        return view('front.auth.student');
    })->name('student');
    Route::get('teacher', function () {
        return view('front.auth.teacher');
    })->name('teacher');
    Route::get('admin', function () {
        return view('front.auth.admin');
    })->name('admin');
});


Route::prefix('check')->name('check.')->group(function () {
    Route::post('admin', [AuthController::class, 'admin'])->name('admin');
    Route::post('student', [AuthController::class, 'student'])->name('student');
    Route::post('teacher', [AuthController::class, 'teacher'])->name('teacher');
});



Route::prefix('student')->name('student.')->middleware('is.student')->group(function () {

    Route::get('',[HomeStudentController::class,'get'])->name('home');
    Route::prefix('project')->name('project.')->middleware('is.student.assign')->group(function (){
        Route::get('list', [ProjectController::class, 'get'])->name('list');
        Route::middleware(['is.student.period','student.status.project'])->get('add', [ProjectController::class, 'add'])->name('add');
        Route::post('create', [ProjectController::class, 'create'])->name('create');
        Route::get('detail/{id}', [ProjectController::class, 'detail'])->name('detail');
    });

    Route::prefix('report')->name('report.')->middleware('is.student.assign')->group(function () {

        Route::get('list', [ReportController::class, 'get'])->name('list');
        Route::middleware(['is.student.period','is.student.project','student.status.report'])->get('add', [ReportController::class, 'add'])->name('add');
        Route::post('create', [ReportController::class, 'create'])->name('create');
        Route::get('detail/{id}', [ReportController::class, 'detail'])->name('detail');
    });


    Route::prefix('diss')->name('diss.')->middleware('is.student.assign')->group(function () {

        Route::get('list', [DissController::class, 'get'])->name('list');
        Route::middleware(['is.student.period','is.student.project','is.student.report','student.status.diss'])->get('add', [DissController::class, 'add'])->name('add');
        Route::post('create', [DissController::class, 'create'])->name('create');
        Route::get('detail/{id}', [DissController::class, 'detail'])->name('detail');
    });




    Route::get('error', function () {
        return view('back.student.error');
    })->name('error');

    Route::get('success', function () {
        return view('back.student.success');
    })->name('success');
});

Route::prefix('admin')->name('admin.')->middleware('is.admin')->group(function () {


    //home
   //Route::get('',function(){  return view('back.admin.home');  })->name('home');   eski hali 
   Route::get('',[AdminController::class,'home'])->name('home');
    //period
    Route::get('period/add', [PeriodController::class, 'add'])->name('period');
    Route::get('period/list', [PeriodController::class, 'get'])->name('period.list');
    Route::post('period/active', [PeriodController::class, 'active'])->name('period.active');
    Route::post('period/create', [PeriodController::class, 'create'])->name('period.create');

    Route::get('error', function () {
        return view('back.admin.error');
    })->name('error');


    //list
    Route::middleware('is.period')->get('student/list', [StudentController::class, 'get'])->name('student.list');
    Route::middleware('is.period')->get('teacher/list', [TeacherController::class, 'get'])->name('teacher.list');
    Route::get('admin/list',  [AdminController::class, 'get'])->name('admin.list');

    Route::get('user/list',   [UserController::class, 'get'])->name('user.list');

    //add
    Route::middleware(['is.period', 'is.assign'])->get('student/add', [StudentController::class, 'add'])->name('student.add');
    Route::middleware(['is.period', 'is.assign'])->get('teacher/add', [TeacherController::class, 'add'])->name('teacher.add');
    Route::get('admin/add', [AdminController::class, 'add'])->name('admin.add');


    //create
    Route::post('student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('admin/create', [AdminController::class, 'create'])->name('admin.create');

    //assign
    Route::post('assign', [AssignController::class, 'create'])->name('assign');
    Route::get('assign/page', [AssignController::class, 'get'])->name('assign.page');

    //excel
    Route::post('student/add/excel', [StudentController::class, 'excel'])->name('student.excel');
    Route::post('teacher/add/excel', [TeacherController::class, 'excel'])->name('teacher.excel');
    Route::post('admin/add/excel', [AdminController::class, 'excel'])->name('admin.excel');

    //system_ex
    Route::get('teacher/system', [TeacherController::class, 'getOld'])->name('teacher.system');
    Route::get('student/system', [StudentController::class, 'getOld'])->name('student.system');

    //system_ex create
    Route::post('teacher/system/add', [TeacherController::class, 'createOld'])->name('teacher.system.create');
    Route::post('student/system/add', [StudentController::class, 'createOld'])->name('student.system.create');

    //admin project seen
    Route::get('project/list', [AdminProjectController::class, 'projects'])->name('project.list');
    Route::get('report/list', [AdminReportController::class, 'report'])->name('report.list');
    Route::get('diss/list', [AdminDissController::class, 'diss'])->name('diss.list');

});

Route::prefix('teacher')->name('teacher.')->middleware('is.teacher')->group(function () {
    Route::get('',[HomeTeacherController::class,'get'])->name('home');
    Route::get('users',[TeacherUserController::class,'get'])->name('users');

    Route::prefix('project')->name('project.')->middleware('is.teacher.assign')->group(function () {
        Route::get('list', [ProjectTeacherController::class, 'get'])->name('list');
        Route::get('detail/{id}', [ProjectTeacherController::class, 'detail'])->name('detail');
        Route::get('approve/{id}', [ProjectTeacherController::class, 'updateApprove'])->name('up.approve');
        Route::post('reject', [ProjectTeacherController::class, 'updateReject'])->name('up.reject');
        
        Route::get('explain/reject/{id}',function ($id) {
            $data['route']="teacher.project.reject";
            $data['id']=$id;
            return view('back.teacher.explain',$data);
        })->name('explain');


        Route::get('wait', [ProjectTeacherController::class, 'wait'])->name('wait');
        Route::get('reject', [ProjectTeacherController::class, 'reject'])->name('reject');
        Route::get('approve', [ProjectTeacherController::class, 'approve'])->name('approve');


        Route::get('user/{id}', [TeacherUserController::class, 'userProject'])->name('user');
    });

    Route::prefix('report')->name('report.')->middleware('is.teacher.assign')->group(function () {
        Route::get('list', [ReportTeacherController::class, 'get'])->name('list');
        Route::post('form', [ReportTeacherController::class, 'form'])->name('form');
        Route::get('list/{event}', [ReportTeacherController::class, 'get'])->name('list.detail');

        Route::get('approve/{id}', [ReportTeacherController::class, 'updateApprove'])->name('up.approve');
        Route::post('reject', [ReportTeacherController::class, 'updateReject'])->name('up.reject');
        
        Route::get('explain/reject/{id}',function ($id) {
            $data['route']="teacher.report.up.reject";
            $data['id']=$id;
            return view('back.teacher.explain',$data);
        })->name('explain');


        Route::get('user/{id}', [TeacherUserController::class, 'userReport'])->name('user');
    });

    Route::prefix('diss')->name('diss.')->middleware('is.teacher.assign')->group(function () {
        Route::get('list', [DissTeacherController::class, 'get'])->name('list');
        Route::get('detail/{id}', [DissTeacherController::class, 'detail'])->name('detail');
        Route::post('form', [DissTeacherController::class, 'form'])->name('form');

        Route::get('list/{event}', [DissTeacherController::class, 'get'])->name('list.detail');

        Route::get('approve/{id}', [DissTeacherController::class, 'updateApprove'])->name('up.approve');
        Route::post('reject', [DissTeacherController::class, 'updateReject'])->name('up.reject');
        
        Route::get('explain/reject/{id}',function ($id) {
            $data['route']="teacher.diss.up.reject";
            $data['id']=$id;
            return view('back.teacher.explain',$data);
        })->name('explain');


        Route::get('user/{id}', [TeacherUserController::class, 'userDiss'])->name('user');
    });

    Route::get('error', function () {
        return view('back.teacher.error');
    })->name('error');

    

});

// Route::get('deneme',[TableStorage::class,'admin'])->name('deneme');
Route::get('logout', [LogoutController::class, 'index'])->name('logout');


//Admin Profil işlemleri
Route::get('admin/profile', [ProfilController::class, 'get'])->name('admin.profile');
Route::post('admin/profile', [ProfilController::class, 'update'])->name('admin.profilUpdate');
Route::post('admin/change-password', [ProfilController::class, 'changePassword'])->name('admin.changePassword');


//Student Profil İşlemleri
Route::get('student/profile', [StudentProfilController::class, 'get'])->name('student.profile');
Route::post('student/profile', [StudentProfilController::class, 'update'])->name('student.profilUpdate');
Route::post('student/change-password', [StudentProfilController::class, 'changePassword'])->name('student.changePassword');

//Teacher Profil İşlemleri
Route::get('teacher/profile', [TeacherProfilController::class, 'get'])->name('teacher.profile');
Route::post('teacher/profile', [TeacherProfilController::class, 'update'])->name('teacher.profilUpdate');
Route::post('teacher/change-password', [TeacherProfilController::class, 'changePassword'])->name('teacher.changePassword');

//Sifre Sıfırlama İşlemleri
Route::get('admin/sifreSifirlama', [ProfilController::class, 'get'])->name('admin.SifreSifirlama');
Route::get('admin/deneme', function () {
    return view('back.admin.system_ex.teacher');
})->name('admin.SifreSifirlama');


//Student password reset routes
Route::get('/forgot-password-student', function () {
    return view('front.auth.student_forgot_password');
});
Route::post('/forgot-password-student-post', [PasswordResetController::class, 'student_new_password']);

//Teacher password reset routes
Route::get('/forgot-password-teacher', function () {
    return view('front.auth.teacher_forgot_password');
});
Route::post('/forgot-password-teacher-post', [PasswordResetController::class, 'teacher_new_password']);

//Admin password reset routes
Route::get('/forgot-password-admin', function () {
    return view('front.auth.admin_forgot_password');
});
Route::post('/forgot-password-admin-post', [PasswordResetController::class, 'admin_new_password']);

Route::get('/deneme2',[AdminProjectController::class,'diss']);

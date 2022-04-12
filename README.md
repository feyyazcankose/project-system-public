# Projenin Amacı

Laravel kullanarak Proje derslerinde, öğrencilerin proje konusu önermesi, kabul ettirmesi, projeyi raporlaştırması ve tez haline getirmesini düzenleyen web tabanlı bir Proje Takip Sistemi geliştirilecektir.

## Projenin isterleri
Projenin tüm isterlerine `required` klasöründen görüntüleyebilirsiniz.
## Projenin Veri Tabanı Modeli
Proje için kullanmış olduğumuz veri tabanı modeli [Görüntüle](https://github.com/feyyazcankose/project-system-public/blob/main/readme/document/databesemodel.pdf) 
## Kurulum
Projeyi aşağıdaki komut ile indirebilirsiniz. Komutu kullanmak için sisteminizde [git](https://git-scm.com/downloads) olması gerekiyor.
```bash
git clone https://github.com/feyyazcankose/project-system-public.git
```
Proje indirdikten sonra proje için gerekli olan kütüphanelerin indirilmesi için 
aşağıdaki komutu çalıştırmalısınız.
```bash
composer update
```
Komutu kullanmak için sisteminizde [composer](https://getcomposer.org/) kurulu olması gerekiyor.
## .ENV Yapılandırma 
`.env.example` dosyasının kopyasını oluşturup `.env` olarak ismini güncelleyin. Aşağıdaki adımları `.env` dosyası içerisinde gerçekleştirmeniz gerekiyor.
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=root
DB_PASSWORD=
```
Sisteminizde oluşturduğunuz veri tabanı ismini `DB_DATABASE` eklemelisiniz. Benzer şekilde diğer bilgileri sisteminizdeki server bilgileri içinde yapmalısınız. Ben XAMMP kullandığım için `DB_USERNAME=root` ve `DB_PASSWORD=` şeklinde oluyor. Fakat kullandığınız sisteme göre farklılık gösterebilir.

## Admin Giriş Bilgileri Yapılandırma
.env dosyasında aşağıdaki kısımları yapılandırmanız gerekiyor.
```env
DEFAULT_EMAIL_ADDRESS=example@example.com
DEFAULT_NAME=example
DEFAULT_PASSWORD=example123
```
Admin girişi yapmak için buradaki bilgiler gerekli bu bilgileri kendinize göre yapılandırabilirsiniz.

## Tabloların Oluşturulması
Aşağıdaki komut ile `database\migrations` dizini altındaki oluşturulan tabloları veri tabanında oluşturmayı sağlıyoruz.
```bash
php artisan migrate 
```

## Sistemi Çalıştırmak
Aşağıdaki komut ile sistemi local'de çalıştırıyoruz.
```bash
php artisan serve
```
`http://127.0.0.1:8000/` adresinde uygulamayı çalıştırıyor. 
## Admin Girişi
`http://127.0.0.1:8000/login/admin` adresine giderek. `.env` dosyasında belirlediğiniz `DEFAULT_EMAIL_ADDRESS` ve `DEFAULT_PASSWORD` ile sisteme giriş yapabilirsiniz.

## Kullandığımız Kaynaklar
1. [Laravel Eğitim](https://www.youtube.com/playlist?list=PL5HkP8Ta9WU8367CJK4OyfYdJ7X6-5W-Z)
2. [Laravel Standartlaştırma Kuralları](https://dev.to/lathindu1/laravel-best-practice-coding-standards-part-01-304l)
2. [Excel Gerekli Olan Kütüphane](https://github.com/rap2hpoutre/fast-excel): `rap2hpoutre/fast-excel`
3. Benzerlik Testi: `algolia/algoliasearch-client-php` ve `laravel/scout`


## Route Listesi
```
GET|HEAD   / ....................................................................................................................... home
  POST       _ignition/execute-solution ..................... ignition.executeSolution › Spatie\LaravelIgnition › ExecuteSolutionController
  GET|HEAD   _ignition/health-check ................................. ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckController
  POST       _ignition/update-config .............................. ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfigController
  GET|HEAD   admin ................................................................................ admin.home › Admin\AdminController@home  
  GET|HEAD   admin/admin/add .................................................................. admin.admin.add › Admin\AdminController@add  
  POST       admin/admin/add/excel ........................................................ admin.admin.excel › Admin\AdminController@excel  
  POST       admin/admin/create ......................................................... admin.admin.create › Admin\AdminController@create  
  GET|HEAD   admin/admin/list ................................................................ admin.admin.list › Admin\AdminController@get  
  POST       admin/assign .................................................................... admin.assign › Admin\AssignController@create  
  GET|HEAD   admin/assign/page ............................................................. admin.assign.page › Admin\AssignController@get  
  POST       admin/change-password ........................................... admin.changePassword › Admin\ProfilController@changePassword  
  GET|HEAD   admin/deneme ............................................................................................ admin.SifreSifirlama  
  GET|HEAD   admin/diss/list .................................................................. admin.diss.list › Admin\DissController@diss  
  GET|HEAD   admin/error ...................................................................................................... admin.error  
  POST       admin/period/active ...................................................... admin.period.active › Admin\PeriodController@active
  GET|HEAD   admin/period/add ................................................................... admin.period › Admin\PeriodController@add  
  POST       admin/period/create ...................................................... admin.period.create › Admin\PeriodController@create  
  GET|HEAD   admin/period/list ............................................................. admin.period.list › Admin\PeriodController@get  
  GET|HEAD   admin/profile ..................................................................... admin.profile › Admin\ProfilController@get  
  POST       admin/profile ............................................................. admin.profilUpdate › Admin\ProfilController@update  
  GET|HEAD   admin/project/list ..................................................... admin.project.list › Admin\ProjectController@projects  
  GET|HEAD   admin/report/list .......................................................... admin.report.list › Admin\ReportController@report  
  GET|HEAD   admin/sifreSifirlama ....................................................... admin.SifreSifirlama › Admin\ProfilController@get  
  GET|HEAD   admin/student/add ............................................................ admin.student.add › Admin\StudentController@add  
  POST       admin/student/add/excel .................................................. admin.student.excel › Admin\StudentController@excel  
  POST       admin/student/create ................................................... admin.student.create › Admin\StudentController@create  
  GET|HEAD   admin/student/list .......................................................... admin.student.list › Admin\StudentController@get  
  GET|HEAD   admin/student/system ................................................... admin.student.system › Admin\StudentController@getOld  
  POST       admin/student/system/add ..................................... admin.student.system.create › Admin\StudentController@createOld
  GET|HEAD   admin/teacher/add ............................................................ admin.teacher.add › Admin\TeacherController@add  
  POST       admin/teacher/add/excel .................................................. admin.teacher.excel › Admin\TeacherController@excel  
  POST       admin/teacher/create ................................................... admin.teacher.create › Admin\TeacherController@create  
  GET|HEAD   admin/teacher/list .......................................................... admin.teacher.list › Admin\TeacherController@get  
  GET|HEAD   admin/teacher/system ................................................... admin.teacher.system › Admin\TeacherController@getOld  
  POST       admin/teacher/system/add ..................................... admin.teacher.system.create › Admin\TeacherController@createOld  
  GET|HEAD   admin/user/list ................................................................... admin.user.list › Admin\UserController@get  
  GET|HEAD   api/user .....................................................................................................................  
  POST       check/admin .......................................................................... check.admin › Auth\AuthController@admin  
  POST       check/student .................................................................... check.student › Auth\AuthController@student  
  POST       check/teacher .................................................................... check.teacher › Auth\AuthController@teacher
  GET|HEAD   deneme2 ......................................................................................... Admin\ProjectController@diss
  GET|HEAD   forgot-password-admin ........................................................................................................  
  POST       forgot-password-admin-post ................................................... Auth\PasswordResetController@admin_new_password  
  GET|HEAD   forgot-password-student ......................................................................................................  
  POST       forgot-password-student-post ............................................... Auth\PasswordResetController@student_new_password  
  GET|HEAD   forgot-password-teacher ......................................................................................................  
  POST       forgot-password-teacher-post ............................................... Auth\PasswordResetController@teacher_new_password  
  GET|HEAD   login/admin ...................................................................................................... login.admin  
  GET|HEAD   login/student .................................................................................................. login.student  
  GET|HEAD   login/teacher .................................................................................................. login.teacher  
  GET|HEAD   logout .................................................................................. logout › Auth\LogoutController@index  
  GET|HEAD   sanctum/csrf-cookie .............................................................. Laravel\Sanctum › CsrfCookieController@show  
  GET|HEAD   student ............................................................................ student.home › Student\HomeController@get
  POST       student/change-password .............................. student.changePassword › Student\StudentProfilController@changePassword  
  GET|HEAD   student/diss/add ............................................................... student.diss.add › Student\DissController@add  
  POST       student/diss/create ...................................................... student.diss.create › Student\DissController@create  
  GET|HEAD   student/diss/detail/{id} ................................................. student.diss.detail › Student\DissController@detail  
  GET|HEAD   student/diss/list ............................................................. student.diss.list › Student\DissController@get  
  GET|HEAD   student/error .................................................................................................. student.error  
  GET|HEAD   student/profile ........................................................ student.profile › Student\StudentProfilController@get  
  POST       student/profile ................................................ student.profilUpdate › Student\StudentProfilController@update  
  GET|HEAD   student/project/add ...................................................... student.project.add › Student\ProjectController@add  
  POST       student/project/create ............................................. student.project.create › Student\ProjectController@create  
  GET|HEAD   student/project/detail/{id} ........................................ student.project.detail › Student\ProjectController@detail  
  GET|HEAD   student/project/list .................................................... student.project.list › Student\ProjectController@get  
  GET|HEAD   student/report/add ......................................................... student.report.add › Student\ReportController@add
  POST       student/report/create ................................................ student.report.create › Student\ReportController@create  
  GET|HEAD   student/report/detail/{id} ........................................... student.report.detail › Student\ReportController@detail  
  GET|HEAD   student/report/list ....................................................... student.report.list › Student\ReportController@get
  GET|HEAD   student/success .............................................................................................. student.success  
  GET|HEAD   teacher ............................................................................ teacher.home › Teacher\HomeController@get  
  POST       teacher/change-password .............................. teacher.changePassword › Teacher\TeacherProfilController@changePassword  
  GET|HEAD   teacher/diss/approve/{id} ..................................... teacher.diss.up.approve › Teacher\DissController@updateApprove  
  GET|HEAD   teacher/diss/detail/{id} ................................................. teacher.diss.detail › Teacher\DissController@detail  
  GET|HEAD   teacher/diss/explain/reject/{id} ........................................................................ teacher.diss.explain  
  POST       teacher/diss/form ............................................................ teacher.diss.form › Teacher\DissController@form  
  GET|HEAD   teacher/diss/list ............................................................. teacher.diss.list › Teacher\DissController@get  
  GET|HEAD   teacher/diss/list/{event} .............................................. teacher.diss.list.detail › Teacher\DissController@get  
  POST       teacher/diss/reject ............................................. teacher.diss.up.reject › Teacher\DissController@updateReject
  GET|HEAD   teacher/diss/user/{id} ............................................ teacher.diss.user › Teacher\TeacherUserController@userDiss  
  GET|HEAD   teacher/error .................................................................................................. teacher.error  
  GET|HEAD   teacher/profile ........................................................ teacher.profile › Teacher\TeacherProfilController@get  
  POST       teacher/profile ................................................ teacher.profilUpdate › Teacher\TeacherProfilController@update  
  GET|HEAD   teacher/project/approve .......................................... teacher.project.approve › Teacher\ProjectController@approve  
  GET|HEAD   teacher/project/approve/{id} ............................ teacher.project.up.approve › Teacher\ProjectController@updateApprove  
  GET|HEAD   teacher/project/detail/{id} ........................................ teacher.project.detail › Teacher\ProjectController@detail  
  GET|HEAD   teacher/project/explain/reject/{id} .................................................................. teacher.project.explain
  GET|HEAD   teacher/project/list .................................................... teacher.project.list › Teacher\ProjectController@get  
  POST       teacher/project/reject .................................... teacher.project.up.reject › Teacher\ProjectController@updateReject  
  GET|HEAD   teacher/project/reject ............................................. teacher.project.reject › Teacher\ProjectController@reject  
  GET|HEAD   teacher/project/user/{id} ................................... teacher.project.user › Teacher\TeacherUserController@userProject  
  GET|HEAD   teacher/project/wait ................................................... teacher.project.wait › Teacher\ProjectController@wait   
  GET|HEAD   teacher/report/approve/{id} ............................... teacher.report.up.approve › Teacher\ReportController@updateApprove   
  GET|HEAD   teacher/report/explain/reject/{id} .................................................................... teacher.report.explain   
  POST       teacher/report/form ...................................................... teacher.report.form › Teacher\ReportController@form   
  GET|HEAD   teacher/report/list ....................................................... teacher.report.list › Teacher\ReportController@get   
  GET|HEAD   teacher/report/list/{event} ........................................ teacher.report.list.detail › Teacher\ReportController@get   
  POST       teacher/report/reject ....................................... teacher.report.up.reject › Teacher\ReportController@updateReject   
  GET|HEAD   teacher/report/user/{id} ...................................... teacher.report.user › Teacher\TeacherUserController@userReport   
  GET|HEAD   teacher/users .............................................................. teacher.users › Teacher\TeacherUserController@get  
```

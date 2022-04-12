<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Form;
use App\Http\Controllers\FormItem;

class FormStorage extends Controller
{

    static public function studentForm(){
        $form = new Form("admin.student.create","Yeni Öğrenci Ekle","post");
        //input elements
        
        #tc input
        $form->label="TC Kimlik Numarası";
        $form->type="text";
        $form->name="tc";
        $form->placeholder="TC Kimlik Numarası";
        $form->min=11;
        $form->max=11;
        $form->maxLength=11;
        $form->inputAdd();
        #student input
        $form->label="Öğrenci Numarası";
        $form->type="text";
        $form->name="student_number";
        $form->placeholder="Öğrenci Numarası";
        $form->maxLength=9;
        $form->inputAdd();
        
        #name input
        $form->label="E Posta Adresi";
        $form->type="email";
        $form->name="email";
        $form->placeholder="E Posta Adresi";
        $form->inputAdd();

        #name input
        $form->label="Ad Soyad";
        $form->type="text";
        $form->name="name";
        $form->placeholder="Ad Soyad";
        $form->inputAdd();

        #phone input
        $form->label="Telefon Numarası";
        $form->type="text";
        $form->name="phone_number";
        $form->placeholder="Telefon Numarası";
        $form->min=11;
        $form->max=11;
        $form->inputAdd();

        #date input
        $form->label="Doğum Tarihi";
        $form->type="date";
        $form->name="birth";
        $form->min=1900;
        $form->inputAdd();

        
        #üniversite select
        $form->type="select";
        $form->label="Üniversite Seçiniz";
        $form->name="university";
        $form->option("Kocaeli Üniversitesi",true);
        $form->option("İstanbul Teknik Üniversitesi");  
        $form->option("Boğaziçi Üniversitesi");
        $form->option("Yıldız Teknik Üniversitesi");
        $form->option("Bilkent Üniversitesi");
        $form->inputAdd();
        

        #Fakulte select
        $form->type="select";
        $form->label="Fakülte Seçiniz";
        $form->name="faculty";
        $form->option("Teknoloji Fakultesi",true);
        $form->option("Fen Edebiyat Fakultesi");
        $form->option("Spor Bilimleri Fakultesi");
        $form->option("Tıp Fakultesi");
        $form->option("Eğitim Bilimleri Fakultesi");
        $form->inputAdd();


        #Bölüm select
        $form->type="select";
        $form->label="Bölüm Seçiniz";
        $form->name="departman";
        $form->option("Bilişim Sistemleri",true);
        $form->option("Biyoloji Öğretmenliği");
        $form->option("Beden Eğitimi Öğretmenliği");
        $form->option("Sağlık Uzmanı");
        $form->option("Makine Mühendisi");
        $form->inputAdd();

        #Submit item
        $form->submitItem("Öğrenciyi Ekle","btn btn-primary");
        return $form;
    }

    static public function teacherForm(){
        $form = new Form("admin.teacher.create","Yeni Öğretmen Ekle","post");
        //input elements

        #sicil input
        $form->label="Sicil Numarası";
        $form->type="text";
        $form->name="sicil";
        $form->placeholder="Sicil Numarası";
        $form->max="4";
        $form->maxLength="4";
        $form->inputAdd();

        #student input
        $form->label="E Posta Adresi";
        $form->type="email";
        $form->name="email";
        $form->placeholder="E Posta Adresi";
        $form->inputAdd();

        #tc input
        $form->label="Ad Soyad";
        $form->type="text";
        $form->name="name";
        $form->placeholder="Ad Soyad";
        $form->inputAdd();

        

        #student input
        $form->label="Ünvan";
        $form->type="text";
        $form->name="appellation";
        $form->placeholder="Ünvanı";
        $form->inputAdd();


        

          #Submit item
        $form->submitItem("Öğrentmeni Ekle","btn btn-primary");

        return $form;
    }

    static public function adminForm(){
        $form = new Form("admin.admin.create","Yeni Yönetici Ekle","post");
        //input elements
        #tc input
        $form->label="Ad Soyad";
        $form->type="text";
        $form->name="name";
        $form->placeholder="Ad Soyad";
        $form->inputAdd();

        #student input
        $form->label="E Posta Adresi";
        $form->type="email";
        $form->name="email";
        $form->placeholder="E Posta Adresi";
        $form->inputAdd();

        #student input
        $form->label="Ünvan";
        $form->type="text";
        $form->name="appellation";
        $form->placeholder="Ünvanı";
        $form->inputAdd();
        #Submit item
        $form->submitItem("Yöneticiyi Ekle","btn btn-primary");

        return $form;

    }

    static public function assignForm(){
        $form = new Form("admin.assign","Atama İşlemi","Post");
        #üniversite select
        $form->submitItem("Atamayı başlat","btn btn-primary");
    }

    static public function teacherExcel(){
        
        $form = new Form("admin.teacher.excel","Öğretmen için excel yükleyin","post","multipart/form-data");

         #name input
         $form->label="Excel Yükleyin";
         $form->type="file";
         $form->name="file";
         $form->inputAdd();

          #Submit item
        $form->submitItem("Exceli Aktar","btn btn-primary");
        return $form;
    }
    
    static public function studentExcel(){
        
        $form = new Form("admin.student.excel","Öğrenci için excel yükleyin","post","multipart/form-data");

         #name input
         $form->label="Excel Yükleyin";
         $form->type="file";
         $form->name="file";
         $form->inputAdd();

          #Submit item
        $form->submitItem("Exceli Aktar","btn btn-primary");
        return $form;
    }

    static public function adminExcel(){
        
        $form = new Form("admin.admin.excel","Admin için excel yükleyin","post","multipart/form-data");

         #name input
         $form->label="Excel Yükleyin";
         $form->type="file";
         $form->name="file";
         $form->inputAdd();

          #Submit item
        $form->submitItem("Exceli Aktar","btn btn-primary");
        return $form;
    }
    
    static public function periodCreate(){
        $form = new Form("admin.period.create","Dönem Oluştur","post");
        $form->label="Dönem Adı";
        $form->placeholder="Dönem adı belirle";
        $form->type="text";
        $form->name="period_title";
        $form->inputAdd();

        $form->label="Dönem Başlangıç Tarihi";
        $form->type="date";
        $form->name="period_date_start";
        $form->inputAdd();

        $form->label="Dönem Bitiş Tarihi";
        $form->type="date";
        $form->name="period_date_end";
        $form->inputAdd();

        $form->submitItem("Dönem Oluştur","btn btn-primary");

        return $form;
    }


    

}

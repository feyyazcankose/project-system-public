<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\FormStorage;
use App\Models\Period;
class PeriodController extends Controller
{
    //
    public function get(){
        
        $periods=Period::orderBy('created_at','desc')->get()->toArray();
        
        if($periods!=null)
            $data['periods']=$periods;

        
        $data['form']=FormStorage::periodCreate();
        // dd($data);
        return view('back.admin.period.list',$data);


    }

    public function add(){
        
        $periods=Period::all()->toArray();
        // dd($periods);
        
        if($periods!=null)
        $data['periods']=$periods;
        
        $data['form']=FormStorage::periodCreate();
        return view('back.admin.period.add',$data);


    }

    public function create(Request $request){
        $request->validate(
            [
                'period_title' => 'required',
                'period_date_start'=>'required|date',
                'period_date_end'=>'required|date',
            ]
        );
        // dd($request);
        $response=Period::create($request->all());
        if($response)//is added a new student in student table?
            $status = ['Kayıt işlemi başarılı' ,'success'];
        else
            $status= ['Kayıt işlemi başarısız','danger'];


        return redirect()->route('admin.period.list')->with('status',$status);
    }

    public function active(Request $request){
        
       
        if($request->period_add)
        {
            $period=Period::where('id', $request->period_add)->first();
            if($period!=null){
                $response=Period::each(function($period) use ($request){
                    $action=false;
                    if($period->id==$request->period_add)
                        $action=true;
                    Period::where('id',$period->id)->update(['active'=>$action]);
                });
            }

            if($response)//is added a new student in student table?
            $status = ['Aktif dönem başarıyla kayıt edildi.' ,'success'];
            else
            $status= ['Hata','danger'];
        }
        else if($request->period_dis)
        $status= ['Aktif dönemi kaptamazsınız! Sadece başka bir dönem ile değitirebilirsiniz.','danger'];
        


       

        return redirect()->route('admin.period.list')->with('status',$status);

    }
}

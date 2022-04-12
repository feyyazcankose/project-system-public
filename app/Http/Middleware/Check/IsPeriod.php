<?php

namespace App\Http\Middleware\Check;

use App\Models\Period;
use Closure;
use Illuminate\Http\Request;

class IsPeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $periods=Period::all()->toArray();
        

        if($periods==null)
        {
            $data['explain']="Sistemde kayıtlı dönem yok lütfen dönem oluşturun!";
            $data['button']="Dönem Oluştur";
            $data['route']="admin.period";

        }
        else 
        {
            $active=Period::where('active',1)->first();
            if($active==null)
            {
            $data['explain']="Sistemde aktif dönem seçilmedi lütfen dönem seçin";
            $data['route']="admin.period.list";
            $data['button']="Dönem Seç";

             }
            
            else
            return $next($request);
        }

        
        return redirect()->route('admin.error')->with('error',$data);
    }
}

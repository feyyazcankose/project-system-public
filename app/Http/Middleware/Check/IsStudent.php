<?php

namespace App\Http\Middleware\Check;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class IsStudent
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
        if(!Session()->has('user'))
        abort(403);

        $user = Session()->get('user');
        
        if($user)
            $role=Role::where('id',$user->role_id)->first();     

        if($role!=NULL && $role->title == 'student')   
            return $next($request);

        abort(403);
    }
}

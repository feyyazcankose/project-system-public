<?php

namespace App\Http\Middleware\Check;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Validation\Rules\Exists;

class IsAdmin
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

        if($role!=NULL && $role->title == 'admin')   
            return $next($request);

        abort(403);
        
    }
}

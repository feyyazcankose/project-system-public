<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GetUser
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
        $user = Session()->get('user');
        $request->request->add(["user" => $user]);
        dd("sasdasd");

        return $next($request);
    }
}

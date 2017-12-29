<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class groupMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $groupsIds = Auth::user()->groups->pluck('id')->toArray();
        if (in_array($request['group_id'], $groupsIds)) return $next($request);
    }
}

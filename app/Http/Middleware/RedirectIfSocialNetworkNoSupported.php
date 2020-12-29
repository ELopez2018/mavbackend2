<?php

namespace App\Http\Middleware;

use App\Models\SocialProfile;
use Closure;
use Illuminate\Http\Request;

class RedirectIfSocialNetworkNoSupported
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( collect( SocialProfile::$allowed )->contains($request->route('socialNetwork')) )
        {
            return $next($request);
        }
        return redirect()->route('login')->with('warning', 'No es posible autenticarse con ' . $request->route('socialNetwork'));
    }
}

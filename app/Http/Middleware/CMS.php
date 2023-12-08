<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CMS
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
        {
        if (auth()->check() && auth()->user()->role == 4) {
            return $next($request);
        }

        abort(403, 'Nemate dozvolu da pristupite ovoj stranici.');
    }
    }
}

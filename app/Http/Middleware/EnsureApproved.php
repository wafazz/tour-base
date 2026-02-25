<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status !== 'approved') {
            auth()->logout();
            return redirect()->route('pending-approval');
        }

        return $next($request);
    }
}

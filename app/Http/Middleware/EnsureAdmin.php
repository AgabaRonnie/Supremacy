<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403, 'This area is for label administrators only.');

        return $next($request);
    }
}

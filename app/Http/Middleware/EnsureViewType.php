<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureViewType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type = null): Response
    {
        $viewType = $request->session()->get('view_type', 'registry');

        if ($type === null) {
            return $next($request);
        }

        if ($viewType !== $type) {
//            if ($type === 'registry') return redirect('/');

            return redirect('/');
        }

        return $next($request);
    }
}

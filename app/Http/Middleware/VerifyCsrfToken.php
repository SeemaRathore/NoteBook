<?php

// app/Http/Middleware/VerifyCsrfToken.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->session()->token();

        if (
            ! $request->has('_token') ||
            $request->input('_token') !== $token
        ) {
            abort(403, 'CSRF token mismatch');
        }

        return $next($request);
    }
}


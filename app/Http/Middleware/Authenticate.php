<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $data = [
            'message' => 'unauthenticated',
            'status' => 401
        ];
        if ($request->is('api/*')) {
            return response()->json($data, 401);
        }
        return route('login');
    }
}

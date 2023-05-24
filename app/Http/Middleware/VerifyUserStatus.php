<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifyUserStatus
{
    public function handle($request, Closure $next)
    {
        // Obtén el usuario autenticado
        $user = $request->user();

        // usurios administrativos
        if ($user && $user->role_id == 1) {
            return $next($request);
        }

        // usurios administrativos
        if ($user && $user->role_id == 2  && $user->status == 1) {
            return $next($request);
        }

        // usurios administrativos
        if ($user && $user->role_id == 3  && $user->status == 1) {
            $admin = User::find($user->parent_id);

            if ($admin->status === 0) {
                return redirect()->route('login')->with('error', 'Tu cuenta está desactivada.');
            }

            return $next($request);
        }

        // Session::flush();
        // Auth::logout();
        // return route('login');
        // Si el usuario no tiene estado 1, redirige o devuelve una respuesta de error
        return redirect()->route('login')->with('error', 'Tu cuenta está desactivada.');
    }
}

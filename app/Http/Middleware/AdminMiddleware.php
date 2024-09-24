<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Проверяем, авторизован ли пользователь и является ли он администратором
        if (Auth::check() && Auth::user()->offline === 'admin') {
            return $next($request);
        }

        // Если пользователь не админ, перенаправляем на главную страницу
        return redirect()->route('home');
    }
}

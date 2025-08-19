<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Перевіряємо, чи користувач авторизований і чи його роль відповідає
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // Якщо роль не відповідає, повертаємо 403
        abort(403, 'У вас немає доступу до цієї сторінки.');
    }
}

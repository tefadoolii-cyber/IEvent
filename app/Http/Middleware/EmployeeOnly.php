<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // السماح للموظفين المرتبطين بحساب موظف، أو من لديهم دور الموظف
        if ($user->employee || $user->hasRole('employee')) {
            return $next($request);
        }

        // منع المستخدمين الإداريين من بوابة الموظف
        abort(403, 'هذه الصفحة مخصصة للموظفين فقط');
    }
}

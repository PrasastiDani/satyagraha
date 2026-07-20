<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * Contoh:
     * role:admin
     * role:admin,user
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        /*
         * Secara normal kondisi ini ditangani middleware auth.
         * Pengecekan tetap diberikan agar middleware aman.
         */
        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->hasAnyRole($roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
            ],
            'remember' => [
                'nullable',
                'boolean',
            ],
        ]);

        $login = trim($validated['login']);

        /*
         * Jika formatnya valid sebagai email, cari lewat email.
         * Selain itu, cari lewat username.
         */
        $loginField = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $authenticated = Auth::attempt([
            $loginField => $login,
            'password' => $validated['password'],

            /*
             * Hanya user dengan role admin yang boleh
             * melakukan autentikasi melalui portal admin.
             */
            fn(Builder $query) => $query->whereHas(
                'role',
                fn(Builder $roleQuery) => $roleQuery
                    ->where('slug', 'admin')
            ),
        ], $request->boolean('remember'));

        if ($authenticated) {
            $request->session()->regenerate();

            return redirect()->intended(
                route('admin.dashboard')
            );
        }

        throw ValidationException::withMessages([
            'login' => 'Username/email atau password salah, atau akun tidak memiliki akses admin.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Diarahkan kembali ke halaman depan hotel
    }
}

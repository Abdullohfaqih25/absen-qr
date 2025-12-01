<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Role selector protection: ensure selector matches user role.
            // Additionally, require Admin users to login via the admin area (/admin).
            $selectedRole = $request->input('selected_role');
            $user = Auth::user();

            if ($user->isAdmin()) {
                // Allow admin login when selector is empty (direct admin form) or explicitly 'admin'
                if ($selectedRole && $selectedRole !== 'admin') {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Silakan masuk lewat /admin untuk akun administrator.'])->onlyInput('email');
                }
            } else {
                if ($selectedRole) {
                    if ($selectedRole === 'guru' && ! $user->isGuru()) {
                        Auth::logout();
                        return back()->withErrors(['email' => 'Akun ini bukan akun Guru.'])->onlyInput('email');
                    }
                    if ($selectedRole === 'siswa' && ! $user->isSiswa()) {
                        Auth::logout();
                        return back()->withErrors(['email' => 'Akun ini bukan akun Siswa.'])->onlyInput('email');
                    }
                    if ($selectedRole === 'admin') {
                        Auth::logout();
                        return back()->withErrors(['email' => 'Akun ini bukan akun Administrator.'])->onlyInput('email');
                    }
                }
            }

            return $this->authenticated($request, $user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }
}

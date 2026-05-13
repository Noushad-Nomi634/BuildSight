<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Company;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        // Check email exists first to give a specific error
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with that email address.'
            ])->onlyInput('email');
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'The password you entered is incorrect.'
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->super_admin) {
            session()->forget('company_id');
            app(PermissionRegistrar::class)->setPermissionsTeamId(null);
            return redirect()->route('admin.index');
        }
        $companyId = $user->company->id;

        if (!$companyId) {
            Auth::logout();
            $request->session()->invalidate();
            return back()->withErrors([
                'email' => 'Your account is not assigned to any company. Please contact support.'
            ])->onlyInput('email');
        }

        session(['company_id' => $companyId]);
        app(PermissionRegistrar::class)->setPermissionsTeamId($companyId);

        return redirect()->route('company.dashboard'); // fixed typo
    }


    public function RegisterView()
    {
        return view('auth.register');
    }

    public function Register()
    {

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

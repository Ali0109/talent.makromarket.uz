<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.admin.login');
    }

    public function loginPost(Request $request) {
        $validation = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $admin = Admin::where('email', $email)->first();
        if ($admin) {
            if(Hash::check($password, $admin->password)) {
                Auth::guard('admin')->login($admin);
                return redirect()->route('auth.admin.index');
            } else {
                return redirect()->route('admin.login')->withErrors(
                    ['password' => 'Неверный пароль']
                );
            }
        } else {
            return redirect()->route('admin.login')->withErrors(
                ['email' => 'Такой учетной записи не существует']
            );
        }
    }
}

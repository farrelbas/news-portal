<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\UserModel;
use App\Models\Master\LevelModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (session('logged_in')) {
            return redirect('dashboard');
        }

        return view('Admin.Auth.login', [
            'title' => 'Login',
        ]);
    }

    public function check_login(Request $request)
    {
        $username = $request->username;
        $password = md5($request->password);

        $user = UserModel::where('username', $username)
            ->where('password', $password)
            ->where('user_softdel', 0)
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid username or password.');
        }

        $level = LevelModel::where('id_level', $user->id_level)
            ->first();

        if (!$level) {
            return back()->with('error', 'User level is not registered in the system.');
        }

        session([
            'logged_in' => true,
            'id_user' => $user->id_user,
            'username' => $user->username,
            'user_fullname' => $user->user_fullname,
            'user_email' => $user->user_email,
            'id_level' => $user->id_level,
            'level_name' => $level->level_name,
        ]);

        return redirect('dashboard');
    }

    public function register()
    {
        return view('Admin.Auth.register', [
            'title' => 'Register',
        ]);
    }

    public function register_store(Request $request)
    {
        $request->validate([
            'user_fullname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_user,username',
            'user_email' => 'required|email|unique:tb_user,user_email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = UserModel::create([
            'id_level' => 2,
            'user_fullname' => $request->user_fullname,
            'user_email' => $request->user_email,
            'username' => $request->username,
            'password' => md5($request->password),
            'user_softdel' => 0,
            'user_inserted_at' => now(),
            'user_inserted_by' => 0,
            'user_last_updated' => now(),
            'user_updated_by' => 0,
        ]);

        $user->update([
            'user_inserted_by' => $user->id_user,
            'user_updated_by' => $user->id_user,
        ]);

        session([
            'logged_in' => true,
            'id_user' => $user->id_user,
            'username' => $user->username,
            'user_fullname' => $user->user_fullname,
            'user_email' => $user->user_email,
            'id_level' => $user->id_level,
            'level_name' => $user->level_name,
        ]);

        return redirect('dashboard')
            ->with('success', 'Registration successful. Welcome!');
    }

    public function logout()
    {
        Session::flush();

        return redirect('/')
            ->with('success', 'You have been logged out successfully.');
    }
}

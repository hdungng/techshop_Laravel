<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function login() {
        return view('auth.login');
    }

    public function loginUser(Request $request) {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
        ], [
            'email' => "Email",
            'password' => "Mật khẩu",
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if($user) {


            if(Hash::check($request->password, $user->password)) {
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_name', $user->name);
                $request->session()->put('user_thumbnail', $user->thumbnail);
                $request->session()->put('user_role', $user->role);
                


                if(session('user_role') == 1) {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('home_page');
                }
            }
        }
    }

    public function logout() {
        if(Session::has('user_id')) {

            Session::pull('user_id');
            Session::pull('user_name');
            Session::pull('user_thumbnail');
            Session::pull('user_role');

            return redirect()->route('login');
        }
    }


    public function register() {
        return view('auth.register');
    }

    public function registerUser(Request $request) {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
            'unique' => ":attribute đã tồn tại",
        ], [
            'name' => "Tên người dùng",
            'email' => "Email",
            'password' => "Mật khẩu",
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
        ]);

        return redirect()->route('login');
    }

}

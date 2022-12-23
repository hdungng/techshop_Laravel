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

    public function login()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
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

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('user_role', $user->role);

                if (session('user_role') == 1) {
                    $request->session()->put('admin_id', $user->id);
                    $request->session()->put('admin_name', $user->name);
                    $request->session()->put('admin_thumbnail', $user->thumbnail);
                    $request->session()->put('admin_role', $user->role);

                    return redirect()->route('dashboard');
                    
                } else {
                    $request->session()->put('customer_id', $user->id);
                    $request->session()->put('customer_name', $user->name);
                    $request->session()->put('customer_thumbnail', $user->thumbnail);
                    $request->session()->put('customer_role', $user->role);

                    return redirect()->route('home_page');
                }
            } else {
                return redirect()->route('login')->with('status-danger', 'Mật khẩu của bạn không chính xác');
            }
        } else {
            return redirect()->route('login')->with('status-danger', 'Email của bạn chưa được đăng ký');
        }
    }

    public function logout()
    {
        if (Session::has('admin_id') || Session::has('customer_id')) {

            if(session('user_role') == 1) {
                Session::pull('user_role');
                Session::pull('admin_role');
                Session::pull('admin_name');
                Session::pull('admin_thumbnail');
                Session::pull('admin_role');
            } else {
                Session::pull('user_role');
                Session::pull('customer_id');
                Session::pull('customer_name');
                Session::pull('customer_thumbnail');
                Session::pull('customer_role');
            }

            return redirect()->route('login');
        }
    }


    public function register()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|min:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
            'unique' => ":attribute đã tồn tại",
            'confirmed' => ":attribute phải trùng khớp nhau",
        ], [
            'name' => "Tên người dùng",
            'email' => "Email",
            'password' => "Mật khẩu",
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2, //Customer,
        ]);

        return redirect()->route('login')->with('status', 'Đăng ký tài khoản thành công');
    }
}

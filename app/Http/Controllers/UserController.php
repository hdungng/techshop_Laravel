<?php

namespace App\Http\Controllers;

use App\Models\ProductCat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function profile($id)
    {
        $product_brands = ProductCat::where('status', '=', 'Active')->get();
        $product_cats = ProductCat::where('status', '=', 'Active')->get();
        $profile = User::find($id);

        if($profile == null) {
            return redirect()->route('home_page');
        }

        return view('customer.user.profile', compact('profile', 'product_cats', 'product_brands'));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:5'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
        ], [
            'name' => "Tên người dùng",
        ]);

        User::where('id', $id)->update([
            'name' => $request->name,
        ]);
        if(session('customer_id') == $id) {
            $request->session()->put('customer_name', $request->name);
        }

        return redirect()->route('profile', $id)->with('status', 'Chỉnh sửa người dùng thành công!');
    }


    public function resetPassword($id)
    {
        $product_brands = ProductCat::where('status', '=', 'Active')->get();
        $product_cats = ProductCat::where('status', '=', 'Active')->get();
        $profile = User::find($id);

        if($profile == null) {
            return redirect()->route('home_page');
        }
        return view('customer.user.reset-password', compact('profile', 'product_cats', 'product_brands'));
    }

    public function reset(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8', 'string'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'confirmed' => ":attribute phải trùng khớp nhau",
        ], [
            'password' => "Mật khẩu",
        ]);

        $user = User::find($id);
        
        if(Hash::check($request->password, $user->password)) {
            return redirect()->route('reset-password', $id)->with('status-danger', 'Bạn không thể thay đổi mật khẩu hiện tại của bạn');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile', $id)->with('status', 'Đổi mật khẩu mới thành công!');
    }
}

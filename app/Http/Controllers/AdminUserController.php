<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    //

    function listAdmin()
    {

        $users = User::select('users.*', 'roles.name AS role_name')
            ->join('roles', 'users.role', 'roles.id')
            ->where('role', '=', 1)->paginate(5);


        return view('admin.user.list-admin', compact('users'));
    }


    function listCustomer()
    {

        $users = User::select('users.*', 'roles.name AS role_name')
            ->join('roles', 'users.role', 'roles.id')
            ->where('role', '=', 2)->paginate(5);


        return view('admin.user.list-customer', compact('users'));
    }


    function add()
    {
        return view('admin.user.add');
    }

    function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:10',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif",
        ], [
            'name' => "Tên người dùng",
            'thumbnail' => 'Ảnh đại diện người dùng',
        ]);


        if ($request->hasFile('thumbnail')) {
            $thumbnail_file = $request->file('thumbnail');

            // LẤY TÊN FILE
            $thumbnail_file_name = $thumbnail_file->getClientOriginalName();

            // UPLOAD FILE
            $thumbnail = "uploads/users/" . $thumbnail_file_name;

            $thumbnail_check = User::where([
                ['thumbnail', '=', $thumbnail],
                ['id', '=', $id],
            ])->first();


            if ($thumbnail_check == null) {
                // UPLOAD FILE
                $thumbnail_file->move('uploads/users', $thumbnail_file_name);
            } else {
                return redirect()->route('edit_user', $id)->with('status-danger', 'Ảnh này đang là ảnh đại diện của bạn! Vui lòng chọn ảnh khác');
            }

            User::where('id', $id)->update([
                'name' => $request->name,
                'thumbnail' => $thumbnail,
            ]);

            if(session('admin_id') == $id) {
                $request->session()->put('admin_thumbnail', $thumbnail);
                $request->session()->put('admin_name', $request->name);
            }
            // nếu admin hiện tại sửa thông tin CỦA CHÍNH HỌ => ĐỔI SESSION 

            return redirect()->route('list_admin')->with('status', 'Chỉnh sửa admin thành công!');
        }

        User::where('id', $id)->update([
            'name' => $request->name,
        ]);

        if(session('admin_id') == $id) {
            $request->session()->put('admin_name', $request->name);
        }
        
        return redirect()->route('list_admin')->with('status', 'Chỉnh sửa admin thành công!');
    }


    public function resetPassword($id)
    {
        $user = User::find($id);
        return view('admin.user.reset-password', compact('user'));
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
            return redirect()->route('reset-admin-password', $id)->with('status-danger', 'Bạn không thể thay đổi mật khẩu hiện tại của bạn');
        }
        
        $password = Hash::make($request->password);
        
        $user->update([
            'password' => $password,
        ]);


        return redirect()->route('edit_user', $id)->with('status', 'Đổi mật khẩu mới thành công!');
    }



    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
            'unique' => ":attribute đã tồn tại",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif",
            'confirmed' => ":attribute phải trùng khớp nhau",
        ], [
            'name' => "Tên người dùng",
            'email' => "Email",
            'password' => "Mật khẩu",
            'thumbnail' => 'Ảnh đại diện người dùng',
        ]);

        $input = $request->except('_token');


        if ($request->hasFile('thumbnail')) {
            $thumbnail_file = $request->file('thumbnail');

            // LẤY TÊN FILE
            $thumbnail_file_name = $thumbnail_file->getClientOriginalName();

            // UPLOAD FILE
            $thumbnail_file->move('uploads/users', $thumbnail_file_name);
            $thumbnail = "uploads/users/" . $thumbnail_file_name;

            $input['thumbnail'] = $thumbnail;

            User::create([
                'name' => $input['name'],
                'thumbnail' => $input['thumbnail'],
                'password' => Hash::make($input['password']),
                'email' => $input['email'],
                'role' => 1, //Administrator
            ]);
            return redirect('admin/user/list-admin')->with('status', 'Thêm admin thành công!');
        }

        User::create([
            'name' => $input['name'],
            'password' => Hash::make($input['password']),
            'email' => $input['email'],
            'role' => 1, //Administrator
        ]);

        return redirect('admin/user/list-admin')->with('status', 'Thêm admin thành công!');
    }

    function deleteAdmin($id)
    {
        if (session('user_id') == $id) {
            return redirect('admin/user/list-admin')->with('status', 'Bạn không thể xóa tài khoản của bạn ra khỏi hệ thống');
        } else {
            User::find($id)->delete();
            return redirect('admin/user/list-admin')->with('status', 'Đã xóa admin thành công');
        }
    }

    function deleteCustomer($id)
    {
        User::find($id)->delete();
        Session::pull('user_role');
        Session::pull('customer_id');
        Session::pull('customer_name');
        Session::pull('customer_thumbnail');
        Session::pull('customer_role');

        return redirect('admin/user/list-customer')->with('status', 'Đã xóa khách hàng thành công');
    }
}

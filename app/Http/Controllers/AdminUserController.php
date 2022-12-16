<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    //

    function list(Request $request)
    {

        $users = User::select('users.*', 'roles.name AS role_name')
        ->join('roles', 'users.role', 'roles.id')->paginate(10);


        return view('admin.user.list', compact('users'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'thumbnail' => ['image|mimes:png,jpg,jpeg|max:2048'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
            'unique' => ":attribute đã tồn tại",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif"
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
            $thumbnail = "uploads/users" . $thumbnail_file_name;

            $input['thumbnail'] = $thumbnail;

            User::where('id', $id)->update([
                'name' => $input['name'],
                'password' => Hash::make($input['password']),
                'thumbnail' => $input['thumbnail']
            ]);

            return redirect('admin/user/list')->with('status', 'Chỉnh sửa người dùng thành công!');
        }

        User::where('id', $id)->update([
            'name' => $input['name'],
            'password' => Hash::make($input['password']),
        ]);

        return redirect('admin/user/list')->with('status', 'Chỉnh sửa người dùng thành công!');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'thumbnail' => ['image|mimes:png,jpg,jpeg|max:2048'],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'email' => ":attribute chưa đúng định dạng",
            'unique' => ":attribute đã tồn tại",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif"
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
            $thumbnail = "uploads/users" . $thumbnail_file_name;

            $input['thumbnail'] = $thumbnail;

            User::create([
                'name' => $input['name'],
                'thumbnail' => $input['thumbnail'],
                'password' => Hash::make($input['password']),
                'email' => $input['email'],
                'role' => 'Administrator',
            ]);
            return redirect('admin/user/list')->with('status', 'Thêm người dùng thành công!');
        }

        User::create([
            'name' => $input['name'],
            'password' => Hash::make($input['password']),
            'email' => $input['email'],
            'role' => 'Administrator',
        ]);

        return redirect('admin/user/list')->with('status', 'Thêm người dùng thành công!');
    }

    function delete($id)
    {
        if (session('user_id') == $id) {
            return redirect('admin/user/list', 'status', 'Bạn không thể xóa tài khoản của bạn ra khỏi hệ thống');
        } else {
            User::find($id)->delete();
            return redirect('admin/user/list', 'status', 'Đã xóa thành viên thành công');
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);

            return $next($request);
        });
    }

    function list(Request $request)
    {
        $status = $request->input('status');

        $list_act = [
            'delete' => 'Vô hiệu hóa'
        ];

        if ($status == 'trash') {
            $users = User::onlyTrashed()->paginate(10);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $keyword = '';
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();

        $count = [$count_user_active, $count_user_trash];

        return view('admin.user.list', compact('users', 'count', 'list_act'));
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
        if (Auth::id() != $id) {
            User::find($id)->delete();
            return redirect('admin/user/list', 'status', 'Đã xóa thành viên thành công');
        } else {
            return redirect('admin/user/list', 'status', 'Bạn không thể xóa tài khoản của bạn ra khỏi hệ thống');
        }
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check) {
            // kiểm tra xem thành viên là TÀI KHOẢN CỦA MÌNH => KHÔNG THỂ BỊ THAO TÁC
            foreach ($list_check as $key => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$key]);
                }
            }

            // kiểm tra xem danh sách sau khi loại tài khoản mình ra CÒN THÀNH VIÊN nào nữa ko => THAO TÁC
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    // Xóa tạm thời
                    User::destroy($list_check);
                    return redirect('admin/user/list', 'status', 'Bạn đã vô hiệu hóa thành công');
                } else if ($act == 'restore') {
                    // khôi phục
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list', 'status', 'Bạn đã khôi phục thành công');
                } else if ($act == 'forceDelete') {
                    // xóa vĩnh viễn
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list', 'status', 'Bạn đã xóa vĩnh viễn người dùng thành công');
                }
            }
            return redirect('admin/user/list', 'status', 'Bạn không thể thao tác trên tài khoản của bạn');
        } else {
            return redirect('admin/user/list', 'status', 'Bạn cần phải chọn thành viên để thao tác');
        }
    }
}

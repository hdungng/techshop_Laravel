<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class AdminProductCatController extends Controller
{
    //
    function list()
    {
        $product_cats = ProductCat::orderBy('created_at', 'desc')->paginate(6);
        return view('admin.categories.list', compact('product_cats'));
    }

    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2|unique:product_cats',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'unique' => ":attribute đã tồn tại",
        ], [
            'name' => "Tên danh mục",
        ]);

        ProductCat::create([
            'name' => $request->get('name'),
            'status' => 'Pending'
        ]);

        return redirect('admin/product_cat/list')->with('status', 'Thêm danh mục sản phẩm thành công!');
    }

    function delete($id)
    {
        $products = Product::where('cat_id', '=', $id)->get();

        if ($products->count() > 0) {
            return redirect('admin/product_cat/list')->with('status-danger', 'Không thể xóa danh mục này!');
        }

        ProductCat::find($id)->delete();

        return redirect('admin/product_cat/list')->with('status', 'Xóa danh mục sản phẩm thành công!');
    }

    function update($id)
    {
        $product_cat = ProductCat::find($id);
        return view('admin.categories.update', compact('product_cat'));
    }

    function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'status' => 'required',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'unique' => ":attribute đã tồn tại",

        ], [
            'name' => "Tên danh mục",
            'status' => "Trường trạng thái"
        ]);

        ProductCat::where('id', $id)->update([
            'name' => $request->get('name'),
            'status' => $request->get('status')
        ]);

        return redirect('admin/product_cat/list')->with('status', 'Cập nhật danh mục sản phẩm thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProductBrand;
use Illuminate\Http\Request;

class AdminProductBrandController extends Controller
{
    //
    function list()
    {
        $product_brands = ProductBrand::simplePaginate(5);
        return view('admin.product.brand_list', compact('product_brands'));
    }

    function add()
    {
        return view('admin.product.brand_list');
    }

    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:product_brands',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",
            'unique' => ":attribute đã tồn tại",
        ], [
            'name' => "Tên danh mục",
        ]);

        ProductBrand::create([
            'name' => $request->get('name'),
            'status' => 'Pending'
        ]);

        return redirect('admin/product_brand/list')->with('status', 'Thêm thương hiệu sản phẩm thành công!');
    }

    function delete($id)
    {
        ProductBrand::find($id)->delete();
        return redirect('admin/product_brand/list')->with('status', 'Xóa thương hiệu sản phẩm thành công!');
    }

    function update($id)
    {
        $product_brand = ProductBrand::find($id);
        return view('admin.product.update_brand', compact('product_brand'));
    }

    function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài tối đa :max kí tự",

        ], [
            'name' => "Tên danh mục",
            'status' => "Trường trạng thái"
        ]);

        ProductBrand::where('id', $id)->update([
            'name' => $request->get('name'),
            'status' => $request->get('status')
        ]);

        return redirect('admin/product_brand/list')->with('status', 'Cập nhật thương hiệu sản phẩm thành công!');
    }
}

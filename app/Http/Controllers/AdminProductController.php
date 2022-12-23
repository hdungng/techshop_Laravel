<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    //

    function list()
    {
        $products = Product::select(
            'products.*',
            'product_cats.name AS cat_name'
        )
            ->join('product_cats', 'products.cat_id', '=', 'product_cats.id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.product.list', compact('products'));
    }

    function add()
    {
        $list_brands = ProductBrand::where('status', '=', 'Active')->get();
        $list_cats = ProductCat::where('status', '=', 'Active')->get();
        return view('admin.product.add', compact('list_brands', 'list_cats'));
    }

    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|min:5|unique:products',
            'description' => 'required',
            'detail' => 'required',
            'cat_id' => 'required|not_in:Chọn danh mục',
            'brand_id' => 'required|not_in:Chọn hãng',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài ít nhất :max kí tự",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif",
            'integer' => ":attribute không đúng định dạng số",
            'unique' => ":attribute đã tồn tại",
            'not_in' => "Vui lòng chọn :attribute",
        ], [
            'name' => 'Tên sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'detail' => 'Chi tiết sản phẩm',
            'cat_id' => 'Danh mục sản phẩm',
            'brand_id' => 'Thương hiệu sản phẩm',
            'price' => 'Giá sản phẩm',
            'quantity' => 'Số lượng sản phẩm',
            'thumbnail' => 'Ảnh đại diện sản phẩm',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail_file = $request->file('thumbnail');

            // LẤY TÊN FILE
            $thumbnail_file_name = $thumbnail_file->getClientOriginalName();

            $thumbnail = "uploads/" . $thumbnail_file_name;

            $thumbnail_check = Product::where('thumbnail', '=', $thumbnail)->first();


            if ($thumbnail_check == null) {
                // UPLOAD FILE
                $thumbnail_file->move('uploads', $thumbnail_file_name);
            } else {
                return redirect()->route('add_product')
                ->with('status-danger', 'Ảnh này đang là ảnh đại diện của sản phẩm khác! Vui lòng chọn ảnh khác')
                ->withInput($request->except('_token'));
            }
        }

        Product::create([
            'name' => $request->name,
            'thumbnail' => $thumbnail,
            'description' => $request->description,
            'detail' => $request->detail,
            'cat_id' => $request->cat_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => 'Pending'
        ]);

        return redirect()->route('list_product')->with('status', 'Thêm sản phẩm thành công!');
    }

    function update($id)
    {
        $product = Product::select(
            'products.*',
            'product_cats.name AS cat_name',
            'product_brands.name AS brand_name',
            'product_cats.id AS cat_id',
            'product_brands.id AS brand_id'
        )
            ->join('product_cats', 'products.cat_id', '=', 'product_cats.id')
            ->join('product_brands', 'products.brand_id', '=', 'product_brands.id')
            ->find($id);

        $list_brands = ProductBrand::where('status', '=', 'Active')->get();
        $list_cats = ProductCat::where('status', '=', 'Active')->get();
        return view('admin.product.update', compact('product', 'list_brands', 'list_cats'));
    }

    function edit(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|max:100|min:5',
            'description' => 'required',
            'detail' => 'required',
            'cat_id' => 'required|not_in:Chọn danh mục',
            'brand_id' => 'required|not_in:Chọn hãng',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'integer' => ":attribute không đúng định dạng số",
            'required' => ":attribute không được để trống",
            'min' => ":attribute phải có độ dài ít nhất :min kí tự",
            'max' => ":attribute phải có độ dài ít nhất :max kí tự",
            'image' => ":attribute phải là file ảnh có định dạng jpeg, png, bmp, gif",
            'not_in' => "Vui lòng chọn :attribute",
        ], [
            'id' => 'ID',
            'name' => 'Tên sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'detail' => 'Chi tiết sản phẩm',
            'cat_id' => 'Danh mục sản phẩm',
            'brand_id' => 'Thương hiệu sản phẩm',
            'price' => 'Giá sản phẩm',
            'quantity' => 'Số lượng sản phẩm',
            'thumbnail' => 'Ảnh đại diện sản phẩm',
        ]);

        $input = $request->except('_token');


        // NẾU CÓ THAY ĐỔI ẢNH 
        if ($request->hasFile('thumbnail')) {
            $thumbnail_file = $request->file('thumbnail');

            // LẤY TÊN FILE
            $thumbnail_file_name = $thumbnail_file->getClientOriginalName();

            $thumbnail = "uploads/" . $thumbnail_file_name;

            $thumbnail_check = Product::where([
                ['thumbnail', '=', $thumbnail],
                ['id', '=', $id],
            ])->first();


            if ($thumbnail_check == null) {
                // UPLOAD FILE
                $thumbnail_file->move('uploads', $thumbnail_file_name);
                // BỎ CÁI BIẾN $THUMBNAIL VÀO MẢNG INPUT
                $input['thumbnail'] = $thumbnail;
            } else {
                return redirect()->route('update_product', $id)->with('status-danger', 'Ảnh này đang là ảnh đại diện của sản phẩm này! Vui lòng chọn ảnh khác');
            }
        }


        Product::where('id', $id)->update($input);

        return redirect('admin/product/list')->with('status', 'Cập nhật sản phẩm thành công!');
    }

    function delete($id)
    {
        Product::find($id)->delete();

        return redirect('admin/product/list')->with('status', 'Xóa sản phẩm thành công!');
    }
}

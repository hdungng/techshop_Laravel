<?php

namespace App\Http\Controllers;

use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminImageProductController extends Controller
{
    //
    function add($id)
    {
        $product = Product::find($id);
        return view('admin.images.add', compact('product'));
    }

    function create(Request $request)
    {
        $url = array();
        $id = $request->input('id');
        
        $request->validate(
            [
                'url' => 'required',
                'url.*' => 'mimes:jpg,jpeg,png,bmp|image|max:20000'
            ],
            [
                'required' => 'Vui lòng chọn ảnh sản phẩm',
                'mimes' => 'Vui lòng chọn file ảnh có định dạng jpeg, png, bmp, gif',
                'max' => 'Vui lòng chọn file ảnh có kích thước tối đa 20MB',
            ]
        );

        if ($request->hasFile('url')) {
            foreach ($request->url as $url_file) {

                $url_file_name = $url_file->getClientOriginalName();

                // UPLOAD FILE
                $url_file->move('uploads/products/', $url_file_name);
                $url_name = "uploads/products/" . $url_file_name;

                $url[] = $url_name;
            }

            ImageProduct::create([
                'url' => implode('|', $url),
                'product_id' => $id,
                'status' => 'Pending'
            ]);
        }


        return redirect('admin/product/list')->with('status', 'Thêm hình ảnh sản phẩm thành công!');
    }

    function update($id)
    {
        $images = ImageProduct::select('image_products.*', 'products.name')
            ->join('products', 'image_products.product_id', 'products.id')->where('product_id', '=', $id)->first();

        if(empty($images)) {
            return redirect()->route('add_image_product', $id);
        }    
        return view('admin.images.update', compact('images'));
    }

    function store(Request $request, $id)
    {
        
        $url = array();
        $product_id = $request->input('product_id');
        $status = $request->input('status');


        $request->validate(
            [
                'url.*' => 'mimes:jpg,jpeg,png,bmp|image|max:20000'
            ],
            [
                'mimes' => 'Vui lòng chọn file ảnh có định dạng jpeg, png, bmp, gif',
                'max' => 'Vui lòng chọn file ảnh có kích thước tối đa 20MB',
            ]
        );

        if ($request->hasFile('url')) {
            foreach ($request->url as $url_file) {

                $url_file_name = $url_file->getClientOriginalName();

                // UPLOAD FILE
                $url_file->move('uploads/products/', $url_file_name);
                $url_name = "uploads/products/" . $url_file_name;

                $url[] = $url_name;
            }

            ImageProduct::find($id)->update([
                'url' => implode('|', $url),
                'product_id' => $product_id,
                'status' => $status
            ]);
        }

        ImageProduct::find($id)->update([
            'product_id' => $product_id,
            'status' => $status
        ]);


        return redirect('admin/product/list')->with('status', 'Cập nhật hình ảnh sản phẩm thành công!');
    }
}

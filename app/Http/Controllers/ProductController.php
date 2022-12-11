<?php

namespace App\Http\Controllers;

use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function index($id)
    {
        $product_cats = ProductCat::get();

        $images = ImageProduct::select('image_products.*', 'products.name')
            ->join('products', 'image_products.product_id', 'products.id')->where('product_id', '=', $id)->first();

        $product = Product::select('products.*', 'product_cats.name AS cat_name')
            ->join('product_cats', 'products.cat_id', 'product_cats.id')
            ->where('products.id', '=', $id)->first();

        return view('customer.product.detail', compact('product', 'product_cats', 'images'));
    }
}

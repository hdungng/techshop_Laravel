<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class ProductCatController extends Controller
{
    //
    function index($name) {
        $product_brands = ProductBrand::get();

        $product_cats = ProductCat::get();

        $products = Product::select('products.*', 'product_cats.name AS cat_name')
        ->join('product_cats', 'products.cat_id', 'product_cats.id')
        ->where('product_cats.name', '=', $name)->paginate(6);
        return view('customer.product.category', compact('products', 'product_cats', 'product_brands', 'name'));
    }
}

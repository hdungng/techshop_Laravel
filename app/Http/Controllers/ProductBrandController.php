<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    //
    function index($name)
    {
        $product_brands = ProductBrand::where('status', '=', 'Active')->get();

        $product_cats = ProductCat::where('status', '=', 'Active')->get();

        $products = Product::select('products.*', 'product_brands.name AS brand_name')
            ->join('product_brands', 'products.brand_id', 'product_brands.id')
            ->where([
                ['product_brands.name', '=', $name],
                ['products.status', '=', 'Active'],
            ])->orderBy('created_at', 'DESC')->paginate(9);

        $check_brand = ProductBrand::where([
            ['status', '=', 'Active'],
            ['name', '=', $name],
        ])->first();

        if ($check_brand == null) {
            return redirect()->route('home_page');
        }

        return view('customer.product.category', compact('products', 'product_cats', 'product_brands', 'name'));
    }
}

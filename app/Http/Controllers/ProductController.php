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
        $product_cats = ProductCat::where('status', '=', 'Active')->get();
        $product_brands = ProductCat::where('status', '=', 'Active')->get();

        $product = Product::select('products.*', 'product_cats.name AS cat_name')
            ->join('product_cats', 'products.cat_id', 'product_cats.id')
            ->where([
                ['products.id', '=', $id],
                ['products.status', '=', 'Active'],
            ])->first();

            if($product == null) {
                return redirect()->route('home_page');
            }

        return view('customer.product.detail', compact('product', 'product_cats', 'product_brands'));
    }
}

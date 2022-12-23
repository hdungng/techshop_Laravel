<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCat;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    //
    function index()
    {
        $product_cats = ProductCat::where('status', '=', 'Active')->get();
        $product_brands = ProductBrand::where('status', '=', 'Active')->get();

        $laptops = Product::select('products.*', 'product_cats.name AS cat_name')
            ->join('product_cats', 'products.cat_id', '=', 'product_cats.id')
            ->orderBy('created_at', 'desc')->where([
                ['products.status', '=', 'Active'],
                ['product_cats.name', '=', 'Laptop']
            ])->get();

        $tablets = Product::select('products.*', 'product_cats.name AS cat_name')
            ->join('product_cats', 'products.cat_id', '=', 'product_cats.id')
            ->orderBy('created_at', 'desc')->where([
                ['products.status', '=', 'Active'],
                ['product_cats.name', '=', 'Tablet']
            ])->get();

        $mobiles = Product::select('products.*', 'product_cats.name AS cat_name')
            ->join('product_cats', 'products.cat_id', '=', 'product_cats.id')
            ->orderBy('created_at', 'desc')->where([
                ['products.status', '=', 'Active'],
                ['product_cats.name', '=', 'Mobile Phone']
            ])->get();

        return view('customer.index', compact('laptops', 'mobiles', 'tablets', 'product_cats', 'product_brands'));
    }

}

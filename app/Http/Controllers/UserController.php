<?php

namespace App\Http\Controllers;

use App\Models\ProductCat;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function profile($id) {
        $product_cats = ProductCat::get();
        $profile = User::find($id);
        return view('customer.user.profile', compact('profile', 'product_cats'));
    }
}

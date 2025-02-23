<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $data = DB::table('tbl_product')->where('product_id', $productId)->get();

        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id', 'desc')->get();
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product);
    }
}

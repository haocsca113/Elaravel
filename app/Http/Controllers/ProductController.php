<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImportProduct;
use App\Exports\ExcelExportProduct;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Rating;
use File;
use Excel;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

session_start();

class ProductController extends Controller
{
    public function AuthLogin()
    {
        // $admin_id = Session::get('admin_id');
        $admin_id = Auth::id();
        if($admin_id)
        {
            return Redirect::to('dashboard');
        }
        else
        {
            return Redirect::to('admin')->send();
        }
    }

    public function reply_comment(Request $request)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 1;
        $comment->comment_name = Auth::user()->admin_name;
        $comment->save();
    }

    public function allow_comment(Request $request)
    {
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }

    public function comment()
    {
        $comment = Comment::with('product')->where('comment_parent_comment', '=', 0)->orderBy('comment_id', 'DESC')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        return view('admin.comment.list_comment')->with(compact('comment', 'comment_rep'));
    }

    public function send_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;

        $comment = new Comment();
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_product_id = $product_id;
        $comment->comment_status = 0;
        $comment->comment_parent_comment = 0;
        $comment->save();
    }

    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id', $product_id)->where('comment_status', 1)->where('comment_parent_comment', '=', 0)->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        $output = '';
        foreach($comment as $key => $comm)
        {
            $output .= '
                <div class="row style_comment">
                    <div class="col-md-2">
                        <img src="'.asset('frontend/images/batman_icon.png').'" class="img img-responsive img-thumbnail" alt="">
                    </div>
                    <div class="col-md-10">
                        <p style="color: green;">@'.$comm->comment_name.'</p>
                        <p style="color: #333;">'.$comm->comment_date.'</p>
                        <p>'.$comm->comment.'</p>
                    </div>
                </div>
                <p></p>';

                foreach($comment_rep as $key => $rep_comment)
                {
                    if($rep_comment->comment_parent_comment == $comm->comment_id)
                    {
                        $output .= '<div class="row style_comment" style="margin: 5px 40px; background: aquamarine;">
                                        <div class="col-md-2">
                                            <img width="80%" src="'.asset('frontend/images/pogba_icon.webp').'" class="img img-responsive img-thumbnail" alt="">
                                        </div>
                                        <div class="col-md-10">
                                            <p style="color: blue;">@'.Auth::user()->admin_name.'</p>
                                            <p style="color: #333;">'.$rep_comment->comment_date.'</p>
                                            <p>'.$rep_comment->comment.'</p>
                                        </div>
                                    </div>
                                    <p></p>
                                ';
                    }
                }
        }
        echo $output;
    }

    public function quickview(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        
        $gallery = Gallery::where('product_id', $product_id)->get();
        $output['product_gallery'] = '';
        foreach($gallery as $key => $gal)
        {
            $output['product_gallery'] .= '<p><img width="100%" src="upload/gallery/'.$gal->gallery_image.'"></p>';
        }

        $output['product_name'] = $product->product_name;
        $output['product_id'] = $product->product_id;
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_price'] = number_format($product->product_price, 0, ',', '.').' VNĐ';
        $output['product_image'] = '<p><img width="100%" src="upload/product/'.$product->product_image.'"></p>';

        $output['product_button'] = '
            <input type="button" value="Mua ngay" class="btn btn-primary btn-sm add-to-cart-quickview" id="buy_quickview" data-id_product="'.$product->product_id.'" name="add-to-cart">
        ';

        $output['product_quickview_value'] = '
            <input type="hidden" class="cart_product_id_'.$product->product_id.'" value="'.$product->product_id.'">

            <input type="hidden" class="cart_product_name_'.$product->product_id.'" value="'.$product->product_name.'">
            
            <input type="hidden" class="cart_product_image_'.$product->product_id.'" value="'.$product->product_image.'">

            <input type="hidden" class="cart_product_price_'.$product->product_id.'" value="'.$product->product_price.'">

            <input type="hidden" class="cart_product_quantity_'.$product->product_id.'" value="'.$product->product_quantity.'">

            <input type="hidden" class="cart_product_qty_'.$product->product_id.'" value="1">
        ';

        echo json_encode($output);
    }

    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();
        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }

    public function all_product()
    {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        ->orderby('tbl_product.product_id', 'desc')->get();
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();

        // Loc nhung ki tu dac biet chi lay dung so tien
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
        $data['product_status'] = $request->product_status;
        $data['meta_keywords'] = $request->product_keywords;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;

        $path = 'upload/product/';
        $path_gallery = 'upload/gallery/';

        $get_image = $request->file('product_image');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            File::copy($path.$new_image, $path_gallery.$new_image);
            $data['product_image'] = $new_image;
        }

        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('/add-product');
    }

    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
        Session::put('message', 'Không kích hoạt sản phẩm');
        return Redirect::to('all-product');
    }
    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
        Session::put('message', 'Kích hoạt sản phẩm');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product', $brand_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost = filter_var($request->price_cost, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
        $data['product_status'] = $request->product_status;
        $data['meta_keywords'] = $request->product_keywords;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $get_image = $request->file('product_image');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function import_csv_product(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImportProduct, $path);
        return back();
    }

    public function export_csv_product()
    {
        return Excel::download(new ExcelExportProduct, 'product.xlsx');
    }
    // End Admin Page

    public function detail_product(Request $request, $product_id)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $detail_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->get();

        foreach($detail_product as $key => $value)
        {
            $category_id = $value->category_id;
            $product_cate = $value->category_name;

            // Seo
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->meta_keywords;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
        }

        // Gallery
        $gallery = Gallery::where('product_id', $product_id)->get();

        // Update views
        $product = Product::where('product_id', $product_id)->first();
        $product->product_views = $product->product_views + 1;
        $product->save();

        // VD: Lay ra cac san pham co category = 3 tru san pham detail
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        $rating = Rating::where('product_id', $product_id)->avg('rating');
        $rating = round($rating);

        return view('pages.product.show_detail')->with('category', $cate_product)->with('brand', $brand_product)->with('detail_product', $detail_product)->with('related_product', $related_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post)->with('gallery', $gallery)->with('product_cate', $product_cate)->with('rating', $rating);
    }

    public function tag(Request $request, $product_tag)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $meta_desc = 'Tags tìm kiếm: '.$product_tag;
        $meta_keywords = 'Tags tìm kiếm: '.$product_tag;
        $meta_title = 'Tags tìm kiếm: '.$product_tag;
        $url_canonical = $request->url();

        $tag = str_replace("-", " ", $product_tag);
        $pro_tag = Product::where('product_status', 1)->where('product_name', 'LIKE', '%'.$tag.'%')->orWhere('product_tags', 'LIKE', '%'.$tag.'%')->get();

        return view('pages.product.tag')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post)->with('product_tag', $product_tag)->with('pro_tag', $pro_tag);
    }

    public function insert_rating(Request $request)
    {
        // $data = $request->all();
        $product_id = $request->input('product_id');
        $index = $request->input('index');

        $rating = new Rating();
        // $rating->product_id = $data['product_id'];
        // $rating->rating = $data['index'];
        $rating->product_id = $product_id;
        $rating->rating = $index;
        $rating->save();
        echo 'done';
    }

    public function ckeditor_image(Request $request)
    {
        if($request->hasFile('upload'))
        {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move('upload/ckeditor', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('upload/ckeditor/'.$fileName);
            $msg = 'Tải ảnh thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-Type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function file_browser(Request $request)
    {
        $paths = glob(public_path('upload/ckeditor/*'));
        $fileNames = array();
        foreach($paths as $path)
        {
            array_push($fileNames, basename($path));
        }
        $data = array(
            'fileNames' => $fileNames
        );
        return view('admin.images.file_browser')->with($data);
    }
}

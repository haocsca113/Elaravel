<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;    
use App\Models\CategoryPost;
use App\Models\Gallery;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
session_start();

class GalleryController extends Controller
{
    public function AuthLogin()
    {
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

    public function add_gallery($product_id)
    {
        $pro_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }

    public function insert_gallery(Request $request, $pro_id)
    {
        $get_image = $request->file('file');
        if($get_image)
        {
            foreach($get_image as $image)
            {
                $get_name_image = $image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
                $new_image = $name_image.rand(0, 99).'.'.$image->getClientOriginalExtension();
                $image->move('upload/gallery', $new_image);

                $gallery = new Gallery();
                $gallery->product_id = $pro_id;
                $gallery->gallery_name = $new_image;
                $gallery->gallery_image = $new_image;
                $gallery->save();
            }
            return redirect()->back()->with('message', 'Thêm thư viện ảnh thành công');
        }
    }

    public function select_gallery(Request $request)
    {
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tên hình ảnh</th>
                        <th>Hình ảnh</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>

                <tbody>
        ';
        if($gallery_count > 0)
        {
            $i = 0;
            foreach($gallery as $key => $gal)
            {
                $i++;
                $output .= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$gal->gallery_name.'</td>
                        <td><img src="'.url('upload/gallery/'.$gal->gallery_image).'" class="img-thumbnail" style="width: 100px; height: 100px !important;"></td>
                        <td>
                            <button data-gal_id="'.$gal->gallery_id.'" class="btn btn-sm btn-danger delete-gallery">Xóa</button>
                        </td>
                    </tr>
                ';
            }
        }
        else
        {
            $output .= '
                    <tr>
                        <td colspan="4">Sản phẩm này chưa có ảnh</td>
                    </tr>
                ';
        }
        $output.= '
                </tbody>
            </table>
        ';

        echo $output;
    }
}

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

    public function update_gallery_name(Request $request)
    {
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;

        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }

    public function delete_gallery(Request $request)
    {
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('upload/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }

    public function update_gallery(Request $request)
    {
        $gal_id = $request->gal_id;
        $get_image = $request->file('file');
        if($get_image)
        {  
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/gallery', $new_image);

            $gallery = Gallery::find($gal_id);
            unlink('upload/gallery/'.$gallery->gallery_image);
            $gallery->gallery_image = $new_image;
            $gallery->save();
        }
        // return redirect()->back()->with('message', 'Thêm thư viện ảnh thành công');
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
        }
        return redirect()->back()->with('message', 'Thêm thư viện ảnh thành công');
    }

    public function select_gallery(Request $request)
    {
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
            <form>
            '.csrf_field().'
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

                            <td contenteditable class="edit_gal_name" data-gal_id="'.$gal->gallery_id.'">'.$gal->gallery_name.'</td>

                            <td>
                                <img src="'.url('upload/gallery/'.$gal->gallery_image).'" class="img-thumbnail" style="width: 100px; height: 100px !important;">

                                <input type="file" class="file_image" style="width: 40%;" data-gal_id="'.$gal->gallery_id.'" id="file-'.$gal->gallery_id.'" name="file" accept="image/*" />
                            </td>

                            <td>
                                <button type="button" data-gal_id="'.$gal->gallery_id.'" class="btn btn-sm btn-danger delete-gallery">Xóa</button>
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
            </form>
        ';

        echo $output;
    }
}

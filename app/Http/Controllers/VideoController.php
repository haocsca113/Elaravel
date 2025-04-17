<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;    
use App\Models\CategoryPost;     
use App\Models\Video;     
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
session_start();

class VideoController extends Controller
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

    public function video()
    {
        return view('admin.video.list_video');
    }

    public function insert_video(Request $request)
    {
        $data = $request->all();
        $video = new Video();
        $sub_link = substr($data['video_link'], 17); // cat 17 ki tu
        $video->video_title = $data['video_title'];
        $video->video_slug = $data['video_slug'];
        $video->video_link = $sub_link;
        $video->video_desc = $data['video_desc'];

        $get_image = $request->file('file');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();

            $get_image->move('upload/video', $new_image);
            $video->video_image = $new_image;
        }
        $video->save();
    }

    public function delete_video(Request $request)
    {
        $data = $request->all();
        $video_id = $data['video_id'];
        $video = Video::find($video_id);
        unlink('upload/video/'.$video->video_image);
        $video->delete();
    }

    public function update_video(Request $request)
    {
        $data = $request->all();
        $video_id = $data['video_id'];
        $video_edit = $data['video_edit'];
        $video_check = $data['video_check'];
        $video = Video::find($video_id);
        
        if($video_check == 'video_title')
        {
            $video->video_title = $video_edit;
        }
        else if($video_check == 'video_slug')
        {
            $video->video_slug = $video_edit;
        }
        else if($video_check == 'video_link')
        {
            $sub_link = substr($video_edit, 17);
            $video->video_link = $sub_link;
        }
        else if($video_check == 'video_desc')
        {
            $video->video_desc = $video_edit;
        }
        $video->save();
    }

    public function update_video_image(Request $request)
    {
        $video_id = $request->video_id;
        $get_image = $request->file('file');
        if($get_image)
        {  
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/video', $new_image);

            $video = Video::find($video_id);
            unlink('upload/video/'.$video->video_image);
            $video->video_image = $new_image;
            $video->save();
        }
    }

    public function select_video(Request $request)
    {
        $video = Video::orderBy('video_id', 'DESC')->get();
        $video_count = $video->count();
        $output = '
            <form>
            '.csrf_field().'
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên video</th>
                            <th>Slug video</th>
                            <th>Hình ảnh video</th>
                            <th>Link</th>
                            <th>Mô tả</th>
                            <th>Demo video</th>
                            <th>Quản lý</th>
                        </tr>
                    </thead>

                    <tbody>
            ';
        if($video_count > 0)
        {
            $i = 0;
            foreach($video as $key => $vid)
            {
                $i++;
                $output .= ' 
                        <tr>
                            <td>'.$i.'</td>
                            <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_title" class="video_edit" id="video_title_'.$vid->video_id.'">'.$vid->video_title.'</td>

                            <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_slug" class="video_edit" id="video_slug_'.$vid->video_id.'">'.$vid->video_slug.'</td>

                            <td>
                                <img src="'.url('upload/video/'.$vid->video_image).'" style="width: 80px; height: 80px;">

                                <input type="file" class="file_img_video" data-video_id="'.$vid->video_id.'" id="file-video-'.$vid->video_id.'" name="file" accept="image/*" />
                            </td>

                            <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_link" class="video_edit" id="video_link_'.$vid->video_id.'">https://youtu.be/'.$vid->video_link.'</td>

                            <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_desc" class="video_edit" id="video_desc_'.$vid->video_id.'">'.$vid->video_desc.'</td>

                            <td>
                                <iframe width="200" height="200" src="https://www.youtube.com/embed/'.$vid->video_link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </td>

                            <td><button type="button" data-video_id="'.$vid->video_id.'" class="btn btn-sm btn-danger btn-delete-video">Xóa video</button></td>
                        </tr>
                ';
            }
        }
        else
        {
            $output .= '
                    <tr>
                        <td colspan="4">Chưa có video nào</td>
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
    // End Admin Page

    public function video_shop(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Video Bóng Đá Pogshop';
        $meta_keywords = 'video bong da, football player, defender';
        $meta_title = 'Video Pogshop';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $all_video = Video::orderBy('video_id', 'DESC')->paginate(6);

        return view('pages.video.video')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'all_video'));
    }

    public function watch_video(Request $request)
    {
        $video_id = $request->video_id;
        $video = Video::find($video_id);
        $output['video_title'] = $video->video_title;
        $output['video_desc'] = $video->video_desc;
        $output['video_link'] = '<iframe width="100%" height="300" src="https://www.youtube.com/embed/'.$video->video_link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
        
        echo json_encode($output);
    }
}

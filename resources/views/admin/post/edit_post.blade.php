@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật bài viết
            </header>
            <div class="panel-body">
                <?php
                    $message = Session::get('message');
                    if($message)
                    {
                        echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                        Session::put('message', null);
                    }
                ?>
                <div class="position-center">
                    <form role="form" action="{{ url('/update-post/'.$edit_post->post_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên bài viết</label>
                            <input type="text" name="post_title" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{ $edit_post->post_title }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="post_slug" class="form-control" id="convert_slug" value="{{ $edit_post->post_title }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả bài viết</label>
                            <textarea type="text" name="post_desc" class="form-control" style="resize: none;" rows="5" id="ckeditor1">
                                {{ $edit_post->post_desc }}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung bài viết</label>
                            <textarea type="text" name="post_content" class="form-control" style="resize: none;" rows="5" id="ckeditor2">
                                {{ $edit_post->post_content }}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta nội dung</label>
                            <textarea type="text" name="post_meta_desc" class="form-control" style="resize: none;" rows="5" id="exampleInputPassword1">
                                {{ $edit_post->post_meta_desc }}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta từ khóa</label>
                            <textarea type="text" name="post_meta_keywords" class="form-control" style="resize: none;" rows="5" id="exampleInputPassword1">
                                {{ $edit_post->post_meta_keywords }}
                            </textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                            <input type="file" name="post_image" class="form-control" id="exampleInputEmail1">
                            <img src="{{ url('upload/post/'.$edit_post->post_image) }}" alt="" height="100" width="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục bài viết</label>
                            <select name="cate_post_id" class="form-control input-sm m-bot15">
                                @foreach($cate_post as $key => $cate)
                                    @if($cate->cate_post_id == $edit_post->cate_post_id)
                                        <option selected value="{{ $cate->cate_post_id }}">{{ $cate->cate_post_name }}</option>
                                    @else
                                        <option value="{{ $cate->cate_post_id }}">{{ $cate->cate_post_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="post_status" class="form-control input-sm m-bot15">
                                @if($edit_post->post_status == 0)
                                    <option selected value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                @else
                                    <option value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                @endif
                            </select>
                        </div>
                        
                        <button type="submit" name="update_post" class="btn btn-info">Cập nhật bài viết</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@extends('welcome')
@section('content')

<div id="contact-page" class="container-fluid">
    <div class="bg">
        <div class="row">    		
            <div class="col-sm-12">    			   			
                <h2 class="title text-center">Hướng dẫn mua hàng</h2>
                @php
                    $html = file_get_contents(public_path('/html/huongdanmuahang.htm'));
                    $html = mb_convert_encoding($html, 'UTF-8', 'HTML-ENTITIES');

                    // Thay đổi đường dẫn ảnh cho đúng
                    $html = str_replace('src="huongdanmuahang_files/', 'src="/html/huongdanmuahang_files/', $html);

                    // Thay ảnh JPG thành PNG (nếu tồn tại bản PNG tương ứng)
                    $html = preg_replace_callback('/<img[^>]+src="(?:\/html\/)?huongdanmuahang_files\/(image0\d+)\.jpg"/i', function($matches) {
                        $jpgPath = public_path("html/huongdanmuahang_files/{$matches[1]}.jpg");
                        $pngPath = public_path("html/huongdanmuahang_files/{$matches[1]}.png");

                        if (file_exists($pngPath)) {
                            return str_replace("{$matches[1]}.jpg", "{$matches[1]}.png", $matches[0]);
                        }
                        return $matches[0];
                    }, $html);
                @endphp

                <div id="" class="huongdan">
                    {!! $html !!}
                </div>
            </div>			 		
        </div> 
    </div>	
</div><!--/#contact-page-->

@endsection
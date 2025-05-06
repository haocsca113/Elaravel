@extends('welcome')
@section('content')

<div id="contact-page" class="container-fluid">
    <div class="bg">
        <div class="row">    		
            <div class="col-sm-12">    			   			
                <h2 class="title text-center">Liên hệ với chúng tôi</h2>    			    				    				
                <div id="gmap" class="contact-map">
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.858169091033!2d106.68427047387132!3d10.822164158350793!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174deb3ef536f31%3A0x8b7bb8b7c956157b!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBUUC5IQ00!5e0!3m2!1svi!2s!4v1743148059579!5m2!1svi!2s" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    @foreach($contact as $key => $cont)
                        {!! $cont->info_map !!}
                    @endforeach
                </div>
            </div>			 		
        </div>

        <div class="row">  	
            <div class="col-sm-12">
                <div class="contact-info">
                    <h2 class="title text-center">Thông tin liên hệ</h2>
                    <address>
                        @foreach($contact as $key => $cont)
                            {!! $cont->info_contact !!}
                            <p>
                                {!! $cont->info_fanpage !!}
                            </p>
                        @endforeach
                        {{-- <p>Tên cửa hàng: Pogshop</p>
                        <p>Địa chỉ: 12 Nguyễn Văn Bảo, Phường 1, Gò Vấp, TP. Hồ Chí Minh</p>
                        <p>Số điện thoại: 0988820943</p>
                        <p>Email: haocsca113@gmail.com</p>
                        <p>
                            Fanpage: <a href="https://www.facebook.com/profile.php?id=61574220393317" target="_blank">Pogshop</a>
                            
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v22.0&appId=539138461964175"></script>

                            <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=61574220393317" data-tabs="message" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/profile.php?id=61574220393317" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/profile.php?id=61574220393317">Pogshop</a></blockquote></div>
                        </p> --}}
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Social Networking</h2>
                        <ul>
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>    			
        </div>  
    </div>	
</div><!--/#contact-page-->

@endsection
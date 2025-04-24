<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}">
    <meta name="robots" content="INDEX, FOLLOW">
	<link rel="canonical" href="{{ $url_canonical }}">
    <meta name="author" content="">
	<link rel="icon" type="image/x-icon" href="">
    <title>{{ $meta_title }} </title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	{{-- <meta property="og:image" content=""> --}}
	<meta property="og:site_name" content="{{ $url_canonical }}">
	<meta property="og:description" content="{{ $meta_desc }}">
	<meta property="og:title" content="{{ $meta_title }}">
	<meta property="og:url" content="{{ $url_canonical }}">
	<meta property="og:type" content="website">
	
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/lightgallery.min.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/lightslider.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/prettify.css') }}" rel="stylesheet">

	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css" type="text/css"> --}}


    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{ ('frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ ('frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ ('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ ('frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ ('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> 0988820943</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> haocsca113@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{ url('/trang-chu') }}"><img src="{{ asset('frontend/images/pogshop_logo.png') }}" style="width: 80px; height: 50px;" alt="" /></a>
						</div>
						<div class="btn-group" style="margin-left: 20px;">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								{{-- <li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-user"></i> Tài khoản</a></li> --}}
								<li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>

								<?php
									$customer_id = Session::get('customer_id');
									$shipping_id = Session::get('shipping_id');
									if($customer_id !== NULL && $shipping_id == NULL){
								?>
									<li><a href="{{ URL::to('/checkout') }}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}
									elseif($customer_id !== NULL && $shipping_id !== NULL){
								?>
									<li><a href="{{ URL::to('/payment') }}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}
									else{
								?>
									<li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-lock"></i> Thanh toán</a></li>
								<?php
									}
								?>
								
								<li><a href="{{ URL::to('/gio-hang') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>

								<li><a href="{{ URL::to('/order-tracking') }}"><i class="fa fa-truck"></i> Theo dõi đơn hàng</a></li>

								<?php
									$customer_id = Session::get('customer_id');
									$customer_name = Session::get('customer_name');
								?>

								<li class="dropdown">
									<?php
										if($customer_id != NULL){
									?>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-user"></i> {{ $customer_name }} <b class="caret"></b>
									</a>
									<ul class="dropdown-menu">
										<li><a href="{{ URL::to('/my-order') }}"><i class="fa fa-list"></i> Đơn hàng của tôi</a></li>
										<li><a href="{{ URL::to('/logout-checkout') }}"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
									</ul>

									<?php
										}else{
									?>
										<li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
									<?php
										}
									?>
								</li>	
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{ URL::to('trang-chu') }}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="#">Products</a></li>	
                                    </ul>
                                </li> 

								<li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										@foreach($cate_post as $key => $danhmucbaiviet)
											<li><a href="{{ url('/danh-muc-bai-viet/'.$danhmucbaiviet->cate_post_slug) }}">{{ $danhmucbaiviet->cate_post_name }}</a></li>	
										@endforeach
                                    </ul>
                                </li> 

								<li><a href="{{ URL::to('/gio-hang') }}">Giỏ hàng</a></li>

								<li><a href="{{ URL::to('/video-shop') }}">Video</a></li>

								<li><a href="{{ url('/contact-us') }}">Liên hệ</a></li>

								<li><a href="{{ url('/buying-guide') }}">Hướng dẫn mua hàng</a></li>

							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<form action="{{ URL::to('/tim-kiem') }}" autocomplete="off" method="post">
							{{ csrf_field() }}
							<div class="search_box pull-right" style="width: 100%;">
								<input type="text" name="keywords" id="keywords" placeholder="Tìm kiếm sản phẩm"/>
								<input type="submit" name="search_item" class="btn btn-primary btn-sm" value="Tìm kiếm" style="margin-top: 0; color: #fff; width: 90px;">

								<div id="search-ajax"></div>
							</div>
						</form>
						
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							@php
								$i = 0;
							@endphp
							@foreach($banner as $key => $ban)
								@php
									$i++;
								@endphp
								<div class="item {{ $i == 1 ? 'active' : '' }}">
									{{-- <div class="col-sm-6">
										<h1><span>E</span>-SHOPPER</h1>
										<h2>Free E-Commerce Template</h2>
										<p>{{ $ban->banner_desc }}</p>
										<button type="button" class="btn btn-default get">Get it now</button>
									</div> --}}
									<div class="col-sm-12">
										<img src="{{ url('upload/banner/'.$ban->banner_image) }}" alt="{{ $ban->banner_desc }}" height="400" width="100%" class="">
									</div>
								</div>
							@endforeach
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-products-->
							@foreach($category as $key => $cate)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="{{ URL::to('/danh-muc-san-pham/'.$cate->category_id) }}">{{ $cate->category_name }}</a></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu sản phẩm</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach($brand as $key => $brand)
									<li><a href="{{ URL::to('/thuong-hieu-san-pham/'.$brand->brand_id) }}"> <span class="pull-right"></span>{{ $brand->brand_name }}</a></li>
									@endforeach
								</ul>
							</div>
						</div><!--/brands_products-->
						

					</div>
				</div>
				
				<div class="col-sm-9 padding-right">

					@yield('content')
					
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<style>
				.companyinfo, .video-gallery
				{
					margin: 0;
				}
			</style>

			<div class="container" style="padding: 0;">
				<div class="row" style="padding: 30px 0;">
					<div class="col-sm-2">
						<div class="companyinfo text-center">
							<a href="{{ url('/trang-chu') }}"><img src="{{ asset('frontend/images/pogshop_logo_rmbg.png') }}" style="width: 70%; height: 80px;" alt="" /></a>
							<h2 style="margin: 0;">Pogshop</h2>
						</div>
					</div>

					<div class="col-sm-7" style="margin-top: 10px;">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/maldini1.webp') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Football Player</p>
								<h2>Maldini</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/ramos2.webp') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Football Player</p>
								<h2>Ramos</h2>
							</div>
						</div>
                        <div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/vandijk1.webp') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Football Player</p>
								<h2>Van Dijk</h2>
							</div>
						</div>
                        <div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/rudiger1.jpg') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Football Player</p>
								<h2>Rudiger</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<style>
				.single-widget ul li a
				{
					padding: 0;
				}
				.single-widget ul
				{
					color: #8C8C88;
				}
			</style>

			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							
						</div>
					</div>

					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Thông tin liên hệ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li>Địa Chỉ : 12 Nguyễn Văn Bảo, Phường 1, Gò Vấp, TP.HCM</li>
								<li>Số điện thoại : 0988820943</li>
								<li>Email : haocsca113@gmail.com</li>
								<li>Website : https://pogshop.online/</li>
							</ul>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Hướng dẫn</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="{{ url('/buying-guide') }}">Hướng dẫn mua hàng</a></li>
							</ul>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Về chúng tôi</h2>
							<ul class="nav nav-pills nav-stacked">
								<li>Là website bán tay cầm</li>
								<li>Yêu thích thể thao và trò chơi điện tử</li>
							</ul>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Về khách hàng</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2025 By Poghao. All rights reserved.</p>
					{{-- <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p> --}}
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->

	<style>
		.contact-box-bottom {
			position: fixed;
			bottom: 54px;
			/* right: 10px; */
			left: 10px;
			z-index: 10000;
		}

		.contact-box-wrapper {
			display: flex;
			align-items: center;
			background: rgb(255, 255, 255);
			margin-bottom: 10px;
			padding: 10px 20px;
			border-radius: 10px;
			box-shadow: rgb(0 0 0 / 8%) 0px 0px 10px 0px;
		}

		.contact-icon-box {
			display: block;
			text-align: center;
			width: 40px;
			height: 40px;
			font-size: 16px;
			line-height: 38px;
			border: 1px solid rgb(229, 229, 229);
			border-radius: 999px;
		}

		.contact-info {
			padding-left: 10px;
		}

		/* Chatbot */
		.chat-container {
            width: 400px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-box {
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
        }
        .message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 8px;
            max-width: 75%;
        }
        .user {
            background: #007bff;
            color: white;
            align-self: flex-end;
            text-align: right;
        }
        .bot {
            background: #f1f1f1;
            color: black;
            align-self: flex-start;
        }
        .input-container {
            display: flex;
        }
        input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 5px;
            cursor: pointer;
        }
	</style>

	<div class="contact-box-bottom">
		<a class="contact-box-wrapper nut-chat-facebook" href="https://www.facebook.com/profile.php?id=61574220393317" target="_blank">
			<div class="contact-icon-box" style="border: none;">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><radialGradient id="a" cx="101.9" cy="809" r="1.1" gradientTransform="matrix(800 0 0 -800 -81386 648000)" gradientUnits="userSpaceOnUse"><stop offset="0" style="stop-color:#09f"></stop><stop offset=".6" style="stop-color:#a033ff"></stop><stop offset=".9" style="stop-color:#ff5280"></stop><stop offset="1" style="stop-color:#ff7061"></stop></radialGradient><path fill="url(#a)" d="M400 0C174.7 0 0 165.1 0 388c0 116.6 47.8 217.4 125.6 287 6.5 5.8 10.5 14 10.7 22.8l2.2 71.2a32 32 0 0 0 44.9 28.3l79.4-35c6.7-3 14.3-3.5 21.4-1.6 36.5 10 75.3 15.4 115.8 15.4 225.3 0 400-165.1 400-388S625.3 0 400 0z"></path><path fill="#FFF" d="m159.8 501.5 117.5-186.4a60 60 0 0 1 86.8-16l93.5 70.1a24 24 0 0 0 28.9-.1l126.2-95.8c16.8-12.8 38.8 7.4 27.6 25.3L522.7 484.9a60 60 0 0 1-86.8 16l-93.5-70.1a24 24 0 0 0-28.9.1l-126.2 95.8c-16.8 12.8-38.8-7.3-27.5-25.2z"></path>
				</svg>
			</div>
			
			<div class="contact-info">
				<b>Chat Facebook</b>
			</div>
		</a>

		<a class="contact-box-wrapper nut-chat-zalo" href="https://zalo.me/0988820943" rel="nofollow" target="_blank">
			<div class="contact-icon-box" style="border: none;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 161.5 161.5"><path d="M504.54,431.79h14.31c19.66,0,31.15,2.89,41.35,8.36a56.65,56.65,0,0,1,23.65,23.65c5.47,10.2,8.36,21.69,8.36,41.35V519.4c0,19.66-2.89,31.15-8.36,41.35a56.65,56.65,0,0,1-23.65,23.65c-10.2,5.47-21.69,8.36-41.35,8.36H504.6c-19.66,0-31.15-2.89-41.35-8.36a56.65,56.65,0,0,1-23.65-23.65c-5.47-10.2-8.36-21.69-8.36-41.35V505.14c0-19.66,2.89-31.15,8.36-41.35a56.65,56.65,0,0,1,23.65-23.65C473.39,434.68,484.94,431.79,504.54,431.79Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path><path d="M592.21,517v2.35c0,19.66-2.89,31.15-8.35,41.35a56.65,56.65,0,0,1-23.65,23.65c-10.2,5.47-21.69,8.36-41.35,8.36H504.6c-16.09,0-26.7-1.93-35.62-5.63L454.29,572Z" transform="translate(-431.25 -431.25)" style="fill:#001a33;opacity:0.11999999731779099;isolation:isolate"></path><path d="M455.92,572.51c7.53.83,16.94-1.31,23.62-4.56,29,16,74.38,15.27,101.84-2.3q1.6-2.4,3-5c5.49-10.24,8.39-21.77,8.39-41.5v-14.3c0-19.73-2.9-31.26-8.39-41.5a56.86,56.86,0,0,0-23.74-23.74c-10.24-5.49-21.77-8.39-41.5-8.39H504.76c-16.8,0-27.71,2.12-36.88,6.15q-.75.67-1.47,1.37c-26.89,25.92-28.93,82.11-6.13,112.64l.08.14c3.51,5.18.12,14.24-5.18,19.55C454.32,571.89,454.63,572.39,455.92,572.51Z" transform="translate(-431.25 -431.25)" style="fill:#fff"></path><path d="M497.35,486.34H465.84v6.76h21.87l-21.56,26.72a6.06,6.06,0,0,0-1.17,4v1.72h29.73a2.73,2.73,0,0,0,2.7-2.7v-3.62h-23l20.27-25.43,1.11-1.35.12-.18a8,8,0,0,0,1.41-5Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path><path d="M537.47,525.54H542v-39.2h-6.76v36.92A2.27,2.27,0,0,0,537.47,525.54Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path><path d="M514.37,495.07a15.36,15.36,0,1,0,15.36,15.36A15.36,15.36,0,0,0,514.37,495.07Zm0,24.39a9,9,0,1,1,9-9A9,9,0,0,1,514.37,519.46Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path><path d="M561.92,494.82A15.48,15.48,0,1,0,577.4,510.3,15.5,15.5,0,0,0,561.92,494.82Zm0,24.64a9.09,9.09,0,1,1,9.09-9.09A9.07,9.07,0,0,1,561.92,519.46Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path><path d="M526.17,525.54h3.62V495.93h-6.33v27A2.72,2.72,0,0,0,526.17,525.54Z" transform="translate(-431.25 -431.25)" style="fill:#0068ff"></path></svg></div>
			<div class="contact-info">
			  <b>Chat Zalo</b>
			  
			</div>
		</a>

		<a class="contact-box-wrapper nut-goi-hotline" href="tel:0988820943">
			<div class="contact-icon-box" style="color: #ed1b24; font-size: 25px;">
				<i class="fa fa-phone" aria-hidden="true"></i>
			</div>
			
			<div class="contact-info">
				<b>0988820943</b>
			</div>
		</a>
	</div>


	{{-- <div class="chat-container">
        <div class="chat-box" id="chatBox">
			<div class="mb-2" style="margin-bottom: 20px;">
				<div class="float-right px-3 py-2" style="width: 270px; background: #4acfee; border-radius: 10px; float: right; height: 40px; line-height: 40px; padding: 0 10px;">
					Hello World
				</div>
				<div style="clear: both;"></div>
			</div>

			<div class="d-flex mb-2" style="margin-bottom: 10px;">
				<div class="mr-2" style="width: 45px; height: 45px;">
					<div class="text-white px-3 py-2" style="width: 270px; background: #13254b; border-radius: 10px; height: 40px; line-height: 40px; padding: 0 10px; color: #fff;">
						I'm chat bot
					</div>
				</div>
			</div>
		</div>

        <div class="input-container">
            <input type="text" id="userInput" placeholder="Nhập tin nhắn...">
            <button id="button-submit">Gửi</button>
        </div>
    </div> --}}

  
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
	<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('frontend/js/prettify.js') }}"></script>

	{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
	<script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>

	<style>
		#botmanWidgetRoot div[style*="position: fixed"] {
			bottom: 40px !important;
		}
	</style>
	
	<script>
		var botmanWidget = {
			aboutText: 'Welcome',
			introMessage: 'Hi, By Poghao',
		}
	</script>

	<script>
		$('.xemnhanh').click(function(){
			var product_id = $(this).data('id_product');
			$.ajax({
				url: "{{ url('/quickview') }}",
				method: "POST",
				headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				dataType: "JSON",
				data: {product_id: product_id},
				success: function(data){
					$('#product_quickview_title').html(data.product_name);
					$('#product_quickview_id').html(data.product_id);
					$('#product_quickview_price').html(data.product_price);
					$('#product_quickview_image').html(data.product_image);
					$('#product_quickview_gallery').html(data.product_gallery);
					$('#product_quickview_desc').html(data.product_desc);
					$('#product_quickview_content').html(data.product_content);
					$('#product_quickview_value').html(data.product_quickview_value);
					$('#product_quickview_button').html(data.product_button);
				}
			});
		});
	</script>

	<script>
		$('#keywords').keyup(function(){
			var query = $(this).val();
			if(query != '')
			{
				$.ajax({
					url: "{{ url('/autocomplete-ajax') }}",
					method: "POST",
					headers:{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {query: query},
					success: function(data){
						$('#search-ajax').fadeIn();
						$('#search-ajax').html(data);
					}
				});
			}
			else
			{
				$('#search-ajax').fadeOut();
			}
		});

		$(document).on('click', '.li_search_ajax', function(){
			$('#keywords').val($(this).text());
			$('#search-ajax').fadeOut();
		});
	</script>

	<script>
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery:true,
				item:1,
				loop:true,
				thumbItem:3,
				slideMargin:0,
				enableDrag: false,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}   
			});  
		});
	</script>

	<script>
		$(document).on('click', '.watch-video', function(){
			var video_id = $(this).attr('id');
			$.ajax({
				url: "{{ url('/watch-video') }}",
				method: "POST",
				headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				dataType: "JSON",
				data: {video_id: video_id},
				success: function(data){
					$('#video_title').html(data.video_title);
					$('#video_link').html(data.video_link);
					$('#video_desc').html(data.video_desc);
				}
			});
		});
	</script>

	<script>
		$(document).ready(function(){
			$('.send_order').click(function(){
				swal({
					title: "Xác nhận đơn hàng",
					text: "Bạn có chắc chắn muốn đặt hàng không?",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "Không mua",
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Cảm ơn, mua hàng",
					closeOnConfirm: false
				},
				function(isConfirm){
					if (isConfirm) {
						var shipping_email = $('.shipping_email').val();
						var shipping_name = $('.shipping_name').val();
						var shipping_address = $('.shipping_address').val();
						var shipping_phone = $('.shipping_phone').val();
						var shipping_note = $('.shipping_note').val();
						var shipping_method = $('.payment_select').val();
						var order_fee = $('.order_fee').val();
						var order_coupon = $('.order_coupon').val();
						var _token = $('input[name="_token"]').val();
						
						$.ajax({
							url: '{{ url('/confirm-order') }}',
							method: 'POST',
							data: {
								shipping_email: shipping_email,
								shipping_name: shipping_name,
								shipping_address: shipping_address,
								shipping_phone: shipping_phone,
								shipping_note: shipping_note,
								shipping_method: shipping_method,
								order_fee: order_fee,
								order_coupon: order_coupon,
								_token: _token,
							},
							success: function(data){
								if (shipping_method == 0) {
									window.location.href = "{{ url('/payment-info') }}";
								} 
								else if(shipping_method == 1) 
								{
									swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
									setTimeout(function(){
										location.reload();
									}, 3000);
								}
								else if(shipping_method == 2)
								{
									var form = $('<form action="{{ url('/vnpay-payment') }}" method="POST"></form>');
									form.append('@csrf');
									form.append('<input type="hidden" name="vnp_Url" value="' + data.data + '">');

									$('body').append(form);
									form.submit();
								} 
								else if(shipping_method == 3)
								{
									var form = $('<form action="{{ url('/momo-payment') }}" method="POST"></form>');
									form.append('@csrf');
									form.append('<input type="hidden" name="payUrl" value="' + data.data + '">');

									$('body').append(form);
									form.submit();
								} 
							},
						});
					}
					else
					{
						swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");
					}
				});
			});
		});
	</script>

	<script>
		$(document).ready(function(){
			$('.add-to-cart').click(function(){
				var id = $(this).data('id');
				var cart_product_id = $('.cart_product_id_' + id).val();
				var cart_product_name = $('.cart_product_name_' + id).val();
				var cart_product_image = $('.cart_product_image_' + id).val();
				var cart_product_quantity = $('.cart_product_quantity_' + id).val();
				var cart_product_price = $('.cart_product_price_' + id).val();
				var cart_product_qty = $('.cart_product_qty_' + id).val();
				var _token = $('input[name="_token"]').val();
				if(parseInt(cart_product_qty) > parseInt(cart_product_quantity))
				{
					alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
				}
				else
				{
					$.ajax({
						url: '{{ url('/add-cart-ajax') }}',
						method: 'POST',
						data: {
							cart_product_id: cart_product_id,
							cart_product_name: cart_product_name,
							cart_product_image: cart_product_image,
							cart_product_price: cart_product_price,
							cart_product_quantity: cart_product_quantity,
							cart_product_qty: cart_product_qty,
							_token: _token,
						},
						success: function(data){
							swal({
								title: "Đã thêm sản phẩm vào giỏ hàng",
								text: "Bạn có thể mua hàng tiếp và tới giỏ hàng để thanh toán",
								showCancelButton: true,
								cancelButtonText: "Xem tiếp",
								confirmButtonClass: "btn-success",
								confirmButtonText: "Đi đến giỏ hàng",
								closeOnConfirm: false
								}, function(isConfirm){
									if (isConfirm) {
										window.location.href = "{{ url('/gio-hang') }}";
									}
								});
						},
					});
				}
			});
		});
	</script>

	<!-- Add to cart quickview -->
	<script>
		$(document).on('click', '.add-to-cart-quickview', function(){
			var id = $(this).data('id_product');
			var cart_product_id = $('.cart_product_id_' + id).val();
			var cart_product_name = $('.cart_product_name_' + id).val();
			var cart_product_image = $('.cart_product_image_' + id).val();
			var cart_product_quantity = $('.cart_product_quantity_' + id).val();
			var cart_product_price = $('.cart_product_price_' + id).val();
			var cart_product_qty = $('.cart_product_qty_' + id).val();
			var _token = $('input[name="_token"]').val();
			if(parseInt(cart_product_qty) > parseInt(cart_product_quantity))
			{
				alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
			}
			else
			{
				$.ajax({
					url: '{{ url('/add-cart-ajax') }}',
					method: 'POST',
					data: {
						cart_product_id: cart_product_id,
						cart_product_name: cart_product_name,
						cart_product_image: cart_product_image,
						cart_product_price: cart_product_price,
						cart_product_quantity: cart_product_quantity,
						cart_product_qty: cart_product_qty,
						_token: _token,
					},
					beforeSend: function(){
						$("#beforesend_quickview").html("<p class='text text-primary'>Đang thêm sản phẩm vào giỏ hàng</p>");
					},
					success: function(data){
						$("#beforesend_quickview").html("<p class='text text-success'>Đã thêm sản phẩm vào giỏ hàng</p>");
					},
				});
			}
		});

		$(document).on('click', '.redirect-cart', function(){
			window.location.href = "{{ url('/gio-hang') }}";
		});
	</script>

	<script>
		$(document).ready(function(){
			$('.choose').on('change', function(event){
				event.preventDefault();
				var action = $(this).attr('id');
				var ma_id = $(this).val();
				var _token = $('input[name="_token"]').val();
				var result = '';
			   
				if(action == 'city')
				{
					result = 'province';
				}
				else
				{
					result = 'ward';
				}
	
				$.ajax({
					url: '{{ url('/select-delivery-home') }}',
					method: 'POST',
					data: {
						action: action,
						ma_id: ma_id,
						_token: _token,
					},
					success: function(data){
						$('#' + result).html(data);
					},
				});
			});
		});
	</script>

	<script>
		$(document).ready(function(){
			$('.calculate_delivery').click(function(){
				console.log('Button clicked!');
				var matp = $('.city').val();
				var maqh = $('.province').val();
				var xaid = $('.ward').val();
				var _token = $('input[name="_token"]').val();

				console.log('matp:', matp, 'maqh:', maqh, 'xaid:', xaid);
				if(matp == '' && maqh == '' && xaid == '')
				{
					alert('Làm ơn chọn để tính phí vận chuyển');
				}
				else
				{
					$.ajax({
						url: '{{ url('/calculate-fee') }}',
						method: 'POST',
						data: {
							matp: matp,
							maqh: maqh,
							xaid: xaid,
							_token: _token,
						},
						success: function(data){
							location.reload();
						},
					}); 
				}
			});
		});
	</script>

	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v22.0"></script>
</body>
</html>
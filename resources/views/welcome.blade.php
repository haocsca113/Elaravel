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

	{{-- <meta property="og:image" content=""> --}}
	<meta property="og:site_name" content="http://localhost:8080/laravel/webbanhang_tutorial/public/">
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
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
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
							<a href="index.html"><img src="{{ ('frontend/images/home/logo.png') }}" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
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
								

								{{-- <li><a href="{{ URL::to('/show-cart') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li> --}}
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
					<div class="col-sm-8">
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
                                        <li><a href="shop.html">Products</a></li>
										
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                </li> 
								{{-- <li><a href="{{ URL::to('/show-cart') }}">Giỏ hàng</a></li> --}}
								<li><a href="{{ URL::to('/gio-hang') }}">Giỏ hàng</a></li>
								<li><a href="contact-us.html">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<form action="{{ URL::to('/tim-kiem') }}" method="post">
							{{ csrf_field() }}
							<div class="search_box pull-right">
								<input type="text" name="keywords" placeholder="Tìm kiếm sản phẩm"/>
								<input type="submit" name="search_item" class="btn btn-primary btn-sm" value="Tìm kiếm" style="margin-top: 0; color: #fff; width: 90px;">
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
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/iframe1.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/iframe2.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
                        <div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/iframe3.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
                        <div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{ asset('frontend/images/iframe4.png') }}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
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
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
	<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

	{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
	<script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
				var cart_product_price = $('.cart_product_price_' + id).val();
				var cart_product_qty = $('.cart_product_qty_' + id).val();
				var _token = $('input[name="_token"]').val();
				
				$.ajax({
					url: '{{ url('/add-cart-ajax') }}',
					method: 'POST',
					data: {
						cart_product_id: cart_product_id,
						cart_product_name: cart_product_name,
						cart_product_image: cart_product_image,
						cart_product_price: cart_product_price,
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
			});
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
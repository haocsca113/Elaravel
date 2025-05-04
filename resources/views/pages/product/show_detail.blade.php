@extends('welcome')
@section('content')

@foreach($detail_product as $key => $value)
<div class="product-details"><!--product-details-->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: none;">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/danh-muc-san-pham/'.$value->category_id) }}">{{ $product_cate }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $meta_title }}</li>
        </ol>
    </nav>
    <div class="col-sm-5">
        <style>
            #imageGallery li img
            {
                width: 100%;
                height: 329px;
            }

            .lSSlideOuter .lSPager.lSGallery img
            {
                height: 106px;
            }

            li.active
            {
                border: 1px solid #FE980F;
            }
        </style>

        <ul id="imageGallery">
            @foreach($gallery as $key => $gal)
                <li data-thumb="{{ asset('upload/gallery/'.$gal->gallery_image) }}" data-src="{{ asset('upload/gallery/'.$gal->gallery_image) }}">
                    <img src="{{ asset('upload/gallery/'.$gal->gallery_image) }}" alt="{{ $gal->gallery_name }}"/>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{ $value->product_name }}</h2>
            <p>ID: {{ $value->product_id }}</p>
            <img src="images/product-details/rating.png" alt="" />

            <form action=""> {{-- {{ URL::to('/save-cart') }} --}}
                @csrf
                <input type="hidden" class="cart_product_id_{{ $value->product_id }}" value="{{ $value->product_id }}">
                <input type="hidden" class="cart_product_name_{{ $value->product_id }}" value="{{ $value->product_name }}">
                <input type="hidden" class="cart_product_image_{{ $value->product_id }}" value="{{ $value->product_image }}">
                <input type="hidden" class="cart_product_price_{{ $value->product_id }}" value="{{ $value->product_price }}">
                <input type="hidden" class="cart_product_quantity_{{ $value->product_id }}" value="{{ $value->product_quantity }}">
                {{-- <input type="hidden" class="cart_product_qty_{{ $value->product_id }}" value="1"> --}}
            
                <span>
                    <span>{{ number_format($value->product_price).' '.'VNĐ' }}</span>
                    <label>Quantity:</label>
                    <input type="number" class="cart_product_qty_{{ $value->product_id }}" name="qty" min="1" value="1" />
                    <input type="hidden" name="productid_hidden" min="1" value="{{ $value->product_id }}" />
                    
                </span>
                <button type="button" class="btn btn-default add-to-cart" data-id="{{ $value->product_id }}" name="add-to-cart">
                    <i class="fa fa-shopping-cart"></i>
                    Thêm giỏ hàng
                </button>
            </form>
            <p><b>Tình trạng:</b> Còn hàng</p>
            <p><b>Điệu kiện:</b> Mới 100%</p>
            <p><b>Thương hiệu:</b> {{ $value->brand_name }}</p>
            <p><b>Danh mục:</b> {{ $value->category_name }}</p>

            <style>
                a.tags_style
                {
                    margin: 3px 2px;
                    border: 1px solid;
                    height: auto;
                    background: #428bca;
                    color: #fff;
                    padding: 0px;
                }
                a.tags_style:hover
                {
                    background: #000;
                }
            </style>
            <fieldset>
                <legend>Tags</legend>
                <p>
                    <i class="fa fa-tag"></i>
                    @php
                        $tags = $value->product_tags;
                        $tags = explode(",", $tags);
                    @endphp
                    @foreach($tags as $tag)
                        <a href="{{ url('/tag/'.Str::slug($tag)) }}" class="tags_style">{{ $tag }}</a>
                    @endforeach
                </p>
            </fieldset>

            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li><a href="#details" data-toggle="tab">Mô tả</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade" id="details" >
            <p>{!! $value->product_desc !!}</p>       
        </div>
        
        <div class="tab-pane fade" id="companyprofile" >
            <p>{!! $value->product_content !!}</p>        
        </div>
        
        <div class="tab-pane fade active in" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>Admin</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>19:31</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>28/04/2025</a></li>
                </ul>
                
                <style>
                    .style_comment
                    {
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        background: #F0F0E9;
                    }
                </style>

                <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{ $value->product_id }}">
                <div id="comment_show"></div>
                
                <p><b>Viết đánh giá của bạn</b></p>
                
                <form action="#">
                    <span>
                        <input style="width: 100%; margin-left: 0;" type="text" class="comment_name" placeholder="Tên bình luận"/>
                    </span>
                    <textarea name="comment" class="comment_content" placeholder="Nội dung bình luận"></textarea>
                    <div id="notify_comment"></div>
                    <b>Đánh giá sao: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right send-comment">
                        Gửi bình luận
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</div><!--/category-tab-->

@endforeach

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">	
                @foreach($related_product as $key => $lienquan)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                {{-- <img src="{{ URL::to('upload/product/'.$lienquan->product_image) }}" alt="" />
                                <h2>{{ number_format($lienquan->product_price).' '.'VNĐ' }}</h2>
                                <p>{{ $lienquan->product_name }}</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button> --}}

                                <form action="">
                                    @csrf
                                    <input type="hidden" class="cart_product_id_{{ $lienquan->product_id }}" value="{{ $lienquan->product_id }}">
                                    <input type="hidden" class="cart_product_name_{{ $lienquan->product_id }}" value="{{ $lienquan->product_name }}">
                                    <input type="hidden" class="cart_product_image_{{ $lienquan->product_id }}" value="{{ $lienquan->product_image }}">
                                    <input type="hidden" class="cart_product_price_{{ $lienquan->product_id }}" value="{{ $lienquan->product_price }}">
                                    <input type="hidden" class="cart_product_quantity_{{ $lienquan->product_id }}" value="{{ $lienquan->product_quantity }}">
                                    <input type="hidden" class="cart_product_qty_{{ $lienquan->product_id }}" value="1">
        
                                    <a href="{{ URL::to('/chi-tiet-san-pham/'.$lienquan->product_id) }}">
                                        <img src="{{ URL::to('upload/product/'.$lienquan->product_image) }}" alt="" height="250px" />
                                        <h2>{{ number_format($lienquan->product_price, 0, ',', '.').' VNĐ' }}</h2>
                                        <p style="height: 40px;">{{ $lienquan->product_name }}</p>
                                    </a>
                                    <button type="button" class="btn btn-default add-to-cart" data-id="{{ $lienquan->product_id }}" name="add-to-cart">Thêm giỏ hàng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
          
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>			
    </div>
</div><!--/recommended_items-->

@endsection
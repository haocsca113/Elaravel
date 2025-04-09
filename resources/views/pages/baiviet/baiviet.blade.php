@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">{{ $meta_title }}</h2>
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-left">
                    {!! $post->post_content !!}  
                </div>
            </div>
        </div>
</div><!--features_items-->

<style>
    ul.post_relate li
    {
        list-style-type: disc;
        font-size: 16px;
        padding: 6px;
    }
    ul.post_relate li a
    {
        color: #000;
    }
    ul.post_relate li a:hover
    {
        color: #FE980F;
    }
</style>
<h2 class="title text-center" style="margin-bottom: 15px;">Bài viết liên quan</h2>
<ul class="post_relate">
    @foreach($related as $key => $post_relate)
        <li><a href="{{ url('/bai-viet/'.$post_relate->post_slug) }}">{{ $post_relate->post_title }}</a></li>
    @endforeach
</ul>


@endsection
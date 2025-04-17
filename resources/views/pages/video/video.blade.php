@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Video Shop</h2>
    @foreach($all_video as $key => $video)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form action="">
                            @csrf
                            <a href="">
                                <img src="{{ asset('upload/video/'.$video->video_image) }}" alt="{{ $video->video_title }}" height="250px" />
                                <h2 style="height: 80px;">{{ $video->video_title }}</h2>
                                <p style="height: 40px;">{{ $video->video_desc }}</p>
                            </a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary watch-video" data-toggle="modal" data-target="#modal_video" id="{{ $video->video_id }}">
                                Xem video
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div><!--features_items-->

<ul class="pagination pagination-sm m-t-none m-b-none">
    {!! $all_video->links('pagination::bootstrap-4') !!}
</ul>

<!-- Modal xem video -->
<div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="video_title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div id="video_desc"></div>
          <div id="video_link"></div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng video</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal -->

@endsection
@extends('layouts.master')
@section('title','首頁')

@section('content')
        <!--? Hero Area Start-->
        <div class="slider-area ">
            <div class="single-slider slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2 class="hero-title">{{__('Blog').'-'.$cgy->title}}</h2>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <!--? Hero Area End-->

        {{-- 留言便利貼 --}}
        <div class="comments">
			<div class="comment">
				<h3>"手作玩偶"</h3>
				<p> 每次都忍不住想起我們一起笑過、哭過、白癡過！還好有你，分享我人生的每一個時刻💕</p>
				<span class="stars">🌸🌸🌸🌸🌸</span>
			</div>
			<div class="comment">
				<h3>"客製手機殼"</h3>
				<p>永遠都記得我們一起的環島旅行，還有你摔碎的iphone ^^ </p>
				<span class="stars">⭐⭐⭐⭐⭐</span>
			</div>
			<div class="comment">
				<h3>"閨蜜寫真"</h3>
				<p> 跟你約好，走過下一個10年。每次看到你低潮都很捨不得，累的話就回來吧，我們一直都在!</p>
				<span class="stars">💓💓💓💓💓</span>
			</div>
		</div>





        <!--================Blog Area =================-->

        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">

                      <img src="{{asset('img/gift1.png')}}" alt="" class="falling-image-1">
                      <img src="{{asset('img/gift2.png')}}" alt="" class="falling-image-2">
                      <img src="{{asset('img/gift3.png')}}" alt="" class="falling-image-3">
                      <img src="{{asset('img/gift4.png')}}" alt="" class="falling-image-4">
                      <img src="{{asset('img/gift5.png')}}" alt="" class="falling-image-5">

                        <div class="blog_left_sidebar">
                        @foreach ($articles as $article)
                           <article class="blog_item">
                                <div class="blog_item_img">
                                    <img class="card-img rounded-0" src="{{Voyager::image($article->getFirstPic())}}" alt="">
                                    <a href="#" class="blog_item_date">
                                        <h3>{{$article->created_at->isoFormat('Do')}}</h3>
                                        <p>{{$article->created_at->isoFormat('MMM')}}</p>
                                    </a>
                                </div>

                                <div class="blog_details">
                                    <a class="d-inline-block" href="{{url("/blog_details/$article->id")}}">
                                        <h2>{{$article->title}}</h2>
                                    </a>
                                    <p>{{$article->content_small}}</p>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-user"></i> {{$cgy->title}}</a></li>
                                        <li><a href="#"><i class="fa fa-comments"></i> {{$CommQty[$loop->index]}} {{__('Comments')}}</a></li>
                                    </ul>
                                </div>
                            </article>
                            @endforeach
                          {{$articles->links()}}


                            {{-- <nav class="blog-pagination justify-content-center d-flex">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a href="#" class="page-link" aria-label="Previous">
                                            <i class="ti-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link" aria-label="Next">
                                            <i class="ti-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav> --}}
                        </div>
                    </div>
                  @include('includes._blog_sidebar',['enabled'=>0])
                </div>
            </div>
        </section>
        <!--================Blog Area =================-->

 @endsection

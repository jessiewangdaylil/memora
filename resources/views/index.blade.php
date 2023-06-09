@extends('layouts.master')
@section('title','首頁')
@section('content')
        <!--?(1) slider Area Start -->
        <div class="slider-area ">
            <div class="slider-active">
                <!-- Single Slider -->

                @foreach ($sliders as $slider)
                  <div class="single-slider slider-height d-flex align-items-center slide-bg">
                    <div class="container">
                        <div class="row justify-content-between align-items-center">



                            <div class="col-xl-6 col-lg-6 col-md-7">
                                <div class="hero__caption">

                                    <h1 data-animation="fadeInLeft" data-delay=".4s" data-duration="2000ms"> {{$slider->title}} </h1>
                                    <p data-animation="fadeInLeft" data-delay=".7s" data-duration="2000ms"> {{$slider->subtitle}} </p>
                                    <!-- Hero-btn -->
                                    <div class="hero__btn" data-animation="fadeInLeft" data-delay=".8s" data-duration="2000ms">
                                        <a href="{{asset($slider->url)}}" class="btn hero-btn">{{$slider->url_txt}}</a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 d-none d-sm-block">
                                <div class="hero__img" data-animation="bounceIn" data-delay=".4s">
                                    <img src="{{Voyager::image($slider->getFirstPic())}}" alt="" class=" heartbeat">
                                </div>
                            </div> --}}




                        </div>
                    </div>

                 {{-- 紙鶴滑過 --}}
                  <div class="logo-bird-container">
                    <img src="{{asset('img/logo-bird.png')}}" alt="" class="logo-bird" id="logoBird">
                  </div>



                </div>
                @endforeach
            </div>
        </div>
        <!--(1) slider Area End-->

          <!--?(2) Introduction  Start-->
        <div class="Introduction section-padding30">
            <div class="container">
              @foreach ($introductions as $introduction)
                @if ($loop->iteration%2 ==1)
                      {{-- <div class="row align-items-center justify-content-between padding-130">
                        <div class="col-lg-6 col-md-6">
                            <div class="watch-details mb-40">
                                <h2>{{$introduction->title}}</h2>
                                <p>{!!$introduction->content!!}</p>
                                <a href="{{$introduction->url}}<" class="btn">{{$introduction->url_txt}}</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-10">
                            <div class="choice-watch-img mb-40">
                                <img src="{{Voyager::image($introduction->getFirstPic())}}" alt="">
                            </div>
                        </div>
                    </div> --}}
                @else
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-6 col-md-6 col-sm-10">
                            <div class="choice-watch-img mb-40">
                                <img src="{{Voyager::image($introduction->getFirstPic())}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="watch-details mb-40">
                                 <h2>{{$introduction->title}}</h2>
                                {{-- <p>{!!$introduction->content!!}</p> --}}

                                {{-- 前面固定，後面換句翻 --}}
                                {{-- <div class="turn-words-container">
                                  <p class="turn-words">
                                   <span class="turn-words-static">紀念，</span>
                                    <span class="turn-words-scroll">
                                      <span>我們的回憶不變</span>
                                      <span>我們的獨特體驗</span>
                                      <span>我們的驚喜發現</span>
                                      <span>我們的回憶不變</span> <!-- add the first one to the bottom again -->
                                    </span>
                                  </p>
                                </div> --}}



                                <div class="turn-words-container">
                                   <h3 class="turn-words-static">紀念，</h3>
                                    <h3 class="turn-words">
                                        <span class="turn-words-scroll">
                                            <span>我們的回憶不變</span>
                                            <span>我們的獨特體驗</span>
                                            <span>我們的驚喜發現</span>
                                            {{-- <span>我們的回憶不變</span> <!-- 加上第一個元素以循環滾動 --> --}}
                                        </span>
                                      </h3>
                                </div>




                                <a href="{{$introduction->url}}<" class="btn">{{$introduction->url_txt}}</a>
                            </div>
                        </div>
                    </div>
                @endif
              @endforeach
            </div>
        </div>

      {{-- 五線譜 --}}
        <div class="curve-animation">
          <img src="{{asset('img/five-line.png')}}" alt="">
        </div>


        <!--(2) Introduction  End-->
        <!--?(3) Video Area Start -->
        <div class="video-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                    <div class="video-wrap">
                        <div class="play-btn "><a class="popup-video" href="https://www.youtube.com/watch?v=KMc6DyEJp04"><i class="fas fa-play"></i></a></div>
                    </div>
                    </div>
                </div>












                <!-- Arrow -->
                <div class="thumb-content-box">
                    <div class="thumb-content">
                        <h3>品牌形象影片</h3>
                        {{-- <a href="#"> <i class="flaticon-arrow"></i></a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!--(3) Video Area End -->

        {{-- 照片回憶區 --}}

        <div class="Photo-Memory-Container">
          {{-- <!-- last card -->
          <div class="Photo-Memory-Picture">
            <img class="Memory-Picture-img" src="https://media.licdn.com/dms/image/C4D03AQHjPuY9oi3Www/profile-displayphoto-shrink_800_800/0/1579768452204?e=2147483647&v=beta&t=4ZgTgOkSEu2eKRoLWEVtgL8s2zYu80YMxI_0018U9Dk" alt="" />
            <div class="Memory-Picture-note"><span>@DeyJordan - <a class="Network" href="https://codepen.io/DeyJordan" target="_top"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111501.png" alt="CodePen" /></a><a class="Network" href="https://twitter.com/DeyJordan" target="_top"><img src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-logo-vector-png-clipart-1.png" alt="twitter" /></a></span></div>
          </div> --}}
          <!-- other cards -->
          <div class="Photo-Memory-Picture Photo-Memory-Picture-Coupon">
            <img class="Memory-Picture-img" src="https://picsum.photos/id/733/400" alt="" />
            <div class="Memory-Picture-note"><span>點我領取時光驚喜</span></div>
          </div>
          <div class="Photo-Memory-Picture">
            <img class="Memory-Picture-img" src="https://picsum.photos/id/613/400" alt="" />
            <div class="Memory-Picture-note"><span>舊金山</span></div>
          </div>
          <div class="Photo-Memory-Picture">
            <img class="Memory-Picture-img" src="https://picsum.photos/id/923/400" alt="" />
            <div class="Memory-Picture-note"><span>迷霧森林</span></div>
          </div>
          <div class="Photo-Memory-Picture">
            <img class="Memory-Picture-img" src="https://picsum.photos/id/244/400" alt="" />
            <div class="Memory-Picture-note"><span>我們的夏天</span></div>
          </div>
          <div class="Photo-Memory-Picture">
            <img class="Memory-Picture-img" src="{{asset('img/photo-memory.png')}}" alt="" />
            <div class="Memory-Picture-note"><span>"點擊移動，探索更多回憶👀"</span></div>
          </div>
        </div>

        <!--(4)  Photo Memory End -->



       <!--?(5) Popular Article Start -->
        {{-- <div class="popular-items section-padding30">
            <div class="container">
                <!-- Section tittle -->
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-10">
                        <div class="section-tittle mb-70 text-center">
                            <h2>Popular Items</h2>
                            <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular1.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular2.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular3.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular4.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular5.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-popular-items mb-50 text-center">
                            <div class="popular-img">
                                <img src="{{asset('img/gallery/popular6.png')}}" alt="">
                                <div class="img-cap">
                                    <span>Add to cart</span>
                                </div>
                                <div class="favorit-items">
                                    <span class="flaticon-heart"></span>
                                </div>
                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Thermo Ball Etip Gloves</a></h3>
                                <span>$ 45,743</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button -->
                <div class="row justify-content-center">
                    <div class="room-btn pt-70">
                        <a href="catagori.html" class="btn view-btn1">View More Products</a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--(5) Popular Article End -->





        <!--? Shop Method Start-->
        <div class="shop-method-area">
            <div class="container">
                <div class="method-wrapper">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="single-method mb-40">
                                <i class="ti-package"></i>
                                <h6>運送超溫柔</h6>
                                <p>完美呈現，給你最期待的禮物時間</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="single-method mb-40">
                                <i class="ti-unlock"></i>
                                <h6>隱私不用怕</h6>
                                <p>保護你們的親密時光</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="single-method mb-40">
                                <i class="ti-reload"></i>
                                <h6>禮物不喜歡</h6>
                                <p>收禮的朋友們可以自行來網站換貨呦</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Method End-->

 @endsection

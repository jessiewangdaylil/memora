@extends('layouts.master')
@section('title','首頁')
@section('content')
       <!-- Hero Area Start-->
      <div class="slider-area ">
          <div class="single-slider slider-height2 d-flex align-items-center">
              <div class="container">
                  <div class="row">
                      <div class="col-xl-12">
                          <div class="hero-cap text-center">
                              <h2>{{__('Favorites')}}</h2>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--================Cart Area =================-->
      <section class="cart_area section_padding">
        <div class="container">
          <div class="cart_inner">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">{{__('Product')}}</th>
                    <th scope="col">{{__('Price')}}</th>
                    <th scope="col">{{__('Delete')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($likeItems == null)
                  @else
                      @foreach ($likeItems as $item)
                        <tr>
                        <td>
                          <div class="media">
                            <div class="d-flex">
                              <img src="{{Voyager::image($item->getFirstPic())}}" alt="" />
                            </div>
                            <div class="media-body">
                              <p>{{$item->title}}</p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <h5>{{$item->price_new}}</h5>
                        </td>
                      </tr>
                      @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
      </section>
      <!--================End Cart Area =================-->

 @endsection

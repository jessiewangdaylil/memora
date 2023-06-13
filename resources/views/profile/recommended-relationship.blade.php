@extends('layouts.master')
@section('title','首頁')
@section('content')
<!-- Hero Area Start-->
<div class="slider-area ">
  <div class="single-slider slider-height2 d-flex align-users-center">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="hero-cap text-center">
            <h2>{{__('Recommended Relationship')}}</h2>
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
              <th scope="col">{{__('profile')}}</th>
              <th scope="col">{{__('name')}}</th>
              <th scope="col">{{__('desc')}}</th>
              <th scope="col">{{__('invate')}}</th>
            </tr>
          </thead>
          <tbody>
            @if ($users == null)
            @else
            @foreach ($users as $user)
            <tr>
              <td>
                <div class="media">
                  <div class="d-flex">
                    <img src="https://images.unsplash.com/photo-1665699928614-004f7d9f1608?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=855&q=80" alt="" />
                  </div>
                </div>
              </td>
              <td>
                <div class="media-body">
                  <p>{{$user->name}}</p>
                </div>
              </td>
              <td>
                <h5>{{$user->desc}}</h5>
              </td>
               <td>
                <a style="color:black" href="#">製作邀請函</a>
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

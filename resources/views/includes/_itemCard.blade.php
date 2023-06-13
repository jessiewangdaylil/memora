 @foreach ($items as $item)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="single-popular-items mb-50 text-center zoomable">
                                    <div class="popular-img">
                                        <img src="{{Voyager::image($item->getFirstPic())}}" alt="">
                                        <div class="img-cap">
                                      @if(Auth::check())
                                        @if($isLevel2)
                                          @if ($item->stock > 0)
                                            <a href="{{url('/add_item/'.$item->id)}}"><span>{{__('Add to cart')}}</span></a>
                                          @else
                                            <span>{{__('Sold out')}}</span>
                                          @endif
                                        @else
                                         @if ($item->stock > 0)
                                            <a href="{{url('/member_rigister')}}"><span>{{__('Add to cart')}}</span></a>
                                          @else
                                            <span>{{__('Sold out')}}</span>
                                          @endif
                                           {{-- <a href="{{url('/member_rigister')}}"><span>{{__('Activate function')}}</span></a> --}}
                                        @endif
                                      @else
                                          <a href="{{url('/rigister')}}"><span>{{__('register')}}</span></a>
                                      @endif
                                        </div>
                                        @livewire('shop-like',['item'=>$item])
                                        {{-- <div class="favorit-items">
                                            <span class="flaticon-heart"></span>
                                        </div> --}}
                                    </div>
                                    <div class="popular-caption">
                                        <h3><a href="{{url('/product_details/'.$item->id)}}">{{$item->title}}</a></h3>
                                        <span>${{$item->price_new}}</span>
                                    </div>
                                </div>
                            </div>
                          @endforeach

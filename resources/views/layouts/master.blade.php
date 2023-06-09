<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Memora | @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/logo-icon-s.png')}}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('css/slicknav.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
   <link rel="stylesheet" href="{{asset('fontawesome-free-6.2.1-web\css\all.min.css')}}">



   @yield('css')
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.1/dist/cdn.min.js"></script>
   <script src="https://kit.fontawesome.com/2492741ca4.js" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>



   @livewireStyles

</head>

<body>
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{asset('img/logo/logo.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader end -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper">
                        <!-- Logo -->
                        <div class="logo">

                          <a href="{{url('/')}}"><img src="{{Voyager::image(setting('site.logo'))}}" alt=""></a>

                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                              {{menu('header','menu.header')}}
                                {{-- <ul id="navigation">
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li><a href="{{url('/shop')}}">shop</a></li>
                                    <li><a href="{{url('/about')}}">about</a></li>
                                    <li class="hot"><a href="#">Latest</a>
                                        <ul class="submenu">
                                            <li><a href="{{url('/product_list')}}"> Product list</a></li>
                                            <li><a href="{{url('/product_details')}}"> Product Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{url('/blog')}}">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="{{url('/blog')}}">Blog</a></li>
                                            <li><a href="{{url('/blog-details')}}">Blog Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Pages</a>
                                        <ul class="submenu">
                                            <li><a href="{{url('/login')}}">Login</a></li>
                                            <li><a href="{{url('/cart')}}">Cart</a></li>
                                            <li><a href="{{url('/elements')}}">Element</a></li>
                                            <li><a href="{{url('/confirmation')}}">Confirmation</a></li>
                                            <li><a href="{{url('/checkout')}}">Product Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{url('/contact')}}">Contact</a></li>
                                </ul> --}}
                            </nav>
                        </div>


                        <!-- Header Right -->
                        {{-- 右邊懸浮圖示 --}}
                        <div class="header-right">
                            <ul>
                                <li>
                                    <div class="nav-search search-switch">
                                        <span class="flaticon-search"></span>
                                    </div>
                                </li>
                                @if(Auth::check())
                                {{-- <li><a href="{{url('/logout').'/'.Auth::user()->id}}"><i class="fa-solid fa-person-through-window"></i>></a></li> --}}
                                    <li class="centered-icon">
                                      <a href="{{url('/logout1')}}"><i class="fa-solid fa-arrow-right-from-bracket logout-icon"></i></a>
                                    </li>

                                    {{-- <li> <a href="{{url('/dashboard')}}">                                <img src="{{asset('img/logout.png')}}" alt=""></a></li> --}}

                                @else
                                   <li>
                                    <a href="{{url('/login')}}"><span class="flaticon-user"></span></a>
                                  </li>
                                @endif
                                <li class="cart-icon">
                                  <a href="{{url('/cart')}}"><span class="flaticon-shopping-cart"></span></a>
                                </li>

                                <li class="header-right-item">
                                  <a href="{{url('/register')}}"><img class="register-icon" src="{{asset('img/regester-128.png')}}" alt=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>



                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>

    <main>
    @yield('content')
    </main>
    <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="{{url('/index')}}"><img src="{{Voyager::image(setting('site.logo'))}}" alt=""></a>
                                </div>
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <p>{{setting('site.description')}}</p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   {{ menu('footer',"menu.footer")}}
                    {{-- <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Quick Links</h4>
                                <ul>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#"> Offers & Discounts</a></li>
                                    <li><a href="#"> Get Coupon</a></li>
                                    <li><a href="#">  Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>New Products</h4>
                                <ul>
                                    <li><a href="#">Woman Cloth</a></li>
                                    <li><a href="#">Fashion Accessories</a></li>
                                    <li><a href="#"> Man Accessories</a></li>
                                    <li><a href="#"> Rubber made Toys</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Support</h4>
                                <ul>
                                    <li><a href="#">Frequently Asked Questions</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Report a Payment Issue</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- Footer bottom -->
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-8 col-md-7">
                        <div class="footer-copy-right">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> {{__('All rights reserved | This template is made with by')}}{!!setting('site.copyright_icon')!!} <a href="{{setting('site.producer_url')}}" target="_blank">{{setting('site.producer')}}</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-5">
                        <div class="footer-copy-right f-right">
                            <!-- social -->
                            <div class="footer-social">
                                <a href="{{setting('site.Tw_url')}}"><i class="fab fa-twitter"></i></a>
                                <a href="{{setting('site.fb_url')}}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{setting('site.ig_url')}}"><i class="fa-brands fa-instagram"></i></a>
                                <a href="{{setting('site.paypal_url')}}"><i class="fa-brands fa-paypal"></i></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <!--? Search model Begin -->
    <div class="search-model-box">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-btn">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Searching key.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- JS here -->

    <script src="{{asset('js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{asset('js/jquery.slicknav.min.js')}}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/slick.min.js')}}"></script>

    <!-- One Page, Animated-HeadLin -->
    <script src="{{asset('js/wow.min.js')}}"></script>
    <script src="{{asset('js/animated.headline.js')}}"></script>
    <script src="{{asset('js/jquery.magnific-popup.js')}}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('js/jquery.sticky.js')}}"></script>

    <!-- contact js -->
    <script src="{{asset('js/contact.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/mail-script.js')}}"></script>
    <script src="{{asset('js/jquery.ajaxchimp.min.js')}}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{asset('js/plugins.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script>
    <!-- Flash Message Overlay會用到，需保留 -->
    $('#flash-overlay-modal').modal();
    <!-- Flash Message 3秒之後消失，非必須 -->
    $('div.alert').delay(3000).fadeOut(350);


    // logo紙鶴
// var angle = 0;
// var radius = 50; // 自行調整弧線的半徑
// var container = document.querySelector('.hero__image-container');
// var image = container.querySelector('img');

// container.addEventListener('mousemove', function(event) {
//   var rect = container.getBoundingClientRect();
//   var centerX = rect.left + rect.width / 2;
//   var centerY = rect.top + rect.height / 2;
//   var mouseX = event.clientX;
//   var mouseY = event.clientY;
//   var angle = Math.atan2(mouseY - centerY, mouseX - centerX);
//   var x = Math.cos(angle) * radius;
//   var y = Math.sin(angle) * radius;

//   image.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
// });


// 紙鶴滑過
// 緩慢游離
// index
const slideBg = document.querySelector('.slider-height');
const logoBirdContainer = document.querySelector('.logo-bird-container');
const logoBird = document.querySelector('.logo-bird');

slideBg.addEventListener('mousemove', function(e) {
    const containerRect = this.getBoundingClientRect();
    const x = e.clientX - containerRect.left;
    const y = e.clientY - containerRect.top;

    logoBird.style.transform = `translate(${x}px, ${y}px)`;
});



// 準確迅速
// var logoBird = document.getElementById('logoBird');

// document.addEventListener('mousemove', function(event) {
//     var mouseX = event.clientX;
//     var mouseY = event.clientY;

//     // 调整logo-bird元素的位置
//     logoBird.style.left = mouseX + 'px';
//     logoBird.style.top = mouseY + 'px';
// });


// -----------------------------------------------

// 音樂盒圖片縮放
gsap.fromTo('.choice-watch-img', {
  scale: 1,
}, {
  scale: 1.1,
  repeat: -1,
  duration: 6,
  ease: 'power3.inOut',
  yoyo: true
});

// 照片回憶區
const pictures = document.querySelectorAll('.Photo-Memory-Picture');
var previousTouch = undefined;

function updateElementPosition(element, event) {
  var movementX, movementY;

  if (event.type === 'touchmove') {
    const touch = event.touches[0];
    movementX = previousTouch ? touch.clientX - previousTouch.clientX : 0;
    movementY = previousTouch ? touch.clientY - previousTouch.clientY : 0;
    previousTouch = touch;
  } else {
    movementX = event.movementX;
    movementY = event.movementY;
  }

  const elementY = parseInt(element.style.top || 0) + movementY;
  const elementX = parseInt(element.style.left|| 0) + movementX;

  element.style.top = elementY + "px";
  element.style.left = elementX + "px";
}

function startDrag(element, event) {
  const updateFunction = (event) => updateElementPosition(element, event);
  const stopFunction = () => stopDrag({update: updateFunction, stop: stopFunction});
  document.addEventListener("mousemove", updateFunction);
  document.addEventListener("touchmove", updateFunction);
  document.addEventListener("mouseup", stopFunction);
  document.addEventListener("touchend", stopFunction);
}

function stopDrag(functions) {
  previousTouch = undefined;
  document.removeEventListener("mousemove", functions.update);
  document.removeEventListener("touchmove", functions.update);
  document.removeEventListener("mouseup", functions.stop);
  document.removeEventListener("touchend", functions.stop);
}

pictures.forEach(picture => {
  const range = 100;
  const randomX = Math.random() * (range * 2) - range;
  const randomY = Math.random() * (range * 2) - range;
  const randomRotate = Math.random() * (range / 2) - range / 4;
  const startFunction = (event) => startDrag(picture, event);
  picture.style.top = `${randomY}px`;
  picture.style.left = `${randomX}px`;
  picture.style.transform = `translate(-50%, -50%) rotate(${randomRotate}deg)`;
  picture.addEventListener("mousedown", startFunction);
  picture.addEventListener("touchstart", startFunction);
});


//五線譜動態
// 获取目标元素和动画元素
const introductionSection = document.querySelector('.Introduction');
const curveAnimationElement = document.querySelector('.curve-animation img');

// 监听滚动事件
window.addEventListener('scroll', function() {
  // 获取目标元素的位置信息
  const rect = introductionSection.getBoundingClientRect();
  const windowHeight = window.innerHeight;

  // 判断目标元素是否进入视窗
  if (rect.top <= windowHeight) {
    // 添加动画类
    curveAnimationElement.classList.add('animate');
  } else {
    // 移除动画类（可选）
    curveAnimationElement.classList.remove('animate');
  }
});


/* 點擊最後一張跳出優惠碼視窗 */
// 獲取元素
  const photoMemoryPictureCoupon = document.querySelector('.Photo-Memory-Picture-Coupon');

  // 點擊事件監聽器
  photoMemoryPictureCoupon.addEventListener('click', function() {
    // 創建蓋屏視窗元素
    const overlay = document.createElement('div');
    overlay.classList.add('coupon-overlay');

    // 創建蓋屏視窗內容元素
    const overlayContent = document.createElement('div');
    overlayContent.classList.add('coupon-overlay-content');
    overlayContent.innerHTML = '<span>專屬優惠碼給探索中的你: memora2023</span>';

    // 將蓋屏視窗內容添加到蓋屏視窗元素中
    overlay.appendChild(overlayContent);

    // 將蓋屏視窗元素添加到body中
    document.body.appendChild(overlay);

    overlay.addEventListener('click', function(event) {
      if (event.target === overlay) {
        overlay.remove();
      }
    });
  });
























    </script>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
 @livewireScripts
</body>
</html>

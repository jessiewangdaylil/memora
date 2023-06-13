<x-app-layout>
      <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Dashboard') }}
          </h2>
      </x-slot>

      {{-- <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <x-jet-welcome />
              </div>
          </div>
      </div> --}}


      {{-- 會員管理頁面內容 --}}
       <div id="container">
      <div class="content-grid">
        <div class="widget widget-for-account" id="account">
          <div class="profile-picture">
            <img
            src="https://images.unsplash.com/photo-1665699928614-004f7d9f1608?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=855&q=80"
            alt=""
          />
      </div>
          @if(count($userAdvance)==0)
          <h2>等你很久了!</h2>
          <p class="grey">跟我們一起踏上回憶之旅!<br> <a href="{{url('/member_rigister')}}" style="color:#008080">點我一下，開啟導航員功能</a></p>

         @else
          <h2>Hello!導航員</h2>
          <p class="grey">您正在{{substr($date,0,4)}}年{{substr($date,5,2)}}月{{substr($date,8,2)}}日 {{$time}}時空下，<br>旅途進行中...填滿你的__吧</p>

         @endif
          <div class="input">
            <label for="name">{{$name}}</label>
          </div>
          <div class="input">
            <label for="email">Email</label>
          </div>
          <button class="btn-dark">關於我</button>
        </div>

        <div class="widget" id="payment">
          <h4><span>最新通知</span><i class="bi bi-bell-fill"></i></h4>
          <p class="lead grey">
            【會員權益提醒】每個月的最後一天，Memora會員日即將來臨，陪你迎接新的開始，專屬優惠活動，不要錯過！
          </p>
        </div>
        <div class="widget health-widget" id="glucose">
          <i class="bi bi-chat-heart-fill main-icon"></i>
          <h5>我的訊息</h5>
          <p class="grey">14則新消息 <i class="bi bi-arrow-right grey"></i></p>
          {{-- <span class="hero">- 138 mg/dl</span> --}}
        </div>
        <div class="widget health-widget" id="temperature">
          <i class="bi bi-clipboard-heart-fill main-icon"></i>
          <h5>訂單紀錄<br />查看進度</h5>
          <p class="grey">退款申請</p>
          {{-- <span class="hero">35.4&#176; C</span> --}}
        </div>
        <div id="current" class="widget">
          <i class="bi bi-bookmark-heart-fill"></i>
          <p>會員等級:時空旅人</p>
        </div>
        <div class="widget" id="weather">
          <button><i class="bi bi-gift-fill"></i></button>
          <div>
            <h6>守護回憶獎勵任務</h6>
            {{-- <p class="lead grey">20&#176; C</p> --}}
          </div>
          <i class="bi bi-arrow-right grey"></i>
        </div>
        <div class="widget" id="time">
          <div>
            <div>
              <i class="bi bi-heart-fill main-icon"></i>
              <h1>收藏好物</h1>
              <span class="grey">159個禮物等你分享</span>
            </div>
          </div>
          {{-- <p>Upload My Record</p> --}}
        </div>

        <div class="widget health-widget" id="pressure">
          <i class="bi bi-award-fill main-icon"></i>
          <h5>優惠卷<br />升級禮</h5>
          <p class="grey">有3張即將到期 <i class="bi bi-arrow-right grey"></i></p>
          {{-- <span class="hero">- 120/80 mmHg</span> --}}
        </div>
        <div class="widget health-widget" id="sleep">
          <i class="bi bi-credit-card main-icon"></i>
          <h5>信用卡管理</h5>
          <p class="grey">新增常用信用卡 <i class="bi bi-arrow-right grey"></i></p>
          {{-- <span class="hero"></span> --}}
        </div>
        <div class="widget" id="upload">
          <span>
            <i class="bi bi-envelope-paper-heart"></i>
            <i class="bi bi-envelope-paper-heart"></i>
            <i class="bi bi-envelope-paper-heart"></i>
          </span>
          <div>
            <div>
              <h3>再邀3個</h3>
              <span class="grey">邁向下一個里程碑</span>
            </div>
            <div class="progress"></div>
            <p class="lead grey">邀朋友賺回饋</p>
          </div>
          <i class="bi bi-arrow-right grey"></i>
        </div>
      </div>
      {{-- <div class="grid">
        <div class="widget" id="travel">
          <img
            src="https://oyster.ignimgs.com/mediawiki/apis.ign.com/marvel-studios-cinematic-universe/f/f2/Stark_Tower.jpg"
            alt=""
          />
          <div>
            <h3>Get a Trip to the Stark Tower</h3>
            <p class="lead grey">
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde
              placeat iure cumque, mollitia tempora vero.
            </p>
            <button class="btn-dark">Check It Out</button>
          </div>
        </div>
        <div class="widget" id="icons">
          <i class="bi bi-house-door grey"></i>
          <i class="bi bi-credit-card-2-front"></i>
          <i class="bi bi-bag grey"></i>
          <i class="bi bi-alarm grey"></i>
        </div>
        <div id="user" class="widget">
          <i class="bi bi-person-fill"></i><span>Clint Barton</span>
        </div>
        <div id="blogs" class="widget">
          <div class="blog">
            <img
              src="https://www.filmink.com.au/wp-content/uploads/2017/05/111-Thor.jpg"
              alt=""
            />
            <h6>How to Wield a Hammer</h6>
            <div>
              <span class="grey">By Thor</span
              ><span class="grey">5 Days Ago</span>
            </div>
          </div>
          <div class="blog">
            <img
              src="https://cdn.costumewall.com/wp-content/uploads/2018/04/ww2-captain-america.jpg"
              alt=""
            />
            <h6>The WW2 Story</h6>
            <div>
              <span class="grey">By Steve Rogers</span
              ><span class="grey">5 Days Ago</span>
            </div>
          </div>
          <div class="blog">
            <img
              src="https://i.guim.co.uk/img/media/d4a34d97ae20c403c5568ec596e81678dae476a7/0_2_1887_1132/master/1887.jpg?width=1200&quality=85&auto=format&fit=max&s=de0bf53fabd035c5e424a2aefd4234a5"
              alt=""
            />
            <h6>The Basics of Spellcasting</h6>
            <div>
              <span class="grey">By Dr. Strange</span
              ><span class="grey">4 Days Ago</span>
            </div>
          </div>
        </div>
        <div id="progress" class="widget">
          <img
            src="https://www.blendernation.com/wp-content/uploads/2019/12/Top.png"
            alt=""
          />
          <span>Progress Report</span>
          <h3>Creating EDITH</h3>
          <p class="lead grey">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae
            recusandae, eum aliquam ipsa provident natus voluptates. Pariatur
            voluptatum dolore, ex saepe est, non earum nisi ipsa hic, officia
            ullam magni.
          </p>
          <div class="progress"></div>
        </div>
        <div class="widget" id="ticket">
          <div id="badge">Hello</div>
          <h2>Do not forget!</h2>
          <p class="hero grey">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. In quisquam
            quas perferendis maxime delectus neque porro facere assumenda vel
            id.
          </p>
          <div>
            <button class="btn-dark">Do It Now</button
            ><button class="btn-light">Later On</button>
          </div>
        </div>
        <div class="widget" id="map">
          <img
            src="https://www.nycinsiderguide.com/wp-content/uploads/2019/04/new-york-city-street-map.jpg"
            alt=""
          />
          <p>
            <i class="bi bi-geo-alt-fill"></i
            ><span>177A Bleecker Street, NYC</span>
          </p>
        </div>
      </div> --}}
    </div>




</x-app-layout>


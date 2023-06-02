<ul id="navigation">
  @foreach ($items as $item)

    <div class="image-container">

    <li><a href="{{url($item->link())}}">{{$item->title}}</a>

    </div>

     @if (isset($item->children) && count ($item->children) > 0)
      <ul class="submenu">
        @foreach ($item->children as $subitem)

        <div class="image-container">

            <li><a href="{{url($subitem->link())}}">{{$subitem->title}}</a></li>

        </div>

        @endforeach
      </ul>
    @endif
    </li>
  @endforeach
</ul>

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="{{route('admin.home')}}">
            <img width="150" src="backend/assets/images/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            @php
            $sidebar = sidebar();
            @endphp
            <ul class="list-unstyled navbar__list">
                <li class="has-sub">
                    <a class="@if(Route::currentRouteName() == 'admin.home') alert alert-dark @endif"
                        href="{{route('admin.home')}}">
                        <i class="fa fa-home" aria-hidden="true"></i>Home
                    </a>
                </li>
                @foreach($sidebar as $item)
                <li class="has-sub">
                    <a class="js-arrow open" href="#">
                        <i class="{{$item['icon']}}" aria-hidden="true"></i>
                        {{$item['name']}}
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list" @if(in_array(Route::currentRouteName(),
                        $item['routeName'])) style="display: block;">
                        @endif
                        @foreach($item['child'] as $child)
                        <li>
                            <a class="@if(Route::currentRouteName() == $child['routeName']) alert alert-dark @endif"
                                href="{{$child['url']}}"><i class="{{$child['icon']}}" aria-hidden="true"></i>
                                {{$child['name']}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

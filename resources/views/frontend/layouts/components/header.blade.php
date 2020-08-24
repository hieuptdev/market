<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar container py-0 bg-white" role="banner">

    <!-- <div class="container"> -->
    <div class="row align-items-center">
        <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="{{ route('index') }}" class="text-black mb-0">HK<span
                        class="text-primary">MARKET</span> </a></h1>
        </div>
        <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

                <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">

                    {{-- <li><a href="listings.html">Ads</a></li>
                    <li class="has-children">
                        <a href="about.html">About</a>
                        <ul class="dropdown">
                            <li><a href="#">The Company</a></li>
                            <li><a href="#">The Leadership</a></li>
                            <li><a href="#">Philosophy</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact.html">Contact</a></li> --}}
                    @if(Auth::check())
                    <li class="has-children">
                        @php
                        $avatar = Auth::user()->avatar ? Auth::user()->avatar : 'user.jpg';
                        @endphp
                        <a href="{{route('user.account.profile')}}">
                            <img class="rounded-circle" width="40" src="{{asset('uploads/avatar/'.$avatar)}}" alt="">
                            {{Auth::user()->username}}
                        </a>
                        <ul class="dropdown">
                            <li><a href="{{route('user.account.profile')}}" class="font-weight-bold">My Account</a></li>
                            <li><a href="{{route('user.product')}}" class="font-weight-bold">My Product</a></li>
                            <li><a href="{{route('user.purchase')}}" class="font-weight-bold">My Purchase</a></li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <a class="btn btn-link btn-block text-danger text-left"
                                    onclick="this.parentNode.submit();"><i class="fa fa-sign-out"
                                        aria-hidden="true"></i> Log out</a>
                            </form>
                        </ul>
                    </li>
                    @else
                    <li class="ml-xl-3 login active"><a href="{{ route('login') }}"><span
                                class="border-left pl-xl-4"></span>Log In</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                    <li><a href="{{route('frontend.product.create')}}" class="cta"><span
                                class="bg-primary text-white rounded">+ New Product </span></a></li>
                </ul>
            </nav>
        </div>
        <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
        </div>

    </div>
    <!-- </div> -->

</header>

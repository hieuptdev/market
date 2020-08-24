@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
<div class="site-blocks-cover overlay"
    style="background-image: url(https://i.gzn.jp/img/2012/10/02/40-awesome-twitter-covers/04.jpg);" data-aos="fade"
    data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-12">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8 text-center">
                        <h1 class="" data-aos="fade-up">Largest Classifieds In The World</h1>
                        <p data-aos="fade-up" data-aos-delay="100">You can buy, sell anything you want.</p>
                    </div>
                </div>
                <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
                    <form action="" method="get" id="myForm1">
                        <div class="row align-items-center">
                            <div class="col-lg-3">
                                <input type="text" name="search" class="form-control rounded" placeholder="What are you looking for?" value="{{Request::get('search')}}">
                            </div>
                            <div class="col-2">
                                <div class="select-wrap">
                                    <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                    <select class="form-control rounded" name="province" >
                                        <option value="">Province</option>
                                        @foreach($provinces as $province)
                                        <option value="{{$province->id}}"
                                             @if(Request::get('province') == $province->id)
                                                selected
                                            @endif
                                            >{{$province->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="select-wrap">
                                    <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                    <select class="form-control rounded" name="category">
                                        <option value="">Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" 
                                            @if(Request::get('category') == $category->id)
                                                selected
                                            @endif
                                            >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="select-wrap">
                                    <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                                    <select class="form-control rounded" name="sort">
                                        <option value="">Sort By</option>
                                        <option value="titleasc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'titleasc')
                                            selected
                                        @endif
                                        >Alphabetical: A to Z</option>
                                        <option value="titledesc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'titledesc')
                                            selected
                                        @endif
                                        >Alphabetical: Z to A</option>
                                        <option value="priceasc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'priceasc')
                                            selected
                                        @endif
                                        >Price: Low to High</option>
                                        <option value="pricedesc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'pricedesc')
                                            selected
                                        @endif
                                        >Price: High to Low</option>
                                        <option value="avgrateasc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'avgrateasc')
                                            selected
                                        @endif
                                        >Average Rate &#x2191</option>
                                        <option value="avgratedesc" class="font-weight-bold"
                                        @if(Request::get('sort') == 'avgratedesc')
                                            selected
                                        @endif
                                        >Average Rate &#x2193</option>
                                        <option value="latest" class="font-weight-bold"
                                        @if(Request::get('sort') == 'latest')
                                            selected
                                        @endif
                                        >Latest Product</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2 text-right">
                                <input type="submit" class="btn btn-primary btn-block rounded" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="site-section" data-aos="fade">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-7 text-left border-primary">
                <h2 class="font-weight-light text-primary">Category</h2>
            </div>
        </div>
        <div class="row">
            @foreach($rootCategory as $category)
            <div class="col-md-6 mb-3 mb-lg-1 col-lg-2">
                <a href="{{route('frontend.product.category',['id'=>$category->id])}}">
                    <div class="listing-item">
                        <div class="listing-image">
                            <img src="frontend/images/banner5.jpg" alt="Image" class="img-fluid">
                        </div>
                        <div class="listing-item-content">
                            <span class="address">{{$category->name}}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="site-section bg-light">
        <div class="container">
           <div class="row">
                <div class="col-3 border-primary">
                   <h2 class="font-weight-light text-primary">Product</h2>
               </div>
           </div>
            <br>
            <div class="row">
                @foreach ($products as $product)
                <div class="col-3 block-13">
                    <div class="d-block d-md-flex listing vertical">
                        @php
                        $image = json_decode($product->image, true);
                        @endphp
                        <div class="col-12">
                            <a href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}"
                                class="img d-block">
                                <img width="200" height="200" src="{{asset('uploads/product/'.$image[0])}}" alt="">
                            </a>
                        </div>
                        <br>
                        <div class="lh-content col-12">
                            <span class="category text-secondary" href="">
                                {{$product->category->name}}
                            </span>
                            <span class="category">{{ $product->created_at->diffForHumans() }}</span>
                            <h3>
                                <a class="font-weight-bold text-black"
                                    href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}">
                                    {{$product->title}}
                                </a>
                            </h3>
                            <address>
                                {{$product->address->district->name}}, {{$product->address->province->name}}
                            </address>
                            <span class="category text-danger">$ {{number_format($product->price, 2)}}</span>
                            <p>
                                <a>
                                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                    {{$product->seller->username}}
                                </a>
                            </p>
                            <p class="mb-0">
                                @if($product->seller->avg_rate > 0)
                                    @for($i = 0; $i< $product->seller->avg_rate ; $i++)
                                        <span class="icon-star text-warning"></span>
                                    @endfor
                                    <span class="review">({{$product->seller->review->count()}} Reviews)</span>
                                @else
                                    <span class="review">(No Reviews)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {!! $products->appends(request()->query())->links() !!}
        </div>
    </div>
    @stop

    @section('script')
    <script>
        function submitForm() {
            $('#myForm1').submit();
        }
    </script>
    @endsection
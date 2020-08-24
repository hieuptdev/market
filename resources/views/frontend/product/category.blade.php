@extends('frontend.layouts.master')
@section('title', $category->name)
@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                        <h1>{{$category->name}}</h1>
                        <p class="mb-0">Choose product you want</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @foreach($products as $product)
                     <div class="col-lg-4">
                        <div class="d-block d-md-flex listing vertical">
                            <div class="col-12">
                                @php
                                    $image = json_decode($product->image, true);
                                @endphp
                                <a href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}" class="img d-block"
                                    >
                                    <img width="200" height="200" src="{{asset('uploads/product/'.$image[0])}}" alt="">   
                                </a>
                            </div>
                            <br>
                            <div class="lh-content">
                                <span class="category text-secondary">{{$product->name}}</span>
                                <span class="category">{{ $product->created_at->diffForHumans() }}</span>
                                <h3>
                                    <a class="font-weight-bold text-black" href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}">{{$product->title}}
                                    </a>
                                </h3>
                                <address>
                                    {{$product->address->district->name}}, {{$product->address->province->name}}
                                </address>
                                
                                <span class="category text-danger">$ {{number_format($product->price, 2)}}</span>
                                <p>
                                    <a class="d-sm-inline-block">
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
            <div class="col-12 mt-5 text-center">
                {!! $products->appends(request()->query())->links() !!}
            </div>
        </div>
        <div class="col-lg-3 ml-auto">

            <div class="mb-5">
                <h3 class="h5 text-black mb-3">Filters</h3>
                <form action="" method="GET">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="What are you looking for?" class="form-control" value="{{Request::get('search')}}">
                    </div>
                    <div class="select-wrap form-group">
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
                    <div class="select-wrap form-group">
                        <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                        <select class="form-control rounded" name="category">
                            <option value="">Child Category</option>
                            @foreach($childCategory as $category)
                                <option value="{{$category->id}}" 
                                @if(Request::get('category') == $category->id)
                                    selected
                                @endif
                                >{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="select-wrap form-group">
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
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block rounded" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/rangeslider.min.js"></script>

<script src="js/main.js"></script>

</body>

</html>
@stop
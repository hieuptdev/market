@extends('frontend.layouts.master')
@section('title', $product[0]->title)
@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                        <h1 class="text-white">Detail Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="mb-4">
                    <div class="slide-one-item home-slider owl-carousel">
                        @php
                            $image = json_decode($product[0]->image, true);
                            $loop = count($image);
                        @endphp
                        @for($i = 0; $i < $loop; $i++)
                            <div class="col-8 offset-1">
                                <img src="{{asset('uploads/product/'.$image[$i])}}" alt="Image" class="img-fluid">
                            </div>
                        @endfor
                    </div>
                </div>
                <h4 class="h5 mb-4 text-black">
                    <span class="border-bottom font-weight-bold">Product Detail</span>
                </h4>
                <div class="mb-4 row">
                    @foreach($product[0]->attributeProduct as $attributeProduct)
                        <div class="col-4">
                             <p>
                                <span class="text-secondary">{{$attributeProduct->attribute->name}}</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <p>
                                <span class="text-black">{{$attributeProduct->values}}</span>
                            </p>
                        </div>

                    @endforeach
                </div>
                <div>
                    <h4 class="h5 mb-4 text-black"><span class="border-bottom font-weight-bold">Description</span></h4>
                        {!! $product[0]->desc !!}
                </div>
            </div>
            <div class="col-lg-5 ml-auto">
                <div class="mb-5">
                    <h3>{{$product[0]->title}}</h3>
                </div>

                <div class="mb-5 row">
                    <div class="col-4">
                        <p class="text-secondary mb-3">Category</p>
                    </div>
                    <div class="col-6">
                        <p class="text-primary mb-3">{{$product[0]->category->name}}</p>
                    </div>
                </div>

                <div class="mb-5 row">
                    <div class="col-4">
                        <p class="text-secondary mb-3">Price</p>
                    </div>
                    <div class="col-6">
                        <p class="text-black mb-3">${{number_format($product[0]->price, 2)}}</p>
                    </div>
                </div>

                <div class="mb-5 row">
                    <div class="col-4">
                        <p class="text-secondary mb-3">Deliver From</p>
                    </div>
                    <div class="col-8   ">
                        <h5 class="mb-3">
                            <span class="text-dark">{{$product[0]->address->street}}, {{$product[0]->address->ward->name}}, {{$product[0]->address->district->name}}, {{$product[0]->address->province->name}}</span>
                        </h5>
                    </div>
                </div>

                <div class="mb-5">
                    @if($product[0]->seller_id != Auth::user()->id)
                         <a class="btn btn-warning" href="{{route('user.product.get.buy', ['id'=>$product[0]->id])}}">BUY NOW</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-7 text-left border-primary">
                <h2 class="font-weight-light text-primary">Other Product</h2>
            </div>
        </div>
        <div class="row mt-5">
            @foreach($otherProduct as $product)
                <div class="col-lg-6">
                    <div class="d-block d-md-flex listing">
                      @php
                         $image = json_decode($product->image, true);
                      @endphp
                        <div class="col-4">
                            <a href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}" class="img d-block"
                                >
                                <img height="170" width="150" src="{{asset('uploads/product/'.$image[0])}}" alt="">   
                            </a>
                        </div>
                        <div class="lh-content col-8"> 
                            <span class="category text-secondary">{{$product->category->name}}</span>
                            <span class="category">{{ $product->created_at->diffForHumans() }}</span>
                            <h3>
                                <a class="font-weight-bold text-black" href="{{route('frontend.product.detail', ['id'=>$product->id, 'seller_id'=>$product->seller_id])}}">{{$product->title}}
                                </a>
                            </h3>
                            <address>
                                {{$product->address->district->name}}, {{$product->address->province->name}}
                            </address>
                            <span class="category text-danger">$ {{number_format($product->price, 2)}}</span>
                            <p class="mb-0">
                                <a>
                                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> 
                                    {{$product->seller->username}}
                                </a>
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
    </div>
</div>

@stop

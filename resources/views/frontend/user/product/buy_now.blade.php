@extends('frontend.layouts.master')
@section('title', 'BUY NOW')
@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                       <h1> Purchase Information</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="card-body row">
            <div class="col-12">
                <form method="POST" action="{{route('user.product.post.buy', ['id'=>$product->id])}}" enctype="multipart/form-data" id="myform">
                    @csrf
                    <h4 class="font-weight-bold">User Information</h4><br>
                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Name">
                        </div>
                        <div class="col-9 row">
                            <div class="col-12">
                                <input type="text" name="name" readonly class="form-control" value="{{Auth::user()->name}}">
                                {{showError($errors,'name')}}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Email">
                        </div>
                        <div class="col-9 row">
                            <div class="col-12">
                                <input type="text" class="form-control" value="{{Auth::user()->email}}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Phone">
                        </div>
                        <div class="col-9 row">
                            <div class="col-12">
                                <input type="text" class="form-control" value="{{Auth::user()->phone}}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Address">
                        </div>
                        <div class="col-9 row">
                            @foreach($userAddress as $address)
                            <div class="row form-group">
                                <div class="col-1">
                                    <br>
                                    <input type="radio" name="customer_address" value="{{$address->id}}" >
                                </div>
                                <div class="col-11">
                                    <div class="card">
                                        <div class="card-body">
                                           {{$address->street}}, {{$address->ward->name}}, {{$address->district->name}}, {{$address->province->name}}
                                       </div>
                                   </div>
                                    {{showError($errors,'customer_address')}}
                               </div>       
                           </div>
                            @endforeach
                        </div>
                    </div>
                    <h4 class="font-weight-bold">Product Information</h4><br>
                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Title">
                        </div>
                        <div class="col-9 row">
                            <div class="col-12">
                                <input type="text" class="form-control" value="{{$product->title}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Price">
                        </div>
                        <div class="col-9 row">
                            <div class="col-12">
                                <input type="text" class="form-control" value="$ {{number_format($product->price, '0',',','.')}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Image">
                        </div>
                        <div class="col-9 row">
                            @php
                            $image = json_decode($product->image, true);
                            @endphp
                            <div class="col-8 offset-1">
                                <img width="200" src="{{asset('uploads/product/'.$image[0])}}" alt="Image" class="img-fluid">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <input type="text" readonly class="form-control font-weight-bold" value="Deliver From">
                        </div>
                        <div class="col-9 row">
                            <input type="text" readonly class="form-control" value="{{$product->address->street}}, {{$product->address->ward->name}}, {{$product->address->district->name}}, {{$product->address->province->name}}">
                        </div>
                    </div>
                    <div align="center">
                            <button class="btn btn-danger">BUY</button>
                    </div>
                    </form>
                </div>
            </div>
    </div>
</div>

@stop

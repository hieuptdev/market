@extends('frontend.layouts.master')
@section('title', 'Product')
@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                        <h1>Product</h1>
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
                    @for ($i = 1; $i <= 10; $i++) <div class="col-lg-3">

                        <div class="d-block d-md-flex listing vertical">
                            <a href="{{route('frontend.product.detail')}}" class="img d-block"
                                style="background-image: url('frontend/images/img_{{$i}}.jpg')"></a>
                            <div class="lh-content">
                                <span class="category">Cars &amp; Vehicles</span>
                                <h3><a href="{{route('frontend.product.detail')}}">Red Luxury Car</a></h3>
                                <address>Don St, Brooklyn, New York</address>
                                <p class="mb-0">
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-secondary"></span>
                                    <span class="review">(3 Reviews)</span>
                                </p>
                            </div>
                        </div>
                </div>
                @endfor
            </div>

            <div class="col-12 mt-5 text-center">
                <div class="custom-pagination">
                    <span>1</span>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <span class="more-page">...</span>
                    <a href="#">10</a>
                </div>
            </div>

        </div>
        <div class="col-lg-3 ml-auto">

            <div class="mb-5">
                <h3 class="h5 text-black mb-3">Filters</h3>
                <form action="#" method="post">
                    <div class="form-group">
                        <input type="text" placeholder="What are you looking for?" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="select-wrap">
                            <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                            <select class="form-control" name="" id="">
                                <option value="">All Categories</option>
                                <option value="" selected="">Real Estate</option>
                                <option value="">Books &amp; Magazines</option>
                                <option value="">Furniture</option>
                                <option value="">Electronics</option>
                                <option value="">Cars &amp; Vehicles</option>
                                <option value="">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- select-wrap, .wrap-icon -->
                        <div class="wrap-icon">
                            <span class="icon icon-room"></span>
                            <input type="text" placeholder="Location" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-5">
                <form action="#" method="post">
                    <div class="form-group">
                        <p>Radius around selected destination</p>
                    </div>
                    <div class="form-group">
                        <input type="range" min="0" max="10000" value="20" data-rangeslider>
                    </div>
                </form>
            </div>

            <div class="mb-5">
                <form action="#" method="post">
                    <div class="form-group">
                        <p>Category 'Real Estate' is selected</p>
                        <p>More filters</p>
                    </div>
                    <div class="form-group">
                        <ul class="list-unstyled">
                            <li>
                                <label for="option1">
                                    <input type="checkbox" id="option1">
                                    Residential
                                </label>
                            </li>
                            <li>
                                <label for="option2">
                                    <input type="checkbox" id="option2">
                                    Commercial
                                </label>
                            </li>
                            <li>
                                <label for="option3">
                                    <input type="checkbox" id="option3">
                                    Industrial
                                </label>
                            </li>
                            <li>
                                <label for="option4">
                                    <input type="checkbox" id="option4">
                                    Land
                                </label>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>

            <div class="mb-5">
                <h3 class="h6 mb-3">More Info</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatem placeat
                    facilis, reprehenderit eius officiis.</p>
            </div>

        </div>

    </div>
</div>
</div>

<div class="site-section bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-7 text-left border-primary">
                <h2 class="font-weight-light text-primary">Trending Today</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6">

                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_2.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Real Estate</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">House with Swimming Pool</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
                </div>
                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_3.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Furniture</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">Wooden Chair &amp; Table</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
                </div>

                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_4.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Electronics</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">iPhone X gray</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
                </div>



            </div>
            <div class="col-lg-6">

                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_1.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Cars &amp; Vehicles</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">Red Luxury Car</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
                </div>

                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_2.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Real Estate</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">House with Swimming Pool</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
                </div>
                <div class="d-block d-md-flex listing">
                    <a href="#" class="img d-block" style="background-image: url('frontend/images/img_3.jpg')"></a>
                    <div class="lh-content">
                        <span class="category">Furniture</span>
                        <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                        <h3><a href="#">Wooden Chair &amp; Table</a></h3>
                        <address>Don St, Brooklyn, New York</address>
                        <p class="mb-0">
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-secondary"></span>
                            <span class="review">(3 Reviews)</span>
                        </p>
                    </div>
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
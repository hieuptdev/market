@extends('frontend.layouts.master')
@section('title', 'Register')
@section('content')
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                        <h1>Register</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-dark" style="margin-top: -200px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 mb-5" data-aos="fade">
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ session('error') }}</strong>
                </div>
                @endif
                <form action="{{ route('register') }}" method="POST" class="p-5 bg-white">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="email">Name</label>
                            <input type="text" name="name" id="email" class="form-control" value="{{ old('name') }}">
                            {{ showError($errors,'name') }}
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="subject">Phone</label>
                            <input type="phone" name="phone" id="subject" class="form-control"
                                value="{{ old('phone') }}">
                            {{ showError($errors,'phone') }}
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            {{ showError($errors,'email') }}
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="subject">Password</label>
                            <input type="password" name="password" id="subject" class="form-control">
                            {{ showError($errors,'password') }}
                        </div>
                    </div>
                    

                    <div class="row form-group">
                        <div class="col-12">
                            <p>Have an account? <a class="text-primary" href="{{ route('login') }}">Log In</a></p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="submit" value="Register" class="btn btn-warning py-2 px-4 text-white">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@stop

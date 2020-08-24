@extends('backend.layouts.master')
@section('title', 'Admin Create')
@section('user','active')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Admin Create</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="name" type="full" class="form-control"
                                        aria-required="true" aria-invalid="false">
                                    {{showError($errors,'name')}}
                                </div>
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Email</label>
                                    <input id="cc-pament" name="email" type="email" class="form-control"
                                        aria-required="true" aria-invalid="false">
                                    {{showError($errors,'email')}}
                                </div>

                                <div class="form-group">
                                    <select name="role_id" class="custom-select" size="5">
                                        @foreach ($role as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="password">
                                    <label for="cc-payment" class="control-label mb-1">Password</label>
                                    <input id="cc-pament" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    {{showError($errors,'password')}}
                                    <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-pament" name="confirm_password" type="password"
                                        class="form-control @error('confirmation_password') is-invalid @enderror">
                                    {{showError($errors,'confirmation_password')}}
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class=""></i>&nbsp;
                                        <span id="payment-button-amount">Create</span>
                                        <span id="" style="display:none;">Sending…</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop()

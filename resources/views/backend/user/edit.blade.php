@extends('backend.layouts.master')
@section('title', 'Edit user')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-11">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Edit user</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-3 offset-7">
                                    <a href="{{route('user.address', ['id' => $user->id])}}"
                                        class="btn btn-warning float-right">Manage address</a>
                                </div>
                                <div class="col-2">
                                    <form id="myform" action="{{ route('user.delete',['id'=>$user->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" type="submit"
                                            class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <form action="{{ route('user.update',['id' => $user->id])}}" method="POST"
                                    novalidate="novalidate">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" id="userAddress" value="{{$user->address}}">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Username</label>
                                        <input id="cc-pament" name="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" value="{{$user->username}}">
                                        {{showError($errors,'username')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{$user->name}}">
                                        {{showError($errors,'name')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{$user->email}}">
                                        {{showError($errors,'email')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1 ">Phone</label>
                                        <input name="phone" type="number"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" value="{{$user->phone}}"
                                            min="1000000000" max="9999999999">
                                        {{showError($errors,'phone')}}
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="">Gender</label>
                                        </div>
                                        <div class="col-9 text-left">
                                            <input type="radio" name="gender" value="male" @if($user->gender == 'male')
                                            checked @endif> <span>Male</span> &nbsp
                                            <input type="radio" name="gender" value="female" @if($user->gender ==
                                            'female') checked @endif> <span>Female</span> &nbsp
                                            <input type="radio" name="gender" value="other" @if($user->gender ==
                                            'other') checked @endif> <span>Other</span>
                                        </div>
                                        {{showError($errors,'gender')}}
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="">Status</label>
                                        </div>
                                        <div class="col-3 text-left">
                                            <select class="form-control" name="status" id="">
                                                <option value="active" @if($user->status == 'active') selected
                                                    @endif>Active</option>
                                                <option value="banned" @if($user->status == 'banned') selected
                                                    @endif>Ban</option>
                                            </select>
                                        </div>
                                        {{showError($errors,'gender')}}
                                    </div>
                                    <div>
                                        <input class="form-group" type="checkbox" name="changepass" id="checkbox"
                                            value="1">
                                        <span>Change password</span>
                                    </div>
                                    <div class="form-group" id="password" style="display: none;">
                                        <label for="cc-payment" class="control-label mb-1">Password</label>
                                        <input id="cc-pament" name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            {{showError($errors,'password')}} aria-required="true" aria-invalid="false">
                                        <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                        <input id="cc-pament" name="confirm_password" type="password"
                                            class="form-control @error('confirm_password') is-invalid @enderror">
                                        {{showError($errors,'confirm_password')}}
                                    </div>
                            </div>
                            <div class="row" style="margin-top: 50px;">
                                <div class="col-12">
                                    <h3 align="center" class="text-uppercase">Total product sold</h3>
                                </div>
                                <div class="table-responsive table-responsive-data2" style="height: 400px; overflow: auto;">
                                    <table class="table table-data2">
                                        <div class="card card-block">
                                            <thead>
                                                <tr>
                                                    <th>name</th>
                                                    <th>image</th>
                                                    <th>price</th>
                                                    <th>category</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                        </div>
                                        <tbody>
                                            @foreach($totalSold as $product)
                                                <tr class="tr-shadow">
                                                <td>{{$product->title}}</td>
                                                 <td>
                                                    @php
                                                        $image = json_decode($product->image, true);
                                                    @endphp
                                                    <img width="100" src="{{asset('uploads/product/'.$image[0])}}">
                                                </td>
                                                <td>
                                                    <span class="block-email">${{number_format($product->price, 2)}}</span>
                                                </td>
                                                <td>{{$product->category->name}}</td>
                                                <td>{{$product->updated_at}}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12">
                                    <h3 align="center" class="text-uppercase">Total product bought</h3>
                                </div>
                                <div class="table-responsive table-responsive-data2" style="height: 400px; overflow: auto;">
                                    <table class="table table-data2">

                                        <div class="card card-block">
                                            <thead>
                                                <tr>
                                                    <th>name</th>
                                                    <th>Image</th>
                                                    <th>price</th>
                                                    <th>category</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                        </div>
                                        <tbody>
                                            @foreach($totalBought as $product)
                                                <tr class="tr-shadow">
                                                <td>{{$product->title}}</td>
                                                 <td>
                                                    @php
                                                    $image = json_decode($product->image, true);
                                                    @endphp
                                                    <img width="100" src="{{asset('uploads/product/'.$image[0])}}">
                                                </td>
                                                <td>
                                                    <span class="block-email">${{number_format($product->price, 2)}}</span>
                                                </td>
                                                <td>{{$product->category->name}}</td>
                                                <td>{{$product->updated_at}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Submit</span>
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
</div>

@stop()
@section('script')
<script>
    $('body').on('change', '#checkbox', function(event) {
    event.preventDefault();
   var checked = document.getElementById('checkbox').checked;
   if(checked == true){
       document.getElementById('password').style.display = 'inline';
   }else{
        document.getElementById('password').style.display = 'none';
   }

});
</script>

@endsection

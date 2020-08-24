@extends('backend.layouts.master')
@section('title', 'Create user')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <form action="{{ route('user.store')}}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">Create user</h3>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                </div>
                                @endif
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Username</label>
                                        <input name="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{old('username')}}">
                                        {{showError($errors,'username')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{old('name')}}">
                                        {{showError($errors,'name')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{old('email')}}">
                                        {{showError($errors,'email')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input name="phone" type="number"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{old('phone')}}">
                                        {{showError($errors,'phone')}}
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label for="">Gender</label>
                                        </div>
                                        <div class="col-9 text-left">
                                            <input type="radio" name="gender" value="male"> <span>Male</span> &nbsp
                                            <input type="radio" name="gender" value="female"> <span>Female</span> &nbsp
                                            <input type="radio" name="gender" value="other"> <span>Other</span>
                                        </div>
                                        {{showError($errors,'gender')}}
                                    </div>
                                    {{-- <div class="form-group">
                                        <select name="role_id" class="custom-select" size="5">
                                            <option value="">--Role--</option>
                                            @foreach ($roles as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <div id="folder_image" class="row">
                                            <div class="col-md-4">
                                                <label for="cc-payment" class="control-label mb-1">Province</label>
                                                <select id="province" name="province_id"
                                                    class="form-control @error('province') is-invalid @enderror">
                                                    <option value="">--Choose Province--</option>
                                                    @foreach($provinces as $province)
                                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                                    @endforeach
                                                </select>
                                                {{showError($errors,'province_id')}}
                                            </div>
                                            <div class="col-md-4">
                                                <label for="cc-payment" class="control-label mb-1">Districts</label>
                                                <select id="district" name="district_id"
                                                    class="form-control @error('district') is-invalid @enderror">
                                                    <option value="0">--Choose Districts--</option>
                                                </select>
                                                {{showError($errors,'district_id')}}
                                            </div>
                                            <div class="col-md-4">
                                                <label for="cc-payment" class="control-label mb-1">Wards</label>
                                                <select id="ward" name="ward_id"
                                                    class="form-control @error('ward') is-invalid @enderror">
                                                    <option value="0">--Choose Ward--</option>
                                                </select>
                                                {{showError($errors,'ward_id')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Street</label>
                                        <input id="cc-pament" name="street" type="text"
                                            class="form-control @error('street') is-invalid @enderror"
                                            value="{{old('street')}}">
                                        {{showError($errors,'street')}}
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
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
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

    $('body').on('change', '#province', function(event) {
        $("#ward").load(" #ward > * ");
        var province_id = this.value;
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{route("get.districts")}}',
            type: 'POST',
            data: {province_id: province_id, _token:_token},
        })
        .done(function(data) {
            $('#district').html(data);
        });
    });

    $('body').on('change', '#district', function(event) {
        var district_id = this.value;
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{route("get.wards")}}',
            type: 'POST',
            data: {district_id: district_id, _token:_token},
        })
        .done(function(data) {
            $('#ward').html(data);
        })
    });

</script>

@endsection

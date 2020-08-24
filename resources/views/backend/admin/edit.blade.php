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
                            <h3 class="text-center">Admin Edit</h3>
                        </div>
                        <div class="card-body">
                            <div class="float-right form-group ">
                                <form action="{{route('admin.delete',['id'=>$admin->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are you sure?')" class="item btn btn-danger"
                                        title="Delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <form method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="name" type="full" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{$admin->name}}">
                                    {{showError($errors,'name')}}
                                </div>
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Email</label>
                                    <input id="cc-pament" name="email" type="email" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{$admin->email}}">
                                    {{showError($errors,'email')}}
                                </div>

                                <div class="form-group">
                                    <select name="role_id" class="custom-select" size="5">
                                        @foreach ($role as $item)
                                        <option @if ($admin->role_id==$item->id)
                                            selected
                                            @endif value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <input class="form-group" type="checkbox" name="changepass" id="checkbox" value="1">
                                    <span>Change password</span>
                                </div>
                                <div class="form-group" id="password" style="display: none;">
                                    <label for="cc-payment" class="control-label mb-1">Password</label>
                                    <input id="cc-pament" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        {{showError($errors,'password')}} aria-required="true" aria-invalid="false"
                                        value="{{$admin->password}}">
                                    <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-pament" name="confirm_password" type="password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        value="{{$admin->password}}">
                                    {{showError($errors,'confirm_password')}}
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class=""></i>&nbsp;
                                        <span id="payment-button-amount">Edit</span>
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

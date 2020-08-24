@extends('backend.layouts.master')
@section('title', 'Create Review')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Create Review</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </div>
                            @endif
                            <div class="form-group">
                                <form action="{{ route('review.store')}}" method="post" novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Seller</label>
                                        <select name="seller_id" onchange="getIdUser(this)"
                                            class="form-control js-example-tags">
                                            <option selected="selected" value="">--Seller--</option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option>
                                            @endforeach
                                        </select>
                                        {{showError($errors,'seller_id')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Product</label>
                                        <select id="product" name="product_id"  
                                            class="form-control js-example-tags">
                                            <option selected="selected" value="">--Product--</option>
                                        </select>
                                        {{showError($errors,'seller_id')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Customer</label>
                                        <select id="customer" name="customer_id"
                                            class=" form-control js-example-tags">
                                            <option selected="selected" value="">--Customer--</option>
                                           
                                        </select>
                                        {{showError($errors,'customer_id')}}
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Rate</label>
                                        <select class="form-control" name="star">
                                            <option value="">--Star--</option>
                                            <option value="5">
                                                &#9733&#9733&#9733&#9733&#9733
                                            </option>
                                            <option value="4">
                                                &#9733&#9733&#9733&#9733

                                            </option>
                                            <option value="3">
                                                &#9733&#9733&#9733
                                            </option>
                                            <option value="2">&#9733&#9733

                                            </option>
                                            <option value="1">&#9733
                                            </option>
                                        </select>
                                        {{showError($errors,'star')}}

                                    </div>
                                    <div class="form-group">
                                        <label for="textarea-input" class=" form-control-label">Content</label>
                                        <textarea name="content" id="textarea-input" rows="8" placeholder="Content..."
                                            class="form-control">
                                    </textarea>
                                        {{showError($errors,'content')}}
                                    </div>
                            </div>
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
@stop()
@section('script')
<script>

$(".js-example-tags").select2({
  tags: true
});

function getIdUser(data) {
    var _token=$('input[name="_token"]').val();
    var id = data.value;
    $.ajax({
        type: "POST",
        url: "{{route('review.customer')}}",
        data:{id,_token}
    }).done(function (data) {
        if(data['customers']){
            var html = '';
            for (var i = 0; i < data['customers'].length; i++) {
                html += '<option value="'+data['customers'][i]['id']+'"> '+data['customers'][i]['username']+' </option>';
            } 
            $('#customer').html(html);
        }

        if(data['products']){
            var html = '';
            for (var i = 0; i < data['products'].length; i++) {
                html += '<option value="'+data['products'][i]['id']+'"> '+data['products'][i]['title']+' </option>';
            } 
            $('#product').html(html);
        }
        
    });
}

</script>
@endsection

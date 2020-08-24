@extends('backend.layouts.master')
@section('title', 'Edit Review')
@section('main')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Edit Review</h3>
                        </div>
                        <div class="card-body">
                            @if(session('noti'))
                            <div class="alert alert-{{session('status')}}" role="alert">
                                <strong>{{session('noti')}}</strong>
                            </div>
                            @endif
                            <div class="form-group">
                                <form action="{{ route('review.update',['id'=>$review->id])}}" method="post"
                                    novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Seller :
                                            <b>{{$review->user->name}}</b></label>
                                        <input type="hidden" name="seller_id" value="{{$review->seller_id}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Product :
                                            <b>{{$review->product->title}}</b></label>
                                        <input type="hidden" name="product_id" value="{{$review->product_id}}">
                                    </div>

                                    {{showError($errors,'seller_id')}}
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Customer :
                                            <b>{{$review->customer->name}}</b></label>
                                        <input type="hidden" name="customer_id" value="{{$review->customer_id}}">

                                    </div>
                                    {{showError($errors,'customer_id')}}

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Rate</label>
                                        <select class="form-control" name="star">
                                            <option value="">--Star--</option>
                                            <option @if ($review->star=='5') selected @endif value="5">
                                                &#9733&#9733&#9733&#9733&#9733
                                            </option>
                                            <option @if ($review->star=='4') selected @endif value="4">
                                                &#9733&#9733&#9733&#9733

                                            </option>
                                            <option @if ($review->star=='3') selected @endif value="3">
                                                &#9733&#9733&#9733
                                            </option>
                                            <option @if ($review->star=='2') selected @endif value="2">&#9733&#9733

                                            </option>
                                            <option @if ($review->star=='1') selected @endif value="1">&#9733
                                            </option>
                                        </select>
                                        {{showError($errors,'star')}}

                                    </div>

                                    <div class="form-group">
                                        <label for="textarea-input" class=" form-control-label">Description</label>
                                        <textarea name="content" id="textarea-input" rows="8" class="form-control">{{$review->content}}
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
    var id=data.value;
    $.ajax({
        type: "POST",
        url: "{{route('review.customer')}}",
        data:{id,_token}
    }).done(function (data) {
        $('#customer').html(data);
    });
}

$(document).ready(function () {
    var _token=$('input[name="_token"]').val();
    var id=$('#customer_id option:selected').val();
    $.ajax({
        type: "POST",
        url: "{{route('review.customer')}}",
        data:{id,_token}
    }).done(function (data) {
        $('#customer').html(data);
    });
});



</script>

@endsection

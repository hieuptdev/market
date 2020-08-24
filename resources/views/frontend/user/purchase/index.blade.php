@extends('frontend.layouts.master')
@section('title', 'My purchase')
@section('style')
<style>
	#item-name{
		color: black;
		font-weight: bold; 
	}

	body{
		font-size: 14px;
	}
</style>
@endsection()
@section('content')
<div class="overlay" style="background-image: url(frontend/images/background2.jpg);" data-aos="fade"
  data-stellar-background-ratio="0.5">
  <div class="container-fluid">
    <div class="row col-12 justify-content-center text-center" >
      @include('frontend.user_layout.sidebar')
		<div class="row col-9" id="accordionExample" style="margin-top: 150px; margin-bottom: 150px;">
			<div class="accordion col-12" id="accordionExample">
	      		<div class="card">
	      			<div class="card-header" id="headingOne">
	      				<h4 class="text-center">
	      					My Purchase
	      				</h4>
	      			</div>
	      			<div class="card-header row col-12">
	      				<form action="" class="row" id="myForm">
		      				<div class="col-3">
		      					<select class="form-control" name="status" onchange="submitForm();">
		      						<option value="">Status</option>
		      						<option value="3" @if(Request::get('status') == 3) selected @endif>Pending Approval</option>
		      						<option value="4" @if(Request::get('status') == 4) selected @endif>Shipping</option>
		      						<option value="5" @if(Request::get('status') == 5) selected @endif>Delivered</option>
		      						<option value="6" @if(Request::get('status') == 6) selected @endif>Canceled</option>
		      					</select>
		      				</div>
		      				<div class="col-3">
		      					<select class="form-control" name="category" onchange="submitForm();">
                                <option value="">Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if(Request::get('category') == $category->id ) selected @endif>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            	</select>
		      				</div>
		      				<div class="col-3">
		      					<input type="text" name="search" class="form-control" placeholder="Search ..." value="{{Request::get('search')}}">
		      				</div>
		      				<div class="col-2">
		      					<button class="btn btn-success form-control">Search</button>
		      				</div>
		      				<div class="col-1">
		      					<a href="{{route('user.purchase')}}" class="btn btn-primary form-control"><i class="fa fa-refresh" aria-hidden="true"></i></a>
		      				</div>
	      				</form>
	      			</div>
      				<table class="table">
      					<thead class="thead-dark">
      						<tr>
      							<th>Title
                                    <div class="btn-group-vertical">
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'titleasc'])) }}>
                                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                        </a>
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'titledesc'])) }}>
                                           <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                   </th>
      							<th><p>Image</p></th>
      							<th scope="col">Price
      								<div class="btn-group-vertical">
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'priceasc'])) }}>
                                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                        </a>
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'pricedesc'])) }}>
                                           <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        </a>
                                    </div>
      							</th>
      							<th scope="col"><p>Category</p></th>
      							<th scope="col"><p>Status</p></th>
      							<th scope="col">Created at
      								<div class="btn-group-vertical">
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'createasc'])) }}>
                                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                        </a>
                                        <a
                                            href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'createdesc'])) }}>
                                           <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        </a>
                                    </div>
      							</th>
      							<th scope="col"></th>
      						</tr>
      					</thead>
      					<tbody id="listPurchase">
      						@foreach($products as $product)
	      						<tr>
	      							<td>{{$product->title}}</td>
	      							<td>
	      								@php
	      									$image = json_decode($product->image, true);
	      								@endphp
	      								<img width="100" src="{{asset('uploads/product/'.$image[0])}}" alt="">
	      							</td>
	      							<td>${{number_format($product->price, 2)}}</td>
	      							<td>{{$product->category->name}}</td>
	      							<td>
	      								<span class="status--process">{{getStatusName($product->status)}}</span> 
	      							</td>
	      							<td>{{$product->created_at}}</td>
	      							<td>
	      								@if($product->status == $product::PENDING_APPROVAL)
	      									<a href="{{route('user.purchase.cancel', ['id'=>$product->id])}}" onclick="return confirm('Are you sure?')" title="Cancel"><i class="fa fa-ban fa-2x" aria-hidden="true"></i></a>
	      								@elseif($product->status == $product::DELIVERED  && !$product->review)
		      								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" title="Review" onclick="showReviewForm({{$product->id}}, {{$product->seller_id}} )">
		      									<i class="fa fa-star" aria-hidden="true"></i>
		      								</button>
	      								@endif
	      							</td>
	      						</tr>
      						@endforeach
      					</tbody>
      				</table>
	      		</div>
	      		<div class="pagination">
	      			{!! $products->appends(request()->query())->links() !!}
	      		</div>
			</div>
		</div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form action="{{route('ajax.create.review')}}" method="post" id="reviewForm">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<input type="hidden" name="product_id">
				<input type="hidden" name="seller_id">
				<input type="hidden" name="customer_id" value="{{Auth::user()->id}}">
				<div class="modal-body">
					<div class="form-group col-md-12">
						<label class="text-black" for="">Star</label>
						<select class="form-control" name="star" onchange="changeStar(this);">
							<option value="5" selected>
								&#9733&#9733&#9733&#9733&#9733
							</option>
							<option value="4">&#9733&#9733&#9733&#9733
							</option>
							<option value="3">&#9733&#9733&#9733
							</option>
							<option value="2">&#9733&#9733 
							</option>
							<option value="1">&#9733 
							</option>
						</select>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label class="text-black" for="name">Content</label>
							<textarea class="form-control" id="content" name="content" cols="10" rows="5">
								Very good
							</textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnCancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Confirm</button>
				</div>
			</form>
		</div>
	</div>
</div>
@stop
@section('script')
<script>

	function submitForm() {
		$('#myForm').submit();
	}

	$('#reviewForm').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: '{{route("ajax.create.review")}}',
			type: 'POST',
			dataType: 'JSON',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
		})
		.done(function(data) {
			$('#listPurchase').load(' #listPurchase > * ');
			$('#btnCancel').click();
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	function showReviewForm(product_id, seller_id) {
		$('input[name="product_id"]').val(product_id);
		$('input[name="seller_id"]').val(seller_id);
	}
	
	function changeStar(param) {
		switch(param.value) {
			case '1':
		    	$('#content').text('Very bad');
		    break;
		    case '2':
		  		$('#content').text('Bad');
		    break;
		    case '3':
		  		$('#content').text('Not bad');
		    break;
		    case '4':
		  		$('#content').text('Good');
		    break;
		    case '5':
		  		$('#content').text('Very good');
		    break;
		}
	}

</script>
@endsection
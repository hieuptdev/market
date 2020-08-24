@extends('frontend.layouts.master')
@section('title', 'User Product Approval')
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
	      					Product Pending Approval
	      				</h4>
	      				@if(session('success'))
                       		 <div class="alert alert-success">{{Session('success')}}</div>
                        @endif
                        @if(session('error'))
                       		 <div class="alert alert-danger">{{Session('error')}}</div>
                        @endif
	      			</div>
	      			<div class="card-header row col-12">
	      				<form action="" class="row" id="myForm">
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
		      				<div class="col-5">
		      					<input type="text" name="search" class="form-control" placeholder="Search ..." value="{{Request::get('search')}}">
		      				</div>
		      				<div class="col-2">
		      					<button class="btn btn-success form-control">Search</button>
		      				</div>
		      				<div class="col-2">
		      					<a href="{{route('user.product.pending.approval')}}" class="btn btn-primary form-control"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
      					<tbody>
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
	      							<td>{{$product->created_at}}</td>
	      							<td>
	      								<a href="{{route('user.product.pending.approval.confirm', ['id'=>$product->id])}}" title="Confirm"><i class="fa fa-check fa-2x" aria-hidden="true"></i></a>
	      								<br><br>
	      								<a href="{{route('user.product.pending.approval.cancel', ['id'=>$product->id])}}" onclick="return confirm('Are you sure?')" title="Cancel"><i class="fa fa-ban fa-2x" aria-hidden="true"></i></a>
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
@stop
@section('script')
<script>
	function changeImg(input){
        //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
        if(input.files && input.files[0]){
        	var reader = new FileReader();
            //Sự kiện file đã được load vào website
            reader.onload = function(e){
                //Thay đổi đường dẫn ảnh
                $('#avatar').attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
	$('#choose-image').click(function(event) {
		$('#image').click();
	});

	function submitForm() {
		$('#myForm').submit();
	}

	$('#myform').on('submit',function(event) {
		event.preventDefault()
		$.ajax({
			url: '{{route("user.account.edit.profile")}}',
			type: 'POST',
			dataType: 'JSON',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
		})
		.done(function(data) {
			console.log("success");
			$("#userProfile").load(" #userProfile > * ");
			alert('Update profile successfully!');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});

</script>
@endsection
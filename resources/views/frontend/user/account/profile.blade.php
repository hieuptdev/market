@extends('frontend.layouts.master')
@section('title', 'My profile')
@section('style')
<style>
	#item-name{
		color: black;
		font-weight: bold;
	}
</style>
@endsection()
@section('content')
<div class="overlay" style="background-image: url(frontend/images/background2.jpg);" data-aos="fade"
  data-stellar-background-ratio="0.5">
  <div class="container-fluid">
    <div class="row col-12 justify-content-center text-center" >
      @include('frontend.user_layout.sidebar')
	<div class="row col-9" id="accordionExample" style="margin-top: 150px; margin-bottom: 50px; z-index:">
		<div class="col-12" style="margin-bottom: 20px;">
			<div class=" card" id="userProfile">
				<div class="row" style="height: 100px;">
					<div class="col-4" style="top: 20%">
						@php
							$avatar = Auth::user()->avatar ? Auth::user()->avatar : 'user.jpg';
						@endphp
						<a href="{{route('user.account.profile')}}">
							<img src="{{asset('uploads/avatar/'.$avatar)}}" width="45" height="60"  alt="">
							{{Auth::user()->username}}
						</a>
					</div>
					<div class="col-2" style="top: 35%;">
						<i class="fa fa-star-half-o" aria-hidden="true"></i>
						{{totalReview(Auth::user()->id)}}
						@if(totalReview(Auth::user()->id) > 1)
							Reviews
						@else
							Review
						@endif

					</div>
					<div class="col-2" style="top: 35%;">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
						{{totalBought(Auth::user()->id)}}
						@if(totalBought(Auth::user()->id) > 1)
							Boughts
						@else
							Bought
						@endif
						
					</div>
					<div class="col-2" style="top: 35%;">
						<i class="fa fa-sellsy" aria-hidden="true"></i>
						{{totalSold(Auth::user()->id)}}
						@if(totalSold(Auth::user()->id) > 1)
							Solds
						@else
							Sold
						@endif
					</div>
				</div>
      		</div>
		</div>
		<div class="accordion col-12" id="accordionExample">
      		<div class="card">
      			<div class="card-header" id="headingOne">
      				<h4 class="text-left">
      					My profile
      				</h4>
                              <p class="text-left">Manage profile information for account security</p>
      			</div>
				<div class="card-body row">
					<div class="col-12">
					<form method="POST" enctype="multipart/form-data" id="myform">
						@csrf
						<div class="form-group row">
							<div class="mx-auto" align="center">
								<div class="card-img">
									<img width="100" class="img-thumbnail" name="avatar" id="avatar" src="{{asset('uploads/avatar/'.$avatar) }}" alt="">
								</div>
								<br>
								<button type="button" class="btn btn-secondary" id="choose-image">Choose image</button>
							</div>
						</div>

						<div class="form-group">
							<input type="file" name="avatar" id="image" style="display: none;" onchange="changeImg(this)">
						</div>

						<div class="form-group row">
							<div class="col-3">
								<label class="form-control text text-danger" for="">Username</label>
							</div>
							<div class="col-9 row">
								<div class="col-9">
									<input type="text" class="form-control" value="{{Auth::user()->username}}" readonly>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-3">
								<label class="form-control text text-danger" for="">Name</label>
							</div>
							<div class="col-9 row">
								<div class="col-9">
									<input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-3">
								<label class="form-control text text-danger" for="">Email</label>
							</div>
							<div class="col-9 row">
								<div class="col-9">
									<input type="text" class="form-control" value="{{Auth::user()->email}}" readonly>
								</div>
							{{--<div class="col-3">
									<a href="{{route('user.account.change.email')}}" class="btn btn-danger">Change</a>
								</div> --}}
							</div>
						</div>

						<div class="form-group row">
							<div class="col-3">
								<label class="form-control text text-danger" for="">Phone</label>
							</div>
							<div class="col-9 row">
								<div class="col-9">
									<input type="text" class="form-control" value="{{Auth::user()->phone}}" readonly>
								</div>
								{{-- <div class="col-3">
									<a href="{{route('user.account.change.phone')}}" class="btn btn-danger">Change</a>
								</div> --}}
							</div>
						</div>

						<div class="form-group row">
							<div class="col-3">
								<label class="form-control text text-danger" for="">Gender</label>
							</div>
							<div class="col-9 text-left">
								<input type="radio" name="gender" value="male" @if(Auth::user()->gender == 'male') checked @endif> <span>Male</span> &nbsp
								<input type="radio" name="gender" value="female" @if(Auth::user()->gender == 'female') checked @endif> <span>Female</span> &nbsp
								<input type="radio" name="gender" value="other" @if(Auth::user()->gender == 'other') checked @endif> <span>Other</span>
							</div>
						</div>
						<button type="submit" class="btn btn-warning">Save</button>
					</form>
					</div>
				</div>
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

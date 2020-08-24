@extends('frontend.layouts.master')
@section('title', 'Change phone number')
@section('content')
<div class="overlay" style="background-image: url(frontend/images/banner5.jpg);" data-aos="fade"
  data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row col-12 align-items-center justify-content-center text-center">
		<div class="accordion col-8" id="accordionExample">
      		<div class="card" style="margin-top: 180px; margin-bottom: 100px;">
      			<div class="card-header" id="headingOne">
      				<h3 class="text-left">Change phone number</h3>
      				<p class="text-left">To update the new phone number, please confirm by entering the password</p>
      			</div>
      			<div id="showMessageSuccess" style="background-color: black; width: 300px; z-index: 1000; position: absolute; top: 20%; left: 33%; display: none;">
      				<h3 class="text-danger">Change phone number success fully!</h3>
      			</div>
  				<div class="card-body row" id="confirmPhone">
  					<div class="col-12">
  					<form method="POST" enctype="multipart/form-data" id="confirmPhoneForm">
  						@csrf
  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">Phone</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}" readonly>
  								</div>
  							</div>
  						</div>

  						<div class="form-group row" id="inputPassword">
  							<div class="col-3">
  								<label class="form-control" for="">Password</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input class="form-control" type="password" name="password" id="password">
  									<div id="showErrorPassword"></div>
  								</div>
  							</div>
  						</div>
  			
  						<button type="submit" id="btnVerifyPassword" class="btn btn-warning">Confirm</button>
  					</form>
  					</div>
  				</div>

  				<div class="card-body row" id="newPhone" style="display: none;">
  					<div class="col-12">
  					<form method="POST" enctype="multipart/form-data" id="newPhoneForm">
  						@csrf
  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">Phone</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}" readonly>
  								</div>
  							</div>
  						</div>
  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">New Phone</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="newPhone" class="form-control" id="phone">
  									<div id="showErrorPhone"></div>
  								</div>
  							</div>
  						</div>
  						<button type="submit" class="btn btn-warning">Confirm</button>
  						<a href="{{route('user.account.profile')}}" class="btn btn-secondary">Cancel</a>
  					</form>
  					</div>
  				</div>
      		</div>
  		</div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  //
	$('#confirmPhoneForm').on('submit', function(event) {
		event.preventDefault()
		$.ajax({
  			url: '{{route("user.account.verify.password")}}',
  			type: 'POST',
  			dataType: 'JSON',
  			data: new FormData(this),
  			contentType: false,
  			cache: false,
  			processData: false,
		})
		.done(function(data) {
		    if(data == 'success'){
  				 $("#confirmPhone").css('display', 'none');
  				 $("#newPhone").css('display', 'block');
			  }
		})
		.fail(function(error) {
			  var errors = error.responseJSON;
			  if(errors.errors.password != ''){
  				  errorsHtml = '<p class="text-danger text-left">'+errors.errors.password+'</p>';
  				  $("#password").addClass('is-invalid');
            $("#showErrorPassword").html(errorsHtml);
			  }
		 });
	});

  // change phone number
	$('#newPhoneForm').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: '{{route("user.account.change.phone")}}',
			type: 'POST',
			dataType: 'JSON',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
		})
		.done(function(data) {
			if(data == 'success'){
				$("#showMessageSuccess").show("slow").delay(3000).hide("slow");
				setTimeout(function () {
       				window.location.href = '{{route("user.account.profile")}}';
  				}, 2000);
			}
		})
		.fail(function(error) {
			var errors = error.responseJSON;
  			if(errors.errors.newPhone != ''){
  				 errorsHtml = '<p class="text-danger text-left">'+errors.errors.newPhone[0]+'</p>';
  				 $("#phone").addClass('is-invalid');
           $("#showErrorPhone").html(errorsHtml);
  			}
		});
	});
</script>
@endsection
@extends('frontend.layouts.master')
@section('title', 'Change email')
@section('content')
<div class="overlay" style="background-image: url(frontend/images/banner5.jpg);" data-aos="fade"
  data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row col-12 align-items-center justify-content-center text-center">
		<div class="accordion col-8" id="accordionExample">
      		<div class="card" style="margin-top: 180px; margin-bottom: 100px;">
      			<div class="card-header" id="headingOne">
      				<h3 class="text-left">Change email</h3>
      				<p class="text-left">To update the new email, please confirm by entering the password</p>
      			</div>
      			<div id="showMessageSuccess" style="background-color: black; width: 300px; z-index: 1000; position: absolute; top: 20%; left: 33%; display: none;">
      				<h3 class="text-danger">Change email success fully!</h3>
      			</div>
  				<div class="card-body row" id="confirmEmail">
  					<div class="col-12">
  					<form method="POST" enctype="multipart/form-data" id="confirmEmailForm">
  						@csrf
  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">Email</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" readonly>
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
  									<div id="showError"></div>
  								</div>
  							</div>
  						</div>
  			
  						<button type="submit" id="btnVerifyPassword" class="btn btn-warning">Confirm</button>
  					</form>
  					</div>
  				</div>

  				<div class="card-body row" id="newEmail" style="display: none;">
  					<div class="col-12">
  					<form method="POST" enctype="multipart/form-data" id="newEmailForm">
  						@csrf
  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">Email</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" readonly>
  								</div>
  							</div>
  						</div>

  						<div class="form-group row">
  							<div class="col-3">
  								<label class="form-control" for="">New Email</label>
  							</div>
  							<div class="col-9 row">
  								<div class="col-9">
  									<input type="text" name="newEmail" class="form-control" id="email">
  									<div id="showErrorEmail"></div>
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
	$('#confirmEmailForm').on('submit', function(event) {
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
      console.log(data);
  			if(data == 'success'){
  				$("#confirmEmail").css('display', 'none');
  				$("#newEmail").css('display', 'block');
  			}
		})
		.fail(function(error) {
		    var errors = error.responseJSON;
			  if(errors.errors.password != ''){
				    errorsHtml = '<p class="text-danger text-left">'+errors.errors.password+'</p>';
				    $("#password").addClass('is-invalid');
            $("#showError").html(errorsHtml);
			  }
		});
	});

	$('#newEmailForm').on('submit', function(event) {
		event.preventDefault()
		$.ajax({
		    url: '{{route("user.account.change.email")}}',
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
			  if(errors.errors.newEmail != ''){
				    errorsHtml = '<p class="text-danger text-left">'+errors.errors.newEmail+'</p>';
				    $("#email").addClass('is-invalid');
            $("#showErrorEmail").html(errorsHtml);
			  }
		});
	});
</script>
@endsection
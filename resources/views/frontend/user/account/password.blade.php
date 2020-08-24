@extends('frontend.layouts.master')
@section('title', 'Change password')
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
            <div class="col-9" id="accordionExample" style="margin-top: 150px; margin-bottom: 50px; z-index:">
                  <div class="accordion col-12" id="accordionExample">
                        <div class="card">
                              <div class="card-header" id="headingOne">
                                    <h4 class="text-left">
                                         Change password
                                    </h4>
                                    <p class="text-left">For account security, please do not share the password with others</p>
                              </div>
                              <div id="showMessageSuccess" style="background-color: black; width: 300px; z-index: 1000; position: absolute; top: 20%; left: 33%; display: none;">
                                    <h4 class="text-danger">Change password success fully. Please login again!</h4>
                              </div>
                              <div class="card-body row">
                                    <div class="col-12">
                                    <form method="POST" enctype="multipart/form-data" id="changPasswordForm">
                                          @csrf
                                          <div class="form-group row">
                                                <div class="col-4">
                                                      <label class="form-control text text-dark" for="">Current Password</label>
                                                </div>
                                                <div class="col-8 row" id="inputCurrentPassword">
                                                      <div class="col-9">
                                                            <input type="password" name="currentPassword" class="form-control" id="currentPassword">
                                                            <div id="showErrorCurrentPassword"></div>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="form-group row">
                                                <div class="col-4">
                                                      <label class="form-control text text-dark" for="">New Password</label>
                                                </div>
                                                <div class="col-8 row" id="inputPassword">
                                                      <div class="col-9">
                                                            <input type="password" name="password" class="form-control" id="password">
                                                            <div id="showErrorPassword"></div>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="form-group row">
                                                <div class="col-4">
                                                      <label class="form-control text text-dark" for="">Confirm Password</label>
                                                </div>
                                                <div class="col-8 row">
                                                      <div class="col-9">
                                                            <input type="password" name="password_confirmation" class="form-control" id="confirmPassword">
                                                      </div>
                                                </div>
                                          </div>
                                          <button type="submit" class="btn btn-warning">Confirm</button>
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
$('#changPasswordForm').on('submit', function(event) {
      $('#inputCurrentPassword').load(" #inputCurrentPassword > * ");
      $('#intputPassword').load(" #intputPassword > * ");
      event.preventDefault();
      $.ajax({
          url: '{{route("user.account.change.password")}}',
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
                  window.location.href = '{{route("login")}}';
              }, 5000);
          }
      })
      .fail(function(error) {
          var errors = error.responseJSON;
          if(errors.errors.password != null){
                errorsHtml = '<p class="text-danger text-left">'+errors.errors.password+'</p>';
              $("#password").val('');
              $("#confirmPassword").val('');
              $("#password").addClass('is-invalid');
              $("#showErrorPassword").html(errorsHtml);
          }
          if(errors.errors.currentPassword != null){
                errorsHtml = '<p class="text-danger text-left">'+errors.errors.currentPassword+'</p>';
              $("#currentPassword").val('');
              $("#currentPassword").addClass('is-invalid');
              $("#showErrorCurrentPassword").html(errorsHtml);
          }
      });
});
</script>
@endsection
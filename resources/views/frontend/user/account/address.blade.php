@extends('frontend.layouts.master')
@section('title', 'My address')
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
    <div class="row col-12 justify-content-center text-center" id="reloadPage">
        @include('frontend.user_layout.sidebar')
        <div class="col-9" id="accordionExample" style="margin-top: 150px; margin-bottom: 150px; ">
            <div class="accordion col-12" id="accordionExample">
                <div class="card" id="listAddress">
                      <div class="card-header" id="headingOne">
                            <div class="col-12 row">
                              <div class="col-6">
                                  <h4 class="text-left">My address</h4>
                              </div>
                              <div class="col-6" align="right">
                                  <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="addModal"><i class="fa fa-plus" aria-hidden="true"></i> Add Address </button>
                              </div>
                            </div>
                      </div>
                      <div class="card-body row">
                            <div class="col-12">
                              @foreach($userAddress as $address)
                                <div class="form-group row">
                                      <div class="col-2">
                                            <label class="text-danger" for="">Address {{ $loop->index+1 }}</label>
                                      </div>
                                      <div class="col-7 row" id="inputCurrentPassword">
                                          <div class="col-12 text-left">
                                            <span>{{$address->street}}</span>
                                          </div>
                                          <div class="col-12 text-left">
                                            <span>{{$address->ward->name}}</span>
                                          </div>
                                          <div class="col-12 text-left">
                                            <span>{{$address->district->name}}</span>
                                          </div>
                                          <div class="col-12 text-left">
                                            <span>{{$address->province->name}}</span>
                                          </div>
                                      </div>
                                      <div class="col-3">
                                        <div class="col-12 row">
                                            <div class="col-6">
                                              <input type="hidden" name="id" value="{{$address->id}}">
                                               <button class="btn btn-secondary" onclick="editAddress($(this).prev().val());">Edit </button>
                                            </div>
                                            <div class="col-6">
                                              <input type="hidden" name="id" value="{{$address->id}}">
                                               <button onclick="if(confirm('Are you sure?')) deleteAddress($(this).prev().val());" class="btn btn-secondary">Delete</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                          <input type="hidden" name="id" value="{{$address->id}}">
                                          <button onclick="setDefaultAdress($(this).prev().val())" class="btn btn-warning 
                                          @if($address->default == 1) 
                                            invisible
                                          @endif">Set Default</button>
                                        </div>
                                      </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div id="listModal">
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10000;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Add a new address</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" id="btnClose">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="addAddressForm">
            @csrf
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Province</label>
                <select class="form-control" name="province_id" id="province" class="form-control">
                  <option value="">-- choose Province --</option>
                  @foreach($provinces as $province)
                  <option id="province_id" value="{{ $province->id }}">
                    {{ $province->name }}
                  </option>
                  @endforeach
                </select>
                <div id="errorprovince"></div>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">District</label>
                <select class="form-control " name="district_id" id="district" class="form-control">
                </select>
                <div id="errordistrict"></div>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Ward</label>
                <select class="form-control" name="ward_id" id="ward" class="form-control">
                </select>
                <div id="errorward"></div>
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Street</label>
              <input type="text" name="street" id="street" class="form-control">
              <div id="errorstreet"></div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnCancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Complete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
@section('script')
<script>

    $("#btnClose").on('click', function(event) {
      $("#exampleModal").load(" #exampleModal > * ");
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

    $("#addAddressForm").on('submit', function(event) {
        event.preventDefault();
        var data = [];
        data['province'] = $('#province').val();
        data['district'] = $('#district').val();
        data['ward'] = $('#ward').val();
        data['street'] = $('#street').val();
        for (var key in data) {
          // check if the property/key is defined in the object itself, not in parent
          if (data.hasOwnProperty(key)) {           
            if(data[key]==''){
                $('#error'+key+'').html('<p class="text-danger text-left">The '+key+' must be required</p>');
                $('#'+key+'').addClass('is-invalid');
            }else{
                $('#error'+key+'').html('');
                $('#'+key+'').removeClass('is-invalid');
            }
          }
         }
        $.ajax({
          url: '{{route('user.account.address.create')}}',
          type: 'POST',
          dataType: 'JSON',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
        })
         .done(function(data) {
           if(data == 1){
              $("#btnCancel").click();
              location.reload();
           }
        });         
    });
    //
    function setDefaultAdress(id){
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('user.account.address.default')}}',
          type: 'POST',
          dataType: 'JSON',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
          if(data == 1){
              $("#listAddress").load(" #listAddress > * ");
          }
        });
    }

    function deleteAddress(id){
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('user.account.address.delete')}}',
          type: 'POST',
          dataType: 'JSON',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
          if(data == 1){
              $("#listAddress").load(" #listAddress > * ");
          }else{
            alert('You cannot delete the default address');
          }
        });
    }

    function editAddress(id){
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url: '{{ route("user.account.address.edit") }}',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id, _token:_token},
      })
      .done(function(response) {
         $("#addAddressForm").append("<input type='hidden' name ='address_id' value='"+response['editAddress']['id']+"'/>"); 
          $('#province option[value='+response['editAddress']['province_id']+']').attr('selected','selected');
          $("#street").val(response['editAddress']['street']);
          var province_id = $('#province option:selected').val();
          $.ajax({
              url: '{{route("get.districts")}}',
              type: 'POST',
              data: {province_id: province_id, _token:_token},
          })
          .done(function(data) {
              $('#district').html(data);
              $('#district option[value='+response['editAddress']['district_id']+']').attr('selected','selected');

              var district_id = $('#district option:selected').val();
              $.ajax({
                  url: '{{route("get.wards")}}',
                  type: 'POST',
                  data: {district_id: district_id, _token:_token},
              })
              .done(function(data) {
                  $('#ward').html(data);
                  $('#ward option[value='+response['editAddress']['ward_id']+']').attr('selected','selected');
              }); 
          });
          $("#modalTitle").text('Edit Address');
          $("#addModal").click();
      });

    }

</script>
@endsection
@extends('backend.layouts.master')
@section('title', 'Create Product')
@section('main')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Create Product</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </div>
                            @endif
                            <div class="form-group">
                                <form action="{{route('product.store')}}" method="post" novalidate="novalidate"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Title</label>
                                        <input id="cc-pament" name="title" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{old('title')}}">
                                        {{showError($errors,'title')}}
                                    </div>
                                    <div class="form-group" id="user">
                                        <label for="cc-payment" class="control-label mb-1">Seller</label>
                                        <select name="seller_id" class="form-control" onchange="getUserAddress(this);">
                                            <option value="">-- Choose Seller --</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option>
                                            @endforeach
                                        </select>
                                        {{showError($errors,'seller_id')}}
                                        {{showError($errors,'seller_address')}}
                                    </div>
                                    <div id="address"></div>
                                    <div class="form-group" id="user">
                                        <label for="cc-payment" class="control-label mb-1">Customer</label>
                                        <select name="customer_id" class="form-control">
                                            <option value="">-- Choose Customer --</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->username}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Category</label>
                                        <select name="category_id" class="form-control @error('category_id')) is-invalid @enderror" id="category_id" onchange="getAttributes(this)">
                                            <option value="">Choose Category</option>
                                            @foreach ($categories as $category)
                                            <optgroup label="{{$category->name}}">
                                                @foreach($category->childCategory($category->id) as $child)
                                                <option value="{{$child->id}}">{{$child->name}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                        {{showError($errors,'category_id')}}
                                        {{showError($errors,'attributes')}}
                                    </div>
                                    <div id="attribute"></div>

                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Price</label>
                                        <input id="cc-number" name="price" type="number" step="0.01" class="form-control">
                                        {{showError($errors,'price')}}
                                    </div>
                                    <div class="form-group">
                                        <label for="select" class=" form-control-label">Status</label>
                                        @php
                                        $status = statusProduct();
                                        $loop = count($status);
                                        @endphp
                                        <select name="status" id="select" class="form-control">
                                            @for($i = 0; $i < $loop; $i++) <option value="{{$status[$i]['number']}}">
                                                {{$status[$i]['name']}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Image</label>
                                        <input type="file" name="image[]" multiple="true" id="image"
                                            style="display: none;" onchange="changeImg(this)">
                                        <br>
                                        <div id="preview"></div>
                                        {{showError($errors,'image')}}
                                    </div>
                                    <div class="col-3">
                                        <button type="button" id="choose-image" onclick="$('#image').click()">
                                            <i class="fa fa-camera fa-3x" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea-input" class=" form-control-label">Description</label>
                                        <textarea name="desc" id="textarea-input" rows="18" cols="20" placeholder="Content..."
                                            class="form-control">
                                        </textarea>
                                        {{showError($errors,'desc')}}
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
@stop
@section('script')
<script type="text/javascript" src="{{asset('backend/editor/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/editor/ckfinder/ckfinder.js')}}"></script>
<script>
    $(".js-example-tags").select2({
  tags: true
});
    function changeImg(input){
        //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
        if(input.files){
            var html = '';
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                //Sự kiện file đã được load vào website
                reader.onload = function(e){
                //Thay đổi đường dẫn ảnh
                    html += '<img width="100" class="img-thumbnail" name="preview" id="preview" src="'+e.target.result+'" alt="">';
                    $('#preview').html(html);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    function getUserAddress(data) {
        var id = data.value;
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('ajax.get.address')}}',
          type: 'POST',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
          $('#address').html(data);
        });
    }

    function getAttributes(data){
        var id = data.value;
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('ajax.get.attributes')}}',
          type: 'POST',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
            console.log(data);
            if(data != ''){
                var html = '';
                for (var i = 0; i < data['attributes'].length; i++) {
                    html += '<div class="row form-group">';
                    html += '<div class="col-2">';
                    html += '<input type="hidden" name="attributes[attributeId][]" value="'+data['attributes'][i]['id']+'" readonly="true" class="form-control">';
                    html += '<input type="text" name="attributes[name][]" value="'+data['attributes'][i]['name']+'" readonly="true" class="form-control">';
                    html += '</div>';
                    if(data['attributes'][i]['type'] == 'select'){
                        html += '<div class="col-4">';
                        html += '<select name="attributes[values][]" id="" class="form-control">';
                        var myarr = data['attributes'][i]['values'].split(",");
                        for (var j = 0; j < myarr.length; j++) {
                             html += '<option value="'+myarr[j]+'">'+myarr[j]+'</option>';
                        }
                        html += '</select>';
                        html += ' </div>';
                    }
                    if(data['attributes'][i]['type'] == 'radio'){
                        html += '<div class="col-8">';
                        var myarr = data['attributes'][i]['values'].split(",");
                        for (var j = 0; j < myarr.length; j++) {
                             html += '<input type="radio" name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }
                        html += ' </div>';
                    }
                    if(data['attributes'][i]['type'] == 'checkbox'){
                        html += '<div class="col-4">';
                        var myarr = data['attributes'][i]['values'].split(",");
                        for (var j = 0; j < myarr.length; j++) {
                             html += '<input type="checkbox" name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }
                        html += ' </div>';
                    }
                    if(data['attributes'][i]['type'] == 'textarea'){
                        html += '<div class="col-4 form-group">';
                        html += '<textarea class="form-control" name="attributes[values][]"id="" cols="10" rows="5"></textarea>';
                        html += ' </div>';
                    }
                    if(data['attributes'][i]['type'] == 'input'){
                        html += '<div class="col-4">';
                        html += '<input class="form-control" type="text" name="attributes[values][]">';
                        html += ' </div>';
                    }
                    html += '</div>';
                }
                $('#attribute').html(html);
            }else{
                $("#attribute").html('');
            }
        });
    }

    CKEDITOR.replace('desc', {
        filebrowserBrowseUrl: '{{asset("ckfinder/ckfinder.html")}}',
        filebrowserImageBrowseUrl: '{{asset("ckfinder/ckfinder.html?type=backend/Images")}}',
        filebrowserUploadUrl: '{{asset("core/connector/php/connector.php?command=QuickUpload&type=Files")}}',
        filebrowserImageUploadUrl: '{{asset("ckfinder/core/connector/php/connector.php?command=QuickUpload&type=backend/Images")}}',
    });
</script>
@stop

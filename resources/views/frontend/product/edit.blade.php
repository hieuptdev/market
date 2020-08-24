@extends('frontend.layouts.master')
@section('title', $product->title)
@section('content')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(frontend/images/hero_1.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 text-center">
                        <h1>Edit Product Information</h1>
                        <p class="mb-0">{{$product->title}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section" style="background-image: url(frontend/images/background2.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5 sm-12" data-aos="fade" style="background-color: #dfe6e9">
                <form action="{{route('frontend.product.update', ['id'=>$product->id])}}" method="post" class="p-5"
                    enctype="multipart/form-data">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger">{{Session('error')}}</div>
                    @endif
                    <input type="hidden" id="seller_id" name="seller_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="status" value="0">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="name">Title</label>
                            <input type="text" name="title" class="form-control @error('title')) is-valid @enderror" placeholder="Enter title" value="{{$product->title}}">
                            {{showError($errors,'title')}}
                        </div>
                    </div>
                    <div class="col-md-12" id="address">{{showError($errors,'address_id')}}</div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="category">Category</label>
                            <select name="category_id" class="form-control @error('category_id')) is-valid @enderror" id="category_id" onchange="getAttributes(this)">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $category)
                                    <optgroup label="{{$category->name}}">
                                    @foreach($category->childCategory($category->id) as $child)
                                      <option value="{{$child->id}}" 
                                        @if($product->category_id == $child->id)
                                            selected          
                                        @endif
                                        >{{$child->name}}</option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            {{showError($errors,'category_id')}}
                        </div>
                    </div>
                    <div class="col-md-12" id="attribute">{{showError($errors,'attributes')}}</div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="text-black @error('price')) is-valid @enderror" for="subject">Price</label>
                            <input type="number" name="price" step="0.01" class="form-control" value="{{number_format($product->price, 2)}}">
                            {{showError($errors,'price')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12" id="preview">
                           @php
                                $image = json_decode($product->image, true);
                           @endphp

                           @foreach($image as $src)
                                <img width="100" class="img-thumbnail" name="preview" id="preview" src="{{asset('uploads/product/'.$src)}}" alt="">
                           @endforeach
                        </div>
                        <div class="col-md-4">
                            <label class="text-black" for="message">Images</label>
                            <input type="hidden" name="oldImg" value="{{$product->image}}">
                            <input type="file" name="image[]" multiple onchange="changeImg(this)" class="form-control  @error('image')) is-valid @enderror">
                            {{showError($errors,'image')}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="textarea-input" class="form-control-label text-black">Description</label>
                            <textarea name="desc" id="textarea-input" rows="8" class="form-control @error('desc')) is-valid @enderror">
                                {!! $product->desc !!}
                            </textarea>
                            {{showError($errors,'desc')}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="submit" value="Post" class="btn btn-warning py-2 px-4 text-white">
                        </div>
                    </div>
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
        
     $(document).ready(function() {
        var address = {{$product['seller_address']}};
        var id = $('#seller_id').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('ajax.get.address')}}',
          type: 'POST',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
          $('#address').html(data);
          $('input:radio[name=seller_address][value='+address+']').attr('checked', true);
        });

        var id = $('#category_id').val();
        var _token = $('input[name="_token"]').val();
        var productId  = {{$product['id']}};
        $.ajax({
          url: '{{route('ajax.get.attributes')}}',
          type: 'POST',
          data: {id: id, productId: productId, _token:_token},
        })
        .done(function(data) {

            if(data['attributes'] != ''){
                var html = '';
                for (var i = 0; i < data['attributes'].length; i++) {
                    html += '<div class="row form-group">';
                    html += '<div class="col-2">';
                    html += '<input type="hidden" name="attributes[attributeId][]" value="'+data['attributes'][i]['id']+'" readonly="true" class="form-control">';
                    html += '<input type="text" name="attributes[name][]" value="'+data['attributes'][i]['name']+'" readonly="true" class="form-control">';
                    html += '</div>';
                if(data['attributes'][i]['type'] == 'select'){
                    html += '<div class="col-4">';
                    html += '<select name="attributes[values][]" class="form-control">';
                    var myarr = data['attributes'][i]['values'].split(",");
                    for (var j = 0; j < myarr.length; j++) {
                         if(data['productAttr'][i] && data['productAttr'][i]['values'] == myarr[j]){
                            html += '<option value="'+myarr[j]+'" selected>'+myarr[j]+'</option>';
                         }else{
                            html += '<option value="'+myarr[j]+'">'+myarr[j]+'</option>';
                         }
                    }
                    html += '</select>';
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'radio'){
                    html += '<div class="col-8">';
                    var myarr = data['attributes'][i]['values'].split(",");
                    for (var j = 0; j < myarr.length; j++) {
                        if(data['productAttr'][i] && data['productAttr'][i]['values'] == myarr[j]){
                            html += '<input type="radio" checked name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }else{
                            html += '<input type="radio" name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }
                    }
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'checkbox'){
                    html += '<div class="col-4">';
                    var myarr = data['attributes'][i]['values'].split(",");
                    for (var j = 0; j < myarr.length; j++) {
                        if(data['productAttr'][i] && data['productAttr'][i]['values'] == myarr[j]){
                            html += '<input type="checkbox" checked name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }else{
                            html += '<input type="checkbox" required name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                        }
                    }
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'textarea'){
                    html += '<div class="col-4 form-group">';
                    html += '<textarea class="form-control" required name="attributes[values][]"id="" cols="10" rows="5">'+data['productAttr'][i]['values']+'</textarea>';
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'input'){
                    html += '<div class="col-4">';
                    html += '<input class="form-control" required type="text" name="attributes[values][]" value="'+data['productAttr'][i]['values']+'">';
                    html += ' </div>';
                }
                    html += '</div>';
                }
                $('#attribute').html(html);

            }else{
                $("#attribute").html('');
            }
        });
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
    
        function getAttributes(data){
        var id = data.value;
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{route('ajax.get.attributes')}}',
          type: 'POST',
          data: {id: id, _token:_token},
        })
        .done(function(data) {
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
                    html += '<div class="col-8">';
                    var myarr = data['attributes'][i]['values'].split(",");
                    for (var j = 0; j < myarr.length; j++) {
                         html += '<input type="checkbox" name="attributes[values][]" value="'+myarr[j]+'"> '+myarr[j]+' &nbsp';
                    }
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'textarea'){
                    html += '<div class="col-8 form-group">';
                    html += '<textarea class="form-control" name="attributes[values][]"id="" cols="10" rows="5"></textarea>';
                    html += ' </div>';
                }
                if(data['attributes'][i]['type'] == 'input'){
                    html += '<div class="col-8">';
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
@endsection
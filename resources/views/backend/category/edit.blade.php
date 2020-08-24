@extends('backend.layouts.master')
@section('title', 'Edit category')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Edit category</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </div>
                            @endif
                            <div>
                                <form id="myform"
                                    action="{{ route('category.destroy',['category'=>$editCategory->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger float-right" title="Delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <br>
                            <div class="form-group">
                                <form action="{{ route('category.update', ['category'=>$editCategory->id])}}" method="post"
                                    >
                                    @method('PUT')
                                    @csrf
                                    <br>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{$editCategory->name}}">
                                        {{showError($errors,'name')}}
                                    </div>
                                    <div class="form-group">
                                        <input name="category_id" type="hidden" value="{{$editCategory->id}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Parent</label>
                                        <select name="parent_id" class="form-control">
                                            <option value="0">None</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($editCategory->parent_id ==
                                                $category->id)
                                                selected
                                                @endif
                                                >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                        @php 
                                            $i = 0; 
                                            $loop = count($editCategory->attribute);
                                        @endphp
                                        <input type="hidden" name="loop" value="{{$loop}}"> 
	                                    @foreach($editCategory->attribute as $attribute)
                                        @php $i++; @endphp
	                                    <div class="form-group row" id="groupAttr{{$i}}">
	                                    	<div class="col-3">
                                                <input type="hidden" name="attributes[attributeId][]" class="form-control" placeholder="name" value="{{$attribute->id}}">
	                                    		<label for="">Name</label>
	                                    		<input type="text" name="attributes[name][]" class="form-control" placeholder="name" value="{{$attribute->name}}">
	                                    	</div>
	                                    	<div class="col-2">
	                                    		<label for="">Type</label>
	                                    		<select class="form-control" name="attributes[type][]" onchange="checkSelectType(this, $(this).parent().next())">
	                                    			<option value="input"
                                                    @if($attribute->type == 'input')
                                                    selected 
                                                    @endif
                                                    >input</option>
	                                    			<option value="textarea"
                                                    @if($attribute->type == 'textarea')
                                                    selected 
                                                    @endif
                                                    >textarea</option>
	                                    			<option value="radio"
	                                    			@if($attribute->type == 'radio')
	                                    			selected
	                                    			@endif
	                                    			>radio</option>
	                                    			<option value="checkbox"
	                                    			@if($attribute->type == 'checkbox')
	                                    			selected
	                                    			@endif
	                                    			>checkbox</option>
	                                    			<option value="select"
	                                    			@if($attribute->type == 'select')
	                                    			selected
	                                    			@endif
	                                    			>select</option>
	                                    		</select>
	                                    	</div>
	                                    	<div class="col-6 
                                                @if($attribute->type == 'input' || $attribute->type == 'textarea')
                                                    invisible
                                                @endif"
                                                id="values{{$i}}">
    	                                    		<label for="">Values</label>
    	                                    		<input type="text" 
                                                    @if($attribute->type !=='input' && $attribute->type !== 'textarea')
                                                        required 
                                                    @endif 
                                                name="attributes[values][]" class="form-control" placeholder="values" value="{{$attribute->values}}">
	                                    	</div>
	                                    	<div class="col-1">
	                                    		<br>
	                                    		<input type="button" class="btn btn-danger" onclick="removeAttributes($(this).parent().parent())" value="X">
	                                    	</div>
	                                    </div>
	                                    @endforeach
                                    <div id="attributes"></div>
                                    <div>
                                        <button type="button" id="addAttribute" class="btn btn-success">Add attribute</button>
                                    </div>
                                    <br>
                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">Submit</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            </form>
                        </div>
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
    var i = $('input[name="loop"]').val();
    $('#addAttribute').on('click', function(event) {
        event.preventDefault();
        i++;
        var data = '';
            data += '<div class="form-group row" id="groupAttr'+i+'">';
            data += '<div class="col-3">';
            data += '<label for="">Name</label>';
            data += '<input type="text" id="attributeName" name="attributes[name][]" class="form-control" placeholder="name">';
            data += '</div>';
            data += '<div class="col-2">';
            data += '<label for="">Type</label>';
            data += '<select class="form-control" name="attributes[type][]" onchange="checkSelectType(this, $(this).parent().next())">';
            data += '<option value="input">input</option>';
            data += '<option value="textarea">textarea</option>';
            data += '<option value="radio">radio</option>';
            data += '<option value="checkbox">checkbox</option>';
            data += '<option value="select">select</option>';
            data += '</select>';
            data += '</div>';
            data += '<div class="col-6 invisible" id="values'+i+'">';
            data += '<label for="">Values</label>';
            data += '<input type="text" name="attributes[values][]" class="form-control" placeholder="values">';
            data += '</div>';
            data += '<div class="col-1">';
            data += '<br>';
            data += '<input type="button" class="btn btn-danger" onclick="removeAttributes($(this).parent().parent())" value="X">';
            data += '</div>';
            data += '</div>';
        $('#attributes').append(data);
        $('#attributeName').attr('required', 'true');
    });

    function checkSelectType(data, parent){
        if(data.value == 'select' || data.value == 'checkbox' || data.value == 'radio'){
            $('#'+parent.attr('id')+'').removeClass('invisible')
            parent.children('input').attr('required', 'true');
        }
        else{
            $('#'+parent.attr('id')+'').addClass('invisible');
            parent.children('input').removeAttr('required');      
        }
    }

    function removeAttributes(attr){
        attr.remove();
    }
</script>
@endsection()

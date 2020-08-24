@extends('backend.layouts.master')
@section('title', 'Product')
@section('main')
<style>
    .item-1:hover {
        background-color: darkgray;
    }
</style>
<div class="main-content" style="overflow: auto;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Products</h3>
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ session('error') }}</strong>
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ session('success') }}</strong>
                    </div>
                    @endif
                    {{-- Filter --}}
                     <div class="table-data__tool">
                        <form class="form-header" action="{{route('product.index')}}" method="GET" id="myForm">
                            @csrf
                            <input class="au-input au-input--xl" type="text" name="search"
                                placeholder="Search for products" style="height: 41px;" @if(Request::get('search'))
                                value="{{Request::get('search')}}" @endif />
                             <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            &nbsp &nbsp
                            <a href="{{route('product.index')}}" class="au-btn--submit"><i class="fa fa-refresh"
                                    aria-hidden="true"></i></a>
                            &nbsp &nbsp
                            <div class="co-3">
                                <a href="{{route('product.create')}}"
                                    class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Product</a>
                            </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <select class="form-control" name="province" id="province" onchange="submitForm();">
                                <option value="">Province</option>
                                @foreach($provinces as $province)
                                <option value="{{$province->id}}" @if(Request::get('province')==$province->id)
                                    selected
                                    @endif>{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="district" id="district" onchange="submitForm();">
                                <option value="">District</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="ward" id="ward" onchange="submitForm();">
                                <option value="">Ward</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="status" onchange="submitForm();">
                                @php
                                    $listStatus = statusProduct();
                                    $loop = count($listStatus);
                                @endphp
                                <option value="">Status</option>
                                @for($i = 0; $i < $loop; $i++)
                                    <option value="{{$listStatus[$i]['number']}}"
                                    @if(Request::get('status') == $listStatus[$i]['number'])
                                        selected
                                    @endif
                                    >{{$listStatus[$i]['name']}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="category" onchange="submitForm();">
                                <option value="">Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if(Request::get('category') == $category->id ) selected @endif>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
                    {{-- End filter --}}

                    <div class="table-responsive table-responsive-data2" id="dataTable">
                        <table class="table table-data2" style="width: 1700px;">
                            <thead>
                                <tr>
                                   <th>id
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'idasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'iddesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>title
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'titleasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'titledesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">seller</p>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">customer</p>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">Image</p>
                                    </th>
                                    <th>Status
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'statusasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'statusdesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>Price
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'priceasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'pricedesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">Category</p>
                                    </th>
                                    <th>Created_at
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'createasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'createdesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">Action</p>
                                    </th>
                                </tr>
                            </thead>

                            @foreach ($products as $product)
                            <tr class="tr-shadow">
                                <div class="item-1">
                                    <td>{{$product->id}}</td>
                                    <td class="desc">{{$product->title}}</td>
                                    <td>{{$product->seller->username}}</td>
                                    <td>
                                        @if($product->customer != null)
                                            {{$product->customer->username}}
                                        @else
                                             None
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $image = json_decode($product->image, true);
                                        @endphp
                                        <img width="100" src="{{asset('uploads/product/'.$image[0])}}">
                                    </td>
                                    <td>
                                        <span class="status--process">
                                            {{getStatusName($product->status)}}
                                        </span>
                                    </td>
                                    <td>${{number_format($product->price, 2)}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            @if($product->status == $product::PENDING)
                                                <a href="{{route('product.confirm',['id'=>$product->id])}}" title="Confirm" class="item"><i class="fas fa-check"></i>
                                                </a>
                                                <form action="{{ route('product.destroy',['product' => $product->id]) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure?')"
                                                    data-placement="top" class="item" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            @else
                                            <a href="{{route('product.edit',['product'=>$product->id])}}" class="item"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="{{ route('product.destroy',['product' => $product->id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Are you sure?')" data-toggle="tooltip"
                                                    data-placement="top" class="item" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </div>
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
</div>
@stop
@section('script')
<script>
    function changeStatus(id) {
       $.ajax({
           url: '{{route('ajax.approve.product')}}',
           type: 'GET',
           dataType: 'JSON',
           data: {id: id},
       })
       .done(function(response) {
            if(response == 'success'){
                $('#dataTable').load(' #dataTable > * ');
            }
       })
       .fail(function() {
           console.log("error");
       })
       .always(function() {
           console.log("complete");
       });
    }

     function submitForm() {
        $('#myForm').submit();
    }

    $(document).ready(function() {
        var _token = $('input[name="_token"]').val();
        var params = new window.URLSearchParams(window.location.search);
        var province_id = $('#province').val();
        if(province_id != ''){
            $.ajax({
              url: '{{route("get.districts")}}',
              type: 'POST',
              data: {province_id: province_id, _token:_token},
            })
            .done(function(data) {
                $('#district').html(data);
                $('#district option[value='+params.get('district')+']').attr("selected", true);
                var district_id = params.get('district');
                $.ajax({
                  url: '{{route("get.wards")}}',
                  type: 'POST',
                  data: {district_id: district_id, _token:_token},
              })
                .done(function(data) {
                    $('#ward').html(data);
                    $('#ward option[value='+params.get('ward')+']').attr("selected", true);
                });
            });
        }
    });
</script>
@endsection

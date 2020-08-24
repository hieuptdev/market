@extends('backend.layouts.master')
@section('title', 'Category')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Categories</h3>
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
                    <div class="table-data__tool">
                        <form class="form-header" action="{{route('category.index')}}" method="GET" id="myForm">
                            @csrf
                            <div class="rs-select2--light rs-select2--md" style="margin-right: 10px;">
                                <select class="js-select2" name="root">
                                    <option value="">Root</option>
                                    @foreach($rootCategory as $category)
                                        <option value="{{$category->id}}"
                                            @if(Request::get('root') == $category->id)
                                                selected 
                                            @endif
                                            >{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                            &nbsp
                            <input class="au-input au-input--xl" type="text" name="search"
                            placeholder="Search for category" style="height: 41px;" @if(Request::get('search'))
                            value="{{Request::get('search')}}" @endif />
                            <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            &nbsp &nbsp
                            <a href="{{route('category.index')}}" class="au-btn--submit"><i class="fa fa-refresh"
                                aria-hidden="true"></i></a>
                                &nbsp &nbsp
                            <div class="co-3">
                                <a href="{{route('category.create')}}"
                                class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Category</a>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
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
                                    <th>name
                                        <div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'nameasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'namedesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">root</p>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">attributes</p>
                                    </th>
                                    <th>created_at
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
                                        <p style="margin-top: 8px;">action</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>@if($category->parent_id == 0)
                                        <span>----</span>
                                        @else
                                        {{$category->rootName($category->parent_id)}}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($category->attribute as $attribute)
                                            <p>{{$attribute->name}}</p>
                                        @endforeach
                                    </td>
                                    <td>{{$category->created_at}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="{{route('category.edit',['category' => $category->id])}}"
                                                class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <!--  destroy user -->

                                            <form id="myform"
                                                action="{{ route('category.destroy',['category'=>$category->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')" type="submit"
                                                    class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination">
                            {!! $categories->appends(request()->query())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

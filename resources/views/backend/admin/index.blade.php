@extends('backend.layouts.master')
@section('title', 'Admin')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Admin</h3>
                    <div class="table-data__tool">
                        {{-- <form class="form-header" method="get">
                            <div class="rs-select2--light rs-select2--sm" style="margin-right: 10px;">
                                <select class="js-select2" name="roles">
                                    <option value="">All</option>
                                    <option value="">wfw</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <input class="au-input au-input--xl" type="text" name="search"
                                placeholder="Search for users ..." style="height: 41px;"
                                value="{{Request::get('search')}}" />
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                        </form> --}}
                        <div class="table-data__tool-right">
                            <a href="{{route('admin.create')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add item</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $item)
                            <tr class="tr-shadow">
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td class="desc">{{$item->email}}</td>
                                <td>@if ($item->role!= NULL)
                                    {{$item->role->name}}
                                    @endif</td>
                                <td>
                                    <div class="table-data-feature">

                                        <a href="{{route('admin.edit',['id'=>$item->id])}}" class="item"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="zmdi zmdi-edit"></i></a>

                                        <form action="{{route('admin.delete',['id'=>$item->id])}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button onclick="return confirm('Are you sure?')" class="item btn"
                                                title="Delete"><i class="zmdi zmdi-delete"></i></button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->

            </div>
        </div>
    </div>
</div>
</div>

@stop

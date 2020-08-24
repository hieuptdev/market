@extends('backend.layouts.master')
@section('title', 'Users')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <h3 align="center">User detail</h3>
                        <div class="card card-block">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </div>
                        <tbody>
                            <tr class="tr-shadow">
                                <td>{{$userShow->id}}</td>
                                <td>{{$userShow->name}}</td>
                                <td>
                                    <span class="block-email">{{$userShow->email}}</span>
                                </td>
                                <td>{{$userShow->phone}}</td>
                                <td>{{$userShow->created_at}}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <a href="{{route('user.edit',['id' => $userShow->id])}}" class="item"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <!--  destroy user -->

                                        <a href="{{route('user.delete',['id' => $userShow->id])}}">
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="item"
                                                data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @php
            $totalSold = $userShow->userProduct->where('status', 'sold');
            $totalBought = $userShow->userProduct->where('status', 'bought');
            @endphp

            <div class="row" style="margin-top: 50px;">
                <div class="table-responsive table-responsive-data2 col-6">
                    <table class="table table-data2">
                        <h3 align="center">Total product sold</h3>
                        <div class="card card-block">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>price</th>
                                    <th>category</th>
                                </tr>
                            </thead>
                        </div>
                        <tbody>
                            @foreach($totalSold as $item)
                            <tr class="tr-shadow">
                                <td>{{$item->product->id}}</td>
                                <td>{{$item->product->name}}</td>
                                <td>
                                    <span class="block-email">{{$item->product->price}}</span>
                                </td>
                                <td>{{$item->product->category_id}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive table-responsive-data2 col-6">
                    <table class="table table-data2">

                        <h3 align="center">Total product bought</h3>

                        <div class="card card-block">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>phone</th>
                                    <th>category</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </div>
                        <tbody>
                            @foreach($totalBought as $item)
                            <tr class="tr-shadow">
                                <td>{{$item->product->id}}</td>
                                <td>{{$item->product->name}}</td>
                                <td>
                                    <span class="block-email">{{$item->product->price}}</span>
                                </td>
                                <td>{{$item->product->category_id}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@extends('backend.layouts.master')
@section('title', 'Review')
@section('main')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session('noti'))
                    <div class="alert alert-{{session('status')}}" role="alert">
                        <strong>{{session('noti')}}</strong>
                    </div>
                    @endif
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Review</h3>
                    <div class="table-data__tool">
                        <form class="form-header" action="{{route('review.index')}}" method="GET" id="myForm">
                            @csrf
                            <input class="au-input au-input--xl" type="text" name="search"
                            placeholder="Search for review" style="height: 41px;" @if(Request::get('search'))
                            value="{{Request::get('search')}}" @endif />
                            <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            &nbsp &nbsp
                            <a href="{{route('review.index')}}" class="au-btn--submit"><i class="fa fa-refresh"
                                aria-hidden="true"></i></a>
                                &nbsp &nbsp
                            <div class="co-3">
                                <a href="{{route('review.create')}}"
                                class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Review</a>
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
                                    <th>
                                        <p style="margin-top: 8px;">seller</p>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">customer</p>
                                    </th>
                                    <th>
                                        <p style="margin-top: 8px;">content</p>
                                    </th>
                                    <th>star<div class="btn-group-vertical">
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'starasc'])) }}>
                                                <i class="fas fa-sort-up"></i>
                                            </a>
                                            <a
                                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'stardesc'])) }}>
                                                <i class="fas fa-sort-down"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th>created at<div class="btn-group-vertical">
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
                                        <p style="margin-top: 8px">action</p>
                                    </th>
                                </tr>
                            </thead>

                            @foreach ($reviews as $item)
                            @php
                            ;
                            @endphp
                            <tr class="tr-shadow">
                                <td>{{$item->id}}</td>
                                <td>{{$item->seller->username}}</td>
                                <td>
                                    {{$item->customer->username}}
                                </td>
                                <td>{{$item->content}}</td>
                                <td>@for($i=1;$i<=$item->star;$i++) &#9733 @endfor</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <div class="table-data-feature">

                                        <a href="{{route('review.edit',['id'=>$item->id])}}" class="item"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Are you want delete this review?')"
                                            href="{{route('review.delete',['id'=>$item->id])}}" class="item"
                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   {!! $reviews->appends(request()->query())->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@stop

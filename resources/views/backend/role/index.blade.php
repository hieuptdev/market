@extends('backend.layouts.master')
@section('title', 'Roles')
@section('roles','active')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <h3 class="title-5 m-b-35">Roles</h3>
        @if (session('noti'))
        <div class="alert alert-{{session('status')}}" role="alert">
            <strong>{{session('noti')}}</strong>
        </div>
        @endif
        <div class="table-data__tool">
            <form class="form-header" action="{{route('role.index')}}" method="GET" id="myForm">
                @csrf
                <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for roles"
                    style="height: 41px;" @if(Request::get('search')) value="{{Request::get('search')}}" @endif />
                <button class="au-btn--submit" type="submit">
                    <i class="zmdi zmdi-search"></i>
                </button>
                &nbsp &nbsp
                <a href="{{route('role.index')}}" class="au-btn--submit"><i class="fa fa-refresh"
                        aria-hidden="true"></i></a>
                &nbsp &nbsp
                <div class="co-3">
                    <a href="{{route('role.create')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Add Role</a>
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
                            <p style="margin-top: 8px;">permission</p>
                        </th>
                        <th>created at
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
                    @foreach ($roles as $role)
                    <tr class="tr-shadow">
                        <td>{{$role->id}}</td>
                        <td class="desc">{{$role->name}}</td>
                        <td>@foreach ($role->permission as $per)
                            {{$per->name}}<br>
                            @endforeach</td>
                        <td>{{$role->created_at}}</td>
                        <td>
                            <div class="table-data-feature">
                                @if (Auth::guard('admin')->User()->role_id!=$role->id)
                                <a href="{{route('role.edit',['id'=>$role->id])}}" class="item" data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <form action="{{ route('role.delete',['id' => $role->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are you sure?')" class="item" title="Delete">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $roles->appends(request()->query())->links() }}
    </div>
</div>
@stop

@extends('backend.layouts.master')
@section('title', 'Roles add')
@section('roles','active')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                @section('thongbao')
                <div class="alert alert-danger" role="alert">
                    <strong>danger</strong>
                </div>
                @endsection
                <form method="post" action="{{route('role.store')}}">
                    @csrf
                    <div class="card-header">
                        <strong>Create</strong> Roles
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="nf-email" class=" form-control-label">Roles name</label>
                            <input type="text" id="nf-email" name="name" placeholder="Input roles..."
                                class="form-control">
                            {{showError($errors,'name')}}
                        </div>
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    @foreach ($permissions as $item)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <label for="checkbox1" class="form-check-label ">
                                                    <input type="checkbox" id="checkbox1" name="permission_id[]"
                                                        value="{{$item->id}}" class="form-check-input">{{$item->name}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Create
                        </button>
                    </div>
                </form>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</div>
@stop

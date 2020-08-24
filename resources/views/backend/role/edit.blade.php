@extends('backend.layouts.master')
@section('title', 'Roles edit')
@section('roles','active')
@section('main')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Update</strong> Roles
                </div>
                <div class="card-body card-block">
                    <div class="float-right form-group ">
                        <form action="{{ route('role.delete',['id' => $role->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Are you sure?')" class="item btn btn-danger"
                                title="Delete">
                                Delete
                            </button>
                        </form>
                    </div>
                    <form action="{{route('role.update',['id'=>$role->id])}}" method="post" class="">
                        @csrf
                        <div class="form-group">
                            <label for="nf-email" class=" form-control-label">Roles name</label>
                            <input type="text" id="nf-email" name="name" value="{{$role->name}}" class="form-control">
                            {{showError($errors,'name')}}
                        </div>

                        <div class="form-check">
                            <div class="checkbox">
                                <label for="checkbox1" class="form-check-label ">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($permissions as $permission)
                                            <div class="col-md-4">
                                                <input @foreach ($role->permission as $permission_role)
                                                @if ($permission_role->id == $permission->id)
                                                checked
                                                @endif
                                                @endforeach type="checkbox" id="checkbox1" name="permission_id[]"
                                                value="{{$permission->id}}"
                                                class="form-check-input">{{$permission->name}}<br>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</div>
@stop

@extends('backend.layouts.master')
@section('title', 'Users')
@section('style')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
    #blue_color {
        color: blue;
    }
</style>
@endsection
@section('main')
<div class="main-content" style="overflow: auto;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Users</h3>
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{session('success')}}</strong>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{session('error')}}</strong>
                    </div>
                    @endif
                    <div class="table-data__tool">
                        <form class="form-header" action="{{route('user.index')}}" method="GET" id="myForm">
                            @csrf
                            <input class="au-input au-input--xl" type="text" name="search"
                                placeholder="Search for users" style="height: 41px;" @if(Request::get('search'))
                                value="{{Request::get('search')}}" @endif />
                             <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            &nbsp &nbsp
                            <a href="{{route('user.index')}}" class="au-btn--submit"><i class="fa fa-refresh"
                                    aria-hidden="true"></i></a>
                            &nbsp &nbsp
                            <div class="co-3">
                                <a href="{{route('user.create')}}"
                                    class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add user</a>
                            </div>
                    </div>
                    {{-- @if (Gate::forUser(Auth::guard('admin'))->allows('user-read'))@endif --}}

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
                                <option value="">Status</option>
                                <option value="active" @if(Request::get('status')=='active' ) selected @endif>Active
                                </option>

                                <option value="banned" @if(Request::get('status')=='banned' ) selected @endif>Banned
                                </option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="rate" onchange="submitForm();">
                                <option value="">Rate</option>
                                <option value="5" @if(Request::get('rate')==5) selected @endif>
                                    &#9733&#9733&#9733&#9733&#9733
                                </option>
                                <option value="4" @if(Request::get('rate')==4) selected @endif>
                                    &#9733&#9733&#9733&#9733
                                    &#x2191
                                </option>
                                <option value="3" @if(Request::get('rate')==3) selected @endif>&#9733&#9733&#9733
                                    &#x2191
                                </option>
                                <option value="2" @if(Request::get('rate')==2) selected @endif>&#9733&#9733 &#x2191
                                </option>
                                <option value="1" @if(Request::get('rate')==1) selected @endif>&#9733 &#x2191
                                </option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control" name="gender" onchange="submitForm();">
                                <option value="">Gender</option>
                                <option value="male" @if(Request::get('gender')=='male' ) selected @endif>Male
                                </option>
                                <option value="female" @if(Request::get('gender')=='female' ) selected @endif>Female
                                </option>
                                <option value="other" @if(Request::get('gender')=='other' ) selected @endif>Other
                                </option>
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive table-responsive-data2" style="width: 1700px;">
                <table class="table table-data2">
            </div>
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
                    <th>username
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
                    <th>email
                        <div class="btn-group-vertical">
                            <a
                                href={{ url()->full().'?'.http_build_query(array_merge(request()->all(),['sort' => 'emailasc'])) }}>
                                <i class="fas fa-sort-up"></i>
                            </a>
                            <a
                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'emaildesc'])) }}>
                                <i class="fas fa-sort-down"></i>
                            </a>
                        </div>
                    </th>
                   {{--  <th>phone
                        <div class="btn-group-vertical">
                            <a
                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'phoneasc'])) }}>
                                <i class="fas fa-sort-up"></i>
                            </a>
                            <a
                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'phonedesc'])) }}>
                                <i class="fas fa-sort-down"></i>
                            </a>
                        </div>
                    </th> --}}
                    <th>
                        <p style="margin-top: 8px;">address</p>
                    </th>
                    <th>status
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
                    <th>rate
                        <div class="btn-group-vertical">
                            <a
                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'rateasc'])) }}>
                                <i class="fas fa-sort-up"></i>
                            </a>
                            <a
                                href={{ url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' => 'ratedesc'])) }}>
                                <i class="fas fa-sort-down"></i>
                            </a>
                        </div>
                    </th>
                    <th>
                        <p style="margin-top: 8px;">total bought</p>
                    </th>
                    <th>
                        <p style="margin-top: 8px;">total sold</p>
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
        </div>
        <tbody>
            @foreach($users as $user)
            <tr class="tr-shadow">
                <td>{{$user->id}}</td>
                <td>{{$user->username}}</td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    @foreach($user->getUserAddressDefault as $value)
                    <p>{{$value->street}}</p>
                    <p>{{$value->ward->name}}</p>
                    <p>{{$value->district->name}}</p>
                    <p>{{$value->province->name}}</p>
                    @endforeach
                </td>
                <td>{{$user->status}}</td>
                <td>
                    @if($user->avg_rate >=1)
                        @for($i = 0; $i < round($user->avg_rate); $i++)
                            &#9733
                        @endfor
                        <br>
                        @if($user->review->count() > 1)
                            ({{$user->review->count()}} reviews)
                        @else
                            ({{$user->review->count()}} review)
                        @endif
                    @else
                        No review
                    @endif
                </td>
                <td>{{totalBought($user->id)}}</td>
                <td>{{totalSold($user->id)}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    <div class="table-data-feature">
                        <a href="{{route('user.edit',['id' => $user->id])}}" class="item" data-toggle="tooltip"
                            data-placement="top" title="Edit">
                            <i class="zmdi zmdi-edit"></i>
                        </a>
                        <!--  destroy user -->

                        <form action="{{ route('user.delete',['id' => $user->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Are you sure?')" class="item" title="Delete">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="pagination">
        {!! $users->appends(request()->query())->links() !!}
    </div>
</div>
</div>
</div>
</div>
@stop

@section('script')
<script>
    function submitForm() {
        $('#myForm').submit();
    }

    $(document).ready(function() {
        var _token = $('input[name="_token"]').val();
        var params = new window.URLSearchParams(window.location.search);
        var province_id = $('#province').val();;
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
    });

</script>
@endsection

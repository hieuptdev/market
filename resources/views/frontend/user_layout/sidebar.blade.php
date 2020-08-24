    @php
       $arrRoute = explode('.', Route::currentRouteName());
    @endphp
<div class="col-3 accordion" id="accordionExample" style="margin-top: 150px;">
    <div class="card">
         <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                   <button class="btn btn-link btn-block text-left @if(in_array('account', $arrRoute)) alert-danger @endif" type="button" data-toggle="collapse" data-target="#collapseMyAccount" aria-expanded="true" aria-controls="collapseMyAccount">
                        My account
                  </button>
            </h2>
      </div>
      <div id="collapseMyAccount" class="collapse @if(in_array('account', $arrRoute)) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
        <ul class="list-group">
             <li class="list-group-item text-left 
             @if(Route::currentRouteName() == 'user.account.profile') 
              active
              @endif" 
             >
                  <i class="fa fa-home" aria-hidden="true"></i> 
                  &nbsp
                  <a href="{{route('user.account.profile')}}" id="item-name">Profile</a>
            </li>
            <li class="list-group-item text-left 
            @if(Route::currentRouteName() == 'user.account.address')
             active 
            @endif">
                  <i class="fa fa-location-arrow" aria-hidden="true"></i>
                  &nbsp
                  <a href="{{route('user.account.address')}}" id="item-name">Address</a>
            </li>
            <li class="list-group-item text-left
             @if(Route::currentRouteName() == 'user.account.password') 
             active 
             @endif">
                  <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                  &nbsp
                  <a href="{{route('user.account.password')}}" id="item-name">Change Password</a>
            </li>
      </ul>
</div>
</div>


<div class="card">
  <div class="card-header" id="headingProduct">
      <h2 class="mb-1">
           <button class="btn btn-link btn-block text-decoration-none text-left @if(in_array('product', $arrRoute)) alert-danger @endif" type="button" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
                Product
          </button>
      </h2>
  </div>

  <div id="collapseProduct" class="collapse  @if(in_array('product', $arrRoute)) show @endif" aria-labelledby="headingProduct" data-parent="#accordionExample">
    <ul class="list-group" class="text-left">
        <li class="list-group-item text-left  
          @if(Route::currentRouteName() == 'user.product') 
            active
          @endif" >
              <i class="fa fa-product-hunt" aria-hidden="true"></i>
              <a href="{{route('user.product')}}" id="item-name">&nbsp My Product</a>
        </li>

        <li class="list-group-item text-left
          @if(Route::currentRouteName() == 'user.product.pending.approval') 
            active
          @endif 
          ">  
              <i class="fa fa-hourglass-start" aria-hidden="true"></i>
              <a href="{{route('user.product.pending.approval')}}" id="item-name">&nbsp Pending Approval</a>
        </li>
    </ul>
  </div>
</div>

<div class="card">
  <div class="card-header" id="headingPurchase">
       <a href="{{route('user.purchase')}}" class="btn btn-link show btn-block text-decoration-none text-left @if(in_array('purchase', $arrRoute)) alert-danger @endif" >
            My Purchase
      </a>
  </div>
</div>

<div class="card">
   <div class="card-header" id="headingOne">
        <h2 class="mb-0">
             <form action="{{route('logout')}}" method="POST">
                  @csrf
                  <a class="btn btn-link btn-block text-danger text-left" onclick="this.parentNode.submit();"><i class="fa fa-sign-out" aria-hidden="true" ></i> Log out</a>
            </form>
      </h2>
</div>
</div>
</div>
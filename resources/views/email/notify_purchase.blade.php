<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>
	<p>Hi, {{$user->name}}</p>
    <h3>{{$notification}}</h3>
    <div>
        <p><b>Product:</b> {{$product->title}}</p>
        <p><b>Price:</b> ${{number_format($product->price, '0',',','.')}}</p>
        <p><b>Deliver From:</b> {{$product->address->getFullAddress($product->seller_address)}}</p>
        <p><b>Your Address:</b> {{$user->address}}</p>
        <p><b>Your Phone:</b> {{$user->phone}}</p>
    </div>

</body>

</html>
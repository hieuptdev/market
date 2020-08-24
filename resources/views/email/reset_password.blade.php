<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
        	We heard that you lost your HK Market password. Sorry about that!

        	But don’t worry! You can use the following link to reset your password:
        	{{ route('get.reset.password', ['token'=>$token]) }}.<br/>

        	Thanks,
        	HK Market
           
        </div>

    </body>
</html>
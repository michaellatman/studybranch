<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Welcome!</h2>

<div>
    Hi {{$first_name}} how are you?
    <hr>
    {{ URL::to('/api/v1/account/activate', array($token))}}
    <!--here's your token <a href="http://studybranch.com/">{{$token}}</a>-->
</div>
</body>
</html>

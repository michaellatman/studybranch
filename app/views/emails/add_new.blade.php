<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Howdy!</h2>

<div>
    Hi {{$first_name}} how are you?

    You are receiving this email because you requested to add this email address to your StudyBranch account. If you did not request this delete and ignore this email.
    <hr>
    {{ URL::to('/api/v1/account/email_verify', array($token))}}
    <!--here's your token <a href="http://studybranch.com/">{{$token}}</a>-->
</div>
</body>
</html>

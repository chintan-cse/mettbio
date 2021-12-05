<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered email-id is <a href="">{{$user['email']}}</a> , Please find below code to activate your Account.
<br/>
<p style="font-style:bold;">{{$user->verifyUser->token}}</p>
</body>

</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width, user-scalable=no">

<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">

<title>Mailer</title>
<style>
body{font-family: 'Roboto', sans-serif; color: #4e4d4d; background-color: #f9f9f9; margin: 0; padding: 0; overflow-x: hidden;}
table {width: 100%; max-width: 800px;}
td, th {padding:10px;}
th {background: #F9F9F9; border-bottom: solid 1px #ccc;}
.bordered-table td {border-bottom: solid 1px #ccc;}


@media (max-width: 600px) {
table, tbody {display: block; }
tr {width: 100%;}
.inlinerow tr {display: inline-table;}
.inlinerow tr th, .inlinerow tr td {width: 70%;}
}

</style>
</head>

<body>

<!-- BODY -->
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%;" style="border: solid 1px #ccc;">
	<tr align="center">
		<td style="background: #ffffff; padding: 20px; border-bottom:1px solid #ccc; width: 100vw;">
			<img src="{{ url('/') }}/images/logo.jpg" width="120" style="display:inline-block;">
		</td>
	</tr>
	<tr>
		<td>Welcome to <strong style="color: #0d4e61;">Precision Glass Industries!</strong></td>
	</tr>
	<tr>
		<td>Your entered email-id is <a href="">{{$resetvalue['reset_email']}}</a> , Please find below code to reset your account password.</td>
	</tr>
	<tr>
		<td><p style="font-weight:bold;">{{$resetvalue['reset_token']}}</p></td>
	</tr>
	<tr>
		<td>We request you to please feel free for reaching to us at <a href="#!">support@precisionglass.com</a> in case of any queries or concerns.</td>
	</tr>
	<tr>
		<td><font face="roboto, sans-serif" color="#222222" style="font-size:14px; line-height:150%;">Best Regards,<br><strong style="color: #0d4e61;">Team Precision Glass Industries</strong></font></td>
	  </tr>
	
	
	<tr><td></td></tr>
	<tr style="text-align: center; background: #fff;">
		<td style="border-top: 1px solid #ccc; padding: 20px 0;">Copyright 2020</td>
	</tr>
</table>
<!-- /BODY -->

</body>
</html>
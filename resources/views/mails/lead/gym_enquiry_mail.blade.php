<!DOCTYPE html>
<html>
<head>
	<title>Registration Mail</title>
</head>
<body>
	<h2>{{ $mailMessage->body }}</h2>

	<h4>Contact of Gym</h4>
	<p>
		Email: {{ $mailMessage->gym_email }}<br>
		Phone: {{ $mailMessage->gym_phone }}
	</p>
</body>
</html>
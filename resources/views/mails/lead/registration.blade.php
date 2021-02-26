<!DOCTYPE html>
<html>
<head>
	<title>Registration Mail</title>
</head>
<body>
	<h2>{{ $transfer_info->body }}</h2>
	<p>
		Your login credentials:<br>
		Email: {{ $transfer_info->customer_phone }}
		Phone: {{ $transfer_info->customer_email }}
		Password: {{ $transfer_info->customer_password }}
	</p>
	<h4>Contact of Gym</h4>
	<p>
		Email: {{ $transfer_info->gym_email }}<br>
		Phone: {{ $transfer_info->gym_phone }}
	</p>
</body>
</html>
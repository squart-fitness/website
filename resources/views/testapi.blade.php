<!DOCTYPE html>
<html>
<head>
	<title>Test API</title>
</head>
<body>

<form action="{{route('member_login')}}" method="post" accept-charset="utf-8">
	<input type="text" name="member_id" placeholder="username">
	<input type="password" name="password" placeholder="password">
	<button type="submit">submit</button>
</form>
</body>
</html>